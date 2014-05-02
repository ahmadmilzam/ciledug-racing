<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo $template['title']; ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- load compiled css -->
    <?php $this->carabiner->display('main_css'); ?>
    <?php $this->carabiner->display('local_css'); ?>
    <!-- load compiled css -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,300italic,400italic,600italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
  </head>
  <body class="skin-black main-layout">

    <!-- header logo: style can be found in header.less -->
    <?php echo $this->template->load_view('partials/partial_header'); ?>
    <!-- header logo: style can be found in header.less -->

    <div class="wrapper row-offcanvas row-offcanvas-left">

      <!-- Left side column. contains the logo and sidebar -->
      <?php echo $this->template->load_view('partials/partial_sidebar_offcanvas'); ?>
      <!-- Left side column. contains the logo and sidebar -->


      <!-- Right side column. Contains the navbar and content of the page -->
      <aside class="right-side">

          <!-- Content Header (Page header) -->
          <section class="content-header">

              <h1><!-- page title -->
                  <?php echo $page_name; ?>
                  <small>Control panel</small>
              </h1><!-- page title -->

              <!-- breadcrumb -->
              <?php echo $this->breadcrumb->output(); ?>
              <!-- breadcrumb -->

          </section>


          <section class="content"><!-- Main content -->

            <?php echo $this->template->load_view('partials/alert'); ?>

            <!-- dynamic content goes here -->
            <?php echo $template['body']; ?>
            <!-- //dynamic content -->

            <?php echo $this->template->load_view('partials/footer'); ?>

          </section><!-- /.content -->

      </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->

      <!-- add new calendar event modal -->
    <script>var base_url = '<?php echo base_url(); ?>';</script>
    <!-- load compiled script -->
    <?php $this->carabiner->display('main_js'); ?>
    <?php $this->carabiner->display('local_js'); ?>
    <!-- load compiled script -->

  </body>
</html>