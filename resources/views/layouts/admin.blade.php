<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - English LMS</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts: Inter & Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-soft: #eef2ff;
            --secondary: #10b981;
            --secondary-soft: #ecfdf5;
            --warning: #f59e0b;
            --warning-soft: #fffbeb;
            --danger: #ef4444;
            --danger-soft: #fef2f2;
            --bg-body: #f8fafc;
            --bg-card: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --sidebar-width: 280px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            overflow-x: hidden;
        }

        h1, h2, h3, h4, .font-outfit {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            color: var(--text-main);
        }

        #wrapper {
            display: flex;
            width: 100%;
        }

        /* Sidebar Styling */
        #sidebar {
            min-width: var(--sidebar-width);
            max-width: var(--sidebar-width);
            background: var(--bg-card);
            border-right: 1px solid var(--border-color);
            min-height: 100vh;
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #sidebar .sidebar-header {
            padding: 2.5rem 1.5rem;
            display: flex;
            align-items: center;
        }

        #sidebar .logo-box {
            width: 40px;
            height: 40px;
            background: var(--primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
            margin-right: 12px;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        #sidebar .logo-text {
            font-family: 'Outfit', sans-serif;
            font-size: 1.25rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--text-main);
        }

        #sidebar ul.components {
            padding: 0 1rem;
        }

        #sidebar ul li {
            margin-bottom: 0.5rem;
        }

        #sidebar ul li a {
            color: var(--text-muted);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 0.85rem 1rem;
            border-radius: 0.75rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        #sidebar ul li a i {
            width: 24px;
            font-size: 1.15rem;
            margin-right: 12px;
            transition: all 0.2s;
        }

        #sidebar ul li a:hover {
            background: var(--primary-soft);
            color: var(--primary);
        }

        #sidebar ul li.active a {
            background: var(--primary);
            color: white;
            box-shadow: 0 8px 16px rgba(79, 70, 229, 0.2);
        }

        /* Main Content Styling */
        #content {
            flex: 1;
            padding: 2rem 3rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .top-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 3rem;
        }

        .user-profile {
            display: flex;
            align-items: center;
            background: white;
            padding: 0.5rem 1rem;
            border-radius: 3rem;
            border: 1px solid var(--border-color);
            cursor: pointer;
            transition: all 0.2s;
        }

        .user-profile:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        /* Card Styling */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 1.25rem;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px -8px rgba(0,0,0,0.1);
        }

        /* Utility Classes */
        .btn-primary {
            background: var(--primary);
            border: none;
            border-radius: 0.75rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
        }

        .btn-primary:hover {
            background: #4338ca;
            transform: translateY(-1px);
        }

        .badge-soft {
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .badge-soft-primary { background: var(--primary-soft); color: var(--primary); }
        .badge-soft-success { background: var(--secondary-soft); color: var(--secondary); }

        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive */
        @media (max-width: 992px) {
            #sidebar { margin-left: calc(-1 * var(--sidebar-width)); }
            #sidebar.active { margin-left: 0; }
            #content { padding: 1.5rem; }
        }
    </style>
    @yield('styles')
</head>
<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <div class="logo-box">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="logo-text text-uppercase">English LMS</div>
            </div>

            <ul class="list-unstyled components">
                <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home-alt"></i> Dashboard</a>
                </li>
                <li class="{{ request()->is('admin/courses*') ? 'active' : '' }}">
                    <a href="{{ route('courses.index') }}"><i class="fas fa-book-open"></i> Courses</a>
                </li>
                <li class="{{ request()->is('admin/levels*') ? 'active' : '' }}">
                    <a href="{{ route('levels.index') }}"><i class="fas fa-layer-group"></i> Levels</a>
                </li>
                <li class="{{ request()->is('admin/lessons*') ? 'active' : '' }}">
                    <a href="{{ route('lessons.index') }}"><i class="fas fa-circle-play"></i> Lessons</a>
                </li>
                <li class="{{ request()->is('admin/quizzes*') ? 'active' : '' }}">
                    <a href="{{ route('quizzes.index') }}"><i class="fas fa-vial-circle-check"></i> Quizzes</a>
                </li>
                <li class="{{ request()->is('admin/students*') ? 'active' : '' }}">
                    <a href="{{ route('students.index') }}"><i class="fas fa-user-group"></i> Students</a>
                </li>
                <li class="mt-5 pt-5 border-top" style="opacity: 0.6">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="text-danger">
                            <i class="fas fa-sign-out-alt"></i> Sign Out
                        </a>
                    </form>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <div class="top-header">
                <button type="button" id="sidebarCollapse" class="btn btn-light d-lg-none">
                    <i class="fas fa-align-left"></i>
                </button>
                <div class="ms-auto user-profile shadow-sm">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4f46e5&color=fff&bold=true" class="rounded-circle me-2" width="28">
                    <span class="fw-semibold small">{{ Auth::user()->name }}</span>
                    <i class="fas fa-chevron-down ms-3 small opacity-50"></i>
                </div>
            </div>

            <div class="container-fluid px-0">
                @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 fade-in" role="alert">
                        <i class="fas fa-circle-check me-2"></i> {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
