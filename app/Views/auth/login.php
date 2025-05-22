<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50">
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-indigo-900 mb-4">Welcome Back</h1>
                <p class="text-gray-600">Continue your writing journey with Wordingo</p>
            </div>

            <!-- Main Content -->
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
                <div class="grid lg:grid-cols-2">
                    <!-- Left: Login Form -->
                    <div class="p-8 lg:p-12">
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg animate-fade-in">
                                <div class="flex items-center">
                                    <i class="fas fa-exclamation-circle text-red-500 mr-3 text-lg"></i>
                                    <p><?= session()->getFlashdata('error') ?></p>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg animate-fade-in">
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-3 text-lg"></i>
                                    <p><?= session()->getFlashdata('success') ?></p>
                                </div>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('login') ?>" method="post" class="space-y-6">
                            <?= csrf_field() ?>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="email">Username or Email</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" name="email" id="email" value="<?= old('email') ?>"
                                        class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-200 <?= session('errors.email') ? 'border-red-500' : '' ?>"
                                        placeholder="Enter your username or email" required>
                                </div>
                                <?php if (session('errors.email')): ?>
                                    <p class="mt-1 text-sm text-red-600 animate-shake"><?= session('errors.email') ?></p>
                                <?php endif; ?>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="password">Password</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" name="password" id="password"
                                        class="w-full pl-11 pr-32 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-200 <?= session('errors.password') ? 'border-red-500' : '' ?>"
                                        placeholder="Enter your password" required>
                                    <a href="<?= base_url('forgot-password') ?>"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-indigo-600 hover:text-indigo-800 font-medium transition-colors duration-200">
                                        Forgot Password?
                                    </a>
                                </div>
                                <?php if (session('errors.password')): ?>
                                    <p class="mt-1 text-sm text-red-600 animate-shake"><?= session('errors.password') ?></p>
                                <?php endif; ?>
                            </div>

                            <button type="submit" id="loginBtn"
                                class="w-full px-6 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium rounded-xl hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 flex items-center justify-center gap-2">
                                <span id="loginText">Sign In</span>
                                <span id="spinner" class="hidden animate-spin"><i class="fas fa-spinner"></i></span>
                            </button>

                            <div class="relative my-8">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-gray-200"></div>
                                </div>
                                <div class="relative flex justify-center text-sm">
                                    <span class="px-4 bg-white text-gray-500">Or continue with</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-4">
                                <button type="button" class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl border border-gray-200 hover:border-indigo-200 hover:bg-indigo-50 transition-all duration-200">
                                    <i class="fab fa-google text-red-500"></i>
                                    <span class="text-sm font-medium">Google</span>
                                </button>
                                <button type="button" class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl border border-gray-200 hover:border-indigo-200 hover:bg-indigo-50 transition-all duration-200">
                                    <i class="fab fa-apple text-gray-800"></i>
                                    <span class="text-sm font-medium">Apple</span>
                                </button>
                                <button type="button" class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl border border-gray-200 hover:border-indigo-200 hover:bg-indigo-50 transition-all duration-200">
                                    <i class="fab fa-facebook-f text-blue-600"></i>
                                    <span class="text-sm font-medium">Facebook</span>
                                </button>
                            </div>

                            <div class="mt-8 text-center text-sm text-gray-600">
                                Don't have an account? <a href="<?= base_url('register') ?>" class="text-indigo-600 font-medium hover:underline">Sign up</a>
                            </div>
                        </form>
                    </div>

                    <!-- Right: Info Section -->
                    <div class="hidden lg:block bg-gradient-to-br from-indigo-600 to-purple-600 p-12 text-white">
                        <div class="max-w-md mx-auto">
                            <h2 class="text-3xl font-bold mb-8">Welcome Back to Wordingo</h2>

                            <div class="space-y-8">
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-white/20 flex items-center justify-center">
                                        <i class="fas fa-pen-fancy text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold mb-2">Continue Writing</h3>
                                        <p class="text-white/80">Pick up where you left off and continue your writing journey.</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-white/20 flex items-center justify-center">
                                        <i class="fas fa-users text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold mb-2">Connect with Readers</h3>
                                        <p class="text-white/80">Engage with your audience and build your community.</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-white/20 flex items-center justify-center">
                                        <i class="fas fa-chart-line text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold mb-2">Track Your Progress</h3>
                                        <p class="text-white/80">Monitor your growth and celebrate your achievements.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-12 pt-8 border-t border-white/20">
                                <div class="flex items-center gap-4">
                                    <div class="flex -space-x-2">
                                        <img src="https://ui-avatars.com/api/?name=John+Doe&background=random" alt="User" class="w-10 h-10 rounded-full border-2 border-white">
                                        <img src="https://ui-avatars.com/api/?name=Jane+Smith&background=random" alt="User" class="w-10 h-10 rounded-full border-2 border-white">
                                        <img src="https://ui-avatars.com/api/?name=Mike+Johnson&background=random" alt="User" class="w-10 h-10 rounded-full border-2 border-white">
                                    </div>
                                    <p class="text-sm text-white/80">Join thousands of writers already on Wordingo</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fade-in 0.5s ease-out;
    }

    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        25% {
            transform: translateX(-5px);
        }

        75% {
            transform: translateX(5px);
        }
    }

    .animate-shake {
        animation: shake 0.3s ease-in-out;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const loginBtn = document.getElementById('loginBtn');
        const loginText = document.getElementById('loginText');
        const spinner = document.getElementById('spinner');

        form.addEventListener('submit', function(e) {
            loginText.classList.add('hidden');
            spinner.classList.remove('hidden');
        });
    });
</script>
<?= $this->endSection() ?>