<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }

    /**
      * Admin Dashboard
    **/
    public function index()
    {
      // load model
      $this->load->model('post/post_model', 'post');
      $this->load->model('product/product_model', 'product');
      $this->load->model('banner/banner_model', 'banner');
      $this->load->model('gallery/gallery_model', 'gallery');
      // $this->load->model('video/video_model', 'video');

      //get recent data
      $data['posts']    = $this->post->select('id_post, title, pubdate')->limit(10)->order_by('id_post', 'DESC')->get_all();
      $data['products'] = $this->product->select('id_product, name, price')->limit(10)->order_by('id_product', 'DESC')->get_all();
      $data['banners']  = $this->banner->select('id_banner, title, enable_on, disable_on')->limit(5)->order_by('id_banner', 'DESC')->get_all();
      $data['images']   = $this->gallery->select('id_img, filename, caption')->limit(8)->order_by('id_img', 'DESC')->get_all();

      if($this->ion_auth->is_admin())
      {
        $this->load->model('user/user_model', 'user');
        $data['users']   = $this->user->select('id, first_name, last_name, email, active')->limit(5)->order_by('id', 'DESC')->get_all();
      }


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