<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <title>@yield('title', 'Welcome to Newtrition')</title>
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
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <img src="{{ asset('images/newtrition_logo.png') }}" alt="Newtrition Logo">
            @auth
                <nav>
                    <ul>
                        <li><a href="{{ route('food.search') }}"><i class="fas fa-search"></i> Food Search</a></li>
                        <li><a href="{{ route('food.entries') }}">Food Entries</a></li> 
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
            @else
                <nav>
                    <ul>
                        <li><a href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                        <li><a href="{{ route('register') }}" class="btn btn-primary"><i class="fas fa-user-plus"></i> Register</a></li>
                    </ul>
                </nav>
            @endauth
        </div>
    </header>

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
</body>
</html>
