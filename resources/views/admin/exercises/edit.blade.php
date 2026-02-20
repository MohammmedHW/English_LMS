@extends('layouts.admin')

@section('title', 'Edit Exercise')

@section('content')

{{-- Page Header --}}
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h4 mb-1">Edit Practice Exercise</h1>
        <p class="text-muted small mb-0">
            <i class="fas fa-edit me-1 opacity-50"></i>
            {{ $exercise->lesson->title }}
            <span class="mx-2 opacity-25">|</span>
            Order #{{ $exercise->order }}
        </p>
    </div>
    <a href="{{ route('lessons.exercises.index', $exercise->lesson_id) }}" class="btn btn-sm btn-light border">
        <i class="fas fa-arrow-left me-2"></i>Back to List
    </a>
</div>

{{-- Validation Errors --}}
@if($errors->any())
<div class="alert alert-danger border-0 rounded-3 mb-4">
    <i class="fas fa-triangle-exclamation me-2"></i>
    <strong>Update failed.</strong> Please review the fields below.
    <ul class="mb-0 mt-2 ps-3">
        @foreach($errors->all() as $error)
            <li class="small">{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('exercises.update', $exercise) }}" method="POST" id="edit-form">
    @csrf
    @method('PUT')

    <div class="question-card card border-0 shadow-sm mb-5">
        <div class="card-header bg-white py-3 px-4">
            <div class="d-flex align-items-center gap-3">
                <span class="question-index-badge">EDIT</span>
                <span class="fw-semibold text-dark">Modify Question Details</span>
            </div>
        </div>

        <div class="card-body px-4 pt-3 pb-4">
            {{-- Type Selection --}}
            <div class="mb-4">
                <label class="form-label label-sm">Question Type</label>
                <select name="type" class="form-select form-select-sm type-select" id="type-select">
                    @foreach(['Multiple Choice', 'True/False', 'Fill in the Blank', 'Complete the Sentence', 'Match the Pair'] as $type)
                        <option value="{{ $type }}" {{ $exercise->question->type === $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Question Text --}}
            <div class="mb-4">
                <label class="form-label label-sm question-text-label">Question Text</label>
                <textarea name="question" class="form-control" rows="3" required placeholder="Enter the question here...">{{ $exercise->question->question }}</textarea>
                <div class="form-text question-hint mt-1">Write a clear, concise question.</div>
            </div>

            {{-- ─── MCQ ─── --}}
            <div class="type-section mcq-section d-none">
                <div class="section-label mb-2">Answer Options</div>
                <div class="row g-2 mb-3">
                    @for($i = 0; $i < 4; $i++)
                    <div class="col-md-6">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text option-badge option-{{ chr(97 + $i) }}">{{ chr(65 + $i) }}</span>
                            <input type="text" name="options[]" class="form-control" placeholder="Option {{ chr(65 + $i) }} {{ $i > 1 ? '(optional)' : '' }}" 
                                value="{{ isset($exercise->question->options[$i]) ? $exercise->question->options[$i] : '' }}">
                        </div>
                    </div>
                    @endfor
                </div>
                <label class="form-label label-sm correct-label">Correct Answer</label>
                <input type="text" name="answer_mcq" class="form-control form-control-sm correct-input"
                    value="{{ $exercise->question->type === 'Multiple Choice' ? $exercise->question->answer : '' }}"
                    placeholder="Type the exact text of the correct option">
            </div>

            {{-- ─── True / False ─── --}}
            <div class="type-section tf-section d-none">
                <div class="section-label mb-3">Select the Correct Answer</div>
                <div class="d-flex gap-3">
                    <label class="tf-option">
                        <input type="radio" name="answer_tf" value="True" {{ $exercise->question->answer === 'True' ? 'checked' : '' }}>
                        <span class="tf-label true-label"><i class="fas fa-check me-2"></i>True</span>
                    </label>
                    <label class="tf-option">
                        <input type="radio" name="answer_tf" value="False" {{ $exercise->question->answer === 'False' ? 'checked' : '' }}>
                        <span class="tf-label false-label"><i class="fas fa-times me-2"></i>False</span>
                    </label>
                </div>
            </div>

            {{-- ─── Fill in the Blank ─── --}}
            <div class="type-section fib-section d-none">
                <div class="hint-box mb-3">
                    <i class="fas fa-info-circle me-2 text-primary"></i>
                    Use <code>___</code> in the question text above to mark the blank.
                </div>
                <label class="form-label label-sm correct-label">Correct Word / Phrase</label>
                <input type="text" name="answer_fib" class="form-control form-control-sm correct-input"
                    value="{{ $exercise->question->type === 'Fill in the Blank' ? $exercise->question->answer : '' }}"
                    placeholder="The word that fills the blank">
            </div>

            {{-- ─── Complete the Sentence ─── --}}
            <div class="type-section cts-section d-none">
                <div class="section-label mb-2">Answer Options</div>
                <div class="row g-2 mb-3">
                    @for($i = 0; $i < 4; $i++)
                    <div class="col-md-6">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text option-badge option-{{ chr(97 + $i) }}">{{ chr(65 + $i) }}</span>
                            <input type="text" name="options[]" class="form-control" placeholder="Option {{ chr(65 + $i) }}"
                                value="{{ isset($exercise->question->options[$i]) ? $exercise->question->options[$i] : '' }}">
                        </div>
                    </div>
                    @endfor
                </div>
                <label class="form-label label-sm correct-label">Correct Answer</label>
                <input type="text" name="answer_cts" class="form-control form-control-sm correct-input"
                    value="{{ $exercise->question->type === 'Complete the Sentence' ? $exercise->question->answer : '' }}"
                    placeholder="Which option completes the sentence?">
            </div>

            {{-- ─── Match the Pair ─── --}}
            <div class="type-section mtp-section d-none">
                <div class="hint-box mb-3">
                    <i class="fas fa-info-circle me-2 text-primary"></i>
                    Pairs are stored as JSON. Students will connect left items to correct right items.
                </div>
                <div class="pair-container mb-2">
                    @php
                        $pairs = $exercise->question->type === 'Match the Pair' ? $exercise->question->options : [['left' => '', 'right' => '']];
                        if (!is_array($pairs)) $pairs = [['left' => '', 'right' => '']];
                    @endphp
                    @foreach($pairs as $pair)
                    <div class="pair-row row g-2 align-items-center mb-2">
                        <div class="col-md-5">
                            <input type="text" name="pairs[left][]" class="form-control form-control-sm" placeholder="Left item" value="{{ $pair['left'] ?? '' }}">
                        </div>
                        <div class="col-auto text-muted"><i class="fas fa-arrow-right-long"></i></div>
                        <div class="col-md-5">
                            <input type="text" name="pairs[right][]" class="form-control form-control-sm" placeholder="Right item" value="{{ $pair['right'] ?? '' }}">
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-sm btn-light border remove-pair-btn"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-sm btn-light border add-pair-btn">
                    <i class="fas fa-plus me-1"></i>Add Pair
                </button>
                <input type="hidden" name="answer_mtp" value="pairs">
            </div>

            {{-- Real answer field to be synced --}}
            <input type="hidden" name="answer" id="final-answer" value="{{ $exercise->question->answer }}">

        </div>
    </div>

    {{-- Footer Actions --}}
    <div class="d-flex justify-content-end gap-2 mb-5">
        <a href="{{ route('lessons.exercises.index', $exercise->lesson_id) }}" class="btn btn-light px-4 border">Cancel</a>
        <button type="submit" class="btn btn-primary px-5">
            <i class="fas fa-save me-2"></i>Update Exercise
        </button>
    </div>
</form>

@endsection

@section('styles')
<style>
    .question-card { border-radius: 0.75rem; border-left: 3px solid #4f46e5 !important; }
    .question-index-badge { display: inline-flex; align-items: center; justify-content: center; width: 45px; height: 30px; border-radius: 20px; background: #eef2ff; color: #4f46e5; font-size: 0.65rem; font-weight: 800; }
    .label-sm { font-size: 0.8rem; font-weight: 600; color: #475569; margin-bottom: 0.375rem; }
    .section-label { font-size: 0.78rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; }
    .correct-label { color: #059669 !important; }
    .correct-input { border-color: #059669; }
    .option-badge { width: 32px; font-weight: 700; font-size: 0.75rem; justify-content: center; }
    .option-a { background: #eef2ff; color: #4f46e5; border-color: #e0e7ff; }
    .option-b { background: #f8fafc; color: #334155; border-color: #e2e8f0; }
    .option-c { background: #f0fdf4; color: #059669; border-color: #dcfce7; }
    .option-d { background: #fffbeb; color: #d97706; border-color: #fef3c7; }
    .tf-option input[type="radio"] { display: none; }
    .tf-label { display: inline-flex; align-items: center; padding: 0.5rem 1.25rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; cursor: pointer; font-size: 0.875rem; font-weight: 600; color: #64748b; background: white; }
    .tf-option input[type="radio"]:checked + .true-label  { background: #f0fdf4; border-color: #059669; color: #059669; }
    .tf-option input[type="radio"]:checked + .false-label { background: #fef2f2; border-color: #ef4444; color: #ef4444; }
    .hint-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 0.5rem; padding: 0.75rem 1rem; font-size: 0.825rem; color: #64748b; }
    textarea.form-control { min-height: 100px; }
</style>
@endsection

@section('scripts')
<script>
const TYPE_CONFIG = {
    'Multiple Choice':       { section: 'mcq-section', label: 'Question Text', hint: 'Write a question, then fill in the answer options below.' },
    'True/False':            { section: 'tf-section',  label: 'Statement',     hint: 'Write a statement that is either true or false.' },
    'Fill in the Blank':     { section: 'fib-section', label: 'Sentence with Blank', hint: 'Use ___ to mark the blank.' },
    'Complete the Sentence': { section: 'cts-section', label: 'Incomplete Sentence',  hint: 'Write the sentence, then add choices below.' },
    'Match the Pair':        { section: 'mtp-section', label: 'Instructions', hint: 'Provide instructions for the student.' },
};

function switchType(type) {
    const cfg = TYPE_CONFIG[type];
    document.querySelectorAll('.type-section').forEach(s => s.classList.add('d-none'));
    document.querySelector('.' + cfg.section).classList.remove('d-none');
    document.querySelector('.question-text-label').textContent = cfg.label;
    document.querySelector('.question-hint').textContent = cfg.hint;
}

document.getElementById('type-select').addEventListener('change', function() {
    switchType(this.value);
});

// Add pair
document.querySelector('.add-pair-btn').addEventListener('click', function() {
    const container = document.querySelector('.pair-container');
    const firstRow  = container.querySelector('.pair-row');
    const newRow    = firstRow.cloneNode(true);
    newRow.querySelectorAll('input').forEach(i => i.value = '');
    newRow.querySelector('.remove-pair-btn').addEventListener('click', () => newRow.remove());
    container.appendChild(newRow);
});

document.querySelectorAll('.remove-pair-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        if (document.querySelectorAll('.pair-row').length > 1) this.closest('.pair-row').remove();
    });
});

// Final sync before POST
document.getElementById('edit-form').addEventListener('submit', function() {
    const type = document.getElementById('type-select').value;
    let val = '';
    
    if (type === 'Multiple Choice') val = document.querySelector('[name="answer_mcq"]').value;
    else if (type === 'True/False') {
        const checked = document.querySelector('[name="answer_tf"]:checked');
        val = checked ? checked.value : '';
    }
    else if (type === 'Fill in the Blank') val = document.querySelector('[name="answer_fib"]').value;
    else if (type === 'Complete the Sentence') val = document.querySelector('[name="answer_cts"]').value;
    else if (type === 'Match the Pair') val = 'pairs';

    document.getElementById('final-answer').value = val;
});

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    switchType(document.getElementById('type-select').value);
});
</script>
@endsection
