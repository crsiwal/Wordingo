<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="min-h-[80vh] flex items-center justify-center">
        <div class="max-w-md w-full">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold">Welcome Back</h1>
                <p class="text-gray-600">Please sign in to your account</p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-8">
                <form action="<?= base_url('login') ?>" method="post">
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

                    <!-- Password -->
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input type="password" 
                               name="password" 
                               id="password"
                               class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary-500 <?= session('errors.password') ? 'border-red-500' : '' ?>"
                               required>
                        <?php if (session('errors.password')): ?>
                            <p class="mt-1 text-sm text-red-600"><?= session('errors.password') ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="remember" 
                                   class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>
                        <a href="<?= base_url('forgot-password') ?>" class="text-sm text-primary-600 hover:text-primary-700">
                            Forgot password?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-primary-600 text-white px-6 py-2 rounded-lg hover:bg-primary-700">
                        Sign In
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Don't have an account? 
                        <a href="<?= base_url('register') ?>" class="text-primary-600 hover:text-primary-700">
                            Register here
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?> 