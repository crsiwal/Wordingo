<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- Header Section with Animated Background -->
<div class="relative mb-10 overflow-hidden rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 p-8">
    <div class="absolute inset-0 bg-grid-white/20 bg-grid-8"></div>
    <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="text-white">
            <h1 class="text-5xl font-bold leading-tight mb-2">Create Account</h1>
            <p class="text-indigo-100 text-xl">Join our community today</p>
        </div>
        <a href="<?= base_url('') ?>" class="group relative px-8 py-3 bg-white text-indigo-600 rounded-full font-medium shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
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
                style="<?= 'width: ' . (rand(30, 80)) . 'px; height: ' . (rand(30, 80)) . 'px; left: ' . (rand(0, 100)) . '%; top: ' . (rand(0, 100)) . '%; animation: float ' . (rand(5, 12)) . 's ease-in-out infinite;' ?>"></div>
        <?php endfor; ?>
    </div>
</div>

<?php if (session()->getFlashdata('error')): ?>
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-md max-w-md mx-auto">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle text-red-500 mr-3 text-lg"></i>
            <p><?= session()->getFlashdata('error') ?></p>
        </div>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-md max-w-md mx-auto">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-500 mr-3 text-lg"></i>
            <p><?= session()->getFlashdata('success') ?></p>
        </div>
    </div>
<?php endif; ?>

<div class="bg-white rounded-xl shadow-md transition-all duration-300 hover:shadow-lg mb-10 max-w-2xl mx-auto">
    <form action="<?= base_url('register') ?>" method="post" enctype="multipart/form-data" class="p-6">
        <?= csrf_field() ?>

        <div class="flex items-center gap-4 mb-6">
            <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-xl">
                <i class="fas fa-user-plus"></i>
            </div>
            <div>
                <h3 class="text-xl font-semibold text-gray-900">Account Registration</h3>
                <p class="text-gray-500">Create your new account</p>
            </div>
        </div>

        <!-- Registration Information -->
        <div class="mb-6">
            <h4 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Personal Information</h4>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Full Name -->
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="name">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2.5 <?= session('errors.name') ? 'border-red-500' : '' ?>"
                            id="name"
                            type="text"
                            name="name"
                            value="<?= old('name') ?>"
                            placeholder="Enter your full name"
                            required>
                    </div>
                    <?php if (session('errors.name')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= session('errors.name') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Username -->
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="username">
                        Username <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-at text-gray-400"></i>
                        </div>
                        <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2.5 <?= session('errors.username') ? 'border-red-500' : '' ?>"
                            id="username"
                            type="text"
                            name="username"
                            value="<?= old('username') ?>"
                            placeholder="Choose a username"
                            required>
                    </div>
                    <?php if (session('errors.username')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= session('errors.username') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="email">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2.5 <?= session('errors.email') ? 'border-red-500' : '' ?>"
                            id="email"
                            type="email"
                            name="email"
                            value="<?= old('email') ?>"
                            placeholder="Enter your email address"
                            required>
                    </div>
                    <?php if (session('errors.email')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= session('errors.email') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="phone">
                        Phone <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-phone text-gray-400"></i>
                        </div>
                        <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2.5 <?= session('errors.phone') ? 'border-red-500' : '' ?>"
                            id="phone"
                            type="tel"
                            name="phone"
                            value="<?= old('phone') ?>"
                            placeholder="Enter your phone number"
                            required>
                    </div>
                    <?php if (session('errors.phone')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= session('errors.phone') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Date of Birth -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-sm font-medium mb-2">
                        Date of Birth <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-3 gap-2">
                        <!-- Day -->
                        <div>
                            <select name="birth_day" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 <?= session('errors.birth_day') ? 'border-red-500' : '' ?>" required>
                                <option value="" disabled <?= !old('birth_day') ? 'selected' : '' ?>>Day</option>
                                <?php for ($i = 1; $i <= 31; $i++): ?>
                                    <option value="<?= $i ?>" <?= old('birth_day') == $i ? 'selected' : '' ?>><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                            <?php if (session('errors.birth_day')): ?>
                                <p class="text-red-500 text-xs italic mt-1"><?= session('errors.birth_day') ?></p>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Month -->
                        <div>
                            <select name="birth_month" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 <?= session('errors.birth_month') ? 'border-red-500' : '' ?>" required>
                                <option value="" disabled <?= !old('birth_month') ? 'selected' : '' ?>>Month</option>
                                <?php 
                                $months = [
                                    1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                                    5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                                    9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
                                ];
                                foreach ($months as $num => $name): ?>
                                    <option value="<?= $num ?>" <?= old('birth_month') == $num ? 'selected' : '' ?>><?= $name ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (session('errors.birth_month')): ?>
                                <p class="text-red-500 text-xs italic mt-1"><?= session('errors.birth_month') ?></p>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Year -->
                        <div>
                            <select name="birth_year" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 <?= session('errors.birth_year') ? 'border-red-500' : '' ?>" required>
                                <option value="" disabled <?= !old('birth_year') ? 'selected' : '' ?>>Year</option>
                                <?php for ($i = date('Y') - 13; $i >= date('Y') - 100; $i--): ?>
                                    <option value="<?= $i ?>" <?= old('birth_year') == $i ? 'selected' : '' ?>><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                            <?php if (session('errors.birth_year')): ?>
                                <p class="text-red-500 text-xs italic mt-1"><?= session('errors.birth_year') ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">You must be at least 13 years old to register</p>
                </div>

                <!-- Address -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="address">
                        Address <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute top-3 left-3 pointer-events-none">
                            <i class="fas fa-map-marker-alt text-gray-400"></i>
                        </div>
                        <textarea 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2.5 <?= session('errors.address') ? 'border-red-500' : '' ?>"
                            id="address"
                            name="address"
                            rows="3"
                            placeholder="Enter your full address"
                            required><?= old('address') ?></textarea>
                    </div>
                    <?php if (session('errors.address')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= session('errors.address') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Avatar -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="avatar">
                        Profile Picture
                    </label>
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center overflow-hidden" id="avatar-preview">
                            <i class="fas fa-user text-gray-400 text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <label class="flex flex-col items-center px-4 py-2 bg-white text-indigo-600 rounded-lg border border-indigo-400 cursor-pointer hover:bg-indigo-50">
                                <i class="fas fa-cloud-upload-alt mr-2"></i>
                                <span class="text-sm">Choose a file</span>
                                <input type="file" name="avatar" id="avatar" class="hidden" accept="image/*" onchange="previewImage(this)">
                            </label>
                            <p class="text-xs text-gray-500 mt-1">JPG, PNG or GIF. Max 2MB.</p>
                        </div>
                    </div>
                    <?php if (session('errors.avatar')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= session('errors.avatar') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="password">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2.5 <?= session('errors.password') ? 'border-red-500' : '' ?>"
                            id="password"
                            type="password"
                            name="password"
                            placeholder="Create a strong password"
                            required>
                    </div>
                    <?php if (session('errors.password')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= session('errors.password') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="password_confirm">
                        Confirm Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2.5 <?= session('errors.password_confirm') ? 'border-red-500' : '' ?>"
                            id="password_confirm"
                            type="password"
                            name="password_confirm"
                            placeholder="Confirm your password"
                            required>
                    </div>
                    <?php if (session('errors.password_confirm')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= session('errors.password_confirm') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Terms Checkbox -->
                <div class="md:col-span-2 mt-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" 
                               name="terms" 
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                               required>
                        <span class="ml-2 text-sm text-gray-600">
                            I agree to the 
                            <a href="<?= base_url('terms') ?>" class="text-indigo-600 hover:text-indigo-700">
                                Terms of Service
                            </a>
                            and
                            <a href="<?= base_url('privacy') ?>" class="text-indigo-600 hover:text-indigo-700">
                                Privacy Policy
                            </a>
                        </span>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 pt-4 border-t border-gray-200">
            <div class="text-gray-500 text-sm">
                <p>Already have an account? <a href="<?= base_url('login') ?>" class="text-indigo-600 hover:text-indigo-700">Sign in</a></p>
            </div>
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors inline-flex items-center justify-center">
                <i class="fas fa-user-plus mr-2"></i> Create Account
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

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                var preview = document.getElementById('avatar-preview');
                preview.innerHTML = '<img src="' + e.target.result + '" class="w-full h-full object-cover">';
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<?= $this->endSection() ?> 