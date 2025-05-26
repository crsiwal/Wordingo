<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50 overflow-x-hidden">
    <div class="container mx-auto px-2 sm:px-4 py-12">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-indigo-900 mb-4">Join Wordingo</h1>
                <p class="text-gray-600">Start your writing journey today</p>
    </div>

            <!-- Main Content -->
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 w-full">
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

                        <!-- Social Signup -->
                        <div class="mb-8">
        <div class="flex items-center gap-4 mb-6">
                                <div class="flex-1 h-px bg-gray-200"></div>
                                <span class="text-sm text-gray-500">Sign up with</span>
                                <div class="flex-1 h-px bg-gray-200"></div>
            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <button class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl border border-gray-200 hover:border-indigo-200 hover:bg-indigo-50 transition-all duration-200">
                                    <i class="fab fa-google text-red-500"></i>
                                    <span class="text-sm font-medium">Google</span>
                                </button>
                                <button class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl border border-gray-200 hover:border-indigo-200 hover:bg-indigo-50 transition-all duration-200">
                                    <i class="fab fa-apple text-gray-800"></i>
                                    <span class="text-sm font-medium">Apple</span>
                                </button>
                                <button class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl border border-gray-200 hover:border-indigo-200 hover:bg-indigo-50 transition-all duration-200">
                                    <i class="fab fa-facebook-f text-blue-600"></i>
                                    <span class="text-sm font-medium">Facebook</span>
                                </button>
            </div>
        </div>

                        <!-- Registration Form -->
                        <form id="registerForm" action="<?= base_url('register') ?>" method="post" enctype="multipart/form-data" class="space-y-6">
                            <?= csrf_field() ?>

                            <!-- Step Indicator -->
                            <div class="mb-8">
                                <div class="flex items-center justify-between">
                                    <?php for ($i = 1; $i <= 4; $i++): ?>
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-semibold transition-all duration-300" id="step-indicator-<?= $i ?>">
                                                <?= $i ?>
                        </div>
                                            <?php if ($i < 4): ?>
                                                <div class="w-16 h-1 bg-gray-200 mx-2" id="step-line-<?= $i ?>"></div>
                    <?php endif; ?>
                </div>
                                    <?php endfor; ?>
                    </div>
                </div>

                            <!-- Step 1: Basic Info -->
                            <div class="step-block animate-fade-in" id="step-1">
                                <h2 class="text-2xl font-bold text-gray-900 mb-6">Basic Information</h2>

                                <div class="space-y-6">
                <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2" for="name">Full Name</label>
                                        <input type="text" id="name" name="name" value="<?= old('name') ?>"
                                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-200 <?= session('errors.name') ? 'border-red-500' : '' ?>"
                                            placeholder="Enter your full name" required>
                                        <?php if (session('errors.name')): ?>
                                            <p class="mt-1 text-sm text-red-600 animate-shake"><?= session('errors.name') ?></p>
                    <?php endif; ?>
                </div>

                <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2" for="username">Username</label>
                                        <input type="text" id="username" name="username" value="<?= old('username') ?>"
                                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-200 <?= session('errors.username') ? 'border-red-500' : '' ?>"
                                            placeholder="Choose a username" required>
                                        <?php if (session('errors.username')): ?>
                                            <p class="mt-1 text-sm text-red-600 animate-shake"><?= session('errors.username') ?></p>
                    <?php endif; ?>
                </div>

                        <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                            <select name="birth_day" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-200 <?= session('errors.birth_day') ? 'border-red-500' : '' ?>" required>
                                <option value="" disabled <?= !old('birth_day') ? 'selected' : '' ?>>Day</option>
                                <?php for ($i = 1; $i <= 31; $i++): ?>
                                    <option value="<?= $i ?>" <?= old('birth_day') == $i ? 'selected' : '' ?>><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                                            <select name="birth_month" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-200 <?= session('errors.birth_month') ? 'border-red-500' : '' ?>" required>
                                <option value="" disabled <?= !old('birth_month') ? 'selected' : '' ?>>Month</option>
                                                <?php $months = [1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'];
                                foreach ($months as $num => $name): ?>
                                    <option value="<?= $num ?>" <?= old('birth_month') == $num ? 'selected' : '' ?>><?= $name ?></option>
                                <?php endforeach; ?>
                            </select>
                                            <select name="birth_year" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-200 <?= session('errors.birth_year') ? 'border-red-500' : '' ?>" required>
                                <option value="" disabled <?= !old('birth_year') ? 'selected' : '' ?>>Year</option>
                                <?php for ($i = date('Y') - 13; $i >= date('Y') - 100; $i--): ?>
                                    <option value="<?= $i ?>" <?= old('birth_year') == $i ? 'selected' : '' ?>><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                                        </div>
                                        <div id="dob-error-container"></div>
                                        <p class="mt-2 text-sm text-gray-500">You must be at least 13 years old to register</p>
                                    </div>
                                </div>

                                <div class="mt-8 flex justify-end">
                                    <button type="button" onclick="nextStep(2)"
                                        class="px-6 py-3 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200">
                                        Continue
                                    </button>
                                </div>
                            </div>

                            <!-- Step 2: Contact Info -->
                            <div class="step-block hidden animate-fade-in" id="step-2">
                                <h2 class="text-2xl font-bold text-gray-900 mb-6">Contact Information</h2>

                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2" for="email">Email Address</label>
                                        <input type="email" id="email" name="email" value="<?= old('email') ?>"
                                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-200 <?= session('errors.email') ? 'border-red-500' : '' ?>"
                                            placeholder="Enter your email address" required>
                                        <?php if (session('errors.email')): ?>
                                            <p class="mt-1 text-sm text-red-600 animate-shake"><?= session('errors.email') ?></p>
                                        <?php endif; ?>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2" for="phone">Phone Number</label>
                                        <input type="tel" id="phone" name="phone" value="<?= old('phone') ?>"
                                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-200 <?= session('errors.phone') ? 'border-red-500' : '' ?>"
                                            placeholder="Enter your phone number" required>
                                        <?php if (session('errors.phone')): ?>
                                            <p class="mt-1 text-sm text-red-600 animate-shake"><?= session('errors.phone') ?></p>
                                        <?php endif; ?>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2" for="country">Country</label>
                                        <select id="country" name="country"
                                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-200 <?= session('errors.country') ? 'border-red-500' : '' ?>" required>
                                            <option value="" disabled <?= !old('country') ? 'selected' : '' ?>>Select your country</option>
                                            <?php $countries = ["India", "United States", "United Kingdom", "Canada", "Australia", "Germany", "France", "Other"];
                                            foreach ($countries as $c): ?>
                                                <option value="<?= $c ?>" <?= old('country') == $c ? 'selected' : '' ?>><?= $c ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?php if (session('errors.country')): ?>
                                            <p class="mt-1 text-sm text-red-600 animate-shake"><?= session('errors.country') ?></p>
                                        <?php endif; ?>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2" for="address">Full Address</label>
                                        <textarea id="address" name="address" rows="3"
                                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-200 <?= session('errors.address') ? 'border-red-500' : '' ?>"
                                            placeholder="Enter your full address" required><?= old('address') ?></textarea>
                                        <?php if (session('errors.address')): ?>
                                            <p class="mt-1 text-sm text-red-600 animate-shake"><?= session('errors.address') ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                                <div class="mt-8 flex justify-between">
                                    <button type="button" onclick="prevStep(1)"
                                        class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200">
                                        Back
                                    </button>
                                    <button type="button" onclick="nextStep(3)"
                                        class="px-6 py-3 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200">
                                        Continue
                                    </button>
                                </div>
                </div>

                            <!-- Step 3: Security -->
                            <div class="step-block hidden animate-fade-in" id="step-3">
                                <h2 class="text-2xl font-bold text-gray-900 mb-6">Security Setup</h2>

                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2" for="password">Password</label>
                    <div class="relative">
                                            <input type="password" id="password" name="password"
                                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-200 <?= session('errors.password') ? 'border-red-500' : '' ?>"
                                                placeholder="Create a strong password" required>
                                            <button type="button" onclick="togglePassword()"
                                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-indigo-600">
                                                <i id="eye-icon" class="fas fa-eye"></i>
                                            </button>
                        </div>
                                        <p class="mt-2 text-sm text-gray-500">Password must be at least 8 characters long and include numbers and special characters</p>
                                        <?php if (session('errors.password')): ?>
                                            <p class="mt-1 text-sm text-red-600 animate-shake"><?= session('errors.password') ?></p>
                    <?php endif; ?>
                </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2" for="password_confirm">Confirm Password</label>
                                        <input type="password" id="password_confirm" name="password_confirm"
                                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-200 <?= session('errors.password_confirm') ? 'border-red-500' : '' ?>"
                                            placeholder="Confirm your password" required>
                                        <?php if (session('errors.password_confirm')): ?>
                                            <p class="mt-1 text-sm text-red-600 animate-shake"><?= session('errors.password_confirm') ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="mt-8 flex justify-between">
                                    <button type="button" onclick="prevStep(2)"
                                        class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200">
                                        Back
                                    </button>
                                    <button type="button" onclick="nextStep(4)"
                                        class="px-6 py-3 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200">
                                        Continue
                                    </button>
                                </div>
                            </div>

                            <!-- Step 4: Profile & Terms -->
                            <div class="step-block hidden animate-fade-in" id="step-4">
                                <h2 class="text-2xl font-bold text-gray-900 mb-6">Final Steps</h2>

                                <div class="space-y-6">
                                    <div class="flex flex-col items-center">
                                        <div class="w-24 h-24 rounded-full bg-indigo-50 border-2 border-indigo-200 flex items-center justify-center overflow-hidden mb-4" id="avatar-preview">
                                            <i class="fas fa-user text-indigo-300 text-4xl" id="avatar-icon"></i>
                        </div>
                                        <label class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 cursor-pointer">
                                <i class="fas fa-cloud-upload-alt mr-2"></i>
                                            Upload Profile Picture
                                <input type="file" name="avatar" id="avatar" class="hidden" accept="image/*" onchange="previewImage(this)">
                            </label>
                    <?php if (session('errors.avatar')): ?>
                                            <p class="mt-2 text-sm text-red-600 animate-shake"><?= session('errors.avatar') ?></p>
                    <?php endif; ?>
                </div>

                                    <div class="bg-gray-50 rounded-xl p-6">
                                        <label class="flex items-start gap-3">
                                            <input type="checkbox" name="terms" class="mt-1 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" required>
                                            <span class="text-sm text-gray-600">
                                                I agree to the <a href="<?= base_url('terms') ?>" class="text-indigo-600 hover:underline">Terms of Service</a> and <a href="<?= base_url('privacy') ?>" class="text-indigo-600 hover:underline">Privacy Policy</a>
                                            </span>
                    </label>
                                    </div>
                                </div>

                                <div class="mt-8">
                                    <button type="submit" id="submitBtn"
                                        class="w-full px-6 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium rounded-xl hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 flex items-center justify-center gap-2">
                                        <span id="submitText">Create Account</span>
                                        <span id="spinner" class="hidden animate-spin"><i class="fas fa-spinner"></i></span>
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div class="mt-8 text-center text-sm text-gray-600">
                            Already have an account? <a href="<?= base_url('login') ?>" class="text-indigo-600 font-medium hover:underline">Sign in</a>
                        </div>
                    </div>

                    <!-- Right: Info Section -->
                    <div class="hidden lg:block bg-gradient-to-br from-indigo-600 to-purple-600 p-12 text-white">
                        <div class="max-w-md mx-auto">
                            <h2 class="text-3xl font-bold mb-8">Welcome to Wordingo</h2>

                            <div class="space-y-8">
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-white/20 flex items-center justify-center">
                                        <i class="fas fa-pen-fancy text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold mb-2">Write Your Story</h3>
                                        <p class="text-white/80">Share your thoughts, stories, and ideas with a global community of writers.</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-white/20 flex items-center justify-center">
                                        <i class="fas fa-users text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold mb-2">Connect & Collaborate</h3>
                                        <p class="text-white/80">Join a vibrant community of writers, readers, and creative minds.</p>
                                    </div>
                </div>

                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-white/20 flex items-center justify-center">
                                        <i class="fas fa-chart-line text-xl"></i>
                                    </div>
                <div>
                                        <h3 class="text-lg font-semibold mb-2">Grow Your Audience</h3>
                                        <p class="text-white/80">Build your following and get feedback from readers worldwide.</p>
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
    let currentStep = 1;

    function showStep(step) {
        document.querySelectorAll('.step-block').forEach(block => {
            block.classList.add('hidden');
        });
        document.getElementById('step-' + step).classList.remove('hidden');
        for (let i = 1; i <= 4; i++) {
            const indicator = document.getElementById('step-indicator-' + i);
            const line = document.getElementById('step-line-' + i);
            if (i < step) {
                indicator.classList.add('bg-indigo-600', 'text-white');
                indicator.classList.remove('bg-gray-200', 'text-gray-600');
                if (line) line.classList.add('bg-indigo-600');
            } else if (i === step) {
                indicator.classList.add('bg-indigo-600', 'text-white');
                indicator.classList.remove('bg-gray-200', 'text-gray-600');
            } else {
                indicator.classList.add('bg-gray-200', 'text-gray-600');
                indicator.classList.remove('bg-indigo-600', 'text-white');
                if (line) line.classList.remove('bg-indigo-600');
            }
        }
        currentStep = step;
    }

    function validateStep(step) {
        let valid = true;
        let firstInvalid = null;
        // Clear previous error highlights
        document.querySelectorAll('#step-' + step + ' input, #step-' + step + ' select, #step-' + step + ' textarea').forEach(el => {
            el.classList.remove('border-red-500');
        });
        // Remove previous error messages
        document.querySelectorAll('#step-' + step + ' .js-error').forEach(el => el.remove());

        if (step === 1) {
            // Name
            const name = document.getElementById('name');
            if (!name.value.trim()) {
                valid = false;
                name.classList.add('border-red-500');
                showError(name, 'Full name is required');
                firstInvalid = firstInvalid || name;
            }
            // Username
            const username = document.getElementById('username');
            if (!username.value.trim()) {
                valid = false;
                username.classList.add('border-red-500');
                showError(username, 'Username is required');
                firstInvalid = firstInvalid || username;
            }
            // Date of Birth
            const day = document.querySelector('select[name="birth_day"]');
            const month = document.querySelector('select[name="birth_month"]');
            const year = document.querySelector('select[name="birth_year"]');
            const dobErrorContainer = document.getElementById('dob-error-container');
            dobErrorContainer.innerHTML = '';
            if (!day.value || !month.value || !year.value) {
                valid = false;
                day.classList.add('border-red-500');
                month.classList.add('border-red-500');
                year.classList.add('border-red-500');
                // Show error below all selects, full width
                let error = document.createElement('p');
                error.className = 'mt-2 text-sm text-red-600 animate-shake js-error';
                error.innerText = 'Complete date of birth is required';
                dobErrorContainer.appendChild(error);
                firstInvalid = firstInvalid || day;
            }
        } else if (step === 2) {
            // Email
            const email = document.getElementById('email');
            if (!email.value.trim() || !/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(email.value)) {
                valid = false;
                email.classList.add('border-red-500');
                showError(email, 'Valid email is required');
                firstInvalid = firstInvalid || email;
            }
            // Phone
            const phone = document.getElementById('phone');
            if (!phone.value.trim()) {
                valid = false;
                phone.classList.add('border-red-500');
                showError(phone, 'Phone number is required');
                firstInvalid = firstInvalid || phone;
            }
            // Country
            const country = document.getElementById('country');
            if (!country.value) {
                valid = false;
                country.classList.add('border-red-500');
                showError(country, 'Country is required');
                firstInvalid = firstInvalid || country;
            }
            // Address
            const address = document.getElementById('address');
            if (!address.value.trim()) {
                valid = false;
                address.classList.add('border-red-500');
                showError(address, 'Full address is required');
                firstInvalid = firstInvalid || address;
            }
        } else if (step === 3) {
            // Password
            const password = document.getElementById('password');
            if (!password.value.trim() || password.value.length < 8) {
                valid = false;
                password.classList.add('border-red-500');
                showError(password, 'Password must be at least 8 characters');
                firstInvalid = firstInvalid || password;
            }
            // Confirm Password
            const passwordConfirm = document.getElementById('password_confirm');
            if (!passwordConfirm.value.trim() || passwordConfirm.value !== password.value) {
                valid = false;
                passwordConfirm.classList.add('border-red-500');
                showError(passwordConfirm, 'Passwords do not match');
                firstInvalid = firstInvalid || passwordConfirm;
            }
        } else if (step === 4) {
            // Terms
            const terms = document.querySelector('input[name="terms"]');
            if (!terms.checked) {
                valid = false;
                showError(terms.parentElement, 'You must agree to the terms');
                firstInvalid = firstInvalid || terms;
            }
        }
        if (firstInvalid) {
            if (firstInvalid.focus) firstInvalid.focus();
        }
        return valid;
    }

    function showError(element, message) {
        let error = document.createElement('p');
        error.className = 'mt-1 text-sm text-red-600 animate-shake js-error';
        error.innerText = message;
        if (element.parentElement.classList.contains('relative')) {
            element.parentElement.appendChild(error);
        } else if (element.tagName === 'SELECT' || element.tagName === 'TEXTAREA' || element.tagName === 'INPUT') {
            element.parentElement.appendChild(error);
        } else {
            element.appendChild(error);
        }
    }

    function nextStep(step) {
        if (validateStep(currentStep)) {
            showStep(step);
        }
    }

    function prevStep(step) {
        showStep(step);
    }

    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    }

    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('avatar-preview');
                const icon = document.getElementById('avatar-icon');
                if (icon) icon.style.display = 'none';
                preview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        showStep(1);
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            document.getElementById('submitText').classList.add('hidden');
            document.getElementById('spinner').classList.remove('hidden');
        });
    });
</script>
<?= $this->endSection() ?>