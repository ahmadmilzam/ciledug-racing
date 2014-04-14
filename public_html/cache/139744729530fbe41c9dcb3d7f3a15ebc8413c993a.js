$(function() {
    //Make the dashboard widgets sortable Using jquery UI
    $(".connectedSortable").sortable({
        placeholder: "sort-highlight",
        connectWith: ".connectedSortable",
        handle: ".box-header",
        forcePlaceholderSize: true,
        zIndex: 999999
    }).disableSelection();
});

// $(".ajax-refresh-box").boxRefresh({
    //source: "/ajax/dashboard-boxrefresh-demo.php",
    //onLoadDone: function(box) {
        //
    //}
// });
