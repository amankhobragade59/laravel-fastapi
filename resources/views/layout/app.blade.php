<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1e1e2f;
            color: #e0e0e0;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 2.5rem auto;
            padding: 2rem;
            background-color: #2a2a40;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.6);
        }

        /* Dashboard Header */
        .dashboard-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
        }

        .dashboard-header h1 {
            font-size: 26px;
            font-weight: 600;
            letter-spacing: 1px;
            color: #ffffff;
            margin: 0;
        }

        /* Navigation buttons */
        .nav-buttons {
            display: flex;
            gap: 12px;
        }

        .nav-buttons a {
            padding: 8px 18px;
            background-color: #1e90ff;
            color: #ffffff;
            border-radius: 20px;
            font-size: 14px;
            text-decoration: none;
            transition: background 0.2s ease, transform 0.2s ease;
        }

        .nav-buttons a:hover {
            background-color: #187bcd;
            transform: translateY(-1px);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid #444;
        }

        th {
            background-color: #333;
        }

        button {
            background-color: #444;
            color: #e0e0e0;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #555;
        }
    </style>

    @yield('styles')
</head>
<body>

<div class="container">

    <div class="dashboard-header">
        <h1>Dashboard</h1>

        <div class="nav-buttons">
            <a href="{{ route('users.index') }}">Users</a>
            <a href="{{ route('todos.index') }}">Todos</a>
            <a href="{{ route('posts.index') }}">Posts</a>
        </div>
    </div>

    @yield('content')

</div>

@yield('scripts')
</body>
</html>
