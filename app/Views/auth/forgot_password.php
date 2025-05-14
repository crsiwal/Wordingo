<?php echo $this->extend('layouts/main') ?>

<?php echo $this->section('content') ?>
<!-- Header Section with Animated Background -->
<div class="relative mb-10 overflow-hidden rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 p-8">
    <div class="absolute inset-0 bg-grid-white/20 bg-grid-8"></div>
    <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="text-white">
            <h1 class="text-5xl font-bold leading-tight mb-2">Forgot Password</h1>
            <p class="text-indigo-100 text-xl">Reset your account password</p>
        </div>
        <a href="<?php echo base_url('login') ?>" class="group relative px-8 py-3 bg-white text-indigo-600 rounded-full font-medium shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
            <span class="relative z-10 flex items-center">
                <span class="w-7 h-7 flex items-center justify-center bg-indigo-100 rounded-full mr-2 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                    <i class="fas fa-sign-in-alt"></i>
                </span>
                Back to Login
            </span>
            <span class="absolute inset-0 w-0 bg-gradient-to-r from-indigo-500 to-purple-500 transition-all duration-300 group-hover:w-full"></span>
            <span class="absolute inset-0 w-full h-full opacity-0 group-hover:opacity-20 bg-grid-white/20 bg-grid-8 transition-opacity duration-300"></span>
        </a>
    </div>

    <!-- Animated bubbles background effect -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-30 pointer-events-none">
        <?php for ($i = 0; $i < 6; $i++): ?>
            <div class="absolute rounded-full bg-white/30"
                style="<?php echo 'width: ' . (rand(30, 80)) . 'px; height: ' . (rand(30, 80)) . 'px; left: ' . (rand(0, 100)) . '%; top: ' . (rand(0, 100)) . '%; animation: float ' . (rand(5, 12)) . 's ease-in-out infinite;' ?>"></div>
        <?php endfor; ?>
    </div>
</div>

<?php if (session()->getFlashdata('error')): ?>
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-md max-w-md mx-auto">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle text-red-500 mr-3 text-lg"></i>
            <p><?php echo session()->getFlashdata('error') ?></p>
        </div>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-md max-w-md mx-auto">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-500 mr-3 text-lg"></i>
            <p><?php echo session()->getFlashdata('success') ?></p>
        </div>
    </div>
<?php endif; ?>

<div class="bg-white rounded-xl shadow-md transition-all duration-300 hover:shadow-lg mb-10 max-w-md mx-auto">
    <form action="<?php echo base_url('forgot-password') ?>" method="post" class="p-6">
        <?php echo csrf_field() ?>

        <div class="flex items-center gap-4 mb-6">
            <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-xl">
                <i class="fas fa-key"></i>
            </div>
            <div>
                <h3 class="text-xl font-semibold text-gray-900">Password Recovery</h3>
                <p class="text-gray-500">Enter your email to reset your password</p>
            </div>
        </div>

        <!-- Email Information -->
        <div class="mb-6">
            <h4 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Account Verification</h4>

            <div class="space-y-4">
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="email">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2.5                                                                                                                                                                                <?php echo session('errors.email') ? 'border-red-500' : '' ?>"
                            id="email"
                            type="email"
                            name="email"
                            value="<?php echo old('email') ?>"
                            placeholder="Enter your registered email"
                            required>
                    </div>
                    <?php if (session('errors.email')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?php echo session('errors.email') ?></p>
                    <?php endif; ?>
                </div>

                <div class="text-xs text-gray-500 bg-gray-50 p-3 rounded-lg border border-gray-200">
                    <p class="flex items-center"><i class="fas fa-info-circle text-indigo-500 mr-2"></i> A password reset link will be sent to your email address.</p>
                    <p class="mt-1">This link will expire after 30 minutes for security reasons.</p>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row sm:justify-center sm:items-center gap-4 pt-4 border-t border-gray-200">
            <button type="submit" class="px-10 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors inline-flex items-center justify-center">
                <i class="fas fa-paper-plane mr-2"></i> Send Reset Link
            </button>
        </div>
    </form>

    <!-- Gradient bar at bottom -->
    <div class="h-1 bg-gradient-to-r from-indigo-500 to-purple-500"></div>
</div>

<style>
    .bg-grid-white\/20 {
        mask-image: linear-gradient(to bottom, transparent, black);
    }

    .bg-grid-8 {
        background-size: 40px 40px;
        background-image:
            linear-gradient(to right, rgba(255, 255, 255, 0.05) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
    }

    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
        100% { transform: translateY(0px); }
    }
</style>
<?php echo $this->endSection() ?>