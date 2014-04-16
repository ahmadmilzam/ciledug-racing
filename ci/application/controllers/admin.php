<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }

    /**
      * Admin Dashboard
        TODO:
        - check if user already logged in
        - if not logged in, return to login page
        - collect and fetch important data for dashboard
    **/
    public function index()
    {
      /**
       * define partials css and js only for Dashboard page
       * 1. local js
       * 2. compile assets
       */
      //[1]
      $this->local_js = array(
        array('local/dashboard.js')
      );
      //[2]
      $this->carabiner->group('local_js', array('js'=>$this->local_js) );

      //render view
      $data['page_name'] = 'Dashboard';
      $this->template
           ->title($this->config->item('site_name'), $data['page_name'])
           ->build('admin/view_index', $data);
    }

    public function cache()
    {
        //$this->cache->delete_all('model_test');
        $data['data'] = $this->cache->model('model_test', 'get', array()); // keep for 2 minutes
        //$data['data'] = $this->model_test->get(); // keep for 2 minutes

        $this->load->view('admin/cache', $data, FALSE);

    }


}
/* End of file admin.php */
/* Location: ./application/controllers/admin.php */