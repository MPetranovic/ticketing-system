<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class TechnicianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('technicians.index', [
            'technicians' => User::where('role', 'technician')->filter(
                request(['search']))->sortable(['created_at' => 'asc'])
                ->paginate(9)->withQueryString()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $technician)
    {

        $tickets = $technician->technician_tickets()->get();

        return view('technicians.show', [
            'technician' => $technician,
            'tickets' => $tickets,
        ]);
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
    public function destroy($name)
    {
        User::where('name', $name)->delete();

        return redirect('/technicians')->with('warning', 'Technician Deleted');
    }
}
