<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item {{ request()->routeIs('home.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('home.index') }}">Home</a>
                </li>
                <li class="nav-item {{ request()->routeIs('tasks.create') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('tasks.create') }}">Thêm công việc</a>
                </li>
                <li class="nav-item {{ request()->routeIs('tasks.index','tasks.detail','tasks.edit') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('tasks.index') }}">Danh sách công việc</a>
                </li>
                <li class="nav-item {{ request()->routeIs('categories.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('categories.index') }}">Quản lý Category</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
