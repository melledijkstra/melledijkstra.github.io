let storiesMasonry = null;

window.addEventListener('load', function () {
    if (storiesMasonry) {
        storiesMasonry.layout();
    }
    const loader = document.getElementById('page-loader-wrap');
    if (loader) {
        loader.style.transition = 'opacity 500ms';
        loader.style.opacity = '0';
        setTimeout(function () {
            loader.style.display = 'none';
        }, 500);
    }
});

function initStoriesGrid() {
    const gridElement = document.getElementById('grid');
    if (!gridElement) return;

    storiesMasonry = new Masonry(gridElement, {
        columnWidth: '.grid-sizer',
        itemSelector: '.grid-item',
        percentPosition: true
    });

    imagesLoaded(gridElement).on('progress', function () {
        // init Masonry after all images have loaded
        storiesMasonry.layout();
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initStoriesGrid);
} else {
    initStoriesGrid();
}
