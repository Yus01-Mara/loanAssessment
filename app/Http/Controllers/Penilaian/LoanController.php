<?php

namespace App\Http\Controllers\Penilaian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LoanApplication;

class LoanController extends Controller
{
    public function index()
    {
        $apps = DB::table('loan_applications')->get();
        return view('loan.index', compact('apps'));
    }

}
