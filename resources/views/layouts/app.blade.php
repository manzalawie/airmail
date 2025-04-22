<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>
    
    <!-- Fontawesome CSS -->
    <link href="{{ asset('css/fontawesome.min.css') }}" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --sidebar-width: 250px;
            --topbar-height: 56px;
        }
        
        body {
            /* padding-top: var(--topbar-height); */
        }

        .navbar{
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        
        .sidebar {
            width: var(--sidebar-width);
            height: calc(100vh - var(--topbar-height));
            position: fixed;
            left: 0;
            top: var(--topbar-height);
            transition: transform 0.3s ease;
            z-index: 1000;
        }
        
        .main-content {
            margin-top: var(--topbar-height);
            margin-left: var(--sidebar-width);
            padding: 20px;
            transition: margin 0.3s ease;
        }
        
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
        }
        
        .welcome-card {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            border: none;
            overflow: hidden;
        }
    </style>
    @stack('styles')
</head>
<body>
    @include('includes.navbar')
    
    @include('includes.sidebar')
    
    <main class="main-content">
        @yield('content')
    </main>
    @yield('content-nonAuthorized')

    <footer class="main-content">
        <div class="container text-center">
            <span class="text-muted">&copy; {{ date('Y') }} Manzalawie. All rights reserved.</span>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <!-- Font Awesome JS (if using JS version) -->
    <script src="{{ asset('js/fontawesome.min.js') }}"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.querySelector('.sidebar-toggle');
            const sidebar = document.querySelector('.sidebar');
            
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>