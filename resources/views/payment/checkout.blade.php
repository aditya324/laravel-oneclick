<button id="payBtn">Pay ₹300</button>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    document.getElementById('payBtn').onclick = async function() {

        const res = await fetch('{{ route('payment.create') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                student_id: {{ $student->id }}
            })
        });

        const data = await res.json();

        if (!res.ok) {
            alert(data.error || 'Payment cannot be initiated');
            return;
        }

        const options = {
            key: data.key,
            amount: 30000 * 100,
            currency: "INR",
            order_id: data.order_id,
            handler: function(response) {
                fetch('{{ route('payment.verify') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(response)
                }).then(() => window.location.reload());
            }
        };

        new Razorpay(options).open();
    };



    rzp.on('payment.failed', function(response) {

        fetch('/payment/failed', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                razorpay_order_id: response.error.metadata.order_id,
                razorpay_payment_id: response.error.metadata.payment_id ?? null,
                failure_stage: 'authorization',
                failure_reason: response.error.reason,
                description: response.error.description,
                source: response.error.source
            })
        });
    });

    rzp.open();
</script>
