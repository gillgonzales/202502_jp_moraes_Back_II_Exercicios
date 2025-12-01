<?php

namespace App\Http\Controllers;

use App\Models\Automovel;
use Illuminate\Http\Request;

class AutomovelController extends Controller
{
    // Listagem de todos os automóveis
    public function index()
    {
        $automoveis = Automovel::all();
        return view('automoveis.index', compact('automoveis'));
    }

    // Visualização única de um automóvel
    public function show($id)
    {
        $automovel = Automovel::findOrFail($id);
        return view('automoveis.show', compact('automovel'));
    }
}