<h2>{{ $student->name }} – Quiz Performance</h2>

@foreach ($attempts as $attempt)
    <h3>Attempt {{ $attempt->attempt_number }}</h3>
    <p>Score: {{ $attempt->score }}/10</p>
    <p>Status: {{ $attempt->passed ? 'Passed' : 'Failed' }}</p>

    <table border="1" cellpadding="8">
        <tr>
            <th>Question</th>
            <th>Selected</th>
            <th>Correct</th>
        </tr>

        @foreach ($attempt->answers as $answer)
            <tr>
                <td>{{ $answer->question->question }}</td>
                <td>{{ strtoupper($answer->selected_option) }}</td>
                <td>{{ $answer->is_correct ? 'Yes' : 'No' }}</td>
            </tr>
        @endforeach
    </table>
    <hr>
@endforeach
