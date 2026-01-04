<h2>Add Quiz Question</h2>

@if ($errors->any())
    <ul style="color:red">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('quiz-questions.store') }}">
    @csrf

    <textarea name="question" placeholder="Enter question" required></textarea><br><br>

    <input type="text" name="option_a" placeholder="Option A" required><br>
    <input type="text" name="option_b" placeholder="Option B" required><br>
    <input type="text" name="option_c" placeholder="Option C" required><br>
    <input type="text" name="option_d" placeholder="Option D" required><br><br>

    <label>Correct Answer:</label>
    <select name="correct_option" required>
        <option value="">Select</option>
        <option value="a">Option A</option>
        <option value="b">Option B</option>
        <option value="c">Option C</option>
        <option value="d">Option D</option>
    </select><br><br>

    <button type="submit">Save Question</button>
</form>
