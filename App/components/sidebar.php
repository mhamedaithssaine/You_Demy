<!-- app/components/sidebar.php -->
<aside class="fixed inset-y-0 left-0 w-72 bg-white border-r border-gray-200">
    <!-- Logo -->
    <div class="flex items-center h-16 px-6 border-b border-gray-200 bg-white">
        <div class="flex items-center gap-2">
            <div class="bg-indigo-600 p-2 rounded-lg">
                <i class="fas fa-chalkboard-teacher text-white"></i>
            </div>
            <span class="text-xl font-bold text-gray-900">Youdemy</span>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-8 overflow-y-auto">
        <div>
            <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Main</h3>
            <div class="mt-4 space-y-1">
                <a href="#" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50">
                    <i class="fas fa-chart-line w-5 h-5"></i>
                    <span class="ml-3">Dashboard</span>
                </a>
            </div>
        </div>

       

        <div>
            <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Statistics</h3>
            <div class="mt-4 space-y-1">
                <a href="#" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50">
                    <i class="fas fa-chart-bar w-5 h-5"></i>
                    <span class="ml-3">Global Statistics</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Profile Section -->
    <div class="border-t border-gray-200 p-4">
        <div class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-50">
            <img src="https://ui-avatars.com/api/?name=John+Doe" alt="Teacher" class="w-8 h-8 rounded-lg">
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 truncate">John Doe</p>
                <p class="text-xs text-gray-500 truncate">Web Development</p>
            </div>
            <button class="bg-red-500 text-white px-3 py-1 rounded-lg text-sm font-medium hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                Logout
            </button>
        </div>
    </div>
</aside>
