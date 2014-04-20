<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>jQuery Upload</title>
    <!-- Bootstrap styles -->
    <link rel="stylesheet" href="<?php echo base_url('assets/themes/admin/css/bootstrap.css'); ?>">
    <!-- Generic page styles -->
    <link rel="stylesheet" href="<?php echo base_url('assets/themes/admin/css/plugins/jq-file-upload/style.css'); ?>">
    <!-- blueimp Gallery styles -->
    <link rel="stylesheet" href="http://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
    <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
    <link rel="stylesheet" href="<?php echo base_url('assets/themes/admin/css/plugins/jq-file-upload/jquery.fileupload.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/themes/admin/css/plugins/jq-file-upload/jquery.fileupload-ui.css'); ?>">
    <!-- CSS adjustments for browsers with JavaScript disabled -->
    <noscript><link rel="stylesheet" href="<?php echo base_url('assets/themes/admin/css/plugins/jq-file-upload/jquery.fileupload-noscript.css'); ?>"></noscript>
    <noscript><link rel="stylesheet" href="<?php echo base_url('assets/themes/admin/css/plugins/jq-file-upload/jquery.fileupload-ui-noscript.css'); ?>"></noscript>
</head>
<body>
    <form id="fileupload" action="<?php echo base_url('media/upload/gallery') ?>" method="POST" enctype="multipart/form-data">
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row fileupload-buttonbar">
            <div class="col-lg-7">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-primary fileinput-button">
                    <i class="fa fa-plus"></i>
                    <span>Add files...</span>
                    <input type="file" name="userfile" multiple>
                </span>
                <button type="submit" class="btn btn-primary start">
                    <i class="fa fa-upload"></i>
                    <span>Start upload</span>
                </button>
                <button type="reset" class="btn btn-warning cancel">
                    <i class="fa fa-ban-circle"></i>
                    <span>Cancel upload</span>
                </button>
                <button type="button" class="btn btn-danger delete">
                    <i class="fa fa-trash"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" class="toggle">
                <!-- The global file processing state -->
                <span class="fileupload-process"></span>
            </div>
            <!-- The global progress state -->
            <div class="col-lg-5 fileupload-progress fade">
                <!-- The global progress bar -->
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                </div>
                <!-- The extended global progress state -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
        <!-- The table listing the files available for upload/download -->
        <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
    </form>

    <!-- The blueimp Gallery widget -->
    <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
        <div class="slides"></div>
        <h3 class="title"></h3>
        <a class="prev">‹</a>
        <a class="next">›</a>
        <a class="close">×</a>
        <a class="play-pause"></a>
        <ol class="indicator"></ol>
    </div>
    <!-- The template to display files available for upload -->
    <script id="template-upload" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-upload fade">
            <td>
                <span class="preview"></span>
            </td>
            <td>
                <p class="name">{%=file.name%}</p>
                <strong class="error text-danger"></strong>
            </td>
            <td>
                <p class="size">Processing...</p>
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
            </td>
            <td>
                {% if (!i && !o.options.autoUpload) { %}
                    <button class="btn btn-primary start" disabled>
                        <i class="fa fa-upload"></i>
                        <span>Start</span>
                    </button>
                {% } %}
                {% if (!i) { %}
                    <button class="btn btn-warning cancel">
                        <i class="fa fa-ban-circle"></i>
                        <span>Cancel</span>
                    </button>
                {% } %}
            </td>
        </tr>
    {% } %}
    </script>
    <!-- The template to display files available for download -->
    <script id="template-download" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-download fade">
            <td>
                <span class="preview">
                    {% if (file.thumbnailUrl) { %}
                        <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                    {% } %}
                </span>
            </td>
            <td>
                <p class="name">
                    {% if (file.url) { %}
                        <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                    {% } else { %}
                        <span>{%=file.name%}</span>
                    {% } %}
                </p>
                {% if (file.error) { %}
                    <div><span class="label label-danger">Error</span> {%=file.error%}</div>
                {% } %}
            </td>
            <td>
                <span class="size">{%=o.formatFileSize(file.size)%}</span>
            </td>
            <td>
                {% if (file.deleteUrl) { %}
                    <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                        <i class="fa fa-trash-o"></i>
                        <span>Delete</span>
                    </button>
                    <input type="checkbox" name="delete" value="1" class="toggle">
                {% } else { %}
                    <button class="btn btn-warning cancel">
                        <i class="fa fa-ban-circle"></i>
                        <span>Cancel</span>
                    </button>
                {% } %}
            </td>
        </tr>
    {% } %}
    </script>
    <script>var base_url = '<?php echo base_url(); ?>';</script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

    <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
    <script src="<?php echo base_url('assets/themes/admin/js/plugins/jq-file-upload/vendor/jquery.ui.widget.js');?>"></script>

    <!-- The Templates plugin is included to render the upload/download listings -->
    <script src="http://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>

    <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
    <script src="http://blueimp.github.io/JavaScript-Load-Image/js/load-image.min.js"></script>

    <!-- The Canvas to Blob plugin is included for image resizing functionality -->
    <script src="http://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>

    <!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

    <!-- blueimp Gallery script -->
    <script src="http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>

    <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
    <script src="<?php echo base_url('assets/themes/admin/js/plugins/jq-file-upload/jquery.iframe-transport.js');?>"></script>

    <!-- The basic File Upload plugin -->
    <script src="<?php echo base_url('assets/themes/admin/js/plugins/jq-file-upload/jquery.fileupload.js');?>"></script>

    <!-- The File Upload processing plugin -->
    <script src="<?php echo base_url('assets/themes/admin/js/plugins/jq-file-upload/jquery.fileupload-process.js');?>"></script>

    <!-- The File Upload image preview & resize plugin -->
    <script src="<?php echo base_url('assets/themes/admin/js/plugins/jq-file-upload/jquery.fileupload-image.js');?>"></script>

    <!-- The File Upload audio preview plugin -->
    <script src="<?php echo base_url('assets/themes/admin/js/plugins/jq-file-upload/jquery.fileupload-audio.js');?>"></script>

    <!-- The File Upload video preview plugin -->
    <script src="<?php echo base_url('assets/themes/admin/js/plugins/jq-file-upload/jquery.fileupload-video.js');?>"></script>

    <!-- The File Upload validation plugin -->
    <script src="<?php echo base_url('assets/themes/admin/js/plugins/jq-file-upload/jquery.fileupload-validate.js');?>"></script>

    <!-- The File Upload user interface plugin -->
    <script src="<?php echo base_url('assets/themes/admin/js/plugins/jq-file-upload/jquery.fileupload-ui.js');?>"></script>

    <!-- The main application script -->
    <script src="<?php echo base_url('assets/themes/admin/js/plugins/jq-file-upload/main.js');?>"></script>

    <!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
    <!--[if (gte IE 8)&(lt IE 10)]>
    <script src="<?php echo base_url('assets/themes/admin/js/plugins/jq-file-upload/cors/jquery.xdr-transport.js');?>"></script>
    <![endif]-->

</body>
</html>