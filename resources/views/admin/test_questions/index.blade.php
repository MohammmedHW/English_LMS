@extends('layouts.admin')

@section('title', 'Final Test — ' . $lesson->title)

@section('content')

{{-- Page Header --}}
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h4 mb-1">Final Test Questions</h1>
        <p class="text-muted small mb-0">
            <i class="fas fa-clipboard-list me-1 opacity-50"></i>
            {{ $lesson->title }}
            <span class="mx-2 opacity-25">|</span>
            Score to pass: <strong>{{ $lesson->pass_score }}%</strong>
            <span class="mx-2 opacity-25">|</span>
            {{ $questions->count() }} questions
        </p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('lessons.index') }}" class="btn btn-sm btn-light border">
            <i class="fas fa-arrow-left me-2"></i>Lessons
        </a>
        <a href="{{ route('lessons.test_questions.create', $lesson) }}" class="btn btn-sm btn-primary px-3 shadow-none bg-amber-600 border-amber-600">
            <i class="fas fa-plus me-2"></i>Add Question
        </a>
    </div>
</div>

{{-- Info Banner --}}
<div class="info-banner mb-4">
    <i class="fas fa-lock me-2"></i>
    <strong>Test Locked:</strong> Students can only take this test after completing all lesson exercises. Changes here affect the final score.
</div>

{{-- Content Card --}}
<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 custom-table">
                <thead>
                    <tr>
                        <th class="px-4 py-3 text-muted fw-bold small text-uppercase" style="width: 70px;">S.No.</th>
                        <th class="px-4 py-3 text-muted fw-bold small text-uppercase" style="width: 180px;">Type</th>
                        <th class="px-4 py-3 text-muted fw-bold small text-uppercase">Question Detail</th>
                        <th class="px-4 py-3 text-muted fw-bold small text-uppercase" style="width: 250px;">Correct Answer</th>
                        <th class="px-4 py-3 text-muted fw-bold small text-uppercase text-end">Manage</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($questions as $tq)
                    <tr class="fade-in">
                        <td class="px-4 py-3">
                            <span class="text-muted fw-bold small">{{ $loop->iteration }}.</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="type-badge type-{{ Str::slug($tq->question->type) }}">
                                {{ $tq->question->type }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="question-preview" title="{{ $tq->question->question }}">
                                {{ Str::limit($tq->question->question, 60) }}
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <code class="text-success small fw-bold">
                                {{ Str::limit($tq->question->answer, 30) }}
                            </code>
                        </td>
                        <td class="px-4 py-3 text-end">
                            <div class="btn-group">
                                <a href="{{ route('test_questions.edit', $tq) }}" class="btn btn-action" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('test_questions.destroy', $tq) }}" method="POST" class="d-inline ms-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-action text-danger" title="Delete" 
                                        onclick="return confirm('Remove this question from the test?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="empty-state py-4">
                                <div class="empty-icon mb-3 opacity-25 text-warning">
                                    <i class="fas fa-clipboard-question fa-3x"></i>
                                </div>
                                <h6 class="text-muted mb-1">Final Test is Empty</h6>
                                <p class="small text-muted mb-3">Add questions to enable the final evaluation for students.</p>
                                <a href="{{ route('lessons.test_questions.create', $lesson) }}" class="btn btn-sm btn-primary bg-amber-600 border-amber-600">
                                    Add First Test Question
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
    .bg-amber-600 { background-color: #d97706 !important; }
    .border-amber-600 { border-color: #d97706 !important; }
    
    .info-banner { background: #fffbeb; border: 1px solid #fde68a; border-radius: 0.6rem; padding: 0.85rem 1.25rem; font-size: 0.825rem; color: #92400e; }
    
    .custom-table thead { background: #f8fafc; }
    .custom-table th { border-bottom: none; font-size: 0.725rem; letter-spacing: 0.05em; }
    .custom-table tr { border-bottom: 1px solid #f1f5f9; }
    .custom-table tr:last-child { border-bottom: none; }
    
    .pos-badge { font-weight: 700; color: #d97706; font-size: 0.85rem; background: #fffbeb; padding: 2px 8px; border-radius: 6px; }
    
    .type-badge {
        padding: 0.35rem 0.75rem; border-radius: 2rem; font-size: 0.72rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.025em; display: inline-block;
    }
    .type-multiple-choice { background: #eef2ff; color: #4f46e5; }
    .type-true-false { background: #f0fdf4; color: #16a34a; }
    .type-fill-in-the-blank { background: #fff7ed; color: #ea580c; }
    .type-complete-the-sentence { background: #faf5ff; color: #9333ea; }
    .type-match-the-pair { background: #ecfeff; color: #0891b2; }

    .question-preview { font-size: 0.88rem; color: #334155; font-weight: 500; }
    
    .btn-action {
        width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center;
        border-radius: 8px; color: #64748b; background: transparent; border: none; transition: all 0.2s;
    }
    .btn-action:hover { background: #f1f5f9; color: #1e293b; }
    .btn-action.text-danger:hover { background: #fef2f2; color: #ef4444; }

    .fade-in { animation: fadeIn 0.4s ease-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection
