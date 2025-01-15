<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-xl border border-gray-200 shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Register</h2>
        <form method="POST" action="../components/auth/registration.php" class="space-y-4">
            <div>
                <label for="fullname" class="block text-sm font-medium text-gray-700">Full Name</label>
                <input type="text" id="fullname" name="fullname" placeholder="John Doe" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" placeholder="john.doe@example.com" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                <input type="text" id="phone" name="phone" placeholder="123-456-7890" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            <div>
                <label for="bio" class="block text-sm font-medium text-gray-700">Biography</label>
                <textarea id="bio" name="bio" placeholder="Tell us about yourself" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" rows="4" required></textarea>
            </div>
            <div>
                <label for="profil_img_url" class="block text-sm font-medium text-gray-700">Profile Image URL</label>
                <input type="text" id="profil_img_url" name="profil_img_url" placeholder="https://example.com/image.jpg" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="flex items-center mb-4">
                <input type="radio" id="role_student" name="role" value="etudiant" class="mr-2">
                <label for="role_student" class="text-sm font-medium text-gray-700">Register as Student</label>
            </div>
            <div class="flex items-center mb-4">
                <input type="radio" id="role_teacher" name="role" value="enseignant" class="mr-2">
                <label for="role_teacher" class="text-sm font-medium text-gray-700">Register as Teacher</label>
            </div>
            <div class="flex items-center justify-end">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Register
                </button>
            </div>
        </form>
        <p class="text-sm text-gray-600 mt-4 text-center">Vous avez déjà un compte ? <a href="login.php" class="text-indigo-600 hover:text-indigo-700">Connectez-vous</a></p>
    </div>
</body>
</html>
