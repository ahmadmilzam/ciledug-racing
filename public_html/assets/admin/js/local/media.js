$(function(){
  $('#modal').modal('show');

  $('#modal').on('shown.bs.modal',function(){
    get_json_files(base_url+'media/get_files/product').done(function(data){
      console.log(data);
      if(data.length > 0)
      {
        $('#list-img').html('');
        append_image(data);
      }
      else
      {
        $('#list-img').html('Sorry, no image exists');
      }
    })
    .fail(function(xhr, status, error){
        bootbox.alert(error, function() {});
    });
  });
});

$( document ).on('dblclick', '.img-thumb', function() {
  alert( "Handler for .dblclick() called." );
});

function get_json_files(url){
  return $.ajax({
      url: url,
      type: 'GET'
  });
}

function append_image(data){
  var list = '<ul class="small-block-grid-3">';
  $.each(data, function(i, item) {
    list += '<li><img class="img-thumb" src="'+base_url+item.thumb+'" /></li>';
  });
  list += '</ul>';
  $('#list-img').append(list);
}