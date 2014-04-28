$(function() {
    var btn_delete = $('.btn-delete');
    //Make the dashboard widgets sortable Using jquery UI
    $(".connectedSortable").sortable({
        placeholder: "sort-highlight",
        connectWith: ".connectedSortable",
        handle: ".box-header",
        forcePlaceholderSize: true,
        zIndex: 999999
    }).disableSelection();
});

// btn_delete.click(function(){
//     delete_item.done(function(){

//     })
//     .fail(function(xhr, status, err){
//         bootbox.alert(err, function() {});
//     });
// });

// function delete_item(url)
// {
//     return $.ajax({
//         url: url,
//         type: 'GET',
//         // data: {file_name: filename}
//     });
// }
// $(".ajax-refresh-box").boxRefresh({
    //source: "/ajax/dashboard-boxrefresh-demo.php",
    //onLoadDone: function(box) {
        //
    //}
// });