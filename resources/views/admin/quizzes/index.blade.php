@extends('layouts.admin')

@section('title', 'Quizzes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Quizzes</h3>
    <a href="{{ route('quizzes.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add Quiz Question</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3">Lesson</th>
                        <th class="px-4 py-3">Question</th>
                        <th class="px-4 py-3">Correct Answer</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quizzes as $quiz)
                    <tr>
                        <td class="px-4 py-3">{{ $quiz->lesson->title }}</td>
                        <td class="px-4 py-3 fw-medium">{{ Str::limit($quiz->question, 50) }}</td>
                        <td class="px-4 py-3 text-uppercase fw-bold text-success">{{ $quiz->correct_answer }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('quizzes.edit', $quiz) }}" class="btn btn-sm btn-outline-primary me-2"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('quizzes.destroy', $quiz) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
