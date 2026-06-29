<?php

namespace App\Http\Controllers\Print;

use App\Http\Controllers\Controller;

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
