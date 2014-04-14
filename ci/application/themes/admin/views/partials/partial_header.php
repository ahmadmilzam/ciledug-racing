<header class="header">
  <a href="index.html" class="logo">
      <!-- Add the class icon to your logo image or logo icon to add the margining -->
      CLD Racing
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </a>
    <div class="navbar-right">
      <ul class="nav navbar-nav">
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="glyphicon glyphicon-user"></i>
                <span><?php echo userdata('username') ?> <i class="caret"></i></span>
            </a>
            <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header bg-light-blue">
                    <img src="<?php echo base_url('assets/uploads/avatars/default.png'); ?>" class="img-circle" alt="User Image" />
                    <p>
                        <?php echo userdata('first_name').' '.userdata('last_name'); ?>
                        <small>Member since <?php echo date('M, Y', userdata('created_on')) ?></small>
                    </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <div class="pull-right">
                        <a href="<?php echo base_url('user/auth/logout') ?>" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                </li>
            </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>