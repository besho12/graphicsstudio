(function ($) {
    "use strict";

    /** variables */
    var filters = {};

    function fetchProductData(page = 1, filters = {}) {
        const filterParams = new URLSearchParams(filters).toString();
        $.ajax({
            url: `${base_url}/fetch-products?page=${page}&${filterParams}`,
            beforeSend: function () {
                showPreLoader();
            },
            success: function (data) {
                $(".shop__inner-wrap").html(data.views);
                $(".price_slider").slider({
                    range: true,
                    min: 0,
                    max: data.max_price,
                    values: [data.from, data.to],
                    slide: function(event, ui) {
                        $(".from").text(currency_code + + ui.values[0]);
                        $(".to").text(currency_code + + ui.values[1]);
                    },
                    change: function (event, ui) {
                        filters.from = ui.values[0];
                        filters.to = ui.values[1];
                        fetchProductData(1, filters);
                    }
                });
                $(".from").text(currency_code + $(".price_slider").slider("values", 0));
                $(".to").text(currency_code + $(".price_slider").slider("values", 1));
                scrollToElement(".top-baseline");
            },
            error: () => toastr.error(basic_error_message),
            complete: hidePreLoader,
        });

        // Update browser history
        history.pushState({ page, filters }, null, window.location.pathname + (filterParams ? `?${filterParams}` : ""));
    }

    $(document).on("click", ".search-product-btn", function () {
        var search = $('.search-input').val();
        filters.search = search;
        fetchProductData(1, filters);
    });

    $(document).on("change", ".orderby", function (e) {
        var orderby = $(this).val();
        filters.orderby = orderby;
        fetchProductData(1, filters);
    });

    $(document).on("change", ".category-checkbox", function () {
        var selectedCategories = [];
        $(".category-checkbox:checked").each(function () {
            selectedCategories.push($(this).val());
        });
        filters.category = selectedCategories.join(",");
        fetchProductData(1, filters);
    });

    $(document).on("change", ".rating-checkbox", function () {
        var selectedRatings = [];
        $(".rating-checkbox:checked").each(function () {
            selectedRatings.push($(this).val());
        });
        filters.rating = selectedRatings.join(",");
        fetchProductData(1, filters);
    });

    $(document).on("click", ".filter-by-tag a", function (e) {
        e.preventDefault();
        var tag = $(this).data("tag");
        filters.tag = tag;
        fetchProductData(1, filters);
    });

    $(document).on("click", ".pagination a", function (e) {
        e.preventDefault();
        var page = $(this).attr("href").split("page=")[1];
        if (page) {
            fetchProductData(page, filters);
        }
    });

    // On Document Load
    $(document).ready(function () {
        var urlParams = new URLSearchParams(window.location.search);
        var page = urlParams.get("page") || 1;
        var search = urlParams.get("search");
        var orderby = urlParams.get("orderby");
        var tag = urlParams.get("tag");
        var category = urlParams.get("category");
        var rating = urlParams.get("rating");
        var from = urlParams.get("from");
        var to = urlParams.get("to");

        if (search) {
            filters.search = search;
        }
        if (orderby) {
            filters.orderby = orderby;
        }
        if (tag) {
            filters.tag = tag;
        }
        if (from) {
            filters.from = from;
        }
        if (to) {
            filters.to = to;
        }

        if (category) {
            filters.category = category.split(",");
            $(".category-checkbox").each(function () {
                if (filters.category.includes($(this).val())) {
                    $(this).prop("checked", true);
                }
            });
        }
        if (rating) {
            filters.rating = rating.split(",");
            $(".rating-checkbox").each(function () {
                if (filters.rating.includes($(this).val())) {
                    $(this).prop("checked", true);
                }
            });
        }
        $("html, body").animate({ scrollTop: $('.wsus_topbar').offset().top }, 0);
        fetchProductData(page, filters);
    });
})(jQuery);