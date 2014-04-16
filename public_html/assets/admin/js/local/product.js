CKEDITOR.replace('ckeditor', {
        "extraPlugins" : "imagebrowser",
        "imageBrowser_listUrl" : base_url+"media/get_files",
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

$('.file-input').bootstrapFileInput();

var uploading_text = 'Uploading <i class="fa fa-spinner fa-spin"></i>',
    loading_text   = 'Loading <i class="fa fa-spinner fa-spin"></i>',
    product_countainer = $('#product-img-list');

$('#js-upload-button').on("click", function(e){
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
            }
            else
            {
                bootbox.alert(data.msg, function() {
                    refresh_files(data.file);
                    custom_check_radio();
                });
            }
            $('#js-upload-button').html(old_text);
        },
        error : function(xhr, status, error) {
            bootbox.alert(xhr+' status = '+status+' error= '+error, function() {});
        }
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
    row_product += '<input type="radio" id="primary_image_'+id+'" name="primary" value="<?php echo $img_id;?>"> Main Image';
    row_product += '</label>';
    row_product += '<a href="javascript:;" class="btn btn-danger js-delete-img margin-left" data-id="'+id+'"><i class="fa fa-trash-o"></i> Delete</a>';

    row_product += '</div>';
    row_product += '</div>';

    product_countainer.append(row_product);
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
