<h2>Quiz Questions</h2>

@if (session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<a href="{{ route('quiz-questions.create') }}">➕ Add New Question</a>

<table border="1" cellpadding="10">
    <tr>
        <th>#</th>
        <th>Question</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>

    @foreach ($questions as $q)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $q->question }}</td>
            <td>
                {{ $q->is_active ? 'Active' : 'Disabled' }}
            </td>
            <td>
                <a href="{{ route('quiz-questions.edit', $q->id) }}">Edit</a>

                <form method="POST" action="{{ route('quiz-questions.toggle', $q->id) }}" style="display:inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit">
                        {{ $q->is_active ? 'Disable' : 'Enable' }}
                    </button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
