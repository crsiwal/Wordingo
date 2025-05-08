<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="min-h-[80vh] flex items-center justify-center">
        <div class="max-w-md w-full">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold">Forgot Password</h1>
                <p class="text-gray-600">Enter your email to reset your password</p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-8">
                <form action="<?= base_url('forgot-password') ?>" method="post">
                    <?= csrf_field() ?>

                    <!-- Email -->
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="<?= old('email') ?>"
                               class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary-500 <?= session('errors.email') ? 'border-red-500' : '' ?>"
                               required>
                        <?php if (session('errors.email')): ?>
                            <p class="mt-1 text-sm text-red-600"><?= session('errors.email') ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-primary-600 text-white px-6 py-2 rounded-lg hover:bg-primary-700">
                        Send Reset Link
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