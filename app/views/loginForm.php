<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login Form</title>
</head>
<body class="bg-gradient-to-br from-purple-50 to-indigo-50 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white shadow-xl rounded-2xl p-8 max-w-md w-full">
        <!-- Logo/Icon Placeholder -->
        <div class="flex justify-center mb-6">
            <div class="bg-violet-100 p-3 rounded-full">
                <svg class="w-8 h-8 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                </svg>
            </div>
        </div>

        <!-- Heading -->
        <h2 class="text-3xl font-bold text-gray-800 text-center mb-2">Welcome Back</h2>
        <p class="text-gray-500 text-center mb-8">Please login to your account</p>

        <!-- Form -->
        <form action="/login" method="POST" class="space-y-6">
            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input type="email" id="email" name="email" placeholder="you@example.com" 
                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-violet-500 focus:border-violet-500 focus:outline-none transition duration-200 bg-gray-50 hover:bg-white">
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" id="password" name="password" placeholder="••••••••" 
                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-violet-500 focus:border-violet-500 focus:outline-none transition duration-200 bg-gray-50 hover:bg-white">
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-violet-600 focus:ring-violet-500 border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                </div>
                <a href="#" class="text-sm font-medium text-violet-600 hover:text-violet-700 hover:underline transition duration-200">Forgot password?</a>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" 
                    class="w-full bg-violet-600 text-white py-3 rounded-lg font-semibold hover:bg-violet-700 focus:ring-4 focus:ring-violet-200 transition duration-200 transform hover:scale-[1.02]">
                    Log In
                </button>
            </div>
        </form>

        <!-- Footer -->
        <p class="text-sm text-gray-500 mt-8 text-center">
            Don't have an account? 
            <a href="./signup.php" class="text-violet-600 font-semibold hover:text-violet-700 hover:underline transition duration-200">Sign up</a>
        </p>
    </div>
</body>
</html>