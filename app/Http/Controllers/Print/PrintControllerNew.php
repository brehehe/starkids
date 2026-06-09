<?php

namespace App\Http\Controllers\Print;

use App\Http\Controllers\Controller;
use App\Models\Transaction\Transaction;
use Illuminate\Http\Request;

class PrintControllerNew extends Controller
{
    //
    public function invoiceSale()
    {
        return view('print.invoice-sale');
    }

    public function invoicePrint()
    {
        return view('print.invoice-example');
    }
}
