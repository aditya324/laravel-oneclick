@vite(['resources/css/app.css', 'resources/js/app.js'])

@if (session()->has('error'))
    <div class="max-w-5xl mx-auto mb-6 px-4">
        <div class="p-4 rounded-lg bg-red-100 border border-red-300 text-red-700 font-semibold">
            {{ session('error') }}
        </div>
    </div>
@endif

<section class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 py-10 px-4">
    <div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-xl p-8">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <h1 class="text-2xl font-bold text-gray-800">
                Online Assessment
            </h1>

            <!-- Timer -->
            <div class="sticky top-4 z-50 max-w-4xl mx-auto px-4">
    <div
        class="ml-auto w-fit
               flex items-center gap-2
               bg-white border border-red-300
               text-red-600 font-semibold
               px-4 py-2 rounded-lg
               shadow-md">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"></circle>
            <path d="M12 6v6l4 2"></path>
        </svg>
        <span id="timer">15:00</span>
    </div>
</div>
        </div>

        <!-- Quiz Form -->
        <form id="quizForm" method="POST" action="{{ route('quiz.submit', $studentId) }}">
            @csrf

            <div class="space-y-10">

                @foreach ($questions as $index => $q)
                    <div class="border border-gray-200 rounded-xl p-6 hover:shadow-md transition">

                        <!-- Question -->
                        <p class="font-semibold text-gray-800 mb-5">
                            <span class="text-blue-600 font-bold">
                                Q{{ $index + 1 }}.
                            </span>
                            {{ $q->question }}
                        </p>

                        <!-- Options -->
                        <div class="space-y-3">
                            @foreach (['a','b','c','d'] as $opt)
                                <label
                                    class="flex items-start gap-3 p-4 rounded-lg border
                                           cursor-pointer transition
                                           hover:bg-blue-50 hover:border-blue-400">

                                    <input type="radio"
                                           name="answers[{{ $q->id }}]"
                                           value="{{ $opt }}"
                                           class="mt-1 accent-blue-600">

                                    <span class="text-gray-700 leading-relaxed">
                                        {{ $q->{'option_'.$opt} }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach

            </div>

            <!-- Submit -->
            <div class="mt-10 flex justify-between items-center">

                <p class="text-sm text-gray-500">
                    Please review your answers before submitting.
                </p>

                <button type="submit"
                        class="px-8 py-3 bg-blue-600 text-white font-semibold
                               rounded-lg shadow-md hover:bg-blue-700
                               transition focus:outline-none focus:ring-2 focus:ring-blue-400">
                    Submit Quiz
                </button>
            </div>
        </form>
    </div>
</section>

<!-- Timer Script -->
<script>
    let time = 15 * 60;
    const form = document.getElementById('quizForm');
    const timer = document.getElementById('timer');

    const interval = setInterval(() => {
        const m = Math.floor(time / 60);
        const s = time % 60;

        timer.textContent =
            `${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;

        if (time <= 0) {
            clearInterval(interval);
            form.submit();
        }

        time--;
    }, 1000);
</script>

<script>
window.onbeforeunload = () =>
    "Your quiz is in progress. Leaving this page will submit the quiz automatically.";
</script>
