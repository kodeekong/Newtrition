<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <title>@yield('title', 'Welcome to Newtrition')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        /* General body and layout styling */
        body {
            font-family: 'avenir';
            margin: 0;
            padding: 0;
            background-color: #F2F7F6;
            color: #333;
        }

        /* Header styling */
        header {
            background-color: #4195be; /* Turquoise */
            color: white;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        header img {
            height: 75px;
            max-width: 180px;
            object-fit: contain;
        }

        nav ul {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            transition: color 0.3s ease;
        }

        nav ul li a:hover {
            color: #B65449; /* Maroon */
        }

        /* Logout Button Styling */
        .logout-button {
            background-color: #B65449; /* Maroon */
            color: white;
            padding: 10px 20px;
            font-weight: 600;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .logout-button:hover {
            background-color: #4195be; /* Turquoise */
        }

        /* Main content styling */
        main {
            padding: 40px 20px;
        }

        /* Footer section */
        footer {
            background-color: #4195be; /* Turquoise */
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

        .welcome-section {
            text-align: center;
            padding: 60px 20px;
            background-color: #FFFFFF;
            border-radius: 8px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
            margin-top: 80px;
        }

        .welcome-section h1 {
            color: #4195be; /* Turquoise */
            font-size: 48px;
            margin-bottom: 20px;
        }

        .welcome-section p {
            font-size: 18px;
            color: #555;
            margin-bottom: 30px;
        }

    </style>
</head>
<body>

    <header>
        <img src="{{ asset('images/newtrition_logo.png') }}" alt="Newtrition Logo">
        @auth
            <nav>
                <ul>
                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('profile') }}">Profile</a></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="logout-button">Logout</button>
                        </form>
                    </li>
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

    <main>
        @yield('content') 
    </main>

    <footer>
        <p>&copy; 2025 Newtrition. All rights reserved.</p>
    </footer>

</body>
</html>
