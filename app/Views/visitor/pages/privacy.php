<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto bg-white rounded-3xl shadow-xl p-10">
            <h1 class="text-4xl font-bold text-indigo-900 mb-4">Privacy Policy</h1>
            <p class="text-gray-600 mb-8">Your privacy is important to us. This policy explains how Wordingo collects, uses, and protects your information.</p>

            <h2 class="text-2xl font-semibold text-indigo-800 mt-8 mb-2">1. Introduction</h2>
            <p class="text-gray-700 mb-4">This Privacy Policy describes how Wordingo ("we", "us", or "our") collects, uses, and shares your personal information when you use our website and services.</p>

            <h2 class="text-2xl font-semibold text-indigo-800 mt-8 mb-2">2. Information We Collect</h2>
            <ul class="list-disc list-inside text-gray-700 mb-4">
                <li><b>Account Information:</b> Name, email, username, date of birth, and other registration details.</li>
                <li><b>Usage Data:</b> Pages visited, features used, and actions taken on the platform.</li>
                <li><b>Cookies & Tracking:</b> We use cookies and similar technologies to enhance your experience.</li>
            </ul>

            <h2 class="text-2xl font-semibold text-indigo-800 mt-8 mb-2">3. How We Use Your Information</h2>
            <ul class="list-disc list-inside text-gray-700 mb-4">
                <li>To provide and maintain our services</li>
                <li>To personalize your experience</li>
                <li>To communicate with you about updates, offers, and support</li>
                <li>To improve our platform and analyze usage</li>
            </ul>

            <h2 class="text-2xl font-semibold text-indigo-800 mt-8 mb-2">4. Cookies</h2>
            <p class="text-gray-700 mb-4">We use cookies to remember your preferences, keep you logged in, and gather analytics. You can control cookies through your browser settings.</p>

            <h2 class="text-2xl font-semibold text-indigo-800 mt-8 mb-2">5. Data Security</h2>
            <p class="text-gray-700 mb-4">We implement industry-standard security measures to protect your data. However, no method of transmission over the Internet is 100% secure.</p>

            <h2 class="text-2xl font-semibold text-indigo-800 mt-8 mb-2">6. Your Rights</h2>
            <ul class="list-disc list-inside text-gray-700 mb-4">
                <li>Access, update, or delete your personal information</li>
                <li>Opt out of marketing communications</li>
                <li>Request a copy of your data</li>
            </ul>

            <h2 class="text-2xl font-semibold text-indigo-800 mt-8 mb-2">7. Changes to This Policy</h2>
            <p class="text-gray-700 mb-4">We may update this Privacy Policy from time to time. We will notify you of any significant changes by posting the new policy on this page.</p>

            <h2 class="text-2xl font-semibold text-indigo-800 mt-8 mb-2">8. Contact Us</h2>
            <p class="text-gray-700">If you have any questions about this Privacy Policy, please contact us at <a href="mailto:support@wordingo.com" class="text-indigo-600 hover:underline">support@wordingo.com</a>.</p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
