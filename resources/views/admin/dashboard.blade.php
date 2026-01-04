<h2>Admin Dashboard</h2>

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Attempts</th>
            <th>Latest Score</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($students as $student)
            @php
                $latest = $student->quizAttempts->first();
            @endphp
            <tr>
                <td>{{ $student->name }}</td>
                <td>{{ $student->email }}</td>
                <td>{{ $student->quiz_attempts_count }}/3</td>
                <td>{{ $latest->score ?? '-' }}/10</td>
                <td>
                    @if ($latest && $latest->passed)
                        <span style="color:green">Passed</span>
                    @else
                        <span style="color:red">Not Passed</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.students.show', $student->id) }}">View</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>
