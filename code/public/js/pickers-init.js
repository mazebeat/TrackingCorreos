//date picker start
if (top.location != location) {
    top.location.href = document.location.href ;
}

$(function(){
    window.prettyPrint && prettyPrint();
    $('.default-date-picker').datepicker({
        format: 'yyyy-mm',
        language: 'es',
        autoclose: true,
        minViewMode: 'months'
    });

    $('.dpd1').datepicker({
        format: 'yyyy-mm-dd',
        language: 'es',
        autoclose: true
    });

    $('.dpd2').datepicker({
        format: 'yyyy-mm-dd',
        language: 'es',
        autoclose: true
    });

    var checkin = $('.dpd1').datepicker({
        onRender: function(date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
            if (ev.date.valueOf() > checkout.date.valueOf()) {
                var newDate = new Date(ev.date)
                newDate.setDate(newDate.getDate() + 1);
                checkout.setValue(newDate);
            }
            checkin.hide();
            $('.dpd2')[0].focus();
        }).data('datepicker');
    var checkout = $('.dpd2').datepicker({
        onRender: function(date) {
            return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
            checkout.hide();
        }).data('datepicker');
});
