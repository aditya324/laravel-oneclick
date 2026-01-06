@vite(['resources/css/app.css', 'resources/js/app.js'])
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    
</head>
<body>
    <section class="w-full py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

        <!-- LEFT : VIDEO / IMAGE -->
        <div class="relative rounded-2xl overflow-hidden shadow-lg">
            <img
                src="/assets/images/academy-video-thumb.jpg"
                alt="One Click Academy"
                class="w-full h-full object-cover"
            />

            <!-- Play Overlay -->
            <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
                <div class="w-16 h-16 bg-yellow-400 rounded-full flex items-center justify-center cursor-pointer">
                    ▶
                </div>
            </div>
        </div>

        <!-- RIGHT : CONTENT -->
        <div>
            <h2 class="text-4xl font-extrabold text-gray-900 leading-tight">
                Here’s How to Build a
                <span class="text-yellow-500">Profitable</span> &
                <span class="text-yellow-500">Scalable</span> Business
                <br>
                That Can Grow
                <span class="text-yellow-500">Without You</span>
            </h2>

            <p class="mt-4 text-gray-600">
                A short and to-the-point webinar on how to grow any MSME business fast.
            </p>

            <ul class="mt-6 space-y-2 text-gray-700">
                <li>✓ Increase revenue and profits</li>
                <li>✓ Stand out from competition</li>
                <li>✓ Systemize and automate business</li>
                <li>✓ Scale 2X–3X faster</li>
            </ul>

            <button
                onclick="openRegisterModal()"
                class="mt-8 inline-flex items-center gap-3
                       bg-yellow-400 hover:bg-yellow-500
                       text-black font-semibold
                       px-8 py-4 rounded-xl shadow-lg">
                ▶ Watch the Free Demo Now
            </button>

            <p class="mt-4 text-sm text-gray-500">
                70,000+ entrepreneurs rated our training 4.86 ★
            </p>
        </div>
    </div>
</section>
<!-- REGISTER MODAL -->
<div
    id="registerModal"
    class="fixed inset-0 z-50 hidden bg-black/60 flex items-center justify-center px-4">

    <div class="bg-white w-full max-w-md rounded-2xl shadow-xl p-6 relative">

        <!-- Close Button -->
        <button
            onclick="closeRegisterModal()"
            class="absolute top-4 right-4 text-gray-400 hover:text-black">
            ✕
        </button>

        <h3 class="text-2xl font-bold text-gray-900 mb-4">
            Student Registration
        </h3>

        @if(session('success'))
            <p class="mb-4 text-green-600 font-medium">
                {{ session('success') }}
            </p>
        @endif

        <form
            action="{{ route('student.register') }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-4">

            @csrf

            <input
                type="text"
                name="name"
                placeholder="Full Name"
                required
                class="w-full border rounded-lg px-4 py-2">

            <input
                type="text"
                name="phone"
                placeholder="Phone Number"
                required
                class="w-full border rounded-lg px-4 py-2">

            <input
                type="email"
                name="email"
                placeholder="Email"
                required
                class="w-full border rounded-lg px-4 py-2">

            <input
                type="file"
                name="college_id"
                accept="image/*"
                required
                class="w-full border rounded-lg px-4 py-2">

            <button
                type="submit"
                class="w-full bg-yellow-400 hover:bg-yellow-500
                       text-black font-semibold py-3 rounded-lg">
                Submit
            </button>
        </form>
    </div>
</div>
<script>
    function openRegisterModal() {
        document.getElementById('registerModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeRegisterModal() {
        document.getElementById('registerModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>

</body>
</html>