CKEDITOR.replace('ckeditor');
$('.file-input').bootstrapFileInput();

$('#js-upload-button').on("click",function(e){
    //
    var old_text = $(this).html(),
        new_text = 'Uploading <i class="fa fa-spinner fa-spin"></i>',
        url = base_url + 'admin/products/upload/';
        alert(old_text);

    $(this).html(new_text);
    $.ajaxFileUpload
    ({
        url: url,
        secureuri: false,
        fileElementId: 'file',
        dataType: 'json',
    })
    .done(function(data){
      $('#title').val('');
      $('#caption').val('');
      refresh_files(data.file);
    })
    .fail(function(xhr, status, error) {
      bootbox.alert(status + ' - ' + error, function() {});
    })
    .always(function(){
      $(this).html(old_text);
    });

    return false;
});
$(document).on('click','.delete_img_link',function(e)
{
    e.preventDefault();
    var files = $('#img_list');
    bootbox.confirm("This process cannot be undone. Are you sure ?", function(result){
        // console.log(result);
        if(result === true)
        {

        }
    });
    $('.loading').show();
    var div_id = $(this).attr("rel");
    $('.photo_'+div_id).fadeOut('fast', function(){
        $(this).remove();
        if (files.find('.photo-grid').length == 0)
        {
          bootbox.alert('No image uploaded, please upload some', function() {});
        }
    });
    $('#feedback').html('<div class="alert-box alert-success"><a class="close-box">x</a>File successfully deleted</div><br>');
    $('.loading').fadeOut('fast');

    return false;
});

function refresh_files(data)
{
    var p = data.split('.'),
        id = p[0],
        filename = p[0]+'.'+p[1],
        path = 'http://sukukhek.com/uploads/product_images/small/';

    var photo = '<div id="photo_'+id+'" class="photo-grid"><div class="span-small float-L"><input type="hidden" data-id="'+id+'" name="images['+id+'][filename]" value="'+filename+'"/><img class="thumbnail" src="'+path+filename+'"/></div><div class="span-large float-R"><input type="text" class="input-wide" name="images['+id+'][alt]" value="" placeholder="Alt tag"/><br><textarea name="images['+id+'][caption]" class="input-wide" placeholder="Caption"></textarea></div><span class="clear"></span><div class="row align-R"><input type="radio" id="primary_image_'+id+'" name="primary" value="'+id+'"><label for="primary_image_'+id+'">Main image</label><a href="#" rel="'+id+'" id="delete_img_link" class="button button-red"><i class="icon-white trash"></i>Delete</a></div></div>';

    $('#img_list').append(photo);
}