<?php
// Check if post content has any h2, h3, or h4 headings
$hasToc = preg_match('/<h[234][^>]*>/', $post['content']);
?>

<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Reading Progress Bar -->
<div id="reading-progress" class="fixed top-0 left-0 h-1.5 bg-gradient-to-r from-primary-500 to-primary-700 transition-all duration-300 z-[9999] shadow-lg"></div>

<div class="container mx-auto px-4 py-8">
    <div class="flex gap-8">
        <?php if ($hasToc): ?>
            <!-- Table of Contents -->
            <div class="hidden lg:block w-64 flex-shrink-0 relative">
                <div id="toc-container" class="sticky top-24 bg-white rounded-lg shadow-lg h-[calc(100vh-5rem)] overflow-y-auto">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 border-b p-4 sticky top-0 bg-white z-10 flex items-center">
                        <i class="fas fa-list-ul mr-2 text-primary-500"></i>
                        Table of Contents
                    </h3>
                    <nav id="toc" class="text-sm space-y-1 p-4 pr-2">
                        <!-- Will be populated by JavaScript -->
                    </nav>
                </div>
            </div>
        <?php endif; ?>

        <!-- Main Content -->
        <div class="flex-1">
            <article class="max-w-4xl mx-auto">
                <!-- Post Header -->
                <header class="mb-8">
                    <div class="flex flex-wrap items-center gap-3 text-gray-600 text-sm mb-4">
                        <a href="<?= base_url('category/' . $post['category_slug']) ?>" class="inline-flex items-center gap-1.5 text-primary-600 hover:text-primary-800">
                            <i class="fas fa-folder text-primary-500 mr-1"></i>
                            <span class="truncate"><?= esc($post['category_name']) ?></span>
                        </a>
                        <span class="inline-flex items-center gap-1.5">
                            <i class="fas fa-calendar text-gray-500 mr-1"></i>
                            <span class="truncate"><?= date('M d, Y', strtotime($post['published_at'])) ?></span>
                        </span>
                        <span class="inline-flex items-center gap-1.5">
                            <i class="fas fa-user text-gray-500 mr-1"></i>
                            <span class="truncate"><?= esc($post['author_name']) ?></span>
                        </span>
                        <span class="inline-flex items-center gap-1.5">
                            <i class="fas fa-eye text-gray-500 mr-1"></i>
                            <span class="truncate"><?= number_format($post['views']) ?> views</span>
                        </span>
                    </div>
                    <h1 class="text-4xl font-bold mb-4 leading-tight"><?= esc($post['title']) ?></h1>

                    <?php if ($post['thumbnail']): ?>
                        <div class="relative group">
                            <img src="<?= $post['thumbnail']; ?>" alt="<?= esc($post['title']) ?>"
                                class="w-full h-96 object-cover rounded-lg mb-8 transition-transform duration-300 group-hover:scale-[1.02]">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 rounded-lg"></div>
                        </div>
                    <?php endif; ?>
                </header>

                <!-- Post Content Toggle (Read in Short) -->
                <?php if (!empty($post['in_short'])): ?>
                    <div class="flex justify-end mb-4">
                        <button id="toggle-summary" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-primary-50 text-primary-700 border border-primary-100 hover:bg-primary-100 transition font-semibold shadow-sm">
                            <i class="fas fa-align-left"></i>
                            <span>Read in Short</span>
                        </button>
                    </div>
                <?php endif; ?>

                <!-- Post Content -->
                <div class="prose prose-lg max-w-none mb-12">
                    <?php if (!empty($post['in_short'])): ?>
                        <div id="post-summary" class="hidden">
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-lg shadow mb-6">
                                <div class="flex items-start">
                                    <i class="fas fa-bolt text-yellow-400 mt-1 mr-3"></i>
                                    <div>
                                        <div class="font-semibold text-lg mb-2 text-yellow-900">In Short</div>
                                        <div class="text-gray-800 text-base"><?= nl2br($post['in_short']) ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div id="post-content">
                        <?= $post['content'] ?>
                    </div>
                </div>

                <!-- Post Tags -->
                <?php if (!empty($post['tags'])): ?>
                    <div class="mb-12">
                        <h3 class="text-lg font-semibold mb-4">Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($post['tags'] as $tag): ?>
                                <a href="<?= base_url('tag/' . $tag['slug']) ?>"
                                    class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm hover:bg-gray-200 transition-colors duration-200">
                                    <i class="fas fa-tag mr-1 text-primary-500"></i>
                                    <?= esc($tag['name']) ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Modern Share Box -->
                <div class="mb-12 max-w-lg mx-auto bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <div class="flex justify-between items-center mb-2">
                        <div class="font-semibold text-gray-900 text-lg">Share this post</div>
                        <button type="button" aria-label="Close" class="text-gray-400 hover:text-gray-600 focus:outline-none" onclick="this.closest('div').style.display='none'">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="mb-3 flex items-center gap-2 bg-gray-50 rounded-lg px-3 py-2">
                        <i class="fas fa-link text-primary-500"></i>
                        <input
                            id="post-link"
                            type="text"
                            readonly
                            value="<?= current_url() ?>"
                            class="flex-1 bg-transparent border-0 text-gray-700 text-sm focus:outline-none" />
                        <button
                            id="copy-link"
                            type="button"
                            class="flex items-center gap-1 px-3 py-1.5 rounded-lg bg-primary-50 text-primary-700 border border-primary-100 hover:bg-primary-100 transition">
                            <i class="fas fa-copy"></i>
                            <span>Copy</span>
                        </button>
                        <span id="copy-success" class="ml-2 text-green-600 text-xs hidden">
                            <i class="fas fa-check"></i> Copied!
                        </span>
                    </div>
                    <div class="flex items-center gap-4 mt-3">
                        <span class="text-gray-400 text-sm">Share via</span>
                        <a href="https://twitter.com/intent/tweet?url=<?= urlencode(current_url()) ?>" target="_blank" class="rounded-full bg-blue-50 hover:bg-blue-100 text-blue-500 p-2 transition"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(current_url()) ?>" target="_blank" class="rounded-full bg-blue-50 hover:bg-blue-100 text-blue-700 p-2 transition"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="mailto:?subject=<?= urlencode($post['title']) ?>&body=<?= urlencode(current_url()) ?>" class="rounded-full bg-blue-50 hover:bg-blue-100 text-blue-500 p-2 transition"><i class="fas fa-envelope fa-lg"></i></a>
                    </div>
                </div>
            </article>
        </div>
    </div>

    <!-- Related Posts - Full Width -->
    <div class="mt-12">
        <?= layout_posts([
            'label' => 'Related Posts',
            'layout' => 'StandardGrid',
            'posts' => $relatedPosts,
        ]); ?>
    </div>
</div>

<!-- Back to Top Button -->
<button id="back-to-top" class="fixed bottom-8 right-8 bg-primary-600 text-white p-3 rounded-full shadow-lg hover:bg-primary-700 transition-all duration-300 opacity-0 invisible">
    <i class="fas fa-arrow-up"></i>
</button>
<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Reading Progress Bar and TOC Elements
        const $progressBar = $('#reading-progress');
        const $postContent = $('#post-content');
        const $tocContainer = $('#toc-container');
        const $article = $('article');
        const $toc = $('#toc');
        const $headings = $postContent.find('h2, h3, h4');
        let firstSection = true;
        let currentParent = null;

        // Store all parent containers and their children
        const parentContainers = new Map();
        const headingRelations = new Map();

        if ($tocContainer.length && $toc.length && $postContent.length) {
            // Build heading relationships
            let currentH2 = null;
            $headings.each(function() {
                const level = parseInt(this.tagName.charAt(1));
                if (level === 2) {
                    currentH2 = this.id;
                    headingRelations.set(this.id, {
                        parent: null,
                        children: new Set()
                    });
                } else if (currentH2) {
                    if (!headingRelations.has(currentH2)) {
                        headingRelations.set(currentH2, {
                            parent: null,
                            children: new Set()
                        });
                    }
                    headingRelations.get(currentH2).children.add(this.id);
                    headingRelations.set(this.id, {
                        parent: currentH2,
                        children: new Set()
                    });
                }
            });

            // Generate TOC
            $headings.each(function(index) {
                if (!this.id) {
                    this.id = `heading-${index}`;
                }
                const level = parseInt(this.tagName.charAt(1));
                const indent = (level - 2) * 1.5;
                const $linkContainer = $('<div>').addClass('toc-item');
                const $link = $('<a>').attr('href', `#${this.id}`);
                const $icon = $('<i>').addClass(`mr-2 text-primary-500 ${level === 2 ? 'fas fa-circle' : level === 3 ? 'fas fa-circle-dot' : 'far fa-circle'}`);
                const $text = $('<span>').text($(this).text());

                $link.append($icon, $text)
                    .addClass('block py-2 px-3 rounded-lg hover:bg-gray-50 hover:text-primary-600 transition-all duration-200 flex items-center group')
                    .css('marginLeft', `${indent}rem`);

                if (level === 2) {
                    const $toggleIcon = $('<i>').addClass('fas fa-chevron-down ml-auto text-gray-400 transition-transform duration-200');
                    const $childrenContainer = $('<div>').addClass('toc-children');

                    if (!firstSection) {
                        $childrenContainer.addClass('hidden');
                        $toggleIcon.css('transform', 'rotate(0deg)');
                    } else {
                        $toggleIcon.css('transform', 'rotate(-180deg)');
                        firstSection = false;
                    }

                    const relation = headingRelations.get(this.id) || {
                        children: new Set()
                    };
                    parentContainers.set(this.id, {
                        container: $childrenContainer,
                        toggleIcon: $toggleIcon,
                        link: $link,
                        children: relation.children
                    });

                    $link.on('click', function(e) {
                        e.preventDefault();
                        const isExpanded = !$childrenContainer.hasClass('hidden');
                        $childrenContainer.toggleClass('hidden');
                        $toggleIcon.css('transform', isExpanded ? 'rotate(0deg)' : 'rotate(-180deg)');
                    });

                    $linkContainer.append($link, $childrenContainer);
                    $toc.append($linkContainer);
                    currentParent = $childrenContainer;
                } else {
                    $linkContainer.append($link);
                    if (currentParent) {
                        currentParent.append($linkContainer);
                    } else {
                        $toc.append($linkContainer);
                    }
                }

                $link.hover(
                    function() {
                        $icon.addClass('scale-110');
                    },
                    function() {
                        $icon.removeClass('scale-110');
                    }
                );
            });

            // Reading Progress Bar
            function updateReadingProgress() {
                const contentHeight = $postContent[0].scrollHeight;
                const contentTop = $postContent[0].getBoundingClientRect().top + window.scrollY;
                const windowHeight = $(window).height();
                const scrollPosition = $(window).scrollTop();
                const totalScrollable = contentHeight - windowHeight;
                let progress = (scrollPosition - contentTop) / totalScrollable;
                progress = Math.max(0, Math.min(progress, 1));
                $progressBar.css('transform', `scaleX(${progress})`);
            }

            // TOC Position
            function updateTOCPosition() {
                const scrollPosition = $(window).scrollTop();
                const windowHeight = $(window).height();
                const articleBottom = $article.offset().top + $article.outerHeight();
                const tocHeight = $tocContainer.outerHeight();
                const $tocParent = $tocContainer.parent();
                const maxScroll = articleBottom - tocHeight - 24;

                if (scrollPosition + windowHeight > articleBottom) {
                    $tocContainer.css({
                        position: 'absolute',
                        top: `${Math.max(24, maxScroll)}px`
                    });
                    $tocParent.css('height', `${articleBottom - $tocContainer.offset().top}px`);
                } else {
                    $tocContainer.css({
                        position: 'sticky',
                        top: '6rem'
                    });
                    $tocParent.css('height', 'auto');
                }
            }

            // Intersection Observer for TOC highlighting
            const observerOptions = {
                root: null,
                rootMargin: '-20% 0px -70% 0px',
                threshold: [0, 0.1, 0.2, 0.3, 0.4, 0.5, 0.6, 0.7, 0.8, 0.9, 1.0]
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const id = entry.target.getAttribute('id');
                        const $activeLink = $toc.find(`a[href="#${id}"]`);
                        const relation = headingRelations.get(id);

                        $toc.find('a').removeClass('bg-gray-100 text-primary-600 font-medium');

                        if ($activeLink.length) {
                            $activeLink.addClass('bg-gray-100 text-primary-600 font-medium');
                            if (relation && relation.parent) {
                                const parentData = parentContainers.get(relation.parent);
                                if (parentData) {
                                    $(parentData.link).addClass('bg-gray-100 text-primary-600 font-medium');
                                }
                            }
                        }
                    }
                });
            }, observerOptions);

            $headings.each(function() {
                observer.observe(this);
            });

            // Scroll and resize handlers
            let ticking = false;

            function onScrollOrResize() {
                updateReadingProgress();
                updateTOCPosition();
                ticking = false;
            }

            $(window).on('scroll resize', function() {
                if (!ticking) {
                    window.requestAnimationFrame(onScrollOrResize);
                    ticking = true;
                }
            });

            // Back to Top Button
            const $backToTop = $('#back-to-top');
            $(window).on('scroll', function() {
                if ($(this).scrollTop() > 300) {
                    $backToTop.removeClass('opacity-0 invisible').addClass('opacity-100 visible');
                } else {
                    $backToTop.addClass('opacity-0 invisible').removeClass('opacity-100 visible');
                }
            });

            $backToTop.on('click', function() {
                $('html, body').animate({
                    scrollTop: 0
                }, 'smooth');
            });

            // Smooth scroll for TOC links
            $toc.find('a').on('click', function(e) {
                const targetId = $(this).attr('href');
                const $targetElement = $(targetId);
                if ($targetElement.length) {
                    e.preventDefault();
                    $('html, body').animate({
                        scrollTop: $targetElement.offset().top
                    }, 'smooth');
                }
            });
        }

        // Modern Copy Link
        const $copyBtn = $('#copy-link');
        const $postLink = $('#post-link');
        const $copySuccess = $('#copy-success');

        if ($copyBtn.length && $postLink.length && $copySuccess.length) {
            $copyBtn.on('click', async function() {
                try {
                    await navigator.clipboard.writeText($postLink.val());
                    $copySuccess.removeClass('hidden');
                    setTimeout(() => $copySuccess.addClass('hidden'), 2000);
                } catch (err) {
                    alert('Failed to copy link');
                }
            });
        }

        // Read in Short toggle
        const $toggleBtn = $('#toggle-summary');
        const $postSummary = $('#post-summary');

        if ($toggleBtn.length && $postSummary.length && $postContent.length) {
            let showingSummary = false;
            $toggleBtn.on('click', function() {
                showingSummary = !showingSummary;
                if (showingSummary) {
                    $postSummary.removeClass('hidden');
                    $postContent.addClass('hidden');
                    $(this).find('span').text('Read Full');
                    $(this).find('i').removeClass('fa-align-left').addClass('fa-book-open');
                } else {
                    $postSummary.addClass('hidden');
                    $postContent.removeClass('hidden');
                    $(this).find('span').text('Read in Short');
                    $(this).find('i').removeClass('fa-book-open').addClass('fa-align-left');
                }
            });
        }


        // Function to get IP details from free service
        async function getIPDetails() {
            try {
                const response = await fetch('https://ipapi.co/json/');
                const data = await response.json();
                return {
                    ip: data.ip,
                    city: data.city,
                    country: data.country_name,
                    region: data.region
                };
            } catch (error) {
                console.error('Error fetching IP details:', error);
                return null;
            }
        }

        // Function to track post view with IP details
        async function trackPostView() {
            let ipDetails = localStorage.getItem('ipDetails');
            const startTime = Date.now();

            if (!ipDetails) {
                ipDetails = await getIPDetails();
                if (ipDetails) {
                    localStorage.setItem('ipDetails', JSON.stringify(ipDetails));
                }
            } else {
                ipDetails = JSON.parse(ipDetails);
            }

            // Create tracking URL with available data
            let trackingUrl = '/tracking/post?post_id=<?= $post['id'] ?>';

            if (ipDetails) {
                trackingUrl += `&ip=${ipDetails.ip}&city=${ipDetails.city}&country=${ipDetails.country}&region=${ipDetails.region}`;
            }

            // Track initial view
            $('<img>')
                .attr('src', trackingUrl)
                .css('display', 'none')
                .appendTo('body');

            // Track view duration when user leaves the page
            $(window).on('beforeunload', function() {
                const duration = Math.floor((Date.now() - startTime) / 1000); // Convert to seconds
                const durationUrl = `${trackingUrl}&view_duration=${duration}`;
                console.log(durationUrl);
                // Use sendBeacon for more reliable tracking on page unload
                if (navigator.sendBeacon) {
                    navigator.sendBeacon(durationUrl);
                } else {
                    // Fallback to image if sendBeacon is not supported
                    $('<img>')
                        .attr('src', durationUrl)
                        .css('display', 'none')
                        .appendTo('body');
                }
            });
        }

        // Track post view by calling trackPostView when page loads
        trackPostView();
        updateReadingProgress(); // Initialize progress bar on page load
    });
</script>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    /* Custom styles for better typography */
    .prose {
        font-size: 1.125rem;
        line-height: 1.8;
        color: #1a202c;
    }

    .dark .prose {
        color: #e2e8f0;
    }

    .prose h2 {
        font-size: 1.875rem;
        margin-top: 2.5rem;
        margin-bottom: 1.5rem;
        color: #1a202c;
        scroll-margin-top: 100px;
    }

    .dark .prose h2 {
        color: #f7fafc;
    }

    .prose h3 {
        font-size: 1.5rem;
        margin-top: 2rem;
        margin-bottom: 1rem;
        color: #2d3748;
        scroll-margin-top: 100px;
    }

    .dark .prose h3 {
        color: #e2e8f0;
    }

    .prose h4 {
        font-size: 1.25rem;
        margin-top: 1.5rem;
        margin-bottom: 1rem;
        color: #2d3748;
        scroll-margin-top: 100px;
    }

    .dark .prose h4 {
        color: #e2e8f0;
    }

    .prose p {
        margin-bottom: 1.5rem;
    }

    .prose img {
        border-radius: 0.5rem;
        margin: 2rem 0;
        max-width: 100%;
        height: auto;
    }

    .prose blockquote {
        border-left: 4px solid #4299e1;
        padding-left: 1rem;
        font-style: italic;
        color: #4a5568;
    }

    .dark .prose blockquote {
        color: #a0aec0;
    }

    .prose code {
        background-color: #f7fafc;
        padding: 0.2rem 0.4rem;
        border-radius: 0.25rem;
        font-size: 0.875em;
    }

    .dark .prose code {
        background-color: #2d3748;
        color: #e2e8f0;
    }

    .prose pre {
        background-color: #2d3748;
        color: #e2e8f0;
        padding: 1rem;
        border-radius: 0.5rem;
        overflow-x: auto;
    }

    .dark .prose pre {
        background-color: #1a202c;
    }

    /* Smooth transitions */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 300ms;
    }

    /* TOC Container Styles */
    #toc-container {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .dark #toc-container {
        background-color: #1a202c;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2), 0 2px 4px -1px rgba(0, 0, 0, 0.1);
    }

    #toc-container #toc {
        position: sticky;
        top: 6rem;
        height: calc(100vh - 5rem);
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #cbd5e0 #f7fafc;
        scroll-behavior: smooth;
        overscroll-behavior: contain;
    }

    .dark #toc-container #toc {
        scrollbar-color: #4a5568 #2d3748;
    }

    #toc-container::-webkit-scrollbar {
        width: 6px;
    }

    #toc-container::-webkit-scrollbar-track {
        background: #f7fafc;
        border-radius: 3px;
    }

    .dark #toc-container::-webkit-scrollbar-track {
        background: #2d3748;
    }

    #toc-container::-webkit-scrollbar-thumb {
        background-color: #cbd5e0;
        border-radius: 3px;
    }

    .dark #toc-container::-webkit-scrollbar-thumb {
        background-color: #4a5568;
    }

    #toc-container::-webkit-scrollbar-thumb:hover {
        background-color: #a0aec0;
    }

    .dark #toc-container::-webkit-scrollbar-thumb:hover {
        background-color: #718096;
    }

    /* TOC Item Styles */
    .toc-item {
        position: relative;
    }

    .toc-children {
        transition: all 0.3s ease;
        overflow: hidden;
        margin-left: 1rem;
    }

    .toc-children.hidden {
        display: none;
    }

    /* Active TOC link styles */
    #toc a.active,
    #toc a.bg-gray-100 {
        background-color: #f3f4f6;
        color: #3b82f6;
        font-weight: 500;
        transform: translateX(4px);
    }

    .dark #toc a.active,
    .dark #toc a.bg-gray-100 {
        background-color: #2d3748;
        color: #63b3ed;
    }

    #toc a.active i,
    #toc a.bg-gray-100 i {
        color: #3b82f6;
        transform: scale(1.1);
    }

    .dark #toc a.active i,
    .dark #toc a.bg-gray-100 i {
        color: #63b3ed;
    }

    /* TOC link hover effects */
    #toc a {
        position: relative;
        overflow: hidden;
        color: #4a5568;
    }

    .dark #toc a {
        color: #a0aec0;
    }

    #toc a::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 3px;
        background-color: #3b82f6;
        transform: scaleY(0);
        transition: transform 0.2s ease;
    }

    .dark #toc a::before {
        background-color: #63b3ed;
    }

    #toc a:hover::before,
    #toc a.active::before,
    #toc a.bg-gray-100::before {
        transform: scaleY(1);
    }

    /* TOC icon animations */
    #toc a i {
        transition: all 0.2s ease;
    }

    #toc a:hover i {
        transform: scale(1.1);
    }

    /* Ensure TOC content is properly spaced */
    #toc {
        padding-bottom: 1rem;
    }

    /* Make sure the sticky header doesn't overlap content */
    #toc-container h3 {
        background: white;
        padding-bottom: 0.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        color: #1a202c;
    }

    .dark #toc-container h3 {
        background: #1a202c;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        color: #f7fafc;
    }

    /* Reading Progress Bar Styles */
    #reading-progress {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(to right, #3b82f6, #2563eb);
        transform-origin: 0 50%;
        z-index: 9999;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        width: 100vw;
        will-change: transform;
        transform: scaleX(0);
    }

    /* Modern Share Box Styles */
    #copy-link {
        position: relative;
        overflow: hidden;
        font-size: 0.95rem;
        font-weight: 500;
    }

    #copy-link i {
        transition: transform 0.2s;
    }

    #copy-link:hover i {
        transform: scale(1.1);
    }

    #copy-success {
        transition: all 0.3s;
    }

    input#post-link {
        cursor: pointer;
    }

    input#post-link:focus {
        background: #f0f9ff;
    }

    .dark input#post-link:focus {
        background: #2d3748;
    }

    #toggle-summary {
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
        font-size: 1rem;
    }

    #toggle-summary i {
        transition: transform 0.2s;
    }

    #toggle-summary:hover i {
        transform: scale(1.1);
    }

    #post-summary {
        animation: fadeIn 0.3s;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Mobile Responsiveness */
    @media (max-width: 768px) {
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .prose {
            font-size: 1rem;
        }

        .prose h2 {
            font-size: 1.5rem;
            margin-top: 2rem;
        }

        .prose h3 {
            font-size: 1.25rem;
            margin-top: 1.5rem;
        }

        .prose h4 {
            font-size: 1.125rem;
            margin-top: 1.25rem;
        }

        .prose img {
            margin: 1.5rem 0;
        }

        #toc-container {
            display: none;
        }

        .share-box {
            padding: 1rem;
        }

        .share-box .flex {
            flex-wrap: wrap;
        }

        .share-box .gap-4 {
            gap: 0.5rem;
        }
    }

    /* Dark mode styles for share box */
    .dark .share-box {
        background-color: #1a202c;
        border-color: #2d3748;
    }

    .dark .share-box .text-gray-900 {
        color: #f7fafc;
    }

    .dark .share-box .text-gray-400 {
        color: #a0aec0;
    }

    .dark .share-box .bg-gray-50 {
        background-color: #2d3748;
    }

    .dark .share-box .text-gray-700 {
        color: #e2e8f0;
    }

    /* Dark mode styles for tags */
    .dark .bg-gray-100 {
        background-color: #2d3748;
    }

    .dark .text-gray-800 {
        color: #e2e8f0;
    }

    .dark .hover\:bg-gray-200:hover {
        background-color: #4a5568;
    }
</style>
<?= $this->endSection() ?>