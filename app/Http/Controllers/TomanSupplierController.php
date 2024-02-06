<?php

namespace App\Http\Controllers;

use App\Models\TomanSupplier;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TomanSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
        $data = TomanSupplier::all();
        return view('pages.toman_suppliers.index',['party' => $data]);
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
        //
        $client = new TomanSupplier();
        $client->name = $request->title;
        $client->save();
        return Redirect::back()->with('msg', 'The Message');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TomanSupplier  $tomanSupplier
     * @return \Illuminate\Http\Response
     */
    public function show(TomanSupplier $tomanSupplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TomanSupplier  $tomanSupplier
     * @return \Illuminate\Http\Response
     */
    public function edit(TomanSupplier $tomanSupplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TomanSupplier  $tomanSupplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TomanSupplier $tomanSupplier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TomanSupplier  $tomanSupplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(TomanSupplier $tomanSupplier)
    {
        //
    }
}
