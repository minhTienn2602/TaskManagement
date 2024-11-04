@extends('layouts.app')

@section('title', 'Task-list')

@section('content')
<div class="container-task">
    @if(session('success'))
        <div class="alert alert-success" id="successMessage" style="display: block;">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(function() {
                document.getElementById('successMessage').style.display = 'none';
            }, 5000);
        </script>
    @endif
    <h1 class="text-center">Task List</h1>
    <div class="row">
        <div class="col-md-6">
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="searchInput" placeholder="Nhập từ khóa...">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button" onclick="applyFilters()">Tìm kiếm</button>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <select class="form-control" id="statusFilter" onchange="applyFilters()">
                <option value="all">Tất cả trạng thái</option>
                <option value="TODO">TODO</option>
                <option value="IN PROGRESS">IN PROGRESS</option>
                <option value="FINISHED">FINISHED</option>
            </select>
        </div>
        <div class="col-md-3">
            <select class="form-control" id="categoryFilter" onchange="applyFilters()">
                <option value="all">Tất cả loại công việc</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered task-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Mô tả</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngày hết hạn</th>
                    <th>Ngày hoàn thành</th>
                    <th>Trạng thái</th>
                    <th>Loại công việc</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="taskTableBody">
                @foreach ($tasks as $task)
                    <tr class="taskRow">
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->name }}</td>
                        <td>{{ $task->description }}</td>
                        <td>{{ $task->start_date }}</td>
                        <td>{{ $task->due_date }}</td>
                        <td>{{ $task->finished_date }}</td>
                        <td>{{ $task->status }}</td>
                        <td>{{ $task->category_id }}</td>
                        <td class="action-col">
                            <div class="action-buttons">
                                <button class="btn btn-info btn-sm" onclick="viewTask({{ $task->id }})">View</button>
                                <button class="btn btn-warning btn-sm" onclick="updateTask({{ $task->id }})">Update</button>
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa công việc này?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div id="pagination" class="pagination">
        <!-- Nút Previous và Next sẽ được thêm vào đây -->
    </div>
</div>
@endsection

@push('scripts')
<script>
var tasks = @json($tasks);
var currentPage = 1;
var rowsPerPage = 5;
var selectedStatus = 'all';
var selectedCategory = 'all';
var keyword = '';

function applyFilters() {
    selectedStatus = document.getElementById('statusFilter').value;
    selectedCategory = document.getElementById('categoryFilter').value;
    keyword = document.getElementById('searchInput').value.toLowerCase();
    currentPage = 1;
    displayCurrentPage();
}

function displayCurrentPage() {
    var startIndex = (currentPage - 1) * rowsPerPage;
    var endIndex = startIndex + rowsPerPage;
    var taskTableBody = document.getElementById('taskTableBody');
    taskTableBody.innerHTML = '';
    var filteredTasks = tasks.filter(function(task) {
        var statusMatch = (selectedStatus === 'all' || task.status === selectedStatus);
        var categoryMatch = (selectedCategory === 'all' || task.category_id == selectedCategory);
        var keywordMatch = (task.name.toLowerCase().includes(keyword) || task.description.toLowerCase().includes(keyword));
        return statusMatch && categoryMatch && keywordMatch;
    });

    for (var i = startIndex; i < endIndex && i < filteredTasks.length; i++) {
        var task = filteredTasks[i];
        taskTableBody.innerHTML += `
            <tr class="taskRow">
                <td>${task.id}</td>
                <td>${task.name}</td>
                <td>${task.description}</td>
                <td>${task.start_date}</td>
                <td>${task.due_date}</td>
                <td>${task.finished_date}</td>
                <td>${task.status}</td>
                <td>${task.category_id}</td>
                <td class="action-col">
                    <div class="action-buttons">
                        <button class="btn btn-info btn-sm" onclick="viewTask(${task.id})">View</button>
                        <button class="btn btn-warning btn-sm" onclick="updateTask(${task.id})">Update</button>
                        <form action="/tasks/${task.id}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa công việc này?')">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>`;
    }
    createPaginationButtons(filteredTasks.length);
}

function createPaginationButtons(totalItems) {
    var totalPages = Math.ceil(totalItems / rowsPerPage);
    var paginationDiv = document.getElementById('pagination');
    paginationDiv.innerHTML = '';
    if (totalPages > 1) {
        if (currentPage > 1) {
            paginationDiv.innerHTML += `<button class="btn btn-primary pagination-btn" onclick="previousPage()">Previous</button>`;
        }
        for (var i = 1; i <= totalPages; i++) {
            if (i === currentPage) {
                paginationDiv.innerHTML += `<button class="btn btn-secondary pagination-btn current-page" onclick="goToPage(${i})">${i}</button>`;
            } else {
                paginationDiv.innerHTML += `<button class="btn btn-secondary pagination-btn" onclick="goToPage(${i})">${i}</button>`;
            }
        }
        if (currentPage < totalPages) {
            paginationDiv.innerHTML += `<button class="btn btn-primary pagination-btn" onclick="nextPage()">Next</button>`;
        }
    }
}

function previousPage() {
    if (currentPage > 1) {
        currentPage--;
        displayCurrentPage();
    }
}

function nextPage() {
    var totalPages = Math.ceil(tasks.filter(function(task) {
        var statusMatch = (selectedStatus === 'all' || task.status === selectedStatus);
        var categoryMatch = (selectedCategory === 'all' || task.category_id == selectedCategory);
        var keywordMatch = (task.name.toLowerCase().includes(keyword) || task.description.toLowerCase().includes(keyword));
        return statusMatch && categoryMatch && keywordMatch;
    }).length / rowsPerPage);

    if (currentPage < totalPages) {
        currentPage++;
        displayCurrentPage();
    }
}

function goToPage(page) {
    currentPage = page;
    displayCurrentPage();
}

window.onload = function() {
    displayCurrentPage();
};

function viewTask(id) {
    var baseUrl = window.location.origin;
    window.location.href = `${baseUrl}/tasks/${id}`;
}

function updateTask(id) {
    var baseUrl = window.location.origin;
    window.location.href = `${baseUrl}/tasks/${id}/edit`;
}
document.getElementById('searchInput').addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
        applyFilters();
    }
});
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/tasks/index.css') }}">
@endpush
