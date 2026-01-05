<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Payment Failed</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css'])
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center px-4">

    <div class="max-w-md w-full bg-white rounded-2xl shadow-lg p-8 text-center">

        <!-- Icon -->
        <div class="flex justify-center mb-6">
            <div class="w-20 h-20 rounded-full bg-red-100 flex items-center justify-center">
                <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
        </div>

        <!-- Title -->
        <h1 class="text-2xl font-bold text-gray-900">
            Payment Failed
        </h1>

        <!-- Message -->
        <p class="text-gray-600 mt-3 leading-relaxed">
            Unfortunately, your payment could not be completed.
            This may be due to a bank issue, network problem, or insufficient balance.
        </p>

        <!-- Divider -->
        <div class="border-t my-6"></div>

        <!-- Actions -->
        <div class="space-y-3">
            <a href="{{ route('payment.page', $student->id ?? '') }}"
                class="block w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 rounded-lg transition">
                Retry Payment
            </a>

            <a href="{{ route('quiz.start', $student->id ?? '') }}"
                class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-3 rounded-lg transition">
                Go Back to Quiz
            </a>
        </div>

        <!-- Support -->
        <p class="text-xs text-gray-500 mt-6">
            If the amount was debited, it will be automatically refunded within 5–7 working days.
        </p>

    </div>

</body>

</html>
