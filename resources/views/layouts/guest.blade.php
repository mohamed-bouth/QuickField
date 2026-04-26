<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QuickField</title>

    <script src="https://cdn.tailwindcss.com"></script>
    
    </head>
<body class="font-sans antialiased text-gray-900 bg-white">

    <nav class="flex items-center justify-between px-8 py-4 border-b border-gray-100">
        <div class="flex items-center gap-2">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center">
                <img class=rounded src="https://pub-bd8291a7790f4b588b9daf7b1db26e25.r2.dev/app-image/ChatGPT%20Image%20Apr%2026%2C%202026%2C%2002_47_10%20PM.png" alt="">
            </div>
            <span class="text-xl font-semibold text-gray-800">QuickField</span>
        </div>
        
        <div class="flex items-center gap-6">
            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-green-600 transition">Login</a>
            <a href="{{ route('register') }}" class="px-5 py-2 text-sm font-medium text-white bg-green-500 rounded-full hover:bg-green-600 transition">Sign Up</a>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="py-8 bg-[#111827]">
        <div class="flex flex-col items-center justify-center gap-4">
            <div class="flex items-center gap-2">
                <div class="flex items-center justify-center w-6 h-6 bg-green-500 rounded-full text-white font-bold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <span class="text-lg font-semibold text-white">QuickField</span>
            </div>
            <p class="text-sm text-gray-400">© 2026 QuickField. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>