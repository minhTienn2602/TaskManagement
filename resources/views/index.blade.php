@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="text-center mt-5">
    <h1>Chào mừng bạn đến với hệ thống quản lý công việc</h1>
    <p class="lead">Hãy bắt đầu quản lý công việc của bạn ngay bây giờ!</p>
    <button class="btn btn-lg btn-custom" onclick="window.location.href='{{ route('tasks.create') }}'">Thêm công việc mới</button>
</div>
@endsection
