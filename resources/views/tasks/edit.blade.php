@extends('layouts.app')

@section('title', 'Update-task')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/tasks/taskform.css') }}">
@endpush

@section('content')
<div class="task-form">
    <h2>Update Task {{ $task->id }}</h2>
    <form id="updateForm" action="{{ route('tasks.update', $task->id) }}" method="post" onsubmit="return validateTaskForm()">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{ $task->id }}" required>
        
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="{{ $task->name }}" required >

        <label for="description">Description:</label>
        <textarea id="description" name="description" required>{{ $task->description }}</textarea>

        <label for="start_date">Start Date:</label>
        <input type="datetime-local" id="start_date" name="start_date"
            value="{{ date('Y-m-d\TH:i', strtotime($task->start_date)) }}" required>

        <label for="due_date">Due Date:</label>
        <input type="datetime-local" id="due_date" name="due_date"
            value="{{ date('Y-m-d\TH:i', strtotime($task->due_date)) }}" required>

        <label for="finished_date">Finished Date:</label>
        <input type="datetime-local" id="finished_date" name="finished_date"
            value="{{ $task->finished_date ? date('Y-m-d\TH:i', strtotime($task->finished_date)) : '' }}"
            @if ($task->status !== 'FINISHED') readonly @endif>

        <label for="status">Status:</label>
        <select id="status" name="status" onchange="toggleFinishedDate()">
            <option value="TODO" @if ($task->status === 'TODO') selected @endif>TODO</option>
            <option value="IN PROGRESS" @if ($task->status === 'IN PROGRESS') selected @endif>IN PROGRESS</option>
            <option value="FINISHED" @if ($task->status === 'FINISHED') selected @endif>FINISHED</option>
        </select>

        <input type="submit" value="Update Task" class="btn btn-primary">
        <p id="errorMessage" class="invalid-feedback"></p>
        <p id="successMessage" class="invalid-feedback"></p>
    </form>

    <!-- Back button -->
    <button class="back-button" onclick="history.back()">Back</button>
</div>
@endsection

@push('scripts')
<script>
function validateTaskForm() {
    var form = document.getElementById('updateForm');
    var name = form.name.value.trim();
    var description = form.description.value.trim();
    var startDate = new Date(form.start_date.value);
    var dueDate = new Date(form.due_date.value);
    var finishedDate = form.finished_date.value ? new Date(form.finished_date.value) : null;
    var status = form.status.value;

    if (name === '' || description === '') {
        document.getElementById('errorMessage').innerText = 'Name and Description cannot be empty.';
        document.getElementById('errorMessage').style.display = 'block';
        setTimeout(function() {
            document.getElementById('errorMessage').style.display = 'none';
        }, 5000);
        return false;
    }

    if (startDate >= dueDate) {
        document.getElementById('errorMessage').innerText = 'Start Date must be before Due Date.';
        document.getElementById('errorMessage').style.display = 'block';
        setTimeout(function() {
            document.getElementById('errorMessage').style.display = 'none';
        }, 5000);
        return false;
    }

    if (status === 'FINISHED') {
        if (!finishedDate) {
            document.getElementById('errorMessage').innerText = 'Finished Date cannot be empty if status is FINISHED.';
            document.getElementById('errorMessage').style.display = 'block';
            setTimeout(function() {
                document.getElementById('errorMessage').style.display = 'none';
            }, 5000);
            return false;
        }

        if (startDate >= finishedDate) {
            document.getElementById('errorMessage').innerText = 'Start Date must be before Finished Date.';
            document.getElementById('errorMessage').style.display = 'block';
            setTimeout(function() {
                document.getElementById('errorMessage').style.display = 'none';
            }, 5000);
            return false;
        }
    }

    return true;
}

function toggleFinishedDate() {
    var status = document.getElementById('status').value;
    var finishedDateInput = document.getElementById('finished_date');
    if (status === 'FINISHED') {
        finishedDateInput.removeAttribute('readonly');
    } else {
        finishedDateInput.setAttribute('readonly', 'true');
        finishedDateInput.value = '';
    }
}

// Toggle initial state of finished_date input
window.onload = function() {
    toggleFinishedDate();
};
</script>
@endpush
