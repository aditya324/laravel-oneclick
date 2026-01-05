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

        return view('payment.checkout', compact('student'));
    }

    public function createOrder(Request $request)
    {
        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        $order = $api->order->create([
            'receipt' => 'rcpt_' . $request->student_id,
            'amount' => 30000 * 100, // ₹300.00 example
            'currency' => 'INR',
        ]);

        Payment::create([
            'student_registration_id' => $request->student_id,
            'razorpay_order_id' => $order['id'],
            'amount' => 30000 * 100,
        ]);

        return response()->json([
            'order_id' => $order['id'],
            'key' => config('services.razorpay.key'),
        ]);
    }

    public function verify(Request $request)
    {
        $attributes = $request->only([
            'razorpay_order_id',
            'razorpay_payment_id',
            'razorpay_signature',
        ]);

        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        try {
            $api->utility->verifyPaymentSignature($attributes);

            Payment::where('razorpay_order_id', $attributes['razorpay_order_id'])
                ->update(['status' => 'captured']);

            return redirect()->route('payment.success');
        } catch (\Exception $e) {
            Payment::where('razorpay_order_id', $attributes['razorpay_order_id'])
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
