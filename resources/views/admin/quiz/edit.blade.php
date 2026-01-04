<h2>Edit Question</h2>

<form method="POST" action="{{ route('quiz-questions.update', $quiz_question->id) }}">
    @csrf
    @method('PUT')

    <textarea name="question" required>{{ $quiz_question->question }}</textarea><br><br>

    <input name="option_a" value="{{ $quiz_question->option_a }}" required><br>
    <input name="option_b" value="{{ $quiz_question->option_b }}" required><br>
    <input name="option_c" value="{{ $quiz_question->option_c }}" required><br>
    <input name="option_d" value="{{ $quiz_question->option_d }}" required><br><br>

    <select name="correct_option">
        @foreach (['a', 'b', 'c', 'd'] as $o)
            <option value="{{ $o }}" @selected($quiz_question->correct_option === $o)>
                {{ strtoupper($o) }}
            </option>
        @endforeach
    </select><br><br>

    <button type="submit">Update</button>
</form>
