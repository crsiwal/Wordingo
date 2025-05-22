<!-- Full-bleed Hero Section -->
<section class="relative overflow-hidden bg-gradient-to-br from-pink-100 via-blue-100 to-purple-100 w-full">
    <!-- Decorative SVG Blobs -->
    <svg class="absolute left-0 top-0 w-40 sm:w-64 h-40 sm:h-64 opacity-30 -z-10" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
        <path fill="#a5b4fc" d="M44.8,-67.2C56.7,-59.7,63.7,-44.2,68.2,-29.2C72.7,-14.2,74.7,0.3,70.2,13.2C65.7,26.1,54.7,37.4,42.1,46.7C29.5,56,15.2,63.3,0.2,63.1C-14.8,62.9,-29.6,55.2,-41.2,45.2C-52.8,35.2,-61.2,22.9,-65.2,8.7C-69.2,-5.5,-68.8,-21.7,-61.7,-34.2C-54.6,-46.7,-40.8,-55.6,-26.1,-61.7C-11.4,-67.8,4.2,-71.1,19.2,-70.1C34.2,-69.1,49.7,-63.7,44.8,-67.2Z" transform="translate(100 100)" />
    </svg>
    <svg class="absolute right-0 bottom-0 w-52 sm:w-80 h-52 sm:h-80 opacity-20 -z-10" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
        <path fill="#f9a8d4" d="M44.8,-67.2C56.7,-59.7,63.7,-44.2,68.2,-29.2C72.7,-14.2,74.7,0.3,70.2,13.2C65.7,26.1,54.7,37.4,42.1,46.7C29.5,56,15.2,63.3,0.2,63.1C-14.8,62.9,-29.6,55.2,-41.2,45.2C-52.8,35.2,-61.2,22.9,-65.2,8.7C-69.2,-5.5,-68.8,-21.7,-61.7,-34.2C-54.6,-46.7,-40.8,-55.6,-26.1,-61.7C-11.4,-67.8,4.2,-71.1,19.2,-70.1C34.2,-69.1,49.7,-63.7,44.8,-67.2Z" transform="translate(100 100)" />
    </svg>
    <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 flex flex-col md:flex-row items-center justify-between gap-8 md:gap-16">
        <!-- Left: Text Content -->
        <div class="flex-1 flex flex-col items-center md:items-start text-center md:text-left">
            <span class="inline-block bg-pink-200 text-pink-800 text-xs font-semibold px-3 py-1 rounded-full mb-4 shadow leading-relaxed">Becoming a new program online</span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-4 leading-[1.4] bg-gradient-to-r from-blue-600 via-pink-500 to-purple-600 bg-clip-text text-transparent drop-shadow-lg">
                Collection of articles <br class="hidden md:block">about the <span class="text-blue-700">world of work</span>
            </h1>
            <p class="text-base sm:text-lg md:text-xl text-gray-700 mb-6 sm:mb-8 max-w-2xl leading-relaxed">The right source of knowledge can be powerful professional growth, don't quit right there. Find the best advice, tips, and stories for your journey.</p>

            <!-- Search Bar -->
            <form action="<?= base_url('search') ?>" method="get" class="flex flex-col sm:flex-row w-full max-w-xl mx-auto md:mx-0 mb-6 sm:mb-8 shadow-lg rounded-lg overflow-hidden bg-white">
                <input type="text" name="q" class="flex-1 px-4 sm:px-6 py-4 sm:py-5 text-base sm:text-lg border-0 focus:ring-0 focus:outline-none leading-relaxed" placeholder="Search articles, topics, or authors...">
                <button type="submit" class="w-full sm:w-auto px-8 sm:px-10 py-4 sm:py-5 bg-gradient-to-r from-pink-500 to-blue-500 text-white font-bold text-base sm:text-lg transition hover:from-blue-500 hover:to-pink-500 leading-relaxed">Search</button>
            </form>
        </div>

        <!-- Right: Hero Image -->
        <div class="flex-1 flex justify-center md:justify-end items-center relative mt-8 md:mt-0">
            <div class="relative group">
                <img src="<?= base_url('assets/images/hero.png') ?>" alt="Hero" class="object-cover transform group-hover:scale-105 transition duration-500 ease-in-out">
                <!-- Floating effect -->
                <div class="absolute -inset-2 bg-gradient-to-br from-pink-200 via-blue-200 to-purple-200 rounded-3xl blur-2xl opacity-40 -z-10"></div>
            </div>
        </div>
    </div>
</section>