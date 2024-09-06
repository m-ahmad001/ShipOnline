<!DOCTYPE html>
<html>

<head>
    <title>ShipOnline - Home</title>
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Centered box styling */
        .container {
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: center;
            width: 300px;
        }

        h1 {
            margin-bottom: 20px;
            color: #2c3e50;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        nav ul li {
            margin: 10px 0;
        }

        a {
            text-decoration: none;
            color: #2980b9;
            font-weight: bold;
            display: block;
            padding: 10px;
            background-color: #ecf0f1;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #dff9fb;
        }

        /* Simple footer styling */
        footer {
            margin-top: 20px;
            color: #7f8c8d;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Welcome to ShipOnline</h1>
        <nav>
            <ul>
                <li><a href="login">Login</a></li>
                <li><a href="register">Register</a></li>
                <li><a href="admin">Admin</a></li>
            </ul>
        </nav>
        <footer>
            &copy; 2024 ShipOnline. All rights reserved.
        </footer>
    </div>

</body>

</html>