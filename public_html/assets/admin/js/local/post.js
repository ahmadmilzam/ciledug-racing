$('.file-input').bootstrapFileInput();

CKEDITOR.replace('ckeditor', {
        "extraPlugins" : "imagebrowser",
        "imageBrowser_listUrl" : base_url+"admin/media/get_files",
        'filebrowserImageUploadUrl' : base_url+'editor/upload/',
    });

$('#date1').datepicker({
  format:"yyyy-mm-dd",
  autoclose: true,
  startDate: 'now'
});