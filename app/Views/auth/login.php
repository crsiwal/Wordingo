<?php echo $this->extend('layouts/main') ?>

<?php echo $this->section('content') ?>
<!-- Header Section with Animated Background -->
<div class="relative mb-10 overflow-hidden rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 p-8">
    <div class="absolute inset-0 bg-grid-white/20 bg-grid-8"></div>
    <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="text-white">
            <h1 class="text-5xl font-bold leading-tight mb-2">Sign In</h1>
            <p class="text-indigo-100 text-xl">Welcome back to your account</p>
        </div>
        <a href="<?php echo base_url('') ?>" class="group relative px-8 py-3 bg-white text-indigo-600 rounded-full font-medium shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
            <span class="relative z-10 flex items-center">
                <span class="w-7 h-7 flex items-center justify-center bg-indigo-100 rounded-full mr-2 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                    <i class="fas fa-home"></i>
                </span>
                Back to Home
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
    <form action="<?php echo base_url('login') ?>" method="post" class="p-6">
        <?php echo csrf_field() ?>

        <div class="flex items-center gap-4 mb-6">
            <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-xl">
                <i class="fas fa-user"></i>
            </div>
            <div>
                <h3 class="text-xl font-semibold text-gray-900">Account Login</h3>
                <p class="text-gray-500">Sign in to access your dashboard</p>
            </div>
        </div>

        <!-- Login Information -->
        <div class="mb-6">
            <h4 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Login Credentials</h4>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="email">
                        Email or Username <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2.5 <?php echo session('errors.email') ? 'border-red-500' : '' ?>"
                            id="email"
                            type="text"
                            name="email"
                            value="<?php echo old('email') ?>"
                            placeholder="Enter your email or username"
                            required>
                    </div>
                    <?php if (session('errors.email')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?php echo session('errors.email') ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="password">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2.5 <?php echo session('errors.password') ? 'border-red-500' : '' ?>"
                            id="password"
                            type="password"
                            name="password"
                            placeholder="Enter your password"
                            required>
                    </div>
                    <?php if (session('errors.password')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?php echo session('errors.password') ?></p>
                    <?php endif; ?>
                </div>

                <div class="flex items-center justify-between">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="remember" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                    <a href="<?php echo base_url('forgot-password') ?>" class="text-sm text-indigo-600 hover:text-indigo-700">
                        Forgot password?
                    </a>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 pt-4 border-t border-gray-200">
            <div class="text-gray-500 text-sm">
                <p>Don't have an account? <a href="<?php echo base_url('register') ?>" class="text-indigo-600 hover:text-indigo-700">Sign up</a></p>
            </div>
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors inline-flex items-center justify-center">
                <i class="fas fa-sign-in-alt mr-2"></i> Sign In
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