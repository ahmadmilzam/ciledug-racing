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
           'rules' => 'trim|max_length[100]' ),
    array( 'field' => 'excerpt',/*[3]*/
           'label' => 'Post Excerpt',
           'rules' => 'trim|required|max_length[255]' ),
    array( 'field' => 'description',
           'label' => 'Post Description',
           'rules' => 'trim|required' ),
    array( 'field' => 'id_category',
           'label' => 'Post Category',
           'rules' => 'trim|required' ),
    array( 'field' => 'pubdate',
           'label' => 'Publish Date',
           'rules' => 'trim|required' ),
    // array( 'field' => 'thumbnail',
    //        'label' => 'Post Thumbnail',
    //        'rules' => 'trim|required|max_length[100]' ),
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
    $limit = $this->config->item('record_per_page');
    $page = (int) $this->uri->segment(5);

    $page == 0 ? $page = 1 : $page = $page;

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
      $offset = ($page - 1) * $limit;
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
    $data['posts'] = $this->post->limit($limit, $offset)->get_all_post_with_user();

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
    $data['page_name'] = 'Post Form';
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


    $config['upload_path']      = './media/post/';
    $config['allowed_types']    = 'jpeg|jpg|png';
    $config['max_size']         = '1024';
    $config['encrypt_name']     = TRUE;
    $config['remove_spaces']    = TRUE;

    $this->load->library('upload', $config);

    //declare empty variable
    $data['id_post']     = $id;
    $data['id_category'] = '';
    $data['title']       = '';
    $data['excerpt']     = '';
    $data['description'] = '';
    $data['slug']        = '';
    $data['pubdate']     = date('Y-m-d');
    $data['thumbnail']   = '';
    // $data['active']      = '';

    if($id)
    {
      $post = $this->post->get($id);
      if ( ! $post )
      {
          $this->session->set_flashdata('error', 'Post not found.');
          redirect('admin/post', 'refresh');
      }

      $data['id_post']     = $id;
      $data['id_category'] = $post->id_category;
      $data['title']       = $post->title;
      $data['excerpt']     = $post->excerpt;
      $data['description'] = $post->description;
      $data['slug']        = $post->slug;
      $data['pubdate']     = $post->pubdate;
      $data['thumbnail']   = $post->thumbnail;
      // $data['active']      = $article->;
    }

    /**
     * fect all categories from db
     * and reformat to associative from form_dropdown helper
     * with first key is default value or parent category
     * @var array
     */
    $array = array( '' => 'Select Category' );
    $categories = $this->category->dropdown('name');
    foreach ($categories as $key => $value) {
      $array[$key] = $value;
    }
    $data['dropdown_categories'] = $array;

    $this->form_validation->set_rules($this->validate);

    if (empty($_FILES['file']['name']))
    {
      if(empty($data['file']))
      {
        $this->form_validation->set_rules(
          'thumbnail',
          'Thumbnail',
          'trim|required|max_length[100]'
        );
      }
    }

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
      'name'        => 'title',
      'type'        => 'text',
      'placeholder' => 'Enter post title',
      'required'    => 'required'
    );
    //[2]
    $data['input_excerpt'] = array(
      'class'       => 'form-control',
      'name'        => 'excerpt',
      'placeholder' => 'Enter post excerpt',
      'rows'        => '3',
      'required'    => 'required'
    );
    //[3]
    $data['input_description'] = array(
      'class'       => 'form-control',
      'id'          => 'ckeditor',
      'name'        => 'description',
      'placeholder' => 'Enter post description',
      'required'    => 'required'
    );
    //[4]
    $data['input_slug'] = array(
      'class'       => 'form-control',
      'name'        => 'slug',
      'type'        => 'text',
      'placeholder' => 'Enter post slug',
    );
    //[5]
    $data['input_pubdate'] = array(
      'name'        => 'pubdate',
      'class'       => 'form-control',
      'id'          => 'date1',
      'type'        => 'text',
      'placeholder' => 'Enter post publish date',
      'required'    => 'required'
    );
    //[6]
    $data['input_file'] = array(
      'type'                    => 'file',
      'class'                   => 'file-input',
      'id'                      => 'file',
      'name'                    => 'file',
      'title'                   => 'Select for a file to upload',
      'data-filename-placement' => 'inside'
    );

    $data['submit_button'] = [
      'class'   => 'btn btn-primary btn-lg',
      'type'    => 'submit',
      'name'    => 'submit',
      'Value'   => 'Submit',
      'content' => 'Submit'
    ];

    if (!$this->form_validation->run())
    {
      //render view
      $this->template
           ->title($this->config->item('site_name'), $data['page_name'])
           ->build('admin/view_form', $data);
    }
    else
    {
      if ($_FILES['file']['name'])
      {
        $uploaded = $this->upload->do_upload('file');
        if(!$uploaded)
        {
          $data['errors']  = $this->upload->display_errors();
          //render view
          $this->template
               ->title($this->config->item('site_name'), $data['page_name'])
               ->build('admin/view_form', $data);
          return; //end script here if there is an error
        }
        else
        {
          $image              = $this->upload->data();
          $this->resize($image['file_name']);
          $save['thumbnail']  = $image['file_name'];
        }
      }

      if ($this->input->post('slug') == '')
      {
        $slug = url_slug($this->input->post('name'));
      }
      else
      {
        $slug = url_slug($this->input->post('slug'));
      }

      $save['title']       = $this->input->post('title');
      $save['excerpt']     = $this->input->post('excerpt');
      $save['description'] = $this->input->post('description');
      $save['slug']        = $slug;
      $save['pubdate']     = $this->input->post('pubdate');
      $save['id_user']     = userdata('user_id');
      $save['id_category'] = $this->input->post('id_category');

      if ($id)
      {
        //delete the original file if another is uploaded
        if($data['thumbnail'] != '')
        {
            $file = './media/post/'.$data['thumbnail'];

            //delete the existing file if needed
            if(file_exists($file))
            {
                unlink($file);
            }
        }
        $this->post->update($id, $save);
      }
      else
      {
        $this->post->insert($save);
      }

      $this->session->set_flashdata('success', 'Posts has been saved.');
      redirect('admin/post');
    }

  }

  public function delete($id = FALSE)
  {
    if($this->post->delete_post($id))
    {
        $this->session->set_flashdata('success', 'Post has been deleted.');
        // Redirect to your logged in landing page here
        redirect('admin/post', 'refresh');
    }
    else
    {
        $this->session->set_flashdata('error', 'An error occured while deleting post.');
        // Redirect to your logged in landing page here
        redirect('admin/post', 'refresh');
    }
  }

  private function resize($filename)
  {
    /*
    *Array
    (
    [file_name] => png1.jpg
    [file_type] => image/jpeg
    [file_path] => /home/ipresupu/public_html/uploads/
    [full_path] => /home/ipresupu/public_html/uploads/png1.jpg
    [raw_name] => png1
    [orig_name] => png.jpg
    [client_name] => png.jpg
    [file_ext] => .jpg
    [file_size] => 456.93
    [is_image] => 1
    [image_width] => 1198
    [image_height] => 1166
    [image_type] => jpeg
    [image_size_str] => width="1198" height="1166"
    )
   */

    $this->load->library('image_lib');

    //resize large image to thumb image
    $config['image_library'] = 'gd2';
    $config['source_image'] = './media/post/'.$filename;
    $config['new_image'] = './media/post/thumb/'.$filename;
    $config['maintain_ratio'] = true;
    $config['width'] = 300;
    $config['height'] = 300;
    $this->image_lib->initialize($config);
    $this->image_lib->fit();
    $this->image_lib->clear();
  }

}

/* End of file post.php */
/* Location: .//D/server/htdocs/project_cldr/modules/post/controllers/post.php */