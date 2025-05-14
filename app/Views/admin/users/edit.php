<?php echo $this->extend('layouts/admin') ?>

<?php echo $this->section('content') ?>
<!-- Header Section with Animated Background -->
<div class="relative mb-10 overflow-hidden rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 p-8">
    <div class="absolute inset-0 bg-grid-white/20 bg-grid-8"></div>
    <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="text-white">
            <h1 class="text-5xl font-bold leading-tight mb-2">Edit User</h1>
            <p class="text-indigo-100 text-xl">Update user details and permissions</p>
        </div>
        <a href="<?php echo base_url('admin/users') ?>" class="group relative px-8 py-3 bg-white text-indigo-600 rounded-full font-medium shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
            <span class="relative z-10 flex items-center">
                <span class="w-7 h-7 flex items-center justify-center bg-indigo-100 rounded-full mr-2 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                    <i class="fas fa-arrow-left"></i>
                </span>
                Back to Users
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
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-md">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle text-red-500 mr-3 text-lg"></i>
            <p><?php echo session()->getFlashdata('error') ?></p>
        </div>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-md">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-500 mr-3 text-lg"></i>
            <p><?php echo session()->getFlashdata('success') ?></p>
        </div>
    </div>
<?php endif; ?>

<div class="bg-white rounded-xl shadow-md transition-all duration-300 hover:shadow-lg mb-10">
    <form action="<?php echo base_url('admin/users/edit/' . $user['id']) ?>" method="post" enctype="multipart/form-data" class="p-6">
        <?php echo csrf_field() ?>

        <div class="flex items-center gap-4 mb-6">
            <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-xl font-bold overflow-hidden" id="avatar-preview">
                <?php if (! empty($user['avatar'])): ?>
                    <img src="<?php echo base_url($user['avatar']) ?>" alt="<?php echo $user['name'] ?>" class="w-full h-full object-cover">
                <?php else: ?>
<?php echo strtoupper(substr($user['name'] ?? '', 0, 1)) ?>
<?php endif; ?>
            </div>
            <div>
                <h3 class="text-xl font-semibold text-gray-900"><?php echo $user['name'] ?></h3>
                <p class="text-gray-500"><?php echo $user['email'] ?></p>
            </div>
        </div>

        <!-- Basic Information -->
        <div class="mb-6">
            <h4 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Basic Information</h4>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="name">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2.5                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php echo session('errors.name') ? 'border-red-500' : '' ?>"
                            id="name"
                            type="text"
                            name="name"
                            value="<?php echo $formData['name'] ?? '' ?>"
                            required>
                    </div>
                    <?php if (session('errors.name')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?php echo session('errors.name') ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="username">
                        Username <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-at text-gray-400"></i>
                        </div>
                        <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2.5                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php echo session('errors.username') ? 'border-red-500' : '' ?>"
                            id="username"
                            type="text"
                            name="username"
                            value="<?php echo $formData['username'] ?? '' ?>"
                            required>
                    </div>
                    <?php if (session('errors.username')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?php echo session('errors.username') ?></p>
                    <?php endif; ?>
                </div>

            </div>
        </div>

        <!-- Contact Information -->
        <div class="mb-6">
            <h4 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Contact Information</h4>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="email">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2.5                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php echo session('errors.email') ? 'border-red-500' : '' ?>"
                            id="email"
                            type="email"
                            name="email"
                            value="<?php echo $formData['email'] ?? '' ?>"
                            required>
                    </div>
                    <?php if (session('errors.email')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?php echo session('errors.email') ?></p>
                    <?php endif; ?>
                    <div class="flex items-center mt-2">
                        <input type="checkbox" id="email_verified" name="email_verified" value="1" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500" <?php echo (isset($formData['email_verified']) && $formData['email_verified']) ? 'checked' : '' ?>>
                        <label for="email_verified" class="ml-2 text-sm text-gray-600">Mark email as verified</label>
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="phone">
                        Phone Number <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-phone text-gray-400"></i>
                        </div>
                        <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2.5                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php echo session('errors.phone') ? 'border-red-500' : '' ?>"
                            id="phone"
                            type="text"
                            name="phone"
                            value="<?php echo $formData['phone'] ?? '' ?>"
                            required>
                    </div>
                    <?php if (session('errors.phone')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?php echo session('errors.phone') ?></p>
                    <?php endif; ?>
                    <div class="flex items-center mt-2">
                        <input type="checkbox" id="phone_verified" name="phone_verified" value="1" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500" <?php echo (isset($formData['phone_verified']) && $formData['phone_verified']) ? 'checked' : '' ?>>
                        <label for="phone_verified" class="ml-2 text-sm text-gray-600">Mark phone as verified</label>
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="address">
                        Address <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute top-3 left-0 flex items-start pl-3 pointer-events-none">
                            <i class="fas fa-map-marker-alt text-gray-400"></i>
                        </div>
                        <textarea class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2.5                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <?php echo session('errors.address') ? 'border-red-500' : '' ?>"
                            id="address"
                            name="address"
                            rows="3"
                            required><?php echo $formData['address'] ?? '' ?></textarea>
                    </div>
                    <?php if (session('errors.address')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?php echo session('errors.address') ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2" for="date_of_birth">
                                Date of Birth
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <i class="fas fa-calendar-alt text-gray-400"></i>
                                </div>
                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2.5                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?php echo session('errors.date_of_birth') ? 'border-red-500' : '' ?>"
                                    id="date_of_birth"
                                    type="date"
                                    name="date_of_birth"
                                    value="<?php echo old('date_of_birth', $user['date_of_birth']) ?>">
                            </div>
                            <?php if (session('errors.date_of_birth')): ?>
                                <p class="text-red-500 text-xs italic mt-1"><?php echo session('errors.date_of_birth') ?></p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2" for="gender">
                                Gender <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <i class="fas fa-venus-mars text-gray-400"></i>
                                </div>
                                <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2.5                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php echo session('errors.gender') ? 'border-red-500' : '' ?>"
                                    id="gender"
                                    name="gender"
                                    required>
                                    <option value="">Select gender</option>
                                    <option value="male" <?php echo (isset($formData['gender']) && $formData['gender'] === 'male') ? 'selected' : '' ?>>Male</option>
                                    <option value="female" <?php echo (isset($formData['gender']) && $formData['gender'] === 'female') ? 'selected' : '' ?>>Female</option>
                                </select>
                            </div>
                            <?php if (session('errors.gender')): ?>
                                <p class="text-red-500 text-xs italic mt-1"><?php echo session('errors.gender') ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Image -->
        <div class="mb-6">
            <h4 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Profile Image</h4>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="avatar">
                        Avatar
                    </label>
                    <div class="flex items-center">
                        <div class="w-16 h-16 rounded-full bg-gray-200 mr-4 flex items-center justify-center overflow-hidden" id="avatar-preview">
                            <?php if (! empty($user['avatar'])): ?>
                                <img src="<?php echo base_url($user['avatar']) ?>" alt="<?php echo $user['name'] ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <i class="fas fa-user text-gray-400 text-3xl"></i>
                            <?php endif; ?>
                        </div>
                        <div>
                            <label class="cursor-pointer bg-indigo-50 px-4 py-2 rounded-lg text-indigo-600 hover:bg-indigo-100 transition-colors">
                                <i class="fas fa-upload mr-2"></i> Change Image
                                <input type="file" name="avatar" id="avatar" class="hidden" accept="image/*" onchange="previewAvatar(this)">
                            </label>
                            <p class="text-xs text-gray-500 mt-1">JPG, PNG or GIF, max 2MB</p>
                        </div>
                    </div>
                    <?php if (session('errors.avatar')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?php echo session('errors.avatar') ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Account Settings -->
        <div class="mb-6">
            <h4 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Account Settings</h4>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="password">
                        Password <span class="text-gray-400 text-xs">(leave blank to keep current)</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2.5                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php echo session('errors.password') ? 'border-red-500' : '' ?>"
                            id="password"
                            type="password"
                            name="password"
                            placeholder="Enter only to change password">
                    </div>
                    <?php if (session('errors.password')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?php echo session('errors.password') ?></p>
                    <?php endif; ?>
                    <p class="text-xs text-gray-500 mt-1"><i class="fas fa-info-circle mr-1"></i> Password should be at least 8 characters with letters and numbers</p>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="role">
                        User Role <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-user-shield text-gray-400"></i>
                        </div>
                        <?php if ($userRole === 'admin'): ?>
                        <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2.5                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php echo session('errors.role') ? 'border-red-500' : '' ?>"
                            id="role"
                            name="role"
                            required>
                            <option value="admin" <?php echo (isset($formData['role']) && $formData['role'] === 'admin') ? 'selected' : '' ?>>Admin</option>
                            <option value="manager" <?php echo (isset($formData['role']) && $formData['role'] === 'manager') ? 'selected' : '' ?>>Manager</option>
                            <option value="editor" <?php echo (isset($formData['role']) && $formData['role'] === 'editor') ? 'selected' : '' ?>>Editor</option>
                            <option value="user" <?php echo (isset($formData['role']) && $formData['role'] === 'user') ? 'selected' : '' ?>>User</option>
                        </select>
                        <?php else: ?>
                        <input type="hidden" name="role" value="<?php echo $formData['role'] ?? $user['role'] ?>">
                        <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2.5" value="<?php echo ucfirst($formData['role'] ?? $user['role']) ?>" disabled>
                        <?php endif; ?>
                    </div>
                    <?php if (session('errors.role')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?php echo session('errors.role') ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="status">
                        Account Status <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-toggle-on text-gray-400"></i>
                        </div>
                        <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2.5                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php echo session('errors.status') ? 'border-red-500' : '' ?>"
                            id="status"
                            name="status"
                            required>
                            <option value="active" <?php echo (isset($formData['status']) && $formData['status'] === 'active') ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?php echo (isset($formData['status']) && $formData['status'] === 'inactive') ? 'selected' : '' ?>>Inactive</option>
                            <option value="banned" <?php echo (isset($formData['status']) && $formData['status'] === 'banned') ? 'selected' : '' ?>>Banned</option>
                        </select>
                    </div>
                    <?php if (session('errors.status')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?php echo session('errors.status') ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2 flex items-center">
                        Verification
                    </label>
                    <div class="mt-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_verified" value="1" class="form-checkbox h-5 w-5 text-indigo-600" <?php echo (isset($formData['is_verified']) && $formData['is_verified']) ? 'checked' : '' ?>>
                            <span class="ml-2 text-gray-700">Mark account as verified</span>
                        </label>
                    </div>
                    <?php if (session('errors.is_verified')): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?php echo session('errors.is_verified') ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 pt-4 border-t border-gray-200">
            <div class="text-gray-500 text-sm">
                <p><i class="fas fa-info-circle mr-1"></i> Last updated:                                                                                                                                                                                                                         <?php echo date('M d, Y \a\t h:i A', strtotime($user['updated_at'] ?? $user['created_at'])) ?></p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="<?php echo base_url('admin/users') ?>" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors inline-flex items-center justify-center">
                    <i class="fas fa-times mr-2"></i> Cancel
                </a>
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors inline-flex items-center justify-center">
                    <i class="fas fa-save mr-2"></i> Update User
                </button>
            </div>
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
    function previewAvatar(input) {
        const preview = document.getElementById('avatar-preview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<?php echo $this->endSection() ?>