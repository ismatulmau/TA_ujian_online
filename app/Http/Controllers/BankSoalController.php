<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BankSoalController extends Controller
{
    public function index()
    { 
        return view('admin.bank-soal.banksoal.index'); 
    }
}
