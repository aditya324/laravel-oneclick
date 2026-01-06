<?php

namespace App\Http\Controllers;

use Razorpay\Api\Api;
use App\Models\Payment;
use App\Models\StudentRegistration;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function page(StudentRegistration $student)
    {
        // SECURITY: ensure student passed quiz
        // if ($student->latestAttempt?->percentage < 75) {
        //     abort(403);
        // }
        $latestPayment = Payment::where('student_registration_id', $student->id)
            ->latest()
            ->first();

        if ($latestPayment && $latestPayment->isCaptured()) {
            abort(403, 'Payment already completed');
        }
        return view('payment.checkout', compact('student'));
    }

    public function createOrder(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:student_registrations,id',
        ]);

        // 🔒 Get latest payment for this student
        $latestPayment = Payment::where('student_registration_id', $request->student_id)
            ->latest()
            ->first();

        // ❌ Block if already paid
        if ($latestPayment && $latestPayment->isCaptured()) {
            return response()->json([
                'error' => 'Payment already completed'
            ], 409);
        }

        // ❌ Block if a payment is already in progress
        if ($latestPayment && $latestPayment->isPending()) {
            return response()->json([
                'error' => 'Payment already in progress'
            ], 409);
        }

        // ✅ Allow retry ONLY if failed OR no payment exists
        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        $amount = 4200 * 100; // example

        $order = $api->order->create([
            'receipt' => 'rcpt_' . $request->student_id . '_' . time(),
            'amount' => $amount,
            'currency' => 'INR',
        ]);

        Payment::create([
            'student_registration_id' => $request->student_id,
            'razorpay_order_id' => $order['id'],
            'amount' => $amount,
            'status' => 'created',
        ]);

        return response()->json([
            'order_id' => $order['id'],
            'key' => config('services.razorpay.key'),
            'amount' => $amount,
        ]);
    }


    public function verify(Request $request)
    {
        $request->validate([
            'razorpay_order_id'   => 'required|string',
            'razorpay_payment_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        $attributes = [
            'razorpay_order_id'   => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature,
        ];

        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        try {
            // 🔐 Verify signature
            $api->utility->verifyPaymentSignature($attributes);

            // ✅ SAVE EVERYTHING (THIS WAS MISSING)
            Payment::where('razorpay_order_id', $request->razorpay_order_id)
                ->update([
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'razorpay_signature'  => $request->razorpay_signature,
                    'status'              => 'captured',
                ]);

            return redirect()->route('payment.success');
        } catch (\Exception $e) {

            Payment::where('razorpay_order_id', $request->razorpay_order_id)
                ->update([
                    'status' => 'failed',
                    'failure_stage' => 'verification',
                    'failure_reason' => $e->getMessage(),
                ]);

            return redirect()->route('payment.failed.page');
        }
    }



    public function markFailed(Request $request)
    {
        Payment::where('razorpay_order_id', $request->razorpay_order_id)
            ->update([
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'status' => 'failed',
                'failure_stage' => $request->failure_stage,
                'failure_reason' => $request->failure_reason,
                'gateway_response' => json_encode($request->all()),
            ]);

        return response()->json(['status' => 'failure recorded']);
    }
}
