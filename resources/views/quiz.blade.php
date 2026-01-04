<form method="POST" action="{{ route('quiz.submit', $studentId) }}">
    @csrf

    <div id="timer">15:00</div>

    @foreach ($questions as $q)
        <p>{{ $q->question }}</p>

        <label><input type="radio" name="answers[{{ $q->id }}]" value="a"> {{ $q->option_a }}</label><br>
        <label><input type="radio" name="answers[{{ $q->id }}]" value="b"> {{ $q->option_b }}</label><br>
        <label><input type="radio" name="answers[{{ $q->id }}]" value="c"> {{ $q->option_c }}</label><br>
        <label><input type="radio" name="answers[{{ $q->id }}]" value="d"> {{ $q->option_d }}</label><br>
    @endforeach

    <button type="submit">Submit Quiz</button>
</form>

<script>
    let time = 15 * 60;
    setInterval(() => {
        if (time <= 0) document.forms[0].submit();
        time--;
    }, 1000);
</script>
