<aside class="left-side sidebar-offcanvas">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

      <!-- Sidebar user panel -->
      <div class="user-panel">
          <div class="pull-left image">
              <img src="<?php echo base_url('media/avatar/default.png') ?>" class="img-circle" alt="User Image" />
          </div>
          <div class="pull-left info">
              <p>Hello, <?php echo userdata('username') ?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
      </div><!-- Sidebar user panel -->

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="<?php echo $this->uri->segment(2) == '' ? 'active' : ''; ?>"><!-- dashboard link -->
          <a href="<?php echo base_url('admin') ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="treeview <?php echo ($this->uri->segment(2) == 'post' OR ($this->uri->segment(2) == 'category' && $this->uri->segment(4) == 'post') ) ? 'active' : ''; ?>"><!-- posts link -->
          <a href="#">
            <i class="fa fa-code"></i> <span>Posts</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="<?php echo ($this->uri->segment(2) == 'post' && $this->uri->segment(3) == 'list') ? 'active' : ''; ?>">
              <a href="<?php echo base_url('admin/post/index'); ?>"><i class="fa fa-angle-double-right"></i> All Posts</a>
            </li>
            <li class="<?php echo ($this->uri->segment(2) == 'post' && $this->uri->segment(3) == 'form') ? 'active' : ''; ?>">
              <a href="<?php echo base_url('admin/post/form'); ?>"><i class="fa fa-angle-double-right"></i> Add New</a>
            </li>
            <li class="<?php echo ($this->uri->segment(2) == 'category' && $this->uri->segment(4) == 'post') ? 'active' : ''; ?>">
              <a href="<?php echo base_url('admin/category/index/post'); ?>"><i class="fa fa-angle-double-right"></i> Categories</a>
            </li>
          </ul>
        </li>

        <!-- if user is admin, show product link -->
        <?php if ($this->ion_auth->is_admin()): ?>
        <li class="treeview <?php echo ($this->uri->segment(2) == 'product' OR ($this->uri->segment(2) == 'category' && $this->uri->segment(4) == 'product') ) ? 'active' : ''; ?>"><!-- products link -->
          <a href="#">
            <i class="fa fa-laptop"></i>
            <span>Products</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="<?php echo ($this->uri->segment(2) == 'product' && $this->uri->segment(3) == 'index') ? 'active' : ''; ?>">
              <a href="<?php echo base_url('admin/product/index'); ?>"><i class="fa fa-angle-double-right"></i> All Products</a>
            </li>
            <li class="<?php echo ($this->uri->segment(2) == 'product' && $this->uri->segment(3) == 'form') ? 'active' : ''; ?>">
              <a href="<?php echo base_url('admin/product/form'); ?>"><i class="fa fa-angle-double-right"></i> Add New</a>
            </li>
            <li class="<?php echo ($this->uri->segment(2) == 'category' && $this->uri->segment(4) == 'product') ? 'active' : ''; ?>">
              <a href="<?php echo base_url('admin/category/index/product'); ?>"><i class="fa fa-angle-double-right"></i> Categories</a>
            </li>
          </ul>
        </li>
        <!-- if user is admin, show product link -->
        <?php endif ?>

        <li class="treeview <?php echo ($this->uri->segment(2) == 'banner')  ? 'active' : ''; ?>"><!-- banners link -->
          <a href="#">
            <i class="fa fa-bar-chart-o"></i>
            <span>Banners</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="<?php echo ($this->uri->segment(2) == 'banner' && $this->uri->segment(3) == 'index') ? 'active' : ''; ?>">
              <a href="<?php echo base_url('admin/banner/index'); ?>"><i class="fa fa-angle-double-right"></i> All Banners</a>
            </li>
            <li class="<?php echo ($this->uri->segment(2) == 'banner' && $this->uri->segment(3) == 'form') ? 'active' : ''; ?>">
              <a href="<?php echo base_url('admin/banner/form'); ?>"><i class="fa fa-angle-double-right"></i> Add New</a>
            </li>
          </ul>
        </li>

        <li class="treeview <?php echo $this->uri->segment(2) == 'gallery' ? 'active' : ''; ?>"><!-- media library link -->
          <a href="#">
            <i class="fa fa-picture-o"></i>
            <span>Image Gallery</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="<?php echo ($this->uri->segment(2) == 'gallery') ? 'active' : ''; ?>"><a href="<?php echo base_url('admin/gallery/index'); ?>"><i class="fa fa-angle-double-right"></i> All Gallery</a></li>
            <li class="<?php echo ($this->uri->segment(2) == 'banner' && $this->uri->segment(3) == 'dropzone') ? 'active' : ''; ?>"><a href="<?php echo base_url('admin/gallery/dropzone'); ?>"><i class="fa fa-angle-double-right"></i> Add New</a></li>
          </ul>
        </li>

        <li class="treeview <?php echo $this->uri->segment(2) == 'video' ? 'active' : ''; ?>"><!-- media library link -->
          <a href="#">
            <i class="fa fa-video-camera"></i>
            <span>Videos</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="<?php echo ($this->uri->segment(2) == 'video') ? 'active' : ''; ?>"><a href="<?php echo base_url('admin/video/index'); ?>"><i class="fa fa-angle-double-right"></i> Gallery</a></li>
            <li class="<?php echo ($this->uri->segment(2) == 'video' && $this->uri->segment(3) == 'form') ? 'active' : ''; ?>"><a href="<?php echo base_url('admin/video/form'); ?>"><i class="fa fa-angle-double-right"></i> Add New</a></li>
          </ul>
        </li>

        <!-- if user is admin, show users link -->
        <?php if ($this->ion_auth->is_admin()): ?>
        <li class="treeview <?php echo ($this->uri->segment(2) == 'user' OR $this->uri->segment(3) == 'create_user' OR $this->uri->segment(3) == 'create_group' ) ? 'active' : ''; ?>"><!-- users link -->
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Users</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="<?php echo ($this->uri->segment(2) == 'user' && $this->uri->segment(3) == '') ? 'active' : ''; ?>">
              <a href="<?php echo base_url('admin/user/index'); ?>"><i class="fa fa-angle-double-right"></i> All Users</a>
            </li>
            <li class="<?php echo ($this->uri->segment(2) == 'user' && $this->uri->segment(3) == 'create_user') ? 'active' : ''; ?>">
              <a href="<?php echo base_url('admin/user/create_user'); ?>"><i class="fa fa-angle-double-right"></i> Add New</a>
            </li>
            <!-- <li class="<?php echo ($this->uri->segment(2) == 'user' && $this->uri->segment(3) == 'create_group') ? 'active' : ''; ?>">
              <a href="<?php echo base_url('admin/user/create_group'); ?>"><i class="fa fa-angle-double-right"></i> Groups</a>
            </li> -->
          </ul>
        </li>
        <?php endif; ?>
        <!-- if user is admin, show users link -->

      </ul>
  </section>
  <!-- /.sidebar -->
</aside>