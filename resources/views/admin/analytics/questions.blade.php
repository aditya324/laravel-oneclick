<h2>Question Analytics</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>Question</th>
        <th>Total Attempts</th>
        <th>Correct</th>
        <th>Wrong</th>
        <th>Pass Rate (%)</th>
    </tr>

    @foreach ($analytics as $q)
        <tr>
            <td>{{ $q->question }}</td>
            <td>{{ $q->total_attempts ?? 0 }}</td>
            <td>{{ $q->correct_attempts ?? 0 }}</td>
            <td>{{ $q->wrong_attempts ?? 0 }}</td>
            <td>{{ $q->pass_rate ?? 0 }}%</td>
        </tr>
    @endforeach
</table>
