<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Ahmad Milzam</title>
        <?php $this->carabiner->display('main_css'); ?>
        <?php $this->carabiner->display('local_css'); ?>
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
        <script src="<?php echo base_url('assets/themes/flat/js/vendor/modernizr.js');?>"></script>
    </head>
    <body>

        <div class="row">
            <div class="large-12 columns">
                <div class="reveal-modal medium visible radius">
                    <?php echo $this->template->load_view('partials/alert'); ?>
                    <?php echo $template['body']; ?>
                </div><!-- /reveal-modal -->
            </div>
        </div>

        <!-- //load script -->
        <?php $this->carabiner->display('main_js'); ?>
        <?php $this->carabiner->display('local_js'); ?>
        <!-- //load script -->
    </body>
</html>
