jQuery(function () {
    var categories = [];
    var dateRange = {};

    // Reset form on page reload
    $('.event-categories-form').trigger('reset');

    // Checkbox handling
    $('.event-categories-form input[type=checkbox]').on('click', function (e) {
        if (e.target.name === 'all') {
            if ($('input[name="all"]').is(':checked')) {
                $('input[type=checkbox]:not([name="all"])').prop('checked', false);
                categories.length = 0;
                fetchEvents('/eventFilter', categories, dateRange);
            }
        } else {
            $('input[name="all"]').prop('checked', false);
            categories.length = 0;
            $('input[type=checkbox]:checked').each(function () {
                categories.push($(this).val());
            })
            fetchEvents('eventFilter', categories, dateRange);
        };
    });

    // Page link handling
    $(document).on('click', '.page-item:not(.active)', function (event) {
        event.preventDefault();
        var page = $(this).children('.page-link').attr('href').split('page=')[1];
        if ($('input[name="all"]').is(':checked')) {
            fetchEvents('/', categories, dateRange, page);
        } else {
            categories.length = 0;
            $('input[type=checkbox]:checked').each(function () {
                categories.push($(this).val());
            })
            fetchEvents('eventFilter', categories, dateRange, page);
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
            fetchEvents('eventFilter', categories, dateRange)
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
        fetchEvents('eventFilter', categories, dateRange);

    });

    function fetchEvents(url, categories, dateRange, page) {
        page = page || 1;
        categories = categories || [];
        dateRange = dateRange || [];
        $.ajax({
            url: url,
            type: 'GET',
            data: {
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
    }
});
