<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - QuickField</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 flex flex-col font-sans text-gray-900 selection:bg-green-100 selection:text-green-900">

    @include('admin.partials.sidebar')

    <div class="flex-1 lg:pl-72 flex flex-col min-h-screen transition-all duration-300">
        @include('admin.partials.topbar')

        <main class="flex-1 p-4 sm:p-6 lg:p-8 w-full max-w-[1600px] mx-auto overflow-x-hidden">
            @yield('content')
        </main>
    </div>

</body>
</html>