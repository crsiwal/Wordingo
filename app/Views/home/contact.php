<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h1 class="text-3xl font-bold mb-6">Contact Us</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h2 class="text-xl font-semibold mb-4">Get in Touch</h2>
                    <p class="text-gray-700 mb-6">
                        Have questions or feedback? We'd love to hear from you. Fill out the form and we'll get back to you as soon as possible.
                    </p>

                    <div class="space-y-4">
                        <div class="flex items-start">
                            <i class="fas fa-envelope text-primary-600 mt-1 mr-3"></i>
                            <div>
                                <h3 class="font-semibold">Email</h3>
                                <p class="text-gray-600">support@wordiqo.com</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <i class="fas fa-clock text-primary-600 mt-1 mr-3"></i>
                            <div>
                                <h3 class="font-semibold">Response Time</h3>
                                <p class="text-gray-600">Within 24 hours</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <form action="<?= base_url('contact') ?>" method="POST" class="space-y-4">
                        <?= csrf_field() ?>
                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                            <input type="text" name="name" id="name" 
                                   value="<?= old('name') ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                   required>
                            <?php if (session('errors.name')): ?>
                                <p class="mt-1 text-sm text-red-600"><?= session('errors.name') ?></p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" id="email" 
                                   value="<?= old('email') ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                   required>
                            <?php if (session('errors.email')): ?>
                                <p class="mt-1 text-sm text-red-600"><?= session('errors.email') ?></p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                            <input type="text" name="subject" id="subject" 
                                   value="<?= old('subject') ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                   required>
                            <?php if (session('errors.subject')): ?>
                                <p class="mt-1 text-sm text-red-600"><?= session('errors.subject') ?></p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                            <textarea name="message" id="message" rows="4" 
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                      required><?= old('message') ?></textarea>
                            <?php if (session('errors.message')): ?>
                                <p class="mt-1 text-sm text-red-600"><?= session('errors.message') ?></p>
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="w-full bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition-colors">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?> 