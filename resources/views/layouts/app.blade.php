<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <title>@yield('title', 'Welcome to Newtrition') - {{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-hover: #1d4ed8;
            --secondary-color: #64748b;
            --accent-color: #f59e0b;
            --background-color: #f8fafc;
            --card-background: #ffffff;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --border-color: #e2e8f0;
        }

        body, html {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            height: 100%;
            background-color: var(--background-color);
            color: var(--text-primary);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            padding-bottom: 100px;
        }

        header {
            background-color: var(--card-background);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        header img {
            height: 50px;
            max-width: 160px;
            object-fit: contain;
        }

        nav ul {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 1.5rem;
            align-items: center;
        }

        nav ul li a, nav ul li button {
            color: var(--text-primary);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
        }

        nav ul li a:hover, nav ul li button:hover {
            color: var(--primary-color);
            background-color: rgba(37, 99, 235, 0.1);
        }

        .logout-button {
            color: #ef4444 !important;
        }

        .logout-button:hover {
            background-color: rgba(239, 68, 68, 0.1) !important;
        }

        main {
            padding: 2rem 0;
        }

        .card {
            background-color: var(--card-background);
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .welcome-section {
            text-align: center;
            padding: 4rem 2rem;
            background-color: var(--card-background);
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin: 2rem auto;
            max-width: 800px;
        }

        .welcome-section h1 {
            color: var(--primary-color);
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .welcome-section p {
            font-size: 1.125rem;
            color: var(--text-secondary);
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
        }

        footer {
            background-color: var(--card-background);
            color: var(--text-secondary);
            text-align: center;
            padding: 1.5rem;
            position: fixed;
            width: 100%;
            bottom: 0;
            box-shadow: 0 -1px 3px rgba(0, 0, 0, 0.1);
        }

        footer p {
            margin: 0;
            font-size: 0.875rem;
        }

        footer a {
            color: var(--primary-color);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        footer a:hover {
            color: var(--primary-hover);
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1rem;
            }

            nav ul {
                flex-direction: column;
                gap: 0.5rem;
            }

            .welcome-section {
                padding: 2rem 1rem;
            }

            .welcome-section h1 {
                font-size: 2rem;
            }
        }
        /* --- DARK MODE VARIABLES --- */
        body.dark-mode {
            --primary-color: #60a5fa;
            --primary-hover: #3b82f6;
            --secondary-color: #94a3b8;
            --accent-color: #fbbf24;
            --background-color: #18181b;
            --card-background: #27272a;
            --text-primary: #f1f5f9;
            --text-secondary: #a1a1aa;
            --border-color: #27272a;
        }
        body.dark-mode, body.dark-mode html {
            background-color: var(--background-color) !important;
            color: var(--text-primary) !important;
        }
        body.dark-mode header, body.dark-mode footer {
            background-color: var(--card-background) !important;
            color: var(--text-secondary) !important;
        }
        body.dark-mode .card, body.dark-mode .welcome-section {
            background-color: var(--card-background) !important;
            color: var(--text-primary) !important;
        }
        body.dark-mode nav ul li a, body.dark-mode nav ul li button {
            color: var(--text-primary) !important;
        }
        body.dark-mode nav ul li a:hover, body.dark-mode nav ul li button:hover {
            color: var(--primary-color) !important;
            background-color: rgba(96, 165, 250, 0.1) !important;
        }
        body.dark-mode .btn-primary {
            background-color: var(--primary-color) !important;
            color: #fff !important;
        }
        body.dark-mode .btn-primary:hover {
            background-color: var(--primary-hover) !important;
        }
        body.dark-mode .logout-button {
            color: #f87171 !important;
        }
        body.dark-mode .logout-button:hover {
            background-color: rgba(248, 113, 113, 0.1) !important;
        }
        /* --- END DARK MODE --- */

        /* Exercise Tracker Styles */
        .btn-secondary {
            background-color: var(--secondary-color);
            color: white;
        }

        .btn-secondary:hover {
            background-color: #475569;
            transform: translateY(-1px);
        }

        .grid {
            display: grid;
        }

        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }

        @media (min-width: 768px) {
            .md\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        .gap-6 {
            gap: 1.5rem;
        }

        .space-y-6 > * + * {
            margin-top: 1.5rem;
        }

        .rounded-md {
            border-radius: 0.375rem;
        }

        .border-gray-300 {
            border-color: #d1d5db;
        }

        .shadow-sm {
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .focus\:border-primary-500:focus {
            border-color: var(--primary-color);
        }

        .focus\:ring-primary-500:focus {
            --tw-ring-color: var(--primary-color);
        }

        .dark .dark\:bg-gray-700 {
            background-color: #374151;
        }

        .dark .dark\:border-gray-600 {
            border-color: #4b5563;
        }

        .dark .dark\:text-white {
            color: #ffffff;
        }

        .dark .dark\:text-gray-300 {
            color: #d1d5db;
        }

        .dark .dark\:text-gray-400 {
            color: #9ca3af;
        }

        .dark .dark\:text-gray-100 {
            color: #f3f4f6;
        }

        .dark .dark\:bg-gray-800 {
            background-color: #1f2937;
        }

        .dark .dark\:divide-gray-600 > * + * {
            border-color: #4b5563;
        }

        .dark .dark\:hover\:bg-gray-700:hover {
            background-color: #374151;
        }

        body.dark-mode .container {
            background-color: var(--background-color);
            color: var(--text-primary);
        }

        body.dark-mode main {
            background-color: var(--background-color);
            color: var(--text-primary);
        }

        body.dark-mode .card {
            background-color: var(--card-background);
            color: var(--text-primary);
        }

        body.dark-mode .welcome-section {
            background-color: var(--card-background);
            color: var(--text-primary);
        }

        body.dark-mode .welcome-section h1 {
            color: var(--primary-color);
        }

        body.dark-mode .welcome-section p {
            color: var(--text-secondary);
        }

        /* Ensure all text in dark mode is visible */
        body.dark-mode {
            color: var(--text-primary);
        }

        body.dark-mode h1, 
        body.dark-mode h2, 
        body.dark-mode h3, 
        body.dark-mode h4, 
        body.dark-mode h5, 
        body.dark-mode h6 {
            color: var(--text-primary);
        }

        body.dark-mode p {
            color: var(--text-secondary);
        }

        /* Fix dashboard specific styles */
        body.dark-mode .dashboard-stats {
            background-color: var(--card-background);
            color: var(--text-primary);
        }

        body.dark-mode .stat-card {
            background-color: var(--card-background);
            color: var(--text-primary);
            border-color: var(--border-color);
        }

        body.dark-mode .stat-value {
            color: var(--primary-color);
        }

        body.dark-mode .stat-label {
            color: var(--text-secondary);
        }

        /* Fix profile specific styles */
        body.dark-mode .profile-container {
            background-color: var(--card-background);
            color: var(--text-primary);
        }

        body.dark-mode .profile-section {
            background-color: var(--card-background);
            color: var(--text-primary);
            border-color: var(--border-color);
        }

        body.dark-mode .profile-label {
            color: var(--text-secondary);
        }

        body.dark-mode .profile-value {
            color: var(--text-primary);
        }
    </style>
</head>
<body>
    @auth
    <header>
        <div class="header-content">
            <img src="{{ asset('images/newtrition_logo.png') }}" alt="Newtrition Logo">
            <button id="darkModeToggle" aria-label="Toggle dark mode" style="background:none;border:none;cursor:pointer;font-size:1.5rem;margin-right:1rem;" title="Toggle dark mode">
                <i id="darkModeIcon" class="fas fa-moon"></i>
            </button>
            <nav>
                <ul>
                    <li><a href="{{ route('food.search') }}"><i class="fas fa-search"></i> Food Search</a></li>
                    <li><a href="{{ route('food.entries') }}">Food Entries</a></li> 
                    <li><a href="{{ route('exercises.index') }}"><i class="fas fa-running"></i> Exercise Tracker</a></li>
                    <li><a href="{{ route('dashboard') }}"><i class="fas fa-chart-line"></i> Dashboard</a></li>
                    <li><a href="{{ route('profile') }}"><i class="fas fa-user"></i> Profile</a></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="logout-button"><i class="fas fa-sign-out-alt"></i> Logout</button>
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    @endauth

    <main>
        <div class="container">
            @yield('content')
        </div>
    </main>

    <footer>
        <p>&copy; 2025 Newtrition. All rights reserved. |
            <a href="#">Privacy Policy</a> |
            <a href="#">Terms of Service</a>
        </p>
    </footer>
    <script>
        // Dark mode toggle logic
        function setDarkMode(enabled) {
            if (enabled) {
                document.body.classList.add('dark-mode');
                document.getElementById('darkModeIcon').classList.remove('fa-moon');
                document.getElementById('darkModeIcon').classList.add('fa-sun');
            } else {
                document.body.classList.remove('dark-mode');
                document.getElementById('darkModeIcon').classList.remove('fa-sun');
                document.getElementById('darkModeIcon').classList.add('fa-moon');
            }
        }
        // On load, set mode from localStorage or system preference
        (function() {
            const saved = localStorage.getItem('darkMode');
            const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            setDarkMode(saved === 'true' || (saved === null && prefersDark));
        })();
        document.getElementById('darkModeToggle').addEventListener('click', function() {
            const isDark = document.body.classList.contains('dark-mode');
            setDarkMode(!isDark);
            localStorage.setItem('darkMode', String(!isDark));
        });
    </script>
</body>
</html>
