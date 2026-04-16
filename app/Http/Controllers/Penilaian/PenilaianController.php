<?php

namespace App\Http\Controllers\Penilaian;

use App\Http\Controllers\Controller;
use App\Models\CElement;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function create($id)
    {
        $elements = CElement::with('subElements.ratings')->get();
        return view('penilaian.create', compact('elements','id'));
    }
}