<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    //
     public function index()
    {
        $payments = Payment::with('student')
            ->latest()
            ->paginate(20);

        return view('admin.payments.index', compact('payments'));
    }
}
