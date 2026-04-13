  <header class="bg-white sticky top-0 z-50 shadow-sm border-b border-gray-100">
    <div class="w-100% px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
      
      <!-- Logo -->
      <a href="#" class="flex items-center gap-2">
        <div class="w-10 h-10 bg-green-600 rounded-2xl flex items-center justify-center shadow-sm">
          <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/>
          </svg>
        </div>
        <span class="text-2xl font-bold text-gray-900 tracking-tight">QuickField</span>
      </a>

      <!-- Desktop Nav -->
      <nav class="hidden md:flex items-center gap-8">
        <a href="{{ route('public.dashboard.index') }}" class="text-sm font-medium text-green-600">Home</a>
        <a href="{{ route('public.fields.index') }}" class="text-sm font-medium text-gray-600 hover:text-green-600 transition-colors">Explore Fields</a>
      </nav>

      <!-- Desktop Actions -->
      <div class="flex items-center gap-3 sm:gap-4">

        <button class="flex items-center gap-2 pl-2">
            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-sm font-semibold text-green-700 border border-green-200">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <div class="hidden sm:flex flex-col items-start mr-1">
                <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                <span class="text-xs text-gray-500">{{ auth()->user()->email }}</span>
            </div>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/>
            </svg>
        </button>
    </div>

      <!-- Mobile Menu Icon Static -->
      <button class="md:hidden p-2 text-gray-600 rounded-xl hover:bg-gray-100">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
    </div>

    <!-- Mobile Nav Static -->
    <div class="md:hidden bg-white border-t border-gray-100 px-4 pt-4 pb-6 space-y-4">
      <a href="{{ route('public.dashboard.index') }}" class="block px-3 py-3 rounded-xl text-base font-medium text-green-600 bg-green-50">Home</a>
      <a href="" class="block px-3 py-3 rounded-xl text-base font-medium text-gray-700 hover:text-green-600 hover:bg-green-50">Explore Fields</a>

      <div class="pt-4 border-t border-gray-100 flex flex-col gap-3">
        <a href="{{ route('logout') }}" class="w-full rounded-xl h-12 border border-gray-200 inline-flex items-center justify-center text-red-700 font-medium">
          Logout
        </a>
      </div>
    </div>
  </header>