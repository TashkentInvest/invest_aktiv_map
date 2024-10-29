<?php

namespace App\Http\Controllers;

use App\Models\Aktiv;
use App\Http\Requests\StoreAktivRequest;
use App\Http\Requests\UpdateAktivRequest;
use App\Models\Branch;
use App\Models\Regions;

class AktivController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branches = Branch::with(['kt', 'kj', 'ko', 'kz'])->get()->all();
        $regions = Regions::all();
        return view('pages.aktiv.add', compact('branches','regions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAktivRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAktivRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Aktiv  $aktiv
     * @return \Illuminate\Http\Response
     */
    public function show(Aktiv $aktiv)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Aktiv  $aktiv
     * @return \Illuminate\Http\Response
     */
    public function edit(Aktiv $aktiv)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAktivRequest  $request
     * @param  \App\Models\Aktiv  $aktiv
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAktivRequest $request, Aktiv $aktiv)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Aktiv  $aktiv
     * @return \Illuminate\Http\Response
     */
    public function destroy(Aktiv $aktiv)
    {
        //
    }
}
