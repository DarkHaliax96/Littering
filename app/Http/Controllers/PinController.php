<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pin;
users.pin.index;

class PinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pins = Pin::all();
        $residues = Residue::all()->sortBy('name');
        $locations = Location::all()->sortBy('name');

        return view('users.pins.index', compact('pins', 'residues', 'locations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'residue_id' => 'required|numeric',
            'location_id' => 'required|numeric'
        ]);

        if($validator->fails()){
            return redirect()->back()
                ->withInput($request)
                ->withErrors($validator);
        }
        
        $pin = new Pin;
        $pin->residue_id = $request->residue_id;
        $pin->location_id = $request->location_id;
        $pin->save();

        session()->flash('message', 'El pin nuevo se ha creado con exito.');
        return redirect('/users/pins');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Pin $pin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Pin $pin)
    {
        if($pin == null){
            $errors = ['No se ha encontrado el id especificado.'];
            return redirect()->back()->withErrors($errors);
        }

        $residues = Residue::all()->sortBy('name');
        $locations = Location::all()->sortBy('name');

        return view('users.pin.show', compact('pin', 'residues', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pin $pin)
    {
        if($pin == null){
            $errors = ['No se ha encontrado el id especificado.'];
            return redirect()->back()->withErrors($errors);
        }

        $validator = Validator::make($request->all(), [
             'residue_id' => 'required|numeric',
            'location_id' => 'required|numeric'
        ]);

        if($validator->fails()){
            return redirect()->back()
                ->withInput($request)
                ->withErrors($validator);
        }
        
        $pin->residue_id = $request->residue_id;
        $pin->location_id = $request->location_id;
        $pin->save();


        session()->flash('message', 'El pin nuevo se ha creado con exito.');
        return redirect('/users/pins');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pin $pin)
    {
        if($pin == null){
            $errors = ['No se ha encontrado el id especificado.'];
            return redirect()->back()->withErrors($errors);
        }

        $pin->delete();
        return redirect('users.pins.index');
    }
}