function initDaterangepicker() {
    $('.input-datetime').daterangepicker({
        autoUpdateInput: true,
        //            autoApply: true,
        singleDatePicker: true,
        showDropdowns: true,
        timePicker: true,
        autoApply: true,
        timePicker24Hour: true,
        timePickerIncrement: 1,
        timePickerSeconds: false,
        minYear: 1950,
        locale: {
            format: 'YYYY/MM/DD HH:mm:ss',
            'separator': ' - ',
            'applyLabel': 'Apply',
            'cancelLabel': 'Cancel',
            'daysOfWeek': ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            'monthNames': ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            'firstDay': 0
        }
    }).on('apply.daterangepicker', function (e, picker) {
        picker.element.val(picker.startDate.format(picker.locale.format));
        picker.element.valid();
    }).on('show.daterangepicker', function(ev, picker) {
        picker.container.find('.calendar-time').addClass('readonly')
    }).on('hide.daterangepicker', function(ev, picker) {
        picker.container.find('.calendar-time').addClass('readonly')
    })

}
