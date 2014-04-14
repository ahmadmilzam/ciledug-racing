<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    // public function _remap()
    // {
    //     $segment_1 = $this->uri->segment(1);

    //     switch ($segment_1) {
    //         case null:
    //         case false:
    //         case '':
    //             $this->index();
    //         break;

    //         case 'about':
    //             $this->about();
    //         break;

    //         case 'blog':
    //             $this->blog($this->uri->segment(2));
    //         break;

    //     default:
    //         //This is just an example to show
    //         //the 404 page if the page doesn't exist
    //         $this->db->where('url_title',$segment_1);
    //         $db_result = $this->db->get('webpages');

    //         if($db_result->num_rows() == 1)
    //         {
    //             $this->view($segment_1);
    //         }
    //         else
    //         {
    //             show_404();
    //         }
    //     break;
    //     }
    // }

    public function index()
    {
        // $this->local_js     = array(
        //                         array('home.js')
        //                     );

        // $this->carabiner->group('local_js', array('js'=>$this->local_js) );

        // $this->template
        //      ->set_layout('public_2col_layout')
        //      ->title($this->config->item('site_name'), 'Home')
        //      ->build('view_home', $this->data);
    }

    public function about($slug = FALSE)
    {
        dump($slug);
    }

    public function test()
    {
        # code...
        echo url_title('halo & & -- şampĂi jumpa lagi kawan 2 tahun mendatang :)', $separator = '-', $lowercase = TRUE) . '<br>';
        echo slugify('halo & & -- şampĂi jumpa lagi kawan  2 tahun mendatang :)') . '<br>';
        exit;
    }



    public function demo()
    {
        echo 'ini demo test';
    }


}
/* End of file page.php */
/* Location: ./application/modules/page/controllers/page.php */