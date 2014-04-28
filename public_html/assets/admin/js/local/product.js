CKEDITOR.replace('ckeditor', {
        "extraPlugins" : "imagebrowser",
        "imageBrowser_listUrl" : base_url+"admin/media/get_files",
        'filebrowserImageUploadUrl' : base_url+'editor/upload/',
    });

//custom jquery handle error (for jquery 1.7 ++)
jQuery.extend({
    handleError: function( s, xhr, status, e ) {
        // If a local callback was specified, fire it
        if ( s.error )
            s.error( xhr, status, e );
        // If we have some XML response text (e.g. from an AJAX call) then log it in the console
        else if(xhr.responseText)
            console.log(xhr.responseText);
    }
});


var input_file         = $('#file'),
    uploading_text     = 'Uploading <i class="fa fa-spinner fa-spin"></i>',
    deleting_text      = 'Deleting <i class="fa fa-spinner fa-spin"></i>',
    loading_text       = 'Loading <i class="fa fa-spinner fa-spin"></i>',
    input_file         = $('.file-input'),
    upload_btn         = $('#js-upload-button'),
    product_img_container = $('#product-img-list');


input_file.bootstrapFileInput();

upload_btn.on("click", function(e){
    e.preventDefault();

    var old_text = $(this).html(),
        url = base_url + 'admin/product/upload/';

    $(this).html(uploading_text);

    $.ajaxFileUpload({
        url: url,
        secureuri: false,
        fileElementId: 'file',
        dataType: 'json',
        success : function(data, status) {
            if(data.status == '500')
            {
                bootbox.alert(data.msg, function() {});
                upload_btn.html(old_text);
            }
            else
            {
                bootbox.alert(data.msg, function() {
                    refresh_files(data.file);
                    custom_check_radio();
                    upload_btn.html(old_text);
                });
                input_file.attr('title', '');
            }
        },
        error : function(xhr, status, error) {
            bootbox.alert(xhr+' status = '+status+' error= '+error, function() {});
            upload_btn.html(old_text);
        }
    });

    return false;
});


$(document).on('click','.js-delete-img',function(e)
{
    e.preventDefault();

    var url = $(this).attr('href'),
        file_name = $(this).data('filename'),
        div_id = $(this).data('id');

    $(this).html(deleting_text);

    bootbox.confirm("This process cannot be undone. Are you sure ?", function(result){
        // console.log(result);
        if(result === true)
        {
            unlink_image(url, file_name).done(function(data)
            {
                // alert(data.msg);
                if(data.status == '500')
                {
                    bootbox.alert(data.msg, function() {});
                }
                else
                {
                    $('#img_'+div_id).fadeOut('fast', function(){
                        $(this).remove();
                        if (product_img_container.find('.product-img-row').length == 0)
                        {
                          bootbox.alert('We could not find any uploaded image, please upload some', function() {});
                        }
                    });
                }
            })
            .fail(function(xhr, status, err){
                bootbox.alert(err, function() {});
            });
        }
    });

    $(this).html(old_text);
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
        path = base_url+'media/product/thumb/';

    var row_product = '';

    row_product += '<div class="row product-img-row" id="img_'+id+'" >';

    row_product += '<div class="col-lg-2 col-md-3 col-xs-12">';
    row_product += '<a href="#" class="thumbnail">';
    row_product += '<input type="hidden" name="images['+id+'][filename]" value="'+filename+'">';
    row_product += '<img src="'+path+filename+'">';
    row_product += '</a>';
    row_product += '</div>';

    row_product += '<div class="col-lg-10 col-md-9 col-xs-12">';

    row_product += '<div class="form-group">';
    row_product += '<label>Alt Tag:</label>';
    row_product += '<input class="form-control" type="text" name="images['+id+'][alt]" placeholder="Alt tag">';
    row_product += '</div>';

    row_product += '<div class="form-group">';
    row_product += '<label>Caption:</label>';
    row_product += '<textarea class="form-control" rows="3" name="images['+id+'][caption]" class="input-wide" placeholder="Caption"></textarea>';
    row_product += '</div>';

    row_product += '</div>';

    row_product += '<div class="col-xs-12 text-right">';

    row_product += '<label class="radio-inline">';
    row_product += '<input type="radio" id="primary_image_'+id+'" name="primary" value="'+id+'"> Main Image';
    row_product += '</label>';
    row_product += '<a href="'+base_url+'admin/media/unlink/product" class="btn btn-danger js-delete-img margin-left" data-filename="'+filename+'" data-id="'+id+'" ><i class="fa fa-trash-o"></i> Delete</a>';

    row_product += '</div>';
    row_product += '</div>';

    product_img_container.append(row_product);
}


/**
 * function ajax for delete image or unlink
 *
 * @param  {[string]} url
 * @param  {[string]} type     [GET or POST]
 * @param  {[string]} dataType [xml, json, script, or html]
 * @param  {[array]}  data
 */
function unlink_image(url, filename) {
    return $.ajax({
        url: url,
        type: 'POST',
        data: {file_name: filename}
    });
}