function getSelect2SelectedId(element_id) {
    const selected_satuan2 = $(`#${element_id}`).select2("data");
    return selected_satuan2.length == 0 ? "" : selected_satuan2[0].id;
}

/**
 * Reload data local to Select2
 * @param {*} id @example 'mySelect'
 * @param {*} data @example {'id':1,'text': text}
 */
function reloadDataSelect2(id, data) {
    $(`#${id}  option`).remove();
    $(`#${id}`).select2({
        data: data,
    });
}
