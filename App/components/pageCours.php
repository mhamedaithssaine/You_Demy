<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Teacher Courses</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    <!-- Top Navigation -->
    <header class="sticky top-0 z-10 bg-white border-b border-gray-200">
        <div class="px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
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
    </header>

    <!-- Page Content -->
    <main class="flex-1 p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-4">Your Courses</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Course Card -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-2">Advanced JavaScript Course</h2>
                <p class="text-gray-600 mb-4">Master modern JavaScript with advanced concepts and real-world projects.</p>
                <div class="flex items-center gap-4 mb-4">
                    <div class="flex items-center gap-1">
                        <i class="fas fa-users text-gray-400"></i>
                        <span class="text-sm text-gray-600">342 students</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <i class="fas fa-star text-yellow-400"></i>
                        <span class="text-sm text-gray-600">4.9 (128 reviews)</span>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-lg font-bold text-gray-900">$99.99</span>
                    <div class="flex items-center gap-2">
                        <a href="edit_course.php?id=1" class="text-indigo-600 hover:text-indigo-500 font-medium text-sm">
                            Edit Course
                        </a>
                        <form method="POST" action="delete_course.php" style="display:inline;">
                            <input type="hidden" name="id" value="1">
                            <button type="submit" class="text-red-600 hover:text-red-500 font-medium text-sm">
                                Delete Course
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Repeat the above course card for each course -->
        </div>
    </main>
</body>
</html>
