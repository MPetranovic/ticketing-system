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
        //
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
            'title' => 'required | max:255',
            'description' => 'required',
            'client_name' => 'required',
            'client_email' => 'required | email | max:255'

        ]);

        $client = new Client;
        $client->name = $request->input('client_name');
        $client->email = $request->input('client_email');
        $client->save();

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

        return redirect('/dashboard')->with('success', 'Ticket Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
