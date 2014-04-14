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
        <!--[if lt IE 9]>
            <div class="row">
                <div class="small-12 medium-12 large-12 columns">
                    <div data-alert class="alert-box">
                        <p>You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
                        <a href="#" class="close">&times;</a>
                    </div>
                </div>
            </div>
        <![endif]-->

        <!-- main nav -->
        <?php echo $this->template->load_view('partials/admin_nav'); ?>
        <!-- //main nav -->

        <section class="container">

            <div class="sticky-main">

                <!-- Header -->
                <?php echo $this->template->load_view('partials/admin_header'); ?>
                <!-- //header -->

                <!-- dynamic content goes here -->
                <?php echo $template['body']; ?>
                <!-- //dynamic content -->

            </div>

            <!-- sticky footer -->
            <footer class="bar bar--sticky-bottom">
                <?php echo $this->template->load_view('partials/admin_footer'); ?>
            </footer>
            <!-- //sticky footer -->

        </section>

        <!-- //load script -->
        <?php $this->carabiner->display('main_js'); ?>
        <?php $this->carabiner->display('local_js'); ?>
        <!-- //load script -->

    </body>
</html>