<aside class="fixed top-0 left-0 z-50 h-screen w-72 bg-white border-r border-gray-100 flex flex-col transition-transform duration-300 ease-in-out">

    <div class="h-16 flex items-center justify-between px-6 border-b border-gray-100">
        <a href="/admin/dashboard" class="flex items-center gap-3">
            <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                </svg>
            </div>
            <span class="text-xl font-semibold text-gray-900">QuickField</span>
        </a>
    </div>

    <div class="flex-1 overflow-y-auto py-6 px-4 space-y-8">
        <div class="space-y-2">
            <h3 class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                Overview
            </h3>

            <div class="space-y-1">
                <a href="{{  route('admin.dashboard.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors bg-green-50 text-green-700">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.5h8.25V3H3v10.5zm9.75 7.5H21V3h-8.25v18zm-9.75 0h8.25v-4.5H3V21z"/>
                    </svg>
                    <span>Dashboard</span>
                </a>
            </div>
        </div>

        <div class="space-y-2">
            <h3 class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                Management
            </h3>
                <a href="{{ route('admin.fields.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 6l6-3 6 3v12l-6 3-6-3-6 3V6l6-3 6 3"/>
                    </svg>
                    <span>Fields</span>
                </a>
            </div>
        </div>
    </div>

    <div class="p-4 border-t border-gray-100">
        <a href="{{ route('logout') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-600 hover:bg-red-50 hover:text-red-700 transition-colors w-full">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-7.5A2.25 2.25 0 003.75 5.25v13.5A2.25 2.25 0 006 21h7.5a2.25 2.25 0 002.25-2.25V15m-6-3h11.25m0 0l-3.75-3.75M21 12l-3.75 3.75"/>
            </svg>
            <span>Logout</span>
        </a>
    </div>
</aside>