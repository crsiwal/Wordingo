<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h1 class="text-3xl font-bold mb-6">About Wordiqo</h1>
            
            <div class="prose max-w-none">
                <p class="text-lg text-gray-700 mb-6">
                    Wordiqo is a modern blogging platform designed to help writers share their stories, ideas, and expertise with the world. 
                    Our mission is to provide a seamless and enjoyable writing experience while connecting readers with quality content.
                </p>

                <h2 class="text-2xl font-semibold mt-8 mb-4">Our Story</h2>
                <p class="text-gray-700 mb-6">
                    Founded in 2024, Wordiqo was born from a passion for writing and a desire to create a platform that puts content creators first. 
                    We believe that everyone has a story to tell, and we're here to help you share yours.
                </p>

                <h2 class="text-2xl font-semibold mt-8 mb-4">What We Offer</h2>
                <ul class="list-disc list-inside text-gray-700 mb-6">
                    <li class="mb-2">A clean, intuitive writing interface</li>
                    <li class="mb-2">Powerful content management tools</li>
                    <li class="mb-2">Built-in SEO optimization</li>
                    <li class="mb-2">Social sharing capabilities</li>
                    <li class="mb-2">Responsive design for all devices</li>
                </ul>

                <h2 class="text-2xl font-semibold mt-8 mb-4">Join Our Community</h2>
                <p class="text-gray-700 mb-6">
                    Whether you're a seasoned writer or just starting your blogging journey, Wordiqo provides the tools and support you need to succeed. 
                    Join our growing community of writers and readers today.
                </p>

                <div class="mt-8">
                    <a href="<?= base_url('register') ?>" class="inline-block bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition-colors">
                        Get Started
                    </a>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?> 