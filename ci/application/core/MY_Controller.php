<?php defined('BASEPATH') OR exit('No direct script access.');

/**
*
* Base Controller
*
**/
class MY_Controller extends MX_Controller {
    public $main_css        = array();
    public $main_js         = array();
    public $local_css       = array();
    public $local_js        = array();
    public $theme           = '';

    public function __construct()
    {
      //load breadcrumb library
      $this->load->library('breadcrumb');

      //load carabiner asset management library
      $this->load->library('carabiner');

      $carabiner_config = [
          'script_dir'    => 'assets/themes/'. $this->template->get_theme() .'/js/',
          'style_dir'     => 'assets/themes/'. $this->template->get_theme() .'/css/',
          'cache_dir'     => 'cache/',
          'combine'       => TRUE,
          'minify_css'    => FALSE,
          'base_uri'      => base_url(),
          'minify_js'     => FALSE
      ];
      //initialize carabinner library with config
      $this->carabiner->config($carabiner_config);

      $this->load->library('form_validation');
      $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

      //load profiler only in development server
      //it is useful for benchmark and the the performance before uploading to production server
      $this->load->library('profiler');
      $this->output->enable_profiler(ENVIRONMENT == 'development');
    }

}


/**
*
* Admin Controller
*
**/
class Admin_Controller extends MY_Controller {

  public function __construct()
  {
    //set modifier template and layout for admin first
    //so system can set the asset path correctly
    $this->template->set_theme('admin')
                   ->set_layout('layout_main');

    parent::__construct();

    /**
     * set main / required assets for all admin page
     * 1. main css assets
     * 2. main js assets
     * 3. compile assets
     */
    //[1]
    $this->main_css = array(
      array('bootstrap.css'),
      array('bootstrap.css.map'),
      array('plugin/font-awesome.css'),
      array('plugin/ionicons.css'),
      array('admin.css')
    );
    //[2]
    $this->main_js = array(
      array('jquery-2.1.0.js'),
      array('jquery-ui-1.10.3.min.js'),
      array('bootstrap.min.js'),
      array('required_plugin.js'),
      array('plugins/bootbox/bootbox.min.js'),
      array('app.js'),
    );
    //[3]
    $this->carabiner->group('main_css', ['css'=>$this->main_css] );
    $this->carabiner->group('main_js', ['js'=>$this->main_js] );

    //Prepend breadcrumb first link to dashboard
    $this->breadcrumb->prepend('<i class="fa fa-dashboard"></i> Dashboard', 'admin/dashboard');

    /**
     * This code is for prevent back button to see the page after logout
     *
     * CI Version:
     */
    $this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
    $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
    $this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
    $this->output->set_header('Pragma: no-cache');

    // PHP Version:
    // header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
    // header('Cache-Control: no-store, no-cache, must-revalidate');
    // header('Cache-Control: post-check=0, pre-check=0',false);
    // header('Pragma: no-cache');

    // Load auth library only for admin section, it depends on your application
    $this->load->library('user/ion_auth');

    if (!$this->ion_auth->logged_in())
    {
      //set warning message
      $this->session->set_flashdata('info', '<li>You must logged in to enter the control panel</li>');
      //redirect them to the login page
      redirect('user/auth/login', 'refresh');
    }

  }

}

/**
*
* Public Controller
*
**/
class Public_Controller extends MY_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->main_css = [
            ['app.css']
        ];

        $this->main_js = [
            ['core-public.min.js'],
            ['app.js']
        ];

        $this->carabiner->group('main_css', ['css'=>$this->main_css] );
        $this->carabiner->group('main_js', ['js'=>$this->main_js] );

        $this->template->set_layout('public_layout');
    }

}
/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */