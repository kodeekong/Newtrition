<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Welcome to Newtrition')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        /* Global Styles */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #F2F7F6;
            color: #333;
        }

        /* Header Section */
        header {
            background-color: #2F6F76; /* Turquoise */
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 36px;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* Navigation Bar */
        nav ul {
            display: flex;
            justify-content: center;
            list-style: none;
            margin: 20px 0;
            padding: 0;
        }

        nav ul li {
            margin: 0 20px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 18px;
            transition: color 0.3s ease;
        }

        nav ul li a:hover {
            color: #B65449; /* Maroon */
        }

        /* Main Content */
        main {
            padding: 40px 20px;
        }

        /* Footer Section */
        footer {
            background-color: #2F6F76; /* Turquoise */
            color: white;
            text-align: center;
            padding: 20px;
            position: fixed;
            width: 100%;
            bottom: 0;
        }

        footer p {
            margin: 0;
        }

        /* Welcome Section */
        .welcome-section {
            text-align: center;
            padding: 60px 20px;
            background-color: #FFFFFF;
            border-radius: 8px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
            margin-top: 80px;
        }

        .welcome-section h1 {
            color: #2F6F76; /* Turquoise */
            font-size: 48px;
            margin-bottom: 20px;
        }

        .welcome-section p {
            font-size: 18px;
            color: #555;
            margin-bottom: 30px;
        }

        .cta-buttons .btn {
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 5px;
            font-weight: 600;
            margin: 10px;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .cta-buttons .btn-primary {
            background-color: #2F6F76; /* Turquoise */
            color: white;
        }

        .cta-buttons .btn-primary:hover {
            background-color: #B65449; /* Maroon */
        }

        .cta-buttons .btn-secondary {
            background-color: #B65449; /* Maroon */
            color: white;
        }

        .cta-buttons .btn-secondary:hover {
            background-color: #2F6F76; /* Turquoise */
        }

    </style>
</head>
<body>

    <!-- Header Section -->
    <header>
        <h1>Newtrition</h1>
        @auth
            <nav>
                <ul>
                    <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li><a href="{{ route('meal-log.index') }}">Meal Log</a></li>
                    <li><a href="{{ route('goals.index') }}">Goals</a></li>
                    <li><a href="{{ route('profile.show') }}">Profile</a></li>
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                </ul>
            </nav>
        @else
            <nav>
                <ul>
                    <li><a href="{{ route('register') }}">Sign Up</a></li>
                    <li><a href="{{ route('login') }}">Login</a></li>
                </ul>
            </nav>
        @endauth
    </header>

    <!-- Main Content Section -->
    <main>
        @yield('content') <!-- Content from individual views will be injected here -->
    </main>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2025 Newtrition. All rights reserved.</p>
    </footer>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

</body>
</html>
