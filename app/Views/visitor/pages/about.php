<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="relative">
    <!-- Background Pattern -->
    <div class="absolute inset-0 bg-gradient-to-br from-primary-50 to-white -z-10"></div>
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGQ9Ik0zNiAzNGMwIDIuMjA5LTEuNzkxIDQtNCA0cy00LTEuNzkxLTQtNCAxLjc5MS00IDQtNCA0IDEuNzkxIDQgNHoiIGZpbGw9IiNlMmU4ZjAiLz48L2c+PC9zdmc+')] opacity-10 -z-10"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Hero Section with Animation -->
        <div class="text-center mb-16 relative">
            <div class="absolute -top-10 left-1/2 transform -translate-x-1/2 w-20 h-20 bg-primary-100 rounded-full opacity-50 animate-pulse"></div>
            <h1 class="text-5xl font-bold text-gray-900 mb-6 relative">
                About Wordingo
                <span class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 w-24 h-1 bg-primary-600 rounded-full"></span>
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                A modern platform where writers share their stories and readers discover compelling content.
                Join our vibrant community of storytellers, thought leaders, and passionate readers.
            </p>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Left Column -->
            <div class="space-y-8">
                <div class="bg-white rounded-2xl shadow-lg p-8 transform hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-semibold text-gray-900 ml-4">Our Mission</h2>
                    </div>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        Wordingo is dedicated to empowering writers and connecting them with readers worldwide.
                        We believe in the power of storytelling and the impact of well-crafted content.
                    </p>
                    <p class="text-gray-700 leading-relaxed">
                        Our mission is to create a space where creativity thrives, ideas flourish, and meaningful connections are made through the art of writing.
                    </p>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-8 transform hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-semibold text-gray-900 ml-4">What We Offer</h2>
                    </div>
                    <ul class="space-y-4">
                        <li class="flex items-start group">
                            <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center mt-1 mr-3 group-hover:bg-primary-600 transition-colors">
                                <svg class="w-4 h-4 text-primary-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <span class="text-gray-700 font-medium">Intuitive Writing Interface</span>
                                <p class="text-gray-600 text-sm mt-1">A powerful yet simple editor with real-time preview and formatting tools</p>
                            </div>
                        </li>
                        <li class="flex items-start group">
                            <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center mt-1 mr-3 group-hover:bg-primary-600 transition-colors">
                                <svg class="w-4 h-4 text-primary-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <span class="text-gray-700 font-medium">Advanced Analytics</span>
                                <p class="text-gray-600 text-sm mt-1">Track engagement, reader demographics, and content performance</p>
                            </div>
                        </li>
                        <li class="flex items-start group">
                            <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center mt-1 mr-3 group-hover:bg-primary-600 transition-colors">
                                <svg class="w-4 h-4 text-primary-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <span class="text-gray-700 font-medium">SEO Optimization</span>
                                <p class="text-gray-600 text-sm mt-1">Built-in tools to improve search visibility and reach</p>
                            </div>
                        </li>
                        <li class="flex items-start group">
                            <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center mt-1 mr-3 group-hover:bg-primary-600 transition-colors">
                                <svg class="w-4 h-4 text-primary-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <span class="text-gray-700 font-medium">Responsive Design</span>
                                <p class="text-gray-600 text-sm mt-1">Perfect reading experience across all devices</p>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- New Section: Our Values -->
                <div class="bg-white rounded-2xl shadow-lg p-8 transform hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-semibold text-gray-900 ml-4">Our Values</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <h3 class="font-semibold text-gray-900 mb-2">Creativity</h3>
                            <p class="text-gray-600 text-sm">Fostering innovation and artistic expression in every piece of content</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <h3 class="font-semibold text-gray-900 mb-2">Community</h3>
                            <p class="text-gray-600 text-sm">Building meaningful connections between writers and readers</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <h3 class="font-semibold text-gray-900 mb-2">Quality</h3>
                            <p class="text-gray-600 text-sm">Maintaining high standards in content and user experience</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <h3 class="font-semibold text-gray-900 mb-2">Innovation</h3>
                            <p class="text-gray-600 text-sm">Continuously evolving our platform with cutting-edge features</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-8">
                <div class="bg-white rounded-2xl shadow-lg p-8 transform hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-semibold text-gray-900 ml-4">Our Story</h2>
                    </div>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        Founded in 2024, Wordingo emerged from a vision to create a platform that puts content creators first.
                        We understand the challenges writers face in today's digital landscape and are committed to providing
                        the tools and support they need to succeed.
                    </p>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        Our journey began when a group of passionate writers and tech enthusiasts came together with a shared vision:
                        to create a space where quality content thrives and writers can truly connect with their audience.
                    </p>
                    <p class="text-gray-700 leading-relaxed">
                        Today, we're proud to host a diverse community of writers, from emerging talents to established authors,
                        all sharing their unique perspectives and stories with the world.
                    </p>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-8 transform hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-semibold text-gray-900 ml-4">Join Our Community</h2>
                    </div>
                    <p class="text-gray-700 leading-relaxed mb-6">
                        Whether you're a seasoned writer or just starting your journey, Wordingo provides the perfect
                        environment to grow your audience and share your voice with the world.
                    </p>
                    <div class="space-y-4 mb-6">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-primary-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Connect with like-minded writers</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-primary-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Access exclusive writing resources</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-primary-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Participate in writing challenges</span>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="<?= base_url('register') ?>" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-primary-600 hover:bg-primary-700 transition-colors transform hover:scale-[1.02] duration-200">
                            Get Started
                        </a>
                        <a href="<?= base_url('contact') ?>" class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-colors transform hover:scale-[1.02] duration-200">
                            Contact Us
                        </a>
                    </div>
                </div>

                <!-- New Section: Our Team -->
                <div class="bg-white rounded-2xl shadow-lg p-8 transform hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-semibold text-gray-900 ml-4">Our Team</h2>
                    </div>
                    <p class="text-gray-700 leading-relaxed mb-6">
                        Behind Wordingo is a dedicated team of professionals passionate about writing, technology, and community building.
                        We work tirelessly to create the best platform for our users.
                    </p>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-primary-100 rounded-full mx-auto mb-3"></div>
                            <h3 class="font-semibold text-gray-900">Content Team</h3>
                            <p class="text-gray-600 text-sm">Curating quality content</p>
                        </div>
                        <div class="text-center">
                            <div class="w-16 h-16 bg-primary-100 rounded-full mx-auto mb-3"></div>
                            <h3 class="font-semibold text-gray-900">Tech Team</h3>
                            <p class="text-gray-600 text-sm">Building the platform</p>
                        </div>
                        <div class="text-center">
                            <div class="w-16 h-16 bg-primary-100 rounded-full mx-auto mb-3"></div>
                            <h3 class="font-semibold text-gray-900">Support Team</h3>
                            <p class="text-gray-600 text-sm">Helping our users</p>
                        </div>
                        <div class="text-center">
                            <div class="w-16 h-16 bg-primary-100 rounded-full mx-auto mb-3"></div>
                            <h3 class="font-semibold text-gray-900">Community Team</h3>
                            <p class="text-gray-600 text-sm">Growing our network</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="mt-20">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl shadow-lg p-8 text-center transform hover:scale-105 transition-transform duration-300">
                    <div class="w-16 h-16 bg-primary-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div class="text-4xl font-bold text-primary-600 mb-2">1000+</div>
                    <div class="text-gray-600">Active Writers</div>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-8 text-center transform hover:scale-105 transition-transform duration-300">
                    <div class="w-16 h-16 bg-primary-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                    </div>
                    <div class="text-4xl font-bold text-primary-600 mb-2">5000+</div>
                    <div class="text-gray-600">Published Articles</div>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-8 text-center transform hover:scale-105 transition-transform duration-300">
                    <div class="w-16 h-16 bg-primary-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <div class="text-4xl font-bold text-primary-600 mb-2">50K+</div>
                    <div class="text-gray-600">Monthly Readers</div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>