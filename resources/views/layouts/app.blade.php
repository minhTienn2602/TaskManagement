<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Your Website')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    @stack('styles') <!-- Đảm bảo stack styles được sử dụng ở đây -->
</head>
<body>
    <header>
        @include('layouts.header')
    </header>

    <main class="container">
        @yield('content')
    </main>

    <footer>
        @include('layouts.footer')
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const middlewareMessage = "{{ session('middleware_message') }}";
            if (middlewareMessage) {
                console.log(middlewareMessage);
            }
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    @stack('scripts') <!-- Đảm bảo stack scripts được sử dụng ở đây -->
</body>
</html>
