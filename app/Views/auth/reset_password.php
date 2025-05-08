<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="min-h-[80vh] flex items-center justify-center">
        <div class="max-w-md w-full">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold">Reset Password</h1>
                <p class="text-gray-600">Enter your new password below</p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-8">
                <form action="<?= base_url('reset-password/' . $token) ?>" method="post">
                    <?= csrf_field() ?>

                    <!-- Password -->
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                        <input type="password" 
                               name="password" 
                               id="password"
                               class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary-500 <?= session('errors.password') ? 'border-red-500' : '' ?>"
                               required>
                        <?php if (session('errors.password')): ?>
                            <p class="mt-1 text-sm text-red-600"><?= session('errors.password') ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-6">
                        <label for="password_confirm" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                        <input type="password" 
                               name="password_confirm" 
                               id="password_confirm"
                               class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary-500 <?= session('errors.password_confirm') ? 'border-red-500' : '' ?>"
                               required>
                        <?php if (session('errors.password_confirm')): ?>
                            <p class="mt-1 text-sm text-red-600"><?= session('errors.password_confirm') ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-primary-600 text-white px-6 py-2 rounded-lg hover:bg-primary-700">
                        Reset Password
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Remember your password? 
                        <a href="<?= base_url('login') ?>" class="text-primary-600 hover:text-primary-700">
                            Sign in here
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?> 