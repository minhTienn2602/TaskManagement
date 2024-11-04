@extends('layouts.app')

@section('title', 'Add Task')

@section('content')
<div class="task-form">
    <h2>Thêm công việc</h2>
    <form id="addForm" action="{{ route('tasks.store') }}" method="post" onsubmit="return validateForm()">
        @csrf
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" class="form-control" required>{{ old('description') }}</textarea>

        <label for="start_date">Start Date:</label>
        <input type="datetime-local" id="start_date" name="start_date" class="form-control" value="{{ old('start_date') }}" required>

        <label for="due_date">Due Date:</label>
        <input type="datetime-local" id="due_date" name="due_date" class="form-control" value="{{ old('due_date') }}" required>

        <label for="category">Category:</label>
        <select id="category" name="category_id" class="form-control">
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        <input type="submit" value="Add Task" class="btn btn-primary">
        <p id="errorMessage" class="error-message" style="display:none; color: red;"></p>
        <p id="successMessage" class="success-message" style="display:none; color: green;"></p>
    </form>

    <button class="back-button btn btn-secondary" onclick="history.back()">Back</button>
</div>
@endsection

@push('scripts')
<script>
function validateForm() {
    var name = document.getElementById('name').value.trim();
    var description = document.getElementById('description').value.trim();
    var startDate = new Date(document.getElementById('start_date').value);
    var dueDate = new Date(document.getElementById('due_date').value);
    var errorMessage = document.getElementById('errorMessage');

    if (name === '' || description === '') {
        errorMessage.innerText = 'Name and Description cannot be empty.';
        errorMessage.style.display = 'block';
        setTimeout(() => errorMessage.style.display = 'none', 5000);
        return false;
    }

    if (startDate >= dueDate) {
        errorMessage.innerText = 'Start Date must be before Due Date.';
        errorMessage.style.display = 'block';
        setTimeout(() => errorMessage.style.display = 'none', 5000);
        return false;
    }

    return true;
}
</script>
@endpush



@push('styles')
    <link rel="stylesheet" href="{{ asset('css/tasks/taskform.css') }}">
@endpush