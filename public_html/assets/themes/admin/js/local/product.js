CKEDITOR.replace('ckeditor', {
        "extraPlugins" : "imagebrowser",
        "imageBrowser_listUrl" : base_url+"media/get_files",
        'filebrowserImageUploadUrl' : base_url+'editor/upload/',
    });
$('.file-input').bootstrapFileInput();

var uploading_text = 'Uploading <i class="fa fa-spinner fa-spin"></i>',
    loading_text   = 'Loading <i class="fa fa-spinner fa-spin"></i>';

$('#js-upload-button').on("click",function(e){
    //
    var old_text = $(this).html(),
        url = base_url + 'admin/products/upload/';

    $(this)
    .ajaxStart(function(){
        $(this).html(uploading_text);
    })
    .ajaxComplete(function(){
        $(this).html(old_text);
    });

    var upload = $.ajaxFileUpload({
        url: url,
        secureuri: false,
        fileElementId: 'file',
        dataType: 'json',
    })

    upload.done(function(data){
      $('#title').val('');
      $('#caption').val('');
      refresh_files(data.file);
    });

    upload.fail(function(xhr, status, error) {
      bootbox.alert(error, function() {});
    });


    return false;
});


$(document).on('click','.js-delete-img',function(e)
{
    var url = $(this).attr('href'),
        file_name = $(this).data('file'),
        div_id = $(this).data('id');
        old_text = $(this).html();

    bootbox.confirm("This process cannot be undone. Are you sure ?", function(result){
        // console.log(result);
        if(result === true)
        {
            $(this)
            .ajaxStart(function(){
                $(this).html(loading_text);
            });

            delete_image(url, file_name).done(function(response){
                // var
                $('.photo_'+div_id).fadeOut('fast', function(){
                    $(this).remove();
                    if (files.find('.photo-grid').length == 0)
                    {
                      bootbox.alert('No image uploaded, please upload some', function() {});
                    }
                });
                $(this).html(old_text);
            })
            .fail(function(xhr, status, err){
                bootbox.alert(error, function() {});
            });
        }
    });

    return false;
});


/**
 * function for append new uploaded image into layout
 * @param  {[type]} data [description]
 * @return {[type]}      [description]
 */
function refresh_files(data)
{
    var p = data.split('.'),
        id = p[0],
        filename = p[0]+'.'+p[1],
        path = 'http://sukukhek.com/uploads/product_images/small/';

    var photo = '<div id="photo_'+id+'" class="photo-grid"><div class="span-small float-L"><input type="hidden" data-id="'+id+'" name="images['+id+'][filename]" value="'+filename+'"/><img class="thumbnail" src="'+path+filename+'"/></div><div class="span-large float-R"><input type="text" class="input-wide" name="images['+id+'][alt]" value="" placeholder="Alt tag"/><br><textarea name="images['+id+'][caption]" class="input-wide" placeholder="Caption"></textarea></div><span class="clear"></span><div class="row align-R"><input type="radio" id="primary_image_'+id+'" name="primary" value="'+id+'"><label for="primary_image_'+id+'">Main image</label><a href="#" rel="'+id+'" id="delete_img_link" class="button button-red"><i class="icon-white trash"></i>Delete</a></div></div>';

    $('#img_list').append(photo);
}

/**
 * function ajax for delete image or unlink
 *
 * @param  {[string]} url
 * @param  {[string]} type     [GET or POST]
 * @param  {[string]} dataType [xml, json, script, or html]
 * @param  {[array]}  data
 */
function delete_image(url, filename) {
    return $.ajax({
        url: url,
        type: 'POST',
        data: {file_name: filename}
    });
}
