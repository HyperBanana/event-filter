const { filter } = require("lodash");

jQuery(function () {

    var filterOptions = {
        categories: [],
        dateRange: {},
        searchTerms: [],
        page: 1
    }

    // Reset form on page reload
    $('.event-categories-form').trigger('reset');

    // Checkbox handling
    $('.event-categories-form input[type=checkbox]').on('click', function (e) {
        if (e.target.name === 'all') {
            if ($('input[name="all"]').is(':checked')) {
                $('input[type=checkbox]:not([name="all"])').prop('checked', false);
                filterOptions.categories.length = 0;
                filterOptions.page = 1;
                fetchEvents(filterOptions);
            }
        } else {
            $('input[name="all"]').prop('checked', false);
            filterOptions.categories.length = 0;
            filterOptions.page = 1;
            $('input[type=checkbox]:checked').each(function () {
                filterOptions.categories.push($(this).val());
            })
            fetchEvents(filterOptions);
        };
    });

    // Search handling
    $(document).on('keyup', '.search-input-field', function (event) {
        if (event.which === 13) {
            $('.btn-search').trigger('click');
        }
    });

    $(document).on('click', '.btn-search', function () {
        $searchField = $('[name=search-input-field]');
        if ($searchField.val() && $searchField.val().trim()) {
            filterOptions.searchTerms = $searchField.val().trim().split(/\s+/);
            fetchEvents(filterOptions);
        }
    });

    // Page button handling
    $(document).on('click', '.page-link-btn', function (event) {
        event.preventDefault();
        filterOptions.page = $(this).attr('href').split('page=')[1];
        fetchEvents(filterOptions);
    });

    /* $('.page-link-btn').on('click', function (event) {
        event.preventDefault();
        filterOptions.page = $(this).attr('href').split('page=')[1];
        fetchEvents(filterOptions);
    }); */

    // Calendar handling
    moment.locale('lv');
    $('.daterange').daterangepicker({
        autoUpdateInput: false,
        "locale": {
            "applyLabel": "Lietot",
            "cancelLabel": "Notīrīt",
        }
    },
        function (start, end) {
            filterOptions.dateRange['start'] = start.format('YYYY-MM-DD');
            filterOptions.dateRange['end'] = end.format('YYYY-MM-DD');
            $('.daterange').val(start.format('DD.MM.YYYY.') + ' - ' + end.format('DD.MM.YYYY.'));
            fetchEvents(filterOptions)
        });

    $('.daterange').data('daterangepicker').setStartDate('01/09/2018');
    $('.daterange').data('daterangepicker').setEndDate('10/09/2018');

    $('[data-toggle=datepicker]').on('click', function () {
        $('.daterange').data('daterangepicker').toggle();
    });
    $('.daterange').on('cancel.daterangepicker', function (ev, picker) {
        for (prop in filterOptions.dateRange) {
            delete filterOptions.dateRange[prop]
        }
        $('.daterange').val('');
        fetchEvents(filterOptions);
    });

    function fetchEvents(options) {
        //history.pushState({page : options.page}, '', '/');
        $.ajax({
            url: '/',
            type: 'GET',
            data: options,
            success: function (data) {
                if (data.error) {
                    console.log(data.error);
                } else {
                    $('.events-grid').html(data);
                }
            }
        });
    }

    /* function fetchEvents(url, searchCriteria, categories, dateRange, page) {
        page = page || 1;
        categories = categories || [];
        dateRange = dateRange || [];
        search = searchCriteria || undefined;
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                search : search,
                categories: categories,
                dateRange: dateRange,
                page: page
            },
            success: function (data) {
                if (data.error) {
                    console.log(data.error);
                } else {
                    $('.events-grid').html(data);
                }
            }
        });
    } */

    /* var categories = [];
    var dateRange = {};
    var searchCriteria;

    var filterOptions = {
        url: '',
        categories : [],
        dateRange : {},
        searchCriteria : '',
        page : 1
    }

    // Reset form on page reload
    $('.event-categories-form').trigger('reset');

    // Checkbox handling
    $('.event-categories-form input[type=checkbox]').on('click', function (e) {
        if (e.target.name === 'all') {
            if ($('input[name="all"]').is(':checked')) {
                $('input[type=checkbox]:not([name="all"])').prop('checked', false);
                categories.length = 0;
                fetchEvents('/eventFilter', searchCriteria, categories, dateRange);
            }
        } else {
            $('input[name="all"]').prop('checked', false);
            categories.length = 0;
            $('input[type=checkbox]:checked').each(function () {
                categories.push($(this).val());
            })
            fetchEvents('eventFilter', searchCriteria, categories, dateRange);
        };
    });

    // Search handling
    $(document).on('click', '.btn-search', function () {
        searchCriteria = $('[name=search-input-field]').val();
        fetchEvents('eventFilter', searchCriteria, categories, dateRange);
    });

     $(document).on('keyup', '.search-input-field', function(event) {
        if (event.which === 13) {
          $('.btn-search').trigger('click');
        }
      });  

    // Page link handling
    $(document).on('click', '.page-item', function (event) {
        event.preventDefault();
        var page = $(this).children('.page-link-button').attr('href').split('page=')[1];
        if ($('input[name="all"]').is(':checked')) {
            fetchEvents('/', categories, searchCriteria, dateRange, page);
        } else {
            categories.length = 0;
            $('input[type=checkbox]:checked').each(function () {
                categories.push($(this).val());
            })
            fetchEvents('eventFilter', searchCriteria, categories, dateRange, page);
        }
    });

    // Calendar handling
    moment.locale('lv');
    $('.daterange').daterangepicker({
        autoUpdateInput: false,
        "locale": {
            "applyLabel": "Lietot",
            "cancelLabel": "Notīrīt",
        }
    },
        function (start, end) {
            dateRange['start'] = start.format('YYYY-MM-DD');
            dateRange['end'] = end.format('YYYY-MM-DD');
            //$('.fa-calendar-alt').hide();
            $('.daterange').val(start.format('MM.DD.YYYY.') + ' - ' + end.format('MM.DD.YYYY.'));
            fetchEvents('eventFilter', searchCriteria, categories, dateRange)
        });

    $('.daterange').children('.fa-calendar-alt').on('click', function(){

    });
     $('.daterange').data('daterangepicker').setStartDate('01/09/2018');
    $('.daterange').data('daterangepicker').setEndDate('10/09/2018');

    $('[data-toggle=datepicker]').on('click', function(){
        $('.daterange').data('daterangepicker').toggle();
    });
    $('.daterange').on('cancel.daterangepicker', function (ev, picker) {
        delete dateRange.start;
        delete dateRange.end;
        $('.daterange').val('');
        //$('.fa-calendar-alt').show();
        fetchEvents('eventFilter', searchCriteria, categories, dateRange);

    });

    function fetchEvents(options) {
        url = options.url || '/';
        page = options.page || 1;
        categories = options.categories;
        dateRange = options.dateRange;
        search = options.searchCriteria || undefined;
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                search : search,
                categories: categories,
                dateRange: dateRange,
                page: page
            },
            success: function (data) {
                if (data.error) {
                    console.log(data.error);
                } else {
                    $('.events-grid').html(data);
                }
            }
        });
    } */
});
