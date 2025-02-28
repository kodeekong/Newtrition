<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Welcome to Newtrition')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: 'avenir';
            margin: 0;
            padding: 0;
            background-color: #F2F7F6;
            color: #333;
        }

        header {
    background-color: #4195be; /* Turquoise */
    color: white;
    padding: 10px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

header img {
    height: 75px; /* Adjust the height of the logo */
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


        main {
            padding: 40px 20px;
        }

        /* Footer Section */
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
            background-color: #4195be; /* Turquoise */
            color: white;
        }

        .cta-buttons .btn-primary:hover {
            background-color: #B65449; /* Maroon */
        }

        .cta-buttons .btn-secondary {
            background-color: #4195be; /* Maroon */
            color: white;
        }

        .cta-buttons .btn-secondary:hover {
            background-color: #B65449; /* Turquoise */
        }

        .img {

        }

    </style>
</head>
<body>

    <header>
        <img src="{{ asset('images/newtrition_logo.png') }}" alt="Newtrition Logo">
        @auth
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

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

</body>
</html>
