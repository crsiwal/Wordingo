<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50">
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-indigo-900 mb-4">Forgot Password</h1>
                <p class="text-gray-600">Reset your account password</p>
            </div>

            <!-- Main Content -->
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
                <div class="grid lg:grid-cols-2">
                    <!-- Left: Form Section -->
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

                        <form action="<?= base_url('forgot-password') ?>" method="post" class="space-y-6">
                            <?= csrf_field() ?>

                            <div class="flex items-center gap-4 mb-8">
                                <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-xl">
                                    <i class="fas fa-key"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900">Password Recovery</h3>
                                    <p class="text-gray-500">Enter your email to reset your password</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="email">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" id="email" name="email" value="<?= old('email') ?>"
                                        class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-200 <?= session('errors.email') ? 'border-red-500' : '' ?>"
                                        placeholder="Enter your registered email" required>
                                </div>
                                <?php if (session('errors.email')): ?>
                                    <p class="mt-1 text-sm text-red-600 animate-shake"><?= session('errors.email') ?></p>
                                <?php endif; ?>
                            </div>

                            <div class="bg-indigo-50 rounded-xl p-4 border border-indigo-100">
                                <div class="flex items-start gap-3">
                                    <i class="fas fa-info-circle text-indigo-500 mt-1"></i>
                                    <div class="text-sm text-indigo-700">
                                        <p class="font-medium">Password Reset Instructions</p>
                                        <ul class="mt-2 space-y-1 list-disc list-inside">
                                            <li>A password reset link will be sent to your email address</li>
                                            <li>The link will expire after 30 minutes for security reasons</li>
                                            <li>Check your spam folder if you don't receive the email</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-4 pt-6">
                                <a href="<?= base_url('login') ?>"
                                    class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200 flex items-center justify-center gap-2">
                                    <i class="fas fa-arrow-left"></i>
                                    Back to Login
                                </a>
                                <button type="submit" id="submitBtn"
                                    class="flex-1 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium rounded-xl hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 flex items-center justify-center gap-2">
                                    <span id="submitText">Send Reset Link</span>
                                    <span id="spinner" class="hidden animate-spin"><i class="fas fa-spinner"></i></span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Right: Info Section -->
                    <div class="hidden lg:block bg-gradient-to-br from-indigo-600 to-purple-600 p-12 text-white">
                        <div class="max-w-md mx-auto">
                            <h2 class="text-3xl font-bold mb-8">Need Help?</h2>

                            <div class="space-y-8">
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-white/20 flex items-center justify-center">
                                        <i class="fas fa-envelope text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold mb-2">Check Your Email</h3>
                                        <p class="text-white/80">We'll send you a secure link to reset your password.</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-white/20 flex items-center justify-center">
                                        <i class="fas fa-clock text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold mb-2">Quick Process</h3>
                                        <p class="text-white/80">Reset your password in just a few simple steps.</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-white/20 flex items-center justify-center">
                                        <i class="fas fa-shield-alt text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold mb-2">Secure & Private</h3>
                                        <p class="text-white/80">Your account security is our top priority.</p>
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
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');
        const spinner = document.getElementById('spinner');

        form.addEventListener('submit', function(e) {
            submitText.classList.add('hidden');
            spinner.classList.remove('hidden');
        });
    });
</script>
<?= $this->endSection() ?>