<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - QuickField</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-50 min-h-screen flex">

    <div class="w-full lg:w-1/2 flex flex-col relative p-8 md:p-12">
        <a href="{{ url('/') }}" class="absolute top-8 left-8 flex items-center gap-2 text-sm text-gray-500 hover:text-gray-800 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Back to Home
        </a>

        <div class="flex-1 flex flex-col justify-center items-center">
            <div class="bg-white w-full max-w-md p-8 rounded-3xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-2 mb-8">
                    <div class="flex items-center justify-center w-8 h-8 bg-green-500 rounded-full text-white font-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <span class="text-xl font-semibold text-gray-800">QuickField</span>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 mb-2">Welcome back</h2>
                <p class="text-sm text-gray-500 mb-8">Login to access your account and book fields</p>

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            </div>
                            <input type="email" name="email" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 sm:text-sm transition" placeholder="your@email.com" required>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-sm font-medium text-gray-700">Password</label>
                            <a href="#" class="text-xs text-green-600 hover:text-green-500 font-medium">Forgot password?</a>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                            <input type="password" name="password" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 sm:text-sm transition" placeholder="••••••••" required>
                        </div>
                    </div>

                    <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
                        Login
                    </button>
                </form>

                <div class="mt-8 relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Or continue with</span>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-2 gap-3">
                    <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                        Google
                    </a>
                    <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                        Facebook
                    </a>
                </div>

                <p class="mt-8 text-center text-sm text-gray-600">
                    Don't have an account? <a href="{{ route('register') }}" class="font-medium text-green-600 hover:text-green-500">Sign up</a>
                </p>
            </div>
        </div>
    </div>

    <div class="hidden lg:flex lg:w-1/2 relative bg-green-600 items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1529900965600-058862ef2a02?auto=format&fit=crop&q=80')] bg-cover bg-center mix-blend-overlay opacity-30"></div>
        
        <div class="relative z-10 text-center px-12 max-w-lg">
            <h2 class="text-4xl font-bold text-white mb-4">Your Game Awaits</h2>
            <p class="text-green-50 text-lg mb-12">Access premium football fields across the city. Book instantly, play immediately.</p>
            
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-white/10 backdrop-blur-sm p-4 rounded-xl border border-white/20">
                    <h3 class="text-2xl font-bold text-white mb-1">24/7</h3>
                    <p class="text-xs text-green-100">Availability</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm p-4 rounded-xl border border-white/20">
                    <h3 class="text-2xl font-bold text-white mb-1">50+</h3>
                    <p class="text-xs text-green-100">Locations</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm p-4 rounded-xl border border-white/20">
                    <h3 class="text-2xl font-bold text-white mb-1">Fast</h3>
                    <p class="text-xs text-green-100">Booking</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>