<h2>{{ $student->name }} – Quiz Attempts</h2>
@php
    $latest = $student->latestSubmittedAttempt;
@endphp
<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>Attempt</th>
            <th>Score</th>
            <th>Passed</th>
            <th>Started At</th>
            <th>Submitted At</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($attempts as $attempt)
            <tr>
                <td>{{ $attempt->attempt_number }}</td>
                <td>{{ $attempt->score }}/10</td>
                <td>{{ $attempt->passed ? 'Yes' : 'No' }}</td>
                <td>{{ $attempt->started_at }}</td>
                <td>{{ $attempt->submitted_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
