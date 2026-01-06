<div class="max-w-md mx-auto mt-20 text-center">
    <h1 class="text-3xl font-bold text-red-600">
        Quiz Failed
    </h1>

    <p class="mt-4 text-gray-600">
        You did not meet the 75% passing criteria.
    </p>

    <a href="{{ url()->previous() }}"
       class="inline-block mt-6 px-6 py-3
              bg-blue-600 text-white rounded">
        Try Again
    </a>
</div>
