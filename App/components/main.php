<div class="lg:pl-72 flex flex-col flex-1">
    <!-- Top Navigation -->
    <header class="sticky top-0 z-10 bg-white border-b border-gray-200">
        <div class="px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <button class="lg:hidden text-gray-500 hover:text-gray-600">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <div class="hidden sm:block">
                        <div class="relative">
                            <input type="text" placeholder="Search your courses..." class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-plus mr-2"></i>
                        Create New Course
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <main class="flex-1 p-6">
        <!-- Filters and Sorting -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">My Courses</h1>
                    <p class="mt-1 text-sm text-gray-600">Manage and track your course content</p>
                </div>
                <div class="flex items-center gap-4">
                    <select class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option>All Categories</option>
                        <option>Web Development</option>
                        <option>JavaScript</option>
                        <option>React</option>
                        <option>Node.js</option>
                    </select>
                    <select class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option>Sort by: Recent</option>
                        <option>Most Popular</option>
                        <option>Highest Rated</option>
                        <option>Title A-Z</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Course Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Course Card - Active -->
            <div class="bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-all">
                <div class="relative">
                    <img src="/api/placeholder/400/200" alt="Course thumbnail" class="w-full h-48 object-cover rounded-t-xl">
                    <span class="absolute top-4 right-4 px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                        Active
                    </span>
                </div>
                <div class="p-6">
                    <h3 class="font-semibold text-lg text-gray-900">Advanced JavaScript Course</h3>
                    <p class="text-sm text-gray-600 mt-2">Master modern JavaScript with advanced concepts and real-world projects.</p>
                    <div class="flex items-center gap-4 mt-4">
                        <div class="flex items-center gap-1">
                            <i class="fas fa-users text-gray-400"></i>
                            <span class="text-sm text-gray-600">342 students</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <i class="fas fa-star text-yellow-400"></i>
                            <span class="text-sm text-gray-600">4.9 (128 reviews)</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-6">
                        <span class="text-lg font-bold text-gray-900">$99.99</span>
                        <button class="text-indigo-600 hover:text-indigo-500 font-medium text-sm">
                            Edit Course
                        </button>
                    </div>
                </div>
            </div>

            <!-- Course Card - Draft -->
            <div class="bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-all opacity-75">
                <div class="relative">
                    <img src="/api/placeholder/400/200" alt="Course thumbnail" class="w-full h-48 object-cover rounded-t-xl">
                    <span class="absolute top-4 right-4 px-2 py-1 bg-gray-100 text-gray-800 text-xs font-medium rounded-full">
                        Draft
                    </span>
                </div>
                <div class="p-6">
                    <h3 class="font-semibold text-lg text-gray-900">React Performance Optimization</h3>
                    <p class="text-sm text-gray-600 mt-2">Learn advanced techniques to optimize React applications for better performance.</p>
                    <div class="flex items-center gap-4 mt-4">
                        <div class="flex items-center gap-1">
                            <i class="fas fa-clock text-gray-400"></i>
                            <span class="text-sm text-gray-600">Last edited 2 days ago</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-6">
                        <span class="text-lg font-bold text-gray-900">$89.99</span>
                        <button class="text-indigo-600 hover:text-indigo-500 font-medium text-sm">
                            Continue Editing
                        </button>
                    </div>
                </div>
            </div>

            <!-- Course Card - Under Review -->
            <div class="bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-all">
                <div class="relative">
                    <img src="/api/placeholder/400/200" alt="Course thumbnail" class="w-full h-48 object-cover rounded-t-xl">
                    <span class="absolute top-4 right-4 px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">
                        Under Review
                    </span>
                </div>
                <div class="p-6">
                    <h3 class="font-semibold text-lg text-gray-900">Node.js Microservices</h3>
                    <p class="text-sm text-gray-600 mt-2">Build scalable applications with microservices architecture using Node.js</p>
                    <div class="flex items-center gap-4 mt-4">
                        <div class="flex items-center gap-1">
                            <i class="fas fa-clock text-gray-400"></i>
                            <span class="text-sm text-gray-600">Submitted 1 day ago</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-6">
                        <span class="text-lg font-bold text-gray-900">$129.99</span>
                        <button class="text-indigo-600 hover:text-indigo-500 font-medium text-sm">
                            View Details
                        </button>
                    </div>
                </div>
            </div>

            <!-- Add New Course Card -->
            <div class="bg-gray-50 rounded-xl border border-dashed border-gray-300 hover:border-indigo-500 transition-all cursor-pointer p-6 flex flex-col items-center justify-center min-h-[400px]">
                <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-plus text-2xl text-indigo-600"></i>
                </div>
                <h3 class="font-semibold text-lg text-gray-900">Create New Course</h3>
                <p class="text-sm text-gray-600 text-center mt-2">Start building your next awesome course</p>
            </div>
        </div>
    </main>
</div>
