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
                    <div class="flex items-center text-gray-600 text-sm mb-4">
                        <a href="<?= base_url('category/' . $post['category_slug']) ?>" class="text-primary-600 hover:text-primary-800 mr-4">
                            <i class="fas fa-folder"></i> <?= esc($post['category_name']) ?>
                        </a>
                        <span class="mr-4">
                            <i class="fas fa-calendar"></i> <?= date('M d, Y', strtotime($post['published_at'])) ?>
                        </span>
                        <span class="mr-4">
                            <i class="fas fa-user"></i> <?= esc($post['author_name']) ?>
                        </span>
                        <span class="mr-4">
                            <i class="fas fa-eye"></i> <?= number_format($post['views']) ?> views
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
            'title' => 'Related Posts',
            'layout' => 'StandardGrid',
            'posts' => $relatedPosts,
        ]); ?>
    </div>
</div>

<!-- Back to Top Button -->
<button id="back-to-top" class="fixed bottom-8 right-8 bg-primary-600 text-white p-3 rounded-full shadow-lg hover:bg-primary-700 transition-all duration-300 opacity-0 invisible">
    <i class="fas fa-arrow-up"></i>
</button>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Reading Progress Bar
        const progressBar = document.getElementById('reading-progress');
        const postContent = document.getElementById('post-content');
        const tocContainer = document.getElementById('toc-container');
        const article = document.querySelector('article');
        const toc = document.getElementById('toc');
        const headings = postContent.querySelectorAll('h2, h3, h4');
        let firstSection = true;
        let currentParent = null;

        // Store all parent containers and their children
        const parentContainers = new Map();
        const headingRelations = new Map();

        if (tocContainer && toc && postContent) {

            // Build heading relationships
            let currentH2 = null;
            headings.forEach((heading) => {
                const level = parseInt(heading.tagName.charAt(1));
                if (level === 2) {
                    currentH2 = heading.id;
                    headingRelations.set(heading.id, {
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
                    headingRelations.get(currentH2).children.add(heading.id);
                    headingRelations.set(heading.id, {
                        parent: currentH2,
                        children: new Set()
                    });
                }
            });

            // Generate TOC
            headings.forEach((heading, index) => {
                if (!heading.id) {
                    heading.id = `heading-${index}`;
                }
                const level = parseInt(heading.tagName.charAt(1));
                const indent = (level - 2) * 1.5;
                const linkContainer = document.createElement('div');
                linkContainer.className = 'toc-item';
                const link = document.createElement('a');
                link.href = `#${heading.id}`;
                const icon = document.createElement('i');
                icon.className = `mr-2 text-primary-500 ${level === 2 ? 'fas fa-circle' : level === 3 ? 'fas fa-circle-dot' : 'far fa-circle'}`;
                const text = document.createElement('span');
                text.textContent = heading.textContent;
                link.appendChild(icon);
                link.appendChild(text);
                link.className = 'block py-2 px-3 rounded-lg hover:bg-gray-50 hover:text-primary-600 transition-all duration-200 flex items-center group';
                link.style.marginLeft = `${indent}rem`;
                if (level === 2) {
                    const toggleIcon = document.createElement('i');
                    toggleIcon.className = 'fas fa-chevron-down ml-auto text-gray-400 transition-transform duration-200';
                    link.appendChild(toggleIcon);
                    const childrenContainer = document.createElement('div');
                    childrenContainer.className = 'toc-children';
                    if (!firstSection) {
                        childrenContainer.classList.add('hidden');
                        toggleIcon.style.transform = 'rotate(0deg)';
                    } else {
                        toggleIcon.style.transform = 'rotate(-180deg)';
                        firstSection = false;
                    }
                    const relation = headingRelations.get(heading.id) || {
                        children: new Set()
                    };
                    parentContainers.set(heading.id, {
                        container: childrenContainer,
                        toggleIcon: toggleIcon,
                        link: link,
                        children: relation.children
                    });
                    link.addEventListener('click', (e) => {
                        e.preventDefault();
                        const isExpanded = !childrenContainer.classList.contains('hidden');
                        childrenContainer.classList.toggle('hidden');
                        toggleIcon.style.transform = isExpanded ? 'rotate(0deg)' : 'rotate(-180deg)';
                    });
                    linkContainer.appendChild(link);
                    linkContainer.appendChild(childrenContainer);
                    toc.appendChild(linkContainer);
                    currentParent = childrenContainer;
                } else {
                    linkContainer.appendChild(link);
                    if (currentParent) {
                        currentParent.appendChild(linkContainer);
                    } else {
                        toc.appendChild(linkContainer);
                    }
                }
                link.addEventListener('mouseenter', () => {
                    icon.classList.add('scale-110');
                });
                link.addEventListener('mouseleave', () => {
                    icon.classList.remove('scale-110');
                });
            });

            // Reading Progress Bar
            function updateReadingProgress() {
                const contentHeight = postContent.offsetHeight;
                const scrollPosition = window.scrollY;
                const windowHeight = window.innerHeight;
                const contentTop = postContent.offsetTop;
                const scrolled = scrollPosition + windowHeight - contentTop;
                const totalScrollable = contentHeight + windowHeight;
                const progress = (scrolled / totalScrollable) * 100;
                progressBar.style.transform = `scaleX(${Math.min(Math.max(progress, 0), 100) / 100})`;
            }

            // TOC Position
            function updateTOCPosition() {
                const scrollPosition = window.scrollY;
                const windowHeight = window.innerHeight;
                const articleBottom = article.offsetTop + article.offsetHeight;
                const tocHeight = tocContainer.offsetHeight;
                const tocParent = tocContainer.parentElement;
                const maxScroll = articleBottom - tocHeight - 24;
                if (scrollPosition + windowHeight > articleBottom) {
                    tocContainer.style.position = 'absolute';
                    tocContainer.style.top = `${Math.max(24, maxScroll)}px`;
                    tocParent.style.height = `${articleBottom - tocContainer.offsetTop}px`;
                } else {
                    tocContainer.style.position = 'sticky';
                    tocContainer.style.top = '6rem';
                    tocParent.style.height = 'auto';
                }
            }

            // Highlight current section in TOC and scroll TOC to keep current section visible
            const observerOptions = {
                root: null,
                rootMargin: '-20% 0px -70% 0px',
                threshold: [0, 0.1, 0.2, 0.3, 0.4, 0.5, 0.6, 0.7, 0.8, 0.9, 1.0]
            };
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const id = entry.target.getAttribute('id');
                        const activeLink = toc.querySelector(`a[href="#${id}"]`);
                        const relation = headingRelations.get(id);
                        toc.querySelectorAll('a').forEach(link => {
                            link.classList.remove('bg-gray-100', 'text-primary-600', 'font-medium');
                        });
                        if (activeLink) {
                            activeLink.classList.add('bg-gray-100', 'text-primary-600', 'font-medium');
                            if (relation && relation.parent) {
                                const parentData = parentContainers.get(relation.parent);
                                if (parentData) {
                                    parentData.link.classList.add('bg-gray-100', 'text-primary-600', 'font-medium');
                                }
                            }
                        }
                    }
                });
            }, observerOptions);

            headings.forEach(heading => observer.observe(heading));

            // Combined scroll/resize event listeners
            let ticking = false;

            function onScrollOrResize() {
                updateReadingProgress();
                updateTOCPosition();
                ticking = false;
            }
            window.addEventListener('scroll', () => {
                if (!ticking) {
                    window.requestAnimationFrame(onScrollOrResize);
                    ticking = true;
                }
            });
            window.addEventListener('resize', onScrollOrResize);

            // Back to Top Button
            const backToTop = document.getElementById('back-to-top');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 300) {
                    backToTop.classList.remove('opacity-0', 'invisible');
                    backToTop.classList.add('opacity-100', 'visible');
                } else {
                    backToTop.classList.add('opacity-0', 'invisible');
                    backToTop.classList.remove('opacity-100', 'visible');
                }
            });
            backToTop.addEventListener('click', () => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

            // Smooth scroll for TOC links
            if (toc) {
                toc.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', function(e) {
                        const targetId = link.getAttribute('href');
                        const targetElement = document.querySelector(targetId);
                        if (targetElement) {
                            e.preventDefault();
                            targetElement.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    });
                });
            }
        }

        // Modern Copy Link
        const copyBtn = document.getElementById('copy-link');
        const postLink = document.getElementById('post-link');
        const copySuccess = document.getElementById('copy-success');
        if (copyBtn && postLink && copySuccess) {
            copyBtn.addEventListener('click', async () => {
                try {
                    await navigator.clipboard.writeText(postLink.value);
                    copySuccess.classList.remove('hidden');
                    setTimeout(() => copySuccess.classList.add('hidden'), 2000);
                } catch (err) {
                    alert('Failed to copy link');
                }
            });
        }

        // Read in Short toggle
        const toggleBtn = document.getElementById('toggle-summary');
        const postSummary = document.getElementById('post-summary');
        if (toggleBtn && postSummary && postContent) {
            let showingSummary = false;
            toggleBtn.addEventListener('click', function() {
                showingSummary = !showingSummary;
                if (showingSummary) {
                    postSummary.classList.remove('hidden');
                    postContent.classList.add('hidden');
                    toggleBtn.querySelector('span').textContent = 'Read Full';
                    toggleBtn.querySelector('i').className = 'fas fa-book-open';
                } else {
                    postSummary.classList.add('hidden');
                    postContent.classList.remove('hidden');
                    toggleBtn.querySelector('span').textContent = 'Read in Short';
                    toggleBtn.querySelector('i').className = 'fas fa-align-left';
                }
            });
        }

    });
</script>

<style>
    /* Custom styles for better typography */
    .prose {
        font-size: 1.125rem;
        line-height: 1.8;
    }

    .prose h2 {
        font-size: 1.875rem;
        margin-top: 2.5rem;
        margin-bottom: 1.5rem;
        color: #1a202c;
        scroll-margin-top: 100px;
    }

    .prose h3 {
        font-size: 1.5rem;
        margin-top: 2rem;
        margin-bottom: 1rem;
        color: #2d3748;
        scroll-margin-top: 100px;
    }

    .prose h4 {
        font-size: 1.25rem;
        margin-top: 1.5rem;
        margin-bottom: 1rem;
        color: #2d3748;
        scroll-margin-top: 100px;
    }

    .prose p {
        margin-bottom: 1.5rem;
    }

    .prose img {
        border-radius: 0.5rem;
        margin: 2rem 0;
    }

    .prose blockquote {
        border-left: 4px solid #4299e1;
        padding-left: 1rem;
        font-style: italic;
        color: #4a5568;
    }

    .prose code {
        background-color: #f7fafc;
        padding: 0.2rem 0.4rem;
        border-radius: 0.25rem;
        font-size: 0.875em;
    }

    .prose pre {
        background-color: #2d3748;
        color: #e2e8f0;
        padding: 1rem;
        border-radius: 0.5rem;
        overflow-x: auto;
    }

    /* Smooth transitions */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 300ms;
    }

    /* TOC Container Styles */
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

    #toc-container::-webkit-scrollbar {
        width: 6px;
    }

    #toc-container::-webkit-scrollbar-track {
        background: #f7fafc;
        border-radius: 3px;
    }

    #toc-container::-webkit-scrollbar-thumb {
        background-color: #cbd5e0;
        border-radius: 3px;
    }

    #toc-container::-webkit-scrollbar-thumb:hover {
        background-color: #a0aec0;
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

    #toc a.active i,
    #toc a.bg-gray-100 i {
        color: #3b82f6;
        transform: scale(1.1);
    }

    /* TOC link hover effects */
    #toc a {
        position: relative;
        overflow: hidden;
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
</style>

<?= $this->endSection() ?>