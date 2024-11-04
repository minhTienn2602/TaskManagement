@extends('layouts.app')

@section('title', 'Category-list')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success" id="successMessage">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(function() {
                document.getElementById('successMessage').style.display = 'none';
            }, 5000);
        </script>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" id="errorMessage">
            {{ session('error') }}
        </div>
        <script>
            setTimeout(function() {
                document.getElementById('errorMessage').style.display = 'none';
            }, 5000);
        </script>
    @endif
    <h1 class="center">Category list</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Date Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->date_created }}</td>
                <td>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc xóa loại công việc này không?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="row">
        <div class="col-md-6">
            <form id="addCategoryForm" action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="categoryName" name="name" placeholder="Enter new category name" required>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Add</button>
                    </div>
                </div>
                <div id="error-message" class="text-danger" style="display: none;"></div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var existingCategoryNames = @json($categoryNames);

    document.getElementById('addCategoryForm').addEventListener('submit', function(event) {
        var categoryName = document.getElementById('categoryName').value.trim();
        var errorMessage = document.getElementById('error-message');
        errorMessage.style.display = 'none';

        if (categoryName === '') {
            errorMessage.textContent = 'Category name cannot be empty';
            errorMessage.style.display = 'block';
            setTimeout(function() {
                errorMessage.style.display = 'none';
            }, 5000);
            event.preventDefault();
            return;
        }

        if (existingCategoryNames.includes(categoryName)) {
            errorMessage.textContent = 'Category name already exists';
            errorMessage.style.display = 'block';
            setTimeout(function() {
                errorMessage.style.display = 'none';
            }, 5000);
            event.preventDefault();
            return;
        }
    });
});
</script>
@endpush

@push('styles')
<style>
.center {
    text-align: center;
}

.back-button {
    margin-bottom: 20px;
}
</style>
@endpush
