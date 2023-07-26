let dateNow = new Date();
$.fn.datetimepicker.Constructor.Default = $.extend({}, $.fn.datetimepicker.Constructor.Default, {
    format: "D-M-YYYY",
    defaultDate: dateNow,
});

/**
 * Get Value from Tempus Dominus Datetimepicker
 * @param {*} id @example $('#id')
 * @returns
 */
function getValueDatepicker(id) {
    if (id == "" || id == undefined || id == null) return "";

    const data = $(`#${id}`).datetimepicker("date");
    if (data == null) return "";

    return data._i;
}
