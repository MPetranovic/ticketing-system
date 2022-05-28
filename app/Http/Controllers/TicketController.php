<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Status;
use App\Models\Technician;
use App\Models\Ticket;
use Illuminate\Http\Request;


class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = auth()->user()->id;
        // $client_name = request('search');
        // dd($client_name);
        // if (request('search') != null) {
        //     $clients = Client::where('name', 'like', '%' . request('search') . '%')->get();
        // }

        // dd($clients);

        $tickets = Ticket::where('user_id', $id)->latest()->filter(
                    request(['search']))->paginate(7)->withQueryString();

        return view('dashboard',[
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
            'technicians' => Technician::all()
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
            'technician' => 'required'

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
        $ticket->technician_id = $request->input('technician');
        $ticket->status_id = $status->id;
        $ticket->save();

        $status->ticket_id = $ticket->id;
        $status->save();

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
        $technician = $ticket->technician;
        $status = $ticket->status;

        return view('tickets.show', [
            'ticket' => $ticket,
            'client' => $client,
            'technician' => $technician,
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

        return view('tickets.edit', [
            'ticket' => $ticket,
            'technicians' => Technician::all()
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
            'technician' => 'required',
            'status' => 'required'
        ]);

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

        $status = $ticket->status;
        $status->status = $request->input('status');
        $status->save();

        $ticket->title = $request->input('title');
        $ticket->description = $request->input('description');
        $ticket->technician_id = $request->input('technician');
        $ticket->save();

        return redirect('/dashboard')->with('info', 'Ticket Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
