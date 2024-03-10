<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css','resources/js/app.js'])

    <title>Document</title>
</head>
<body>
    <!-- Header -->
    <header class="sticky top-0 z-40 bg-gray-800 text-white p-5">
        <div class="mx-auto">
            <h1 class="text-3xl font-semibold">Blog - Posts</h1>
        </div>
    </header>

    {{ $slot }}

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-5 px-5 text-center">
        <div class="mx-auto">
            <p>&copy; 2024 Blog - All rights reserved</p>
        </div>
    </footer>
</body>
</html>
