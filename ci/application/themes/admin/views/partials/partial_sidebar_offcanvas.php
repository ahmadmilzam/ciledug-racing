<aside class="left-side sidebar-offcanvas">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

      <!-- Sidebar user panel -->
      <div class="user-panel">
          <div class="pull-left image">
              <img src="<?php echo base_url('media/avatars/default.png') ?>" class="img-circle" alt="User Image" />
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
        <li class="treeview <?php echo ($this->uri->segment(2) == 'product' OR ($this->uri->segment(2) == 'category' && $this->uri->segment(4) == 'product') ) ? 'active' : ''; ?>"><!-- products link -->
          <a href="#">
            <i class="fa fa-laptop"></i>
            <span>Products</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="<?php echo ($this->uri->segment(2) == 'product' && $this->uri->segment(3) == '') ? 'active' : ''; ?>">
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
        <li class="treeview<?php echo $this->uri->segment(2) == 'banner' ? 'active' : ''; ?>"><!-- banners link -->
          <a href="#">
            <i class="fa fa-bar-chart-o"></i>
            <span>Banners</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/UI/general.html"><i class="fa fa-angle-double-right"></i> All Banners</a></li>
            <li><a href="pages/UI/icons.html"><i class="fa fa-angle-double-right"></i> Add New</a></li>
            <li><a href="pages/UI/buttons.html"><i class="fa fa-angle-double-right"></i> Categories</a></li>
          </ul>
        </li>
        <li class="treeview <?php echo $this->uri->segment(2) == 'media' ? 'active' : ''; ?>"><!-- media library link -->
          <a href="#">
            <i class="fa fa-picture-o"></i>
            <span>Media</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/charts/morris.html"><i class="fa fa-angle-double-right"></i> Gallery</a></li>
            <li><a href="pages/charts/flot.html"><i class="fa fa-angle-double-right"></i> Add New</a></li>
          </ul>
        </li>

      </ul>
  </section>
  <!-- /.sidebar -->
</aside>