<?php

namespace App\Http\Controllers;

use App\Models\Adotante;
use Illuminate\Http\Request;
use Psr\Http\Message\ServerRequestInterface;

class AdotanteController extends Controller
{

    public function index()
    {
        return Adotante::all();
    }


    public function store(Request $request)
    {
        return Adotante::create($request->all());
    }


    public function show(Adotante $adotante)
    {
        //
    }


    public function update(Request $request, Adotante $adotante)
    {
        //
    }

    public function destroy(Adotante $adotante)
    {
        //
    }
}