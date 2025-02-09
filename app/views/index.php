<?php session_start();
$SESSION_['user'] = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>YouDem - Empower Your Future</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-50">
<!-- Navigation -->
<header class="bg-white sticky top-0 z-50 border-b border-gray-100">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <a href="#" class="flex items-center space-x-2">
          <span class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">YouDem</span>
        </a>
        <nav class="hidden md:flex">
          <ul class="flex space-x-8">
            <li><a href="#" class="text-gray-700 hover:text-blue-600 font-medium">Home</a></li>
            <li><a href="#" class="text-gray-700 hover:text-blue-600 font-medium">Categories</a></li>
            <li><a href="#" class="text-gray-700 hover:text-blue-600 font-medium">About</a></li>
            <li><a href="#" class="text-gray-700 hover:text-blue-600 font-medium">Contact</a></li>
          </ul>
        </nav>
        <?php if (empty($_SESSION['user'])): ?>
          <div class="hidden md:flex space-x-4">
            <a href="login.php" class="px-4 py-2 text-gray-700 hover:text-blue-600 font-medium">Login</a>
            <a href="signup.php" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">Sign Up</a>
          </div>
        <?php endif; ?>
        <button class="md:hidden p-2 rounded-lg hover:bg-gray-100">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
      </div>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="relative overflow-hidden bg-gradient-to-r from-blue-600 to-indigo-600">
    <div class="absolute inset-0 bg-grid-white/[0.05] bg-[size:16px]"></div>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-24 relative">
      <div class="grid lg:grid-cols-2 gap-12 items-center">
        <div class="max-w-2xl">
          <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white mb-6 leading-tight">
            Empower Your Future Through Learning
          </h1>
          <p class="text-xl text-blue-100 mb-8 leading-relaxed">
            Join thousands of learners worldwide and unlock your potential with our expert-led courses. Start your journey today.
          </p>
          <div class="flex flex-col sm:flex-row gap-4">
            <a href="#" class="inline-flex items-center justify-center px-6 py-3 rounded-lg bg-white text-blue-600 font-semibold hover:bg-blue-50 transition-colors">
              Get Started
              <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </a>
            <a href="#" class="inline-flex items-center justify-center px-6 py-3 rounded-lg bg-blue-700 text-white font-semibold hover:bg-blue-800 transition-colors">
              Browse Courses
            </a>
          </div>
        </div>
        <div class="relative">
          <div class="absolute inset-0 bg-gradient-to-r from-blue-600/20 to-indigo-600/20 rounded-2xl filter blur-3xl"></div>
          <img src="/api/placeholder/600/400" alt="Learning" class="relative rounded-2xl shadow-2xl">
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="py-24 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center max-w-3xl mx-auto mb-16">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Why Choose YouDem?</h2>
        <p class="text-xl text-gray-600">Discover the features that make our platform the perfect choice for your learning journey.</p>
      </div>
      <div class="grid md:grid-cols-3 gap-8">
        <div class="p-8 rounded-2xl bg-gray-50 hover:bg-gray-100 transition-colors">
          <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mb-6">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-900 mb-4">Expert Instructors</h3>
          <p class="text-gray-600">Learn from industry professionals with years of real-world experience.</p>
        </div>
        <div class="p-8 rounded-2xl bg-gray-50 hover:bg-gray-100 transition-colors">
          <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mb-6">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-900 mb-4">Flexible Learning</h3>
          <p class="text-gray-600">Study at your own pace with lifetime access to course materials.</p>
        </div>
        <div class="p-8 rounded-2xl bg-gray-50 hover:bg-gray-100 transition-colors">
          <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mb-6">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-900 mb-4">Money-Back Guarantee</h3>
          <p class="text-gray-600">30-day refund policy if you're not completely satisfied.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Featured Categories Section -->
  <section class="py-24 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center max-w-3xl mx-auto mb-16">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Featured Categories</h2>
        <p class="text-xl text-gray-600">Explore our most popular learning paths and start your journey today.</p>
      </div>
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Category Card 1 -->
        <div class="group relative bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
          <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/60 z-10"></div>
          <img src="/api/placeholder/400/250" alt="Web Development" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
          <div class="absolute bottom-0 left-0 right-0 p-6 text-white z-20">
            <h3 class="text-2xl font-bold mb-2">Web Development</h3>
            <p class="text-blue-100 mb-4">Master modern web development with hands-on projects.</p>
            <a href="#" class="inline-flex items-center text-sm font-semibold hover:text-blue-200">
              Explore Courses
              <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </a>
          </div>
        </div>

        <!-- Category Card 2 -->
        <div class="group relative bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
          <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/60 z-10"></div>
          <img src="/api/placeholder/400/250" alt="Mobile Development" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
          <div class="absolute bottom-0 left-0 right-0 p-6 text-white z-20">
            <h3 class="text-2xl font-bold mb-2">Mobile Development</h3>
            <p class="text-blue-100 mb-4">Build native and cross-platform mobile applications.</p>
            <a href="#" class="inline-flex items-center text-sm font-semibold hover:text-blue-200">
              Explore Courses
              <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </a>
          </div>
        </div>

        <!-- Category Card 3 -->
        <div class="group relative bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
          <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/60 z-10"></div>
          <img src="/api/placeholder/400/250" alt="Data Science" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
          <div class="absolute bottom-0 left-0 right-0 p-6 text-white z-20">
            <h3 class="text-2xl font-bold mb-2">Data Science</h3>
            <p class="text-blue-100 mb-4">Learn data analysis, ML, and AI fundamentals.</p>
            <a href="#" class="inline-flex items-center text-sm font-semibold hover:text-blue-200">
              Explore Courses
              <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="relative py-24 bg-gradient-to-r from-blue-600 to-indigo-600 overflow-hidden">
    <div class="absolute inset-0 bg-grid-white/[0.05] bg-[size:16px]"></div>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative">
      <div class="max-w-3xl mx-auto text-center">
        <h2 class="text-4xl font-bold text-white mb-6">Ready to Start Your Learning Journey?</h2>
        <p class="text-xl text-blue-100 mb-8">Join thousands of students worldwide and transform your career with YouDem.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <a href="#" class="inline-flex items-center justify-center px-8 py-4 rounded-lg bg-white text-blue-600 font-semibold hover:bg-blue-50 transition-colors">
            Get Started Now
          </a>
          <a href="#" class="inline-flex items-center justify-center px-8 py-4 rounded-lg bg-blue-700 text-white font-semibold hover:bg-blue-800 transition-colors">
            View Pricing
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-900 text-gray-300">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
      <!-- Column 1: Logo & Description -->
      <div class="space-y-4">
        <h3 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-400">YouDem</h3>
        <p class="text-gray-400">Empower your future through learning. Join us and unlock your potential with expert-led courses.</p>
      </div>
      <!-- Column 2: Quick Links -->
      <div>
        <h4 class="text-xl font-semibold mb-4">Quick Links</h4>
        <ul class="space-y-2">
          <li><a href="#" class="hover:text-white">Home</a></li>
          <li><a href="#" class="hover:text-white">Categories</a></li>
          <li><a href="#" class="hover:text-white">About</a></li>
          <li><a href="#" class="hover:text-white">Contact</a></li>
        </ul>
      </div>
      <!-- Column 3: Support -->
      <div>
        <h4 class="text-xl font-semibold mb-4">Support</h4>
        <ul class="space-y-2">
          <li><a href="#" class="hover:text-white">Help Center</a></li>
          <li><a href="#" class="hover:text-white">Terms of Service</a></li>
          <li><a href="#" class="hover:text-white">Privacy Policy</a></li>
          <li><a href="#" class="hover:text-white">FAQs</a></li>
        </ul>
      </div>
    </div>
   
  </div>
</footer>