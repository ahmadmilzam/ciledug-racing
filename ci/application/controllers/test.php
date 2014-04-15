<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends MX_Controller {

    public function index()
    {
        $this->load->model('category/product_category_model', 'category');
        $count = $this->category->count_all();
        $result = $this->category->get_all();
        dump($count);
        dump($result);
    }

}

/* End of file test.php */
/* Location: ./application/controllers/test.php */