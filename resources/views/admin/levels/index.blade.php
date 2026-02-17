@extends('layouts.admin')

@section('title', 'Levels')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Levels</h3>
    <a href="{{ route('levels.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add Level</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3">Course</th>
                        <th class="px-4 py-3">Level Name</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($levels as $level)
                    <tr>
                        <td class="px-4 py-3">{{ $level->course->title }}</td>
                        <td class="px-4 py-3 fw-medium">{{ $level->name }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('levels.edit', $level) }}" class="btn btn-sm btn-outline-primary me-2"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('levels.destroy', $level) }}" method="POST" class="d-inline">
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
