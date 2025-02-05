<!-- resources/views/errors/403.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unauthorized</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800 min-h-screen flex flex-col items-center justify-center">
    <h1 class="text-4xl font-bold text-red-600">403 - Unauthorized</h1>
    <p class="text-lg mt-4">You do not have permission to access this page.</p>
    <a href="{{ route('login') }}" class="mt-6 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
        Go Back to Login
    </a>
</body>

</html>
