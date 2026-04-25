<header class="sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-gray-100 flex h-16 w-full items-center justify-between px-4 sm:px-6">
    <div class="flex items-center gap-4 flex-1">
        <button id="mobileMenuBtn" class="lg:hidden p-2 -ml-2 text-gray-500 hover:text-green-600 rounded-lg hover:bg-green-50 transition-colors">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <div class="hidden sm:flex relative w-full max-w-md">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input
                type="text"
                placeholder="Chercher des réservations, terrains..."
                class="w-full bg-gray-50 border border-transparent focus:bg-white focus:border-green-500 focus:ring-green-500 rounded-xl pl-10 pr-4 py-2 outline-none text-sm transition-all"
            >
        </div>
    </div>

    <div class="flex items-center gap-2 sm:gap-4">

        @can('scan-qr-code')
        <a href="{{ route('admin.scan-ticket.index') }}" class="hidden sm:flex items-center gap-2 bg-green-50 text-green-700 hover:bg-green-100 px-3 py-1.5 rounded-lg text-sm font-semibold transition-colors border border-green-200">
            <i class="fas fa-qrcode"></i>
            <span>Scanner</span>
        </a>
        @endcan

        <button class="relative p-2 text-gray-400 hover:text-green-600 rounded-full hover:bg-gray-50 transition-colors">
            <span class="absolute top-1.5 right-1.5 block h-2.5 w-2.5 rounded-full bg-red-500 ring-2 ring-white"></span>
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
            </svg>
        </button>

        <div class="h-6 w-px bg-gray-200 hidden sm:block mx-1"></div>

        <div class="relative">
            <button id="profileDropdownBtn" class="flex items-center gap-2 hover:bg-gray-50 p-1 pr-2 rounded-xl transition-colors">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center text-sm font-bold text-green-700 border border-green-300 shadow-sm">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="hidden sm:flex flex-col items-start mr-1">
                    <span class="text-sm font-bold text-gray-700 leading-none">{{ auth()->user()->name ?? 'Admin' }}</span>
                    <span class="text-[11px] text-gray-500 mt-0.5 capitalize">{{ auth()->user()->roles->first()->name ?? 'Utilisateur' }}</span>
                </div>
                <svg id="profileChevron" class="w-4 h-4 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/>
                </svg>
            </button>

            <div id="profileDropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50 transition-all duration-200 origin-top-right">
                
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition-colors">
                    <i class="far fa-user w-5 text-gray-400"></i> Mon Profil
                </a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition-colors">
                    <i class="fas fa-cog w-5 text-gray-400"></i> Paramètres
                </a>
                
                <div class="border-t border-gray-100 my-1"></div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                        <i class="fas fa-sign-out-alt w-5"></i> Déconnexion
                    </button>
                </form>
            </div>
        </div>

    </div>
</header>
