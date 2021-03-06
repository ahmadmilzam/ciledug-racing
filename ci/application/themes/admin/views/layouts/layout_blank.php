<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo $template['title']; ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- load compiled css -->
    <?php //$this->carabiner->display('main_css'); ?>
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


    <section class="container"><!-- Main content -->
      <!-- dynamic content goes here -->
      <?php echo $template['body']; ?>
      <!-- //dynamic content -->
    </section><!-- /.content -->

      <!-- add new calendar event modal -->
    <script>var base_url = '<?php echo base_url(); ?>';</script>
    <!-- load compiled script -->
    <?php //$this->carabiner->display('main_js'); ?>
    <?php $this->carabiner->display('local_js'); ?>
    <!-- load compiled script -->

  </body>
</html>