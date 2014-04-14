<ul class="nav nav--stacked nav--main" id="js-main-nav">
    <li>
        <a href="javascript:;">
            <i class="nav__icon nav__icon--main fa fa-home"></i>
            <span class="nav__description">Dashboard</span>
        </a>
    </li>
    <li class="has-sub-nav">
        <a href="javascript:;">
            <i class="nav__icon nav__icon--main fa fa-file-text"></i>
            <span class="nav__description">Posts</span>
            <i class="fa fa-angle-right nav__icon nav__icon--extended"></i>
        </a>
        <ul class="nav nav--stacked nav--sub js-dropdown">
            <li>
                <a href="javascript:;">
                    <span class="nav__description nav__description--sub">All Posts</span>
                </a>
            </li>
            <li>
                <a href="javascript:;">
                    <span class="nav__description nav__description--sub">Add New</span>
                </a>
            </li>
            <li>
                <a href="javascript:;">
                    <span class="nav__description nav__description--sub">Categories</span>
                </a>
            </li>
            <li>
                <a href="javascript:;">
                    <span class="nav__description nav__description--sub">Tags</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="has-sub-nav">
        <a href="javascript:;">
            <i class="nav__icon nav__icon--main fa fa-picture-o"></i>
            <span class="nav__description">Media</span>
            <i class="fa fa-angle-right nav__icon nav__icon--extended"></i>
        </a>
        <ul class="nav nav--stacked nav--sub js-dropdown">
            <li>
                 <a href="javascript:;">
                    <span class="nav__description nav__description--sub">Library</span>
                </a>
            </li>
            <li>
                 <a href="javascript:;">
                    <span class="nav__description nav__description--sub">Add New</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="has-sub-nav">
        <a href="javascript:;">
            <i class="nav__icon nav__icon--main fa fa-files-o"></i>
            <span class="nav__description">Pages</span>
            <i class="fa fa-angle-right nav__icon nav__icon--extended"></i>
        </a>
        <ul class="nav nav--stacked nav--sub js-dropdown">
            <li>
                 <a href="javascript:;">
                    <span class="nav__description nav__description--sub">All Pages</span>
                </a>
            </li>
            <li>
                 <a href="javascript:;">
                    <span class="nav__description nav__description--sub">Add New</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="has-sub-nav <?php echo ($active_page == 'Users') ? 'active' : '';?>">
        <a href="javascript:;">
            <i class="nav__icon nav__icon--main fa fa-users"></i>
            <span class="nav__description">Users</span>
            <i class="fa fa-angle-right nav__icon nav__icon--extended"></i>
        </a>
        <ul class="nav nav--stacked nav--sub js-dropdown">
            <li>
                <a href="<?php echo base_url('admin/auth'); ?>">
                    <span class="nav__description nav__description--sub">All Users</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('admin/auth/create_user'); ?>">
                    <span class="nav__description nav__description--sub">Add New User</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('admin/auth/create_group'); ?>">
                    <span class="nav__description nav__description--sub">Add New Group</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('admin/auth/profile/'.$this->session->userdata('user_id')); ?>">
                    <span class="nav__description nav__description--sub">My Profile</span>
                </a>
            </li>
        </ul>
    </li>
    <li>
        <a href="javascript:;">
            <i class="nav__icon nav__icon--main fa fa-cog"></i>
            <span class="nav__description">Settings</span>
        </a>
    </li>
    <li>
        <a href="<?php echo base_url('admin/logout'); ?>">
            <i class="fa fa-power-off nav__icon nav__icon--main "></i>
            <span class="nav__description">Log Out</span>
        </a>
    </li>
</ul>