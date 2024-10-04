$(document).on('click', '.mobile-filter-btn', function() {
    const filter_section = $('.mobile-header-filter-section');
    const mobile_filter_products_drawer_section = $('.mobile-filter-products-drawer-section');
    filter_section.removeClass('hidden');
    mobile_filter_products_drawer_section.removeClass('hidden');
});

$(document).on('click', '.mobile-header-filter-close-btn', function() {
    const filter_section = $('.mobile-header-filter-section');
    const mobile_filter_products_drawer_section = $('.mobile-filter-products-drawer-section');
    filter_section.addClass('hidden');
    mobile_filter_products_drawer_section.addClass('hidden');
});

$(document).on('click', '.mobile-pages-drawer-btn', function() {
    const filter_section = $('.mobile-header-filter-section');
    const mobile_filter_products_drawer_section = $('.mobile-pages-drawer-section');
    filter_section.removeClass('hidden');
    mobile_filter_products_drawer_section.removeClass('hidden');
});

$(document).on('click', '.mobile-header-filter-close-btn', function() {
    const filter_section = $('.mobile-header-filter-section');
    const mobile_filter_products_drawer_section = $('.mobile-pages-drawer-section');
    filter_section.addClass('hidden');
    mobile_filter_products_drawer_section.addClass('hidden');
});


function toggleSearchBarVisibility() {
    const filter_section = document.querySelector('.top-product-search-bar');
    const searchBarVisible = localStorage.getItem('searchBarVisible');

    if (window.location.pathname === "/" && searchBarVisible === 'true') {
        filter_section.classList.remove('hidden'); 
        localStorage.removeItem('searchBarVisible');
    }
}

toggleSearchBarVisibility();

$(document).on('click', '.top-product-search-btn', function() {
    localStorage.setItem('searchBarVisible', 'true');
});