<header class="bg-white/90 backdrop-blur-md sticky top-0 z-50 shadow-sm border-b border-gray-100 transition-all">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
      
        <a href="#" class="flex items-center gap-3 group">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center">
                <img class=rounded src="https://pub-bd8291a7790f4b588b9daf7b1db26e25.r2.dev/app-image/ChatGPT%20Image%20Apr%2026%2C%202026%2C%2002_47_10%20PM.png" alt="">
            </div>
            <span class="text-xl font-bold text-gray-900 tracking-tight">QiuckField</span>
        </a>

        <nav class="hidden md:flex items-center gap-8">
            <a href="{{ route('public.dashboard.index') }}" class="text-sm font-semibold text-green-600 relative after:content-[''] after:absolute after:-bottom-1.5 after:left-0 after:w-full after:h-0.5 after:bg-green-600 after:rounded-full">Home</a>
            <a href="{{ route('public.fields.index') }}" class="text-sm font-medium text-gray-600 hover:text-green-600 transition-colors">Explore Fields</a>
            <a href="{{ route('public.reservations.history') }}" class="text-sm font-medium text-gray-600 hover:text-green-600 transition-colors">My Reservations</a>
        </nav>

        <div class="hidden md:flex items-center gap-3 sm:gap-4">
            <div class="relative">
                <button id="publicProfileBtn" class="flex items-center gap-2 p-1.5 pr-3 hover:bg-gray-50 rounded-xl transition-colors border border-transparent hover:border-gray-100">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center text-sm font-bold text-green-700 border border-green-300 shadow-sm">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="flex flex-col items-start mr-1">
                        <span class="text-sm font-bold text-gray-700 leading-none">{{ auth()->user()->name ?? 'Utilisateur' }}</span>
                        <span class="text-[11px] text-gray-500 mt-0.5">{{ auth()->user()->email ?? 'user@email.com' }}</span>
                    </div>
                    <svg id="publicProfileChevron" class="w-4 h-4 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/>
                    </svg>
                </button>

                <div id="publicProfileMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg shadow-gray-200/50 border border-gray-100 py-1 z-50 origin-top-right">
                    <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition-colors">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                        My Profile
                    </a>
                    
                    <div class="border-t border-gray-100 my-1"></div>
                    
                    <form action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-7.5A2.25 2.25 0 003.75 5.25v13.5A2.25 2.25 0 006 21h7.5a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/></svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <button id="mobileNavToggle" class="md:hidden p-2 text-gray-600 rounded-xl hover:bg-gray-100 transition-colors">
            <svg id="hamburgerIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <svg id="closeIcon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <div id="mobileNavMenu" class="hidden md:hidden bg-white border-t border-gray-100 absolute w-full shadow-lg shadow-gray-100/50">
        <div class="px-4 pt-4 pb-6 space-y-2">
            <a href="{{ route('public.dashboard.index') }}" class="block px-4 py-3 rounded-xl text-base font-semibold text-green-700 bg-green-50">Home</a>
            <a href="{{ route('public.fields.index') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:text-green-600 hover:bg-green-50 transition-colors">Explore Fields</a>
            <a href="{{ route('public.reservations.history') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:text-green-600 hover:bg-green-50 transition-colors">My Reservations</a>

            <div class="pt-4 mt-2 border-t border-gray-100">
                <div class="flex items-center gap-3 px-4 py-3 mb-2">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center font-bold text-green-700">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <div>
                        <div class="font-bold text-gray-800">{{ auth()->user()->name ?? 'Utilisateur' }}</div>
                        <div class="text-xs text-gray-500">{{ auth()->user()->email ?? 'user@email.com' }}</div>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full rounded-xl h-12 bg-red-50 text-red-600 hover:bg-red-100 inline-flex items-center justify-center font-semibold transition-colors">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
<script>
  
</script>