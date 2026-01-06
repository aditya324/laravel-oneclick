
@vite(['resources/css/app.css', 'resources/js/app.js'])

<div class="p-6">

    <h1 class="text-2xl font-bold mb-6">Payments</h1>

    <div class="overflow-x-auto bg-white rounded-xl shadow">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">Student</th>
                    <th class="px-4 py-3 text-left">Order ID</th>
                    <th class="px-4 py-3 text-left">Payment ID</th>
                    <th class="px-4 py-3 text-left">Amount</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Failure</th>
                    <th class="px-4 py-3 text-left">Date</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse ($payments as $payment)
                <tr>
                    <td class="px-4 py-3">
                        <div class="font-medium">
                            {{ $payment->student->name ?? '—' }}
                        </div>
                        <div class="text-xs text-gray-500">
                            {{ $payment->student->email ?? '' }}
                        </div>
                        <div class="text-xs text-gray-500">
                            {{ $payment->student->phone ?? '' }}
                        </div>
                    </td>

                    <td class="px-4 py-3 text-xs">
                        {{ $payment->razorpay_order_id }}
                    </td>

                    <td class="px-4 py-3 text-xs">
                        {{ $payment->razorpay_payment_id ?? '—' }}
                    </td>

                    <td class="px-4 py-3 font-semibold">
                        ₹{{ number_format($payment->amount / 100, 2) }}
                    </td>

                    <td class="px-4 py-3">
                        @if($payment->status === 'captured')
                            <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                Captured
                            </span>
                        @elseif($payment->status === 'failed')
                            <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700">
                                Failed
                            </span>
                             @elseif($payment->status === 'paid')
                            <span class="px-3 py-1 text-xs rounded-full bg-green-500 text-white">
                                Paid
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">
                                {{ ucfirst($payment->status) }}
                            </span>
                        @endif
                    </td>

                    <td class="px-4 py-3 text-xs text-red-600">
                        @if($payment->status === 'failed')
                            <div>{{ $payment->failure_stage }}</div>
                            <div class="text-gray-500">
                                {{ $payment->failure_reason }}
                            </div>
                        @else
                            —
                        @endif
                    </td>

                    <td class="px-4 py-3 text-xs text-gray-500">
                        {{ $payment->created_at->format('d M Y, h:i A') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                        No payments found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $payments->links() }}
    </div>

</div>

