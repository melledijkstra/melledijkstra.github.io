$(window).on('load', function() {
    $('#page-loader-wrap').fadeOut(500);
});

$(document).on('ready', function() {
    let grid = $('#grid').masonry({
        "columnWidth": ".grid-sizer",
        "itemSelector": ".grid-item",
        "percentPosition": true
    });

    grid.imagesLoaded().progress(function() {
        // init Masonry after all images have loaded
        grid.masonry('layout');
    });

});
