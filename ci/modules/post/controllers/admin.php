<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Admin post Module, use admin.php as alias that means it's post module for admin
 */
class Admin extends Admin_Controller {
    protected $validate = array(
      array( 'field' => 'title',/*[1]*/
             'label' => 'Post Title',
             'rules' => 'trim|required|max_length[100]' ),
      array( 'field' => 'slug',/*[2]*/
             'label' => 'Post Slug',
             'rules' => 'trim|required|max_length[100]' ),
      array( 'field' => 'excerpt',/*[3]*/
             'label' => 'Post Excerpt',
             'rules' => 'trim|required|max_length[255]' ),
      array( 'field' => 'description',
             'label' => 'Post Description',
             'rules' => 'trim|required' ),
      array( 'field' => 'category_id',
             'label' => 'Post Category',
             'rules' => 'trim|required' ),
      array( 'field' => 'pubdate',
             'label' => 'Publish Date',
             'rules' => 'trim|required' ),
      array( 'field' => 'thumbnail',
             'label' => 'Post Thumbnail',
             'rules' => 'trim|required|max_length[100]' ),
    );
    public function __construct()
    {
      parent::__construct();
      $this->load->model('post_model', 'post');
      $this->load->model('category/post_category_model', 'category');
    }

    public function index()
    {
      //$this->db->where('pubdate <=', date('Y-m-d'));
      $count = $this->post->count_all();
      $limit = 20;

      if ($count > $limit )
      {
        $this->load->library('pagination');
        $config['base_url'] = base_url('admin/post/index/page/');
        $config['total_rows'] = $count;
        $config['per_page'] = $limit;
        $config['uri_segment'] = 5;
        $config['num_links'] = 5;
        $this->pagination->initialize($config);

        $data['pagination'] =  $this->pagination->create_links();
        $offset = $this->uri->segment(4);
      }
      else
      {
        $data['pagination'] = '';
        $offset = 0;
      }

      if($this->input->post('search'))
      {
        $this->db->like('title', $this->input->post('title', TRUE));
        $data['pagination'] = '';
      }

      $this->db->limit($limit, $offset);
      $data['posts'] = $this->post->get_all_post_with_user();

      $data['page_name'] = 'Post List';
      $this->template
           ->title($this->config->item('site_name'), $data['page_name'])
           ->build('admin/view_index', $data);
    }

    /**
     * post Form
     * @param  boolean $id [post id]
     */
    public function form($id = FALSE)
    {


      /**
       * define input field for login form
       * 1. post name (text)
       * 2. post excerpt (textarea)
       * 3. post description (textarea)
       * 4. post price (text)
       * 5. post slug (text)
       * 6. post images (hidden text)
       */
      //[1]
      $data['input_name'] = array(
        'class'       => 'form-control',
        'name'        => 'name',
        'type'        => 'text',
        'placeholder' => 'Enter post name',
        'value'       => $this->form_validation->set_value('name'),
        'required'    => 'required'
      );
      //[2]
      $data['input_excerpt'] = array(
        'class'       => 'form-control',
        'name'        => 'excerpt',
        'placeholder' => 'Enter post excerpt',
        'value'       => $this->form_validation->set_value('excerpt'),
        'rows'        => '3',
        'required'    => 'required'
      );
      //[3]
      $data['input_description'] = array(
        'class'       => 'form-control',
        'id'          => 'ckeditor',
        'name'        => 'description',
        'placeholder' => 'Enter post description',
        'value'       => $this->form_validation->set_value('description'),
        'required'    => 'required'
      );
      //[4]
      $data['input_slug'] = array(
        'class'       => 'form-control',
        'name'        => 'slug',
        'type'        => 'text',
        'placeholder' => 'Enter post slug',
        'value'       => $this->form_validation->set_value('slug'),
      );
      //[5]
      $data['input_pubdate'] = array(
        'name'     => 'pubdate',
        'class'    => 'form-control',
        'id'       => 'date1',
        'type'     => 'text',
        'placeholder' => 'Enter post publish date',
        'required' => 'required'
      );
      //[6]
      $data['input_file'] = array(
        'type'    => 'file',
        'class'   => 'file-input',
        'id'      => 'file',
        'name'    => 'file',
        'title'   => 'Select for a file to upload',
        'data-filename-placement' => 'inside'
      );

      $data['submit_button'] = [
        'class'   => 'btn btn-primary btn-lg',
        'type'    => 'submit',
        'name'    => 'submit',
        'Value'   => 'Submit',
        'content' => 'Submit'
      ];

      // $category_array = $this->category->dropdown('name');
      // var_dump($category_array); exit;
      // $first_array  = array("0" => 'Select Category');

      $data['dropdown_categories'] = $this->category->dropdown('name');

      //declare empty variable
      $data['id_post']     = $id;
      $data['id_category'] = '';
      $data['name']        = '';
      $data['excerpt']     = '';
      $data['description'] = '';
      $data['slug']        = '';
      $data['pubdate']     = '';
      $data['thumbnail']   = '';
      $data['active']      = '';

      if($id)
      {
        //now fetch the post from db
        $post = $this->post->get($id);

        //if result is empty
        if(!$post)
        {
          //set flash error msg and redirect to post index page
          $this->session->set_flashdata('error', 'Error post not found');
          redirect('admin/post');
        }

        //store the post data into empty variables above
        $data['id_post']     = $id;
        $data['id_category'] = $post->id_category;
        $data['name']        = $post->name;
        $data['excerpt']     = $post->excerpt;
        $data['description'] = $post->description;
        $data['slug']        = $post->slug;
        $data['pubdate']     = $post->pubdate;
        $data['thumbnail']   = $post->thumbnail;
        $data['active']      = $post->active;
      }

      if( $this->input->post('submit') )
      {
        $save = array(
          'id_category' => $this->input->post('category'),
          'name'        => $this->input->post('name'),
          'excerpt'     => $this->input->post('excerpt'),
          'description' => $this->input->post('description'),
          'slug'        => url_slug($this->input->post('slug')),
          'price'       => $this->input->post('price'),
          'images'      => $this->input->post('images'),
          'active'      => $this->input->post('active')
        );
        if($id)
        {
          $post_id = $this->post->update($save);
        }
        else
        {
          $post_id = $this->post->update($save);
        }

        if(!$post_id)
        {
          $this->session->set_flashdata('error', 'An error occured, post could not be saved');
          redirect('admin/post');
        }
      }
      /**
       * define partials css and js only for Dashboard page
       * 1. local css
       * 2. local js
       * 3. compile assets
       */
      //[1]
      $this->local_css = array(
        array('lib/datepicker/datepicker.css'),
      );
      //[2]
      $this->local_js = array(
        array('lib/bootstrap-file-input/bs-file-input.js'),
        array('lib/datepicker/datepicker.js'),
        array('js/local/post.js'),
      );

      //[3]
      $this->carabiner->group('local_css', array('css'=>$this->local_css) );
      $this->carabiner->group('local_js', array('js'=>$this->local_js) );

      //append breadcrumb link
      $this->breadcrumb->append('Post', 'admin/post');
      $this->breadcrumb->append('Post Form', 'admin/post/form');

      //render view
      $data['page_name'] = 'Post Form';
      $this->template
           ->title($this->config->item('site_name'), $data['page_name'])
           ->build('admin/view_form', $data);
    }

    public function test()
    {
      $data = array();
      $this->template
           ->title($this->config->item('site_name'), 'Test')
           ->build('admin/view_test', $data);
    }

}

/* End of file post.php */
/* Location: .//D/server/htdocs/project_cldr/modules/post/controllers/post.php */