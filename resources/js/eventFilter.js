jQuery(function () {

    /**
     * Filter criteria storage object
     *
     * @var Object
     */
    var filterData = {
        categories: [],
        dateRange: {},
        searchTerms: [],
        page: 1
    };

    $daterange = $('.daterange');

    // Reset form on page reload
    $('.event-filter-form').trigger('reset');

    // Checkbox handling logic
    $('.event-filter-form input[type=checkbox]').on('click', function (e) {
        if (e.target.name === 'all') {
            if ($('input[name="all"]').is(':checked')) {
                $('input[type=checkbox]').not('[name="all"]').prop('checked', false);
                filterData.categories.length = 0;
                filterData.page = 1;
                fetchEvents(filterData);
            }
        } else {
            $('input[name="all"]').prop('checked', false);
            filterData.categories.length = 0;
            filterData.page = 1;
            $('input[type=checkbox]:checked').each(function () {
                filterData.categories.push($(this).val());
            })
            fetchEvents(filterData);
        };
    });

    // Search field handling logic
    $('.search-input-field').on('keyup', function (event) {
        if (event.which === 13) {
            $('.btn-search').trigger('click');
        }
    });

    $('.btn-search').on('click', function () {
        $searchField = $('.search-input-field');
        if ($searchField.val()) {
            input = $searchField.val().trim();
            if (input) {
                filterData.searchTerms = input.split(/\s+/);
                fetchEvents(filterData);
            }
        } else {
            filterData.searchTerms.length = 0;
            fetchEvents(filterData);
        }
    });

    // Page button handling logic
    $(document).on('click', '.page-link-btn', function (event) {
        event.preventDefault();
        filterData.page = $(this).attr('href').split('page=')[1];
        fetchEvents(filterData);
    });

    // Calendar handling logic
    moment.locale('lv');
    $daterange.daterangepicker({
        autoUpdateInput: false,
        "locale": {
            "applyLabel": "Lietot",
            "cancelLabel": "Notīrīt",
        },
        opens: 'left',
    },
        function (start, end) {
            filterData.dateRange['start'] = start.format('YYYY-MM-DD');
            filterData.dateRange['end'] = end.format('YYYY-MM-DD');
            $daterange.val(start.format('DD.MM.YYYY.') + ' - ' + end.format('DD.MM.YYYY.'));
            fetchEvents(filterData);
        });

    $('.datepicker-btn').on('click', function () {
        $daterange.data('daterangepicker').toggle();
    });

    $daterange.on('cancel.daterangepicker', function () {
        for (prop in filterData.dateRange) {
            delete filterData.dateRange[prop];
        }
        $daterange.val('');
        fetchEvents(filterData);
    });

    /**
     * Fetch event grid view with filtered events
     *
     * @param   Object  options  
     */
    function fetchEvents(options) {
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
});
