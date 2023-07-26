$.extend(true, $.fn.dataTable.defaults, {
    columnDefs: [
        {
            targets: "_all",
            defaultContent: "",
            className: "p-1 h6",
        },
    ],
});
