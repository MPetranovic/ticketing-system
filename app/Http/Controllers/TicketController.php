<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Status;
use App\Models\Ticket;
use App\Models\User;
use App\Models\TechnicianTicket;
use App\Notifications\TicketAssignment;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->role == 'agent') {
            $tickets = Ticket::where('user_id', auth()->user()->id)->filter(
                request(['search', 'client']))->sortable(['updated_at' => 'desc'])
                ->paginate(7)->withQueryString();
        } else {
            $tickets = Ticket::whereHas('technicians', function (Builder $query) {
                $query->where('technician_id', '=', auth()->user()->id);})
            ->filter(request(['search', 'client']))->sortable(['updated_at' => 'desc'])
            ->paginate(7)->fragment('tickets')->withQueryString();
        }

        return view('dashboard',[
            'tickets' => $tickets
        ]);
    }

    public function pending(){
        if (auth()->user()->role == 'agent') {
            $tickets = Ticket::where('user_id', auth()->user()->id)
                ->whereHas('status', function (Builder $query) {
                    $query->where('status', '=', "Pending");})->filter(
                request(['search', 'client']))->sortable(['updated_at' => 'desc'])
                ->paginate(9)->withQueryString();
        } else {
            $tickets = Ticket::whereHas('technicians', function (Builder $query) {
                $query->where('technician_id', '=', auth()->user()->id);})
                ->whereHas('status', function (Builder $query) {
                    $query->where('status', '=', "Open");})
            ->filter(request(['search', 'client']))->sortable(['updated_at' => 'desc'])
            ->paginate(9)->fragment('tickets')->withQueryString();
        }

        return view('tickets.pending',[
            'tickets' => $tickets
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tickets.create', [
            'technicians' => User::where('role', 'technician')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required | max:30',
            'description' => 'required',
            'client_name' => 'required',
            'client_email' => 'required | email | max:30',
            'technicians' => 'required'

        ]);

        $client = Client::firstOrCreate([
            'name' => $request->input('client_name'),
            'email' => $request->input('client_email')
        ]);

        $status = new Status;
        $status->status = 'Open';
        $status->save();

        $ticket = new Ticket;
        $ticket->title = $request->input('title');
        $ticket->description = $request->input('description');
        $ticket->user_id = auth()->user()->id;
        $ticket->client_id = $client->id;
        $ticket->status_id = $status->id;
        $ticket->save();

        $bruhs = [];
        $technicians = $request->input('technicians');
        for ($i=0; $i < count($technicians); $i++) {
            $ticket->technicians()->attach($technicians[$i]);

            $technician = User::where('id', $technicians[$i])->get();

            TicketController::send_to_technicians(auth()->user(), $technician);
            $bruhs[$i] = $technician;
        }

        return redirect('/dashboard')->with('success', 'Ticket Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        $client = $ticket->client;
        $technicians = $ticket->technicians;
        $status = $ticket->status;

        return view('tickets.show', [
            'ticket' => $ticket,
            'client' => $client,
            'technicians' => $technicians,
            'status' => $status
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($title)
    {
        $ticket = Ticket::firstWhere('title', $title);
        $technicians_id = TechnicianTicket::where('ticket_id', $ticket->id)->get()->pluck('technician_id')->toArray();
        $technicians = User::where('role', 'technician')->whereIn('id', $technicians_id)->get();

        $others = User::where('role', 'technician')->get()->except($technicians_id);

        return view('tickets.edit', [
            'ticket' => $ticket,
            'technicians' => $technicians,
            'others' => $others,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $title)
    {
        $ticket = Ticket::firstWhere('title', $title);

        $this->validate($request, [
            'title' => 'required | max:30',
            'description' => 'required',
            'client_name' => 'required',
            'client_email' => 'required | email | max:30',
            'technicians' => 'required',
            'status' => 'required'
        ]);

        if (auth()->user()->role == 'agent') {

            $tmp_client = Client::firstWhere([
                'name' => $request->input('client_name'),
                'email' => $request->input('client_email')
            ]);
            $client = $ticket->client;

            if ($tmp_client != null && $tmp_client != $client) {
                $client->delete();
                $ticket->client_id = $tmp_client->id;
            }

            else {
                $client->name = $request->input('client_name');
                $client->email = $request->input('client_email');
                $client->save();
            }

            $ticket->title = $request->input('title');

            $technicians = $request->input('technicians');

            if($request->input('status') == "Open") {
                for ($i=0; $i < count($technicians); $i++) {
                    $notified = TechnicianTicket::where('technician_id', $technicians[$i])->where('ticket_id', $ticket->id)->get();

                    if(count($notified) == 0) {
                        $technician = User::where('id', $technicians[$i])->get();
                        TicketController::send_to_technicians(auth()->user(), $technician);
                    }
                }
            }

            $ticket->technicians()->sync($technicians);

            if($request->input('status') == "Closed") TicketController::send_to_client($ticket->client, $ticket->title);

        } else {
            if($request->input('status') == "Pending") TicketController::send_to_agent(auth()->user(), $ticket->agent, $ticket->title);
        }

        $ticket->description = $request->input('description');
        $ticket->save();

        $status = $ticket->status;
        $status->status = $request->input('status');
        $status->save();

        return redirect('/dashboard')->with('info', 'Ticket Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($title)
    {
        Ticket::where('title', $title)->delete();

        return redirect('/dashboard')->with('warning', 'Ticket Deleted');
    }

    public function send_to_technicians($agent, $technician)
    {
        $assignmentData = [
            'greeting' => 'Hello '. $technician[0]->name,
            'body' => 'Agent '. $agent->name . ' has assigned you a new ticket.',
            'button' => 'Visit Site',
            'url' => url('/dashboard'),
        ];

        $technician[0]->notify(new TicketAssignment($assignmentData));
    }

    public function send_to_agent($technician, $agent, $ticket_title)
    {
        $assignmentData = [
            'greeting' => 'Hello '. $agent->name,
            'body' => 'Technician '. $technician->name . ' has solved the issue on ticket "'. $ticket_title .'".' . "\n" . 'Ticket is awaiting your approval.',
            'button' => 'Visit Site',
            'url' => url('/pending'),
        ];

        $agent->notify(new TicketAssignment($assignmentData));
    }

    public function send_to_client($client, $ticket_title)
    {
        $assignmentData = [
            'greeting' => 'Hello '. $client->name,
            'body' => 'Your issue under the name of "'. $ticket_title .'" has been resolved',
            'button' => 'Thank you for your patience',
            'url' => url('/dashboard'),
        ];

        $client->notify(new TicketAssignment($assignmentData));
    }

}
