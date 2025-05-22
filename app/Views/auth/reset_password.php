<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50">
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-indigo-900 mb-4">Reset Password</h1>
                <p class="text-gray-600">Create a new secure password</p>
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

                        <form action="<?= base_url('reset-password/' . $token) ?>" method="post" class="space-y-6">
                            <?= csrf_field() ?>

                            <div class="flex items-center gap-4 mb-8">
                                <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-xl">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900">Create New Password</h3>
                                    <p class="text-gray-500">Choose a strong, secure password</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="password">
                                    New Password <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" id="password" name="password"
                                        class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-200 <?= session('errors.password') ? 'border-red-500' : '' ?>"
                                        placeholder="Enter your new password" required>
                                </div>
                                <?php if (session('errors.password')): ?>
                                    <p class="mt-1 text-sm text-red-600 animate-shake"><?= session('errors.password') ?></p>
                                <?php endif; ?>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="password_confirm">
                                    Confirm Password <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" id="password_confirm" name="password_confirm"
                                        class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-200 <?= session('errors.password_confirm') ? 'border-red-500' : '' ?>"
                                        placeholder="Confirm your new password" required>
                                </div>
                                <?php if (session('errors.password_confirm')): ?>
                                    <p class="mt-1 text-sm text-red-600 animate-shake"><?= session('errors.password_confirm') ?></p>
                                <?php endif; ?>
                            </div>

                            <div class="bg-indigo-50 rounded-xl p-4 border border-indigo-100">
                                <div class="flex items-start gap-3">
                                    <i class="fas fa-info-circle text-indigo-500 mt-1"></i>
                                    <div class="text-sm text-indigo-700">
                                        <p class="font-medium">Password Requirements</p>
                                        <ul class="mt-2 space-y-1 list-disc list-inside">
                                            <li>Password should be at least 8 characters long</li>
                                            <li>Use a mix of letters, numbers, and symbols for maximum security</li>
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
                                    <span id="submitText">Set New Password</span>
                                    <span id="spinner" class="hidden animate-spin"><i class="fas fa-spinner"></i></span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Right: Info Section -->
                    <div class="hidden lg:block bg-gradient-to-br from-indigo-600 to-purple-600 p-12 text-white">
                        <div class="max-w-md mx-auto">
                            <h2 class="text-3xl font-bold mb-8">Password Tips</h2>
                            <div class="space-y-8">
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-white/20 flex items-center justify-center">
                                        <i class="fas fa-shield-alt text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold mb-2">Stay Secure</h3>
                                        <p class="text-white/80">Use a unique password for your Wordingo account.</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-white/20 flex items-center justify-center">
                                        <i class="fas fa-key text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold mb-2">Strong Passwords</h3>
                                        <p class="text-white/80">Combine uppercase, lowercase, numbers, and symbols.</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-white/20 flex items-center justify-center">
                                        <i class="fas fa-user-lock text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold mb-2">Keep it Private</h3>
                                        <p class="text-white/80">Never share your password with anyone.</p>
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