<?php

namespace App\Http\Controllers;

use App\Models\Adopter;
use Illuminate\Http\Request;
use Psr\Http\Message\ServerRequestInterface;

class AdopterController extends Controller
{

    public function index()
    {
        return Adopter::all();
    }


    public function store(Request $request)
    {
        return Adopter::create($request->all());
    }


    public function show(Adopter $adopter)
    {
        //
    }


    public function update(Request $request, Adopter $adopter)
    {
        //
    }

    public function destroy(Adopter $adopter)
    {
        //
    }
}