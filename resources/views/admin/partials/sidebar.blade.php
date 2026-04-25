<div id="sidebarOverlay" class="fixed inset-0 bg-gray-900/50 z-40 hidden lg:hidden transition-opacity duration-300 backdrop-blur-sm"></div>

<aside id="sidebar" class="fixed top-0 left-0 z-50 h-screen w-72 bg-white border-r border-gray-100 flex flex-col shadow-sm transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0">

    <div class="h-20 flex items-center justify-between px-6 border-b border-gray-50">
        <a href="/admin/dashboard" class="flex items-center gap-3 group">
            <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-md shadow-green-200 transition-transform group-hover:scale-105">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75"/>
                </svg>
            </div>
            <span class="text-xl font-bold text-gray-800 tracking-tight">QuickField</span>
        </a>
        
        <button id="closeSidebarBtn" class="lg:hidden p-2 text-gray-400 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <div class="flex-1 overflow-y-auto py-6 px-4 space-y-8 sidebar-scroll">
        
        <div class="space-y-2">
            <h3 class="px-3 text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">
                Overview
            </h3>

            <div class="space-y-1">
                @canany(['manager.dashboard.view', 'finance.dashboard.view', 'guard.mobile.access'])
                    <a href="{{ route('admin.dashboard.index') }}"
                       class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 text-gray-600 hover:bg-green-50 hover:text-green-700">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-green-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.5h8.25V3H3v10.5zm9.75 7.5H21V3h-8.25v18zm-9.75 0h8.25v-4.5H3V21z"/>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                @endcanany
            </div>
        </div>

        @canany(['fields.manage', 'staff.manage', 'users.blacklist.manage', 'planning.daily.view', 'manager-requests.review', 'scan-qr-code'])
            <div class="space-y-2">
                <h3 class="px-3 text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">
                    Management
                </h3>
                
                @can('fields.manage')
                    <a href="{{ route('admin.fields.index') }}"
                       class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 text-gray-600 hover:bg-green-50 hover:text-green-700">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-green-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                        <span>Fields</span>
                    </a>
                @endcan

                @canany(['staff.manage', 'users.blacklist.manage'])
                    <a href="{{ route('admin.users.index') }}"
                       class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 text-gray-600 hover:bg-green-50 hover:text-green-700">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-green-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                        </svg>
                        <span>Users</span>
                    </a>
                @endcanany

                @can('planning.daily.view')
                    <a href="{{ route('admin.reservations.index') }}"
                       class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 text-gray-600 hover:bg-green-50 hover:text-green-700">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-green-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z"/>
                        </svg>
                        <span>Reservations</span>
                    </a>
                @endcan

                @can('manager-requests.review')
                    <a href="{{ route('admin.manager-requests.index') }}"
                       class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 text-gray-600 hover:bg-green-50 hover:text-green-700">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-green-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 19.5h3.75M3.375 5.25h17.25c.621 0 1.125.504 1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621-.504 1.125-1.125 1.125H3.375A1.125 1.125 0 012.25 17.625v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621.504-1.125 1.125-1.125z"/>
                        </svg>
                        <span>Manager Requests</span>
                    </a>
                @endcan

                @can('scan-qr-code')
                    <a href="{{ route('admin.scan-ticket.index') }}"
                       class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 text-gray-600 hover:bg-green-50 hover:text-green-700">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-green-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 16.5h.008v.008h-.008v-.008zM13.5 16.5h.008v.008h-.008v-.008zM19.5 16.5h.008v.008h-.008v-.008zM19.5 13.5h.008v.008h-.008v-.008zM19.5 19.5h.008v.008h-.008v-.008zM16.5 19.5h.008v.008h-.008v-.008z"/>
                        </svg>
                        <span>QR Code Scan</span>
                    </a>
                @endcan
            </div>
        @endcanany
    </div>

    <div class="p-4 border-t border-gray-100 bg-gray-50/50">
        <form action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-600 hover:bg-red-50 hover:text-red-700 transition-all duration-200 w-full text-left">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-7.5A2.25 2.25 0 003.75 5.25v13.5A2.25 2.25 0 006 21h7.5a2.25 2.25 0 002.25-2.25V15m-6-3h11.25m0 0l-3.75-3.75M21 12l-3.75 3.75"/>
                </svg>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>