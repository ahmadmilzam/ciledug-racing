$('.file-input').bootstrapFileInput();

$('#date1, #date2').datepicker({
  format:"yyyy-mm-dd",
  autoclose: true,
  startDate: 'now'
});