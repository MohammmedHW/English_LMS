@extends('layouts.admin')

@section('title', 'Add Test Questions — ' . $lesson->title)

@section('content')

{{-- Page Header --}}
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h4 mb-1">Add Test Questions</h1>
        <p class="text-muted small mb-0">
            <i class="fas fa-clipboard-list me-1 opacity-50"></i>
            {{ $lesson->title }}
            <span class="mx-2 opacity-25">|</span>
            Pass score: <strong>{{ $lesson->pass_score }}%</strong>
            <span class="mx-2 opacity-25">|</span>
            <a href="{{ route('lessons.test_questions.index', $lesson) }}" class="text-decoration-none text-muted">View test</a>
        </p>
    </div>
    <a href="{{ route('lessons.test_questions.index', $lesson) }}" class="btn btn-sm btn-light border">
        <i class="fas fa-arrow-left me-2"></i>Back
    </a>
</div>

{{-- Info Banner --}}
<div class="info-banner mb-4">
    <i class="fas fa-lock me-2"></i>
    Questions added here appear in the <strong>final locked test</strong>. Students must pass all exercises before accessing this test.
</div>

{{-- Validation Errors --}}
@if($errors->any())
<div class="alert alert-danger border-0 rounded-3 mb-4">
    <i class="fas fa-triangle-exclamation me-2"></i>
    <strong>Save failed.</strong> Please review the fields below.
    <ul class="mb-0 mt-2 ps-3">
        @foreach($errors->all() as $error)
            <li class="small">{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('lessons.test_questions.store', $lesson) }}" method="POST" id="bulk-form">
    @csrf
    <div id="questions-container"></div>

    {{-- Action Bar --}}
    <div class="d-flex align-items-center gap-2 mt-2 mb-5 p-3 bg-white border rounded-3 shadow-sm">
        <button type="button" class="btn btn-outline-primary btn-sm px-3" id="add-question-btn">
            <i class="fas fa-plus me-2"></i>Add Question
        </button>
        <span class="text-muted small" id="count-label">0 questions</span>
        <div class="ms-auto d-flex gap-2">
            <a href="{{ route('lessons.test_questions.index', $lesson) }}" class="btn btn-sm btn-light border">Cancel</a>
            <button type="submit" class="btn btn-sm btn-primary px-4" id="save-all-btn">
                <i class="fas fa-check me-2"></i>Save Questions
            </button>
        </div>
    </div>
</form>

{{-- Question Card Template --}}
<template id="question-template">
    <div class="question-card card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3 px-4 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <span class="question-index-badge">Q1</span>
                <span class="fw-semibold question-label text-dark">Question 1</span>
            </div>
            <button type="button" class="btn btn-sm text-danger remove-question-btn">
                <i class="fas fa-trash-alt me-1"></i>Remove
            </button>
        </div>

        <div class="card-body px-4 pt-3 pb-4">
            {{-- Type Selection --}}
            <div class="mb-4">
                <label class="form-label label-sm">Question Type</label>
                <select name="questions[__IDX__][type]" class="form-select form-select-sm type-select">
                    <option value="Multiple Choice">Multiple Choice</option>
                    <option value="True/False">True / False</option>
                    <option value="Fill in the Blank">Fill in the Blank</option>
                    <option value="Complete the Sentence">Complete the Sentence</option>
                    <option value="Match the Pair">Match the Pair</option>
                </select>
            </div>

            {{-- Question Text --}}
            <div class="mb-4">
                <label class="form-label label-sm question-text-label">Question Text</label>
                <textarea name="questions[__IDX__][question]" class="form-control" rows="2"
                    placeholder="Enter the question here..."></textarea>
                <div class="form-text question-hint mt-1">Write a clear, concise question.</div>
            </div>

            {{-- ─── MCQ ─── --}}
            <div class="type-section mcq-section" data-section="Multiple Choice">
                <div class="section-label mb-2">Answer Options</div>
                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text option-badge option-a">A</span>
                            <input type="text" name="questions[__IDX__][options][]" class="form-control" placeholder="Option A">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text option-badge option-b">B</span>
                            <input type="text" name="questions[__IDX__][options][]" class="form-control" placeholder="Option B">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text option-badge option-c">C</span>
                            <input type="text" name="questions[__IDX__][options][]" class="form-control" placeholder="Option C (optional)">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text option-badge option-d">D</span>
                            <input type="text" name="questions[__IDX__][options][]" class="form-control" placeholder="Option D (optional)">
                        </div>
                    </div>
                </div>
                <label class="form-label label-sm correct-label">Correct Answer</label>
                <input type="text" name="questions[__IDX__][answer]" class="form-control form-control-sm correct-input"
                    placeholder="Type the exact text of the correct option">
            </div>

            {{-- ─── True / False ─── --}}
            <div class="type-section tf-section d-none" data-section="True/False">
                <div class="section-label mb-3">Select the Correct Answer</div>
                <div class="d-flex gap-3">
                    <label class="tf-option">
                        <input type="radio" name="questions[__IDX__][answer]" value="True" class="tf-radio">
                        <span class="tf-label true-label"><i class="fas fa-check me-2"></i>True</span>
                    </label>
                    <label class="tf-option">
                        <input type="radio" name="questions[__IDX__][answer]" value="False" class="tf-radio">
                        <span class="tf-label false-label"><i class="fas fa-times me-2"></i>False</span>
                    </label>
                </div>
            </div>

            {{-- ─── Fill in the Blank ─── --}}
            <div class="type-section fib-section d-none" data-section="Fill in the Blank">
                <div class="hint-box mb-3">
                    <i class="fas fa-info-circle me-2 text-primary"></i>
                    Use <code>___</code> in the question above to mark the blank. E.g. <em>"She ___ to school every day."</em>
                </div>
                <label class="form-label label-sm correct-label">Correct Word / Phrase</label>
                <input type="text" name="questions[__IDX__][answer]" class="form-control form-control-sm correct-input"
                    placeholder="The word that fills the blank">
            </div>

            {{-- ─── Complete the Sentence ─── --}}
            <div class="type-section cts-section d-none" data-section="Complete the Sentence">
                <div class="hint-box mb-3">
                    <i class="fas fa-info-circle me-2 text-primary"></i>
                    Write the incomplete sentence above, then add completion choices below.
                </div>
                <div class="section-label mb-2">Answer Options</div>
                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text option-badge option-a">A</span>
                            <input type="text" name="questions[__IDX__][options][]" class="form-control" placeholder="Option A">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text option-badge option-b">B</span>
                            <input type="text" name="questions[__IDX__][options][]" class="form-control" placeholder="Option B">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text option-badge option-c">C</span>
                            <input type="text" name="questions[__IDX__][options][]" class="form-control" placeholder="Option C">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text option-badge option-d">D</span>
                            <input type="text" name="questions[__IDX__][options][]" class="form-control" placeholder="Option D">
                        </div>
                    </div>
                </div>
                <label class="form-label label-sm correct-label">Correct Answer</label>
                <input type="text" name="questions[__IDX__][answer]" class="form-control form-control-sm correct-input"
                    placeholder="Which option completes the sentence?">
            </div>

            {{-- ─── Match the Pair ─── --}}
            <div class="type-section mtp-section d-none" data-section="Match the Pair">
                <div class="hint-box mb-3">
                    <i class="fas fa-info-circle me-2 text-primary"></i>
                    Enter matching pairs. Students will connect each left item to its correct right item.
                </div>
                <div class="pair-container mb-2">
                    <div class="pair-row row g-2 align-items-center mb-2">
                        <div class="col-md-5">
                            <input type="text" name="questions[__IDX__][pairs][left][]" class="form-control form-control-sm" placeholder="Left item">
                        </div>
                        <div class="col-auto text-muted"><i class="fas fa-arrow-right-long"></i></div>
                        <div class="col-md-5">
                            <input type="text" name="questions[__IDX__][pairs][right][]" class="form-control form-control-sm" placeholder="Right item">
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-sm btn-light border remove-pair-btn"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <div class="pair-row row g-2 align-items-center mb-2">
                        <div class="col-md-5">
                            <input type="text" name="questions[__IDX__][pairs][left][]" class="form-control form-control-sm" placeholder="Left item">
                        </div>
                        <div class="col-auto text-muted"><i class="fas fa-arrow-right-long"></i></div>
                        <div class="col-md-5">
                            <input type="text" name="questions[__IDX__][pairs][right][]" class="form-control form-control-sm" placeholder="Right item">
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-sm btn-light border remove-pair-btn"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-light border add-pair-btn">
                    <i class="fas fa-plus me-1"></i>Add Pair
                </button>
                <input type="hidden" name="questions[__IDX__][answer]" value="pairs">
            </div>

        </div>
    </div>
</template>

@endsection

@section('styles')
<style>
    .question-card { border-radius: 0.75rem; border-left: 3px solid #f59e0b !important; transition: box-shadow 0.2s; }
    .question-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,0.08) !important; }
    .question-card .card-header { border-bottom: 1px solid #f1f5f9; border-radius: 0.75rem 0.75rem 0 0; }
    .question-index-badge { display: inline-flex; align-items: center; justify-content: center; width: 30px; height: 30px; border-radius: 50%; background: #fffbeb; color: #d97706; font-size: 0.72rem; font-weight: 700; }
    .label-sm { font-size: 0.8rem; font-weight: 600; color: #475569; margin-bottom: 0.375rem; }
    .section-label { font-size: 0.78rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; }
    .correct-label { color: #059669 !important; }
    .correct-input { border-color: #059669; }
    .correct-input:focus { border-color: #059669; box-shadow: 0 0 0 3px rgba(5,150,105,0.1); }
    .option-badge { width: 32px; font-weight: 700; font-size: 0.75rem; justify-content: center; }
    .option-a { background: #eef2ff; color: #4f46e5; border-color: #e0e7ff; }
    .option-b { background: #f8fafc; color: #334155; border-color: #e2e8f0; }
    .option-c { background: #f0fdf4; color: #059669; border-color: #dcfce7; }
    .option-d { background: #fffbeb; color: #d97706; border-color: #fef3c7; }
    .tf-option input[type="radio"] { display: none; }
    .tf-label { display: inline-flex; align-items: center; padding: 0.5rem 1.25rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; cursor: pointer; font-size: 0.875rem; font-weight: 600; transition: all 0.2s; color: #64748b; background: white; }
    .tf-option input[type="radio"]:checked + .true-label  { background: #f0fdf4; border-color: #059669; color: #059669; }
    .tf-option input[type="radio"]:checked + .false-label { background: #fef2f2; border-color: #ef4444; color: #ef4444; }
    .tf-label:hover { background: #f8fafc; }
    .hint-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 0.5rem; padding: 0.75rem 1rem; font-size: 0.825rem; color: #64748b; }
    .info-banner { background: #fffbeb; border: 1px solid #fde68a; border-radius: 0.6rem; padding: 0.85rem 1.25rem; font-size: 0.855rem; color: #92400e; }
    .remove-pair-btn { opacity: 0.5; }
    .remove-pair-btn:hover { opacity: 1; color: #ef4444 !important; }
    textarea.form-control { min-height: 72px; resize: vertical; }
</style>
@endsection

@section('scripts')
<script>
let questionCount = 0;

const TYPE_CONFIG = {
    'Multiple Choice':       { section: 'mcq-section', label: 'Question Text',            hint: 'Write a question, then fill in the answer options below.' },
    'True/False':            { section: 'tf-section',  label: 'Statement',                hint: 'Write a factual statement that is either true or false.' },
    'Fill in the Blank':     { section: 'fib-section', label: 'Sentence with Blank',      hint: 'Use ___ to mark the blank. E.g. "She ___ to school."' },
    'Complete the Sentence': { section: 'cts-section', label: 'Incomplete Sentence',      hint: 'Write the sentence, then add completion choices below.' },
    'Match the Pair':        { section: 'mtp-section', label: 'Instructions (optional)',  hint: 'E.g. "Match each word with its correct definition."' },
};

function syncDisabledState(card) {
    card.querySelectorAll('.type-section').forEach(section => {
        const hidden = section.classList.contains('d-none');
        section.querySelectorAll('input, textarea, select').forEach(el => {
            el.disabled = hidden;
        });
    });
}

function switchType(card, type) {
    const cfg = TYPE_CONFIG[type];
    if (!cfg) return;
    card.querySelectorAll('.type-section').forEach(s => s.classList.add('d-none'));
    card.querySelector('.' + cfg.section).classList.remove('d-none');
    card.querySelector('.question-text-label').textContent = cfg.label;
    card.querySelector('.question-hint').textContent = cfg.hint;
    syncDisabledState(card);
}

function addQuestion() {
    const template = document.getElementById('question-template');
    const clone    = template.content.cloneNode(true);
    const idx      = questionCount;
    questionCount++;

    // Replace __IDX__ in all attributes and text nodes
    function replaceInNode(node) {
        if (node.nodeType === Node.TEXT_NODE) {
            node.textContent = node.textContent.replaceAll('__IDX__', idx);
        } else if (node.nodeType === Node.ELEMENT_NODE) {
            ['name', 'id', 'for'].forEach(attr => {
                if (node.hasAttribute(attr)) {
                    node.setAttribute(attr, node.getAttribute(attr).replaceAll('__IDX__', idx));
                }
            });
            node.childNodes.forEach(replaceInNode);
        }
    }
    clone.childNodes.forEach(replaceInNode);

    const card = clone.querySelector('.question-card');
    card.querySelector('.question-label').textContent       = `Question ${questionCount}`;
    card.querySelector('.question-index-badge').textContent = `Q${questionCount}`;

    // Remove-question
    card.querySelector('.remove-question-btn').addEventListener('click', function () {
        this.closest('.question-card').remove();
        renumber();
    });

    // Type select
    card.querySelector('.type-select').addEventListener('change', function () {
        switchType(this.closest('.question-card'), this.value);
    });

    // Add pair
    card.querySelector('.add-pair-btn').addEventListener('click', function () {
        const container = this.previousElementSibling;
        const firstRow  = container.querySelector('.pair-row');
        const newRow    = firstRow.cloneNode(true);
        newRow.querySelectorAll('input').forEach(i => { i.value = ''; i.disabled = false; });
        newRow.querySelector('.remove-pair-btn').addEventListener('click', () => removePair(newRow));
        container.appendChild(newRow);
    });

    card.querySelectorAll('.remove-pair-btn').forEach(btn => {
        btn.addEventListener('click', function () { removePair(this.closest('.pair-row')); });
    });

    // Default = MCQ active
    switchType(card, 'Multiple Choice');

    document.getElementById('questions-container').appendChild(clone);
    updateUI();
}

function removePair(row) {
    const container = row.parentElement;
    if (container.querySelectorAll('.pair-row').length > 1) row.remove();
}

function renumber() {
    document.querySelectorAll('.question-card').forEach((card, i) => {
        card.querySelector('.question-label').textContent       = `Question ${i + 1}`;
        card.querySelector('.question-index-badge').textContent = `Q${i + 1}`;
    });
    updateUI();
}

function updateUI() {
    const count = document.querySelectorAll('.question-card').length;
    document.getElementById('count-label').textContent = `${count} question${count !== 1 ? 's' : ''}`;
    document.getElementById('save-all-btn').innerHTML  =
        `<i class="fas fa-check me-2"></i>Save ${count > 0 ? count + ' Question' + (count !== 1 ? 's' : '') : 'Questions'}`;
}

document.getElementById('bulk-form').addEventListener('submit', function (e) {
    document.querySelectorAll('.question-card').forEach(card => syncDisabledState(card));
    if (document.querySelectorAll('.question-card').length === 0) {
        e.preventDefault();
        alert('Please add at least one question before saving.');
    }
});

document.addEventListener('DOMContentLoaded', () => {
    addQuestion();
    document.getElementById('add-question-btn').addEventListener('click', addQuestion);
});
</script>
@endsection
