<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title><?php echo $template['title']; ?></title>
        <?php $this->carabiner->display('main_css'); ?>
        <?php $this->carabiner->display('local_css'); ?>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700' rel='stylesheet' type='text/css'>

        <script src="<?php echo base_url('assets/themes/flat/js/modernizr/modernizr.js');?>"></script>
    </head>
    <body>
        <div class="off-canvas-wrap">
            <div class="inner-wrap">
                <!-- Head -->
                <?php echo $this->template->load_view('partials/public_navbar'); ?>
                <!-- //Head -->

                <section class="main-section">
                    <!-- Body -->
                    <div class="row">
                        <div class="large-9 columns">
                            <?php echo $template['body']; ?>
                        </div>
                        <div class="large-3 columns">
                            <?php echo $this->template->load_view('partials/public_sidebar'); ?>
                        </div>
                    </div>
                    <!-- //Body -->

                    <!-- Tail -->
                    <?php echo $this->template->load_view('partials/public_footer'); ?>
                    <!-- //Tail -->
                </section>

                <a class="exit-off-canvas"></a>

            </div>
        </div>

        <!-- Map Modal -->
        <div class="reveal-modal" id="mapModal" data-reveal>
            <h4>Where We Are</h4>
            <p><img src="http://placehold.it/800x600" /></p>

            <!-- Any anchor with this class will close the modal. This also inherits certain styles, which can be overriden. -->
            <a href="#" class="close-reveal-modal">×</a>
        </div>
        <!-- //Map Modal -->


        <!-- //load script -->
        <?php $this->carabiner->display('main_js'); ?>
        <?php $this->carabiner->display('local_js'); ?>
        <!-- //load script -->
    </body>
</html>
