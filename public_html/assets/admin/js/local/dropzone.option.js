// $("#dropzoneDiv").dropzone({  });

Dropzone.options.dropzoneDiv = {
  init: function() {
    this.on("success", function(file, response) {
      file.serverName = response.newname;
      file.category = response.category;
    });
    this.on("removedfile", function(file) {
      console.log(file);
      if (!file.serverName) { return; } // The file hasn't been uploaded
      $.ajax({
        type: 'POST',
        url: base_url+'admin/media/unlink/',
        data: {
          filename : file.serverName,
          category : file.category
        }
      });

      // var _ref;
      // return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
    });
  },
  maxFilesize: 5, // MB
  addRemoveLinks: true,
  // removedfile: function(file) {
    // console.log(file);
    // var name = file.name;
    // $.ajax({
    //     type: 'POST',
    //     url: 'delete.php',
    //     data: "id="+name,
    //     dataType: 'html'
    // });
    // var _ref;
    // return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
  // }
  // success: function(file, serverFileName) {
  //   fileList[serverFileName] = {"serverFileName" : serverFileName, "fileName" : file.name };
  // }
// accept: function(file, done) {
  //   if (file.name == "justinbieber.jpg") {
  //     done("Naha, you don't.");
  //   }
  //   else { done(); }
  // }
};
// Dropzone.autoDiscover = false;
// var myDropzone = new Dropzone("#dropzoneDiv");
// myDropzone.on("success", function(file, serverFileName) {
//   fileList[serverFileName] = {"serverFileName" : serverFileName, "fileName" : file.name };
// });
