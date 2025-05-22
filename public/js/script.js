// Carousel class-based logic for multiple carousels
(function () {
    document.querySelectorAll('[class^="carousel-scroll-"]').forEach(function (scrollContainer) {
        var classList = Array.from(scrollContainer.classList);
        var idClass = classList.find(function (cls) { return cls.startsWith('carousel-scroll-'); });
        if (!idClass) return;
        var carouselId = idClass.replace('carousel-scroll-', '');
        var leftBtn = document.querySelector('.carousel-btn-left-' + carouselId);
        var rightBtn = document.querySelector('.carousel-btn-right-' + carouselId);
        if (!leftBtn || !rightBtn) return;
        // Try to detect type from data attribute, fallback to compact
        var type = scrollContainer.getAttribute('data-carousel-type') || (scrollContainer.classList.contains('gap-8') ? 'grid' : 'compact');
        function getScrollAmount() {
            var card = scrollContainer.querySelector('article');
            if (!card) return (type === 'compact') ? 532 : 350;
            if (type === 'compact') {
                var gap = parseInt(window.getComputedStyle(scrollContainer).columnGap || window.getComputedStyle(scrollContainer).gap) || 0;
                return card.offsetWidth + gap;
            } else {
                var style = window.getComputedStyle(card);
                var marginRight = parseInt(style.marginRight) || 0;
                return card.offsetWidth + marginRight;
            }
        }
        function updateArrows() {
            leftBtn.disabled = scrollContainer.scrollLeft <= 0;
            rightBtn.disabled = scrollContainer.scrollLeft + scrollContainer.offsetWidth >= scrollContainer.scrollWidth - 2;
        }
        leftBtn.addEventListener('click', function () {
            scrollContainer.scrollBy({
                left: -getScrollAmount(),
                behavior: 'smooth'
            });
        });
        rightBtn.addEventListener('click', function () {
            scrollContainer.scrollBy({
                left: getScrollAmount(),
                behavior: 'smooth'
            });
        });
        scrollContainer.addEventListener('scroll', updateArrows);
        updateArrows();
    });
})();
