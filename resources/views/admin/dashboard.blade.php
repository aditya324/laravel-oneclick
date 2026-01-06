@vite(['resources/css/app.css'])

<div class="min-h-screen bg-gray-100 p-6">

    <!-- Header -->
    <div class="max-w-7xl mx-auto mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">
            Admin Dashboard
        </h2>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                Logout
            </button>
        </form>
    </div>

    <!-- Stats -->
    <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-sm text-gray-500">Total Students</p>
            <p class="text-3xl font-bold">{{ $totalStudents }}</p>
        </div>

        <div class="bg-blue-50 p-6 rounded-xl shadow">
            <p class="text-sm text-blue-700">Attempted Quiz</p>
            <p class="text-3xl font-bold text-blue-800">{{ $attemptedStudents }}</p>
        </div>

        <div class="bg-red-50 p-6 rounded-xl shadow">
            <p class="text-sm text-red-700">Not Attempted</p>
            <p class="text-3xl font-bold text-red-800">{{ $notAttemptedStudents }}</p>
        </div>
    </div>

    <!-- Table -->
    <div class="max-w-7xl mx-auto bg-white rounded-xl shadow overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 border-b">
                <tr class="text-left text-gray-600">
                    <th class="px-6 py-4">Name</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">Attempts</th>
                    <th class="px-6 py-4">Latest Score</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @foreach ($students as $student)
                    @php
                        $latest = $student->latestSubmittedAttempt;
                    @endphp

                    <tr class="{{ $student->quiz_attempts_count == 0 ? 'bg-red-50' : '' }}">
                        <td class="px-6 py-4 font-medium">
                            {{ $student->name }}
                        </td>

                        <td class="px-6 py-4 text-gray-600">
                            {{ $student->email }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $student->quiz_attempts_count }}/3
                        </td>

                        <td class="px-6 py-4">
                            {{ $latest?->score ?? '-' }}/10
                        </td>

                        <td class="px-6 py-4">
                            @if ($latest && $latest->passed)
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                    Passed
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                                    Not Passed
                                </span>
                            @endif
                        </td>



                        <td class="px-6 py-4">
                            <a href="{{ route('admin.students.show', $student->id) }}"
                                class="text-blue-600 hover:underline font-medium">
                                View
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
