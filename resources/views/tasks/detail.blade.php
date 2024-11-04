@extends('layouts.app')

@section('title', 'Task-detail')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/tasks/taskform.css') }}">
@endpush

@section('content')
<div class="task-form">
    <h2>Task Detail {{ $task->id }}</h2>
    <div>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="{{ $task->name }}" readonly>

        <label for="description">Description:</label>
        <textarea id="description" name="description" readonly>{{ $task->description }}</textarea>

        <label for="start_date">Start Date:</label>
        <input type="datetime-local" id="start_date" name="start_date"
            value="{{ date('Y-m-d\TH:i', strtotime($task->start_date)) }}" readonly>

        <label for="due_date">Due Date:</label>
        <input type="datetime-local" id="due_date" name="due_date"
            value="{{ date('Y-m-d\TH:i', strtotime($task->due_date)) }}" readonly>

        <label for="finished_date">Finished Date:</label>
        <input type="datetime-local" id="finished_date" name="finished_date"
            value="{{ date('Y-m-d\TH:i', strtotime($task->finished_date)) }}" readonly>

        <label for="status">Status:</label>
        <input type="text" id="status" name="status" value="{{ $task->status }}" readonly>

        <!-- Back button -->
        <button class="back-button" onclick="history.back()">Back</button>
    </div>
</div>
@endsection
