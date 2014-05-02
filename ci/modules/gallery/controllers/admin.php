<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller {
  protected $validate = array(
    array( 'field' => 'alt',/*[1]*/
           'label' => 'Title',
           'rules' => 'trim' ),
    array( 'field' => 'caption',/*[2*/
           'label' => 'Caption',
           'rules' => 'trim' ),
  );

  function __construct()
  {
    parent::__construct();
    $this->load->model('gallery/gallery_model', 'gallery');
  }

  function index()
  {
    $count = $this->gallery->count_all();
    $limit = $this->config->item('record_per_page');
    $page = (int) $this->uri->segment(5);
    $page == 0 ? $page = 1 : $page = $page;

    if ($count > $limit )
    {
      $this->load->library('pagination');
      $config['base_url'] = base_url('admin/gallery/index/page/');
      $config['total_rows'] = $count;
      $config['per_page'] = $limit;
      $config['uri_segment'] = 5;
      $config['num_links'] = 5;
      $this->pagination->initialize($config);

      $data['pagination'] =  $this->pagination->create_links();
      $offset = ($page - 1)  * $limit;
    }
    else
    {
      $data['pagination'] = '';
      $offset = 0;
    }

    $data['images'] = $this->gallery->limit($limit, $offset)->get_all();
    //append breadcrumb link
    $this->breadcrumb->append('Gallery', 'admin/gallery');

    //render view
    $data['page_name'] = 'Gallery List';
    $this->template
         ->title($this->config->item('site_name'), $data['page_name'])
         ->build('admin/view_index', $data);

  }

  function form($id = false)
  {
    if(!$id)
    {
      $this->session->set_flashdata('error', 'Error Image not found');
      redirect('admin/gallery');
    }

    //append breadcrumb link
    $this->breadcrumb->append('Gallery', 'admin/gallery');
    //append breadcrumb link
    $this->breadcrumb->append('Form', 'admin/gallery/form');

    $data['page_name'] = 'Gallery Form';

    //declare empty variable
    $data['id_img']   = $id;
    $data['filename'] = '';
    $data['caption']  = '';
    $data['alt']      = '';

    if($id)
    {
      //now fetch the product from db
      $image = $this->gallery->get($id);

      //if result is empty
      if(!$image)
      {
        //set flash error msg and redirect to product index page
        $this->session->set_flashdata('error', 'Error image not found');
        redirect('admin/gallery');
      }

      //store gallery data into empty variables above
      $data['id_img']   = $id;
      $data['filename'] = $image->filename;
      $data['caption']  = $image->caption;
      $data['alt']      = $image->alt;
    }

    /**
     * define input field for login form
     * 1. gallery title (text)
     * 2. gallery caption (textarea)
     */

    //[1]
    $data['input_title'] = array(
      'class'       => 'form-control',
      'name'        => 'alt',
      'type'        => 'text',
      'placeholder' => 'Enter image title',
    );
    //[2]
    $data['input_caption'] = array(
      'class'       => 'form-control',
      'name'        => 'caption',
      'placeholder' => 'Enter image caption',
      'rows'        => '3',
    );

    $data['submit_button'] = array(
      'class'   => 'btn btn-primary btn-lg',
      'type'    => 'submit',
      'name'    => 'submit',
      'Value'   => 'Submit',
      'content' => 'Submit'
    );


    $this->form_validation->set_rules($this->validate);

    if (!$this->form_validation->run())
    {
      //render view
      $this->template
           ->title($this->config->item('site_name'), $data['page_name'])
           ->build('admin/view_form', $data);
    }
    else
    {
      $save = array(
        'alt'      => $this->input->post('alt'),
        'caption'    => $this->input->post('caption'),
      );


      $gallery_id = $this->gallery->update($id, $save);

      if($gallery_id)
      {
        $this->session->set_flashdata('success', 'Image has been saved successfully');
      }
      else
      {
        $this->session->set_flashdata('success', 'An error occurd while updateing image.');
      }

      redirect('admin/gallery');
    }

  }

  public function dropzone()
  {
    /**
     * define partials css and js only for login page
     * 1. local css
     * 2. local js
     * 3. compile assets
     */
    //[1]
    $this->local_css = array(
      array('lib/dropzone/dropzone.css')
    );

    //[2]
    $this->local_js = array(
      array('lib/dropzone/dropzone.js'),
      array('js/local/dropzone.option.js')
    );

    //[3]
    $this->carabiner->group('local_css', array('css'=>$this->local_css) );
    $this->carabiner->group('local_js', array('js'=>$this->local_js) );

    $data['page_name'] = 'Image Uploader';

    $this->template
     ->title($this->config->item('site_name'), 'Browse File')
     ->build('admin/view_dropzone', $data);
  }

  public function upload()
  {
    if (!empty($_FILES))
    {
      $config = array(
        'upload_path' => FCPATH . 'media/gallery/',
        'allowed_types' => 'jpg|jpeg|png',
        'max_size' => '1024',
        'encrypt_name' => true,
        'remove_spaces' => true
      );

      $this->load->library('upload', $config);
      if(!$this->upload->do_upload('file'))
      {
        $error = $this->upload->display_errors('','');
        $this->output->set_status_header('400', $error);
        header('Content-type: text/plain');
        echo $error;
        exit;
      }
      else
      {
        $uploaded = $this->upload->data();

        if($this->save_to_db($uploaded))
        {
          $this->resize_img($uploaded);
        }

        header('Content-type: application/json');
        echo json_encode(array('newname'=>$uploaded['file_name'], 'category'=>'gallery'));
        exit;
      }

    }
    else
    {
      $this->output->set_status_header('404', 'Not Found');
    }
  }

  function delete($id)
  {
    if($this->gallery->delete_img($id))
    {
      $this->session->set_flashdata('success', 'Image has been deleted.');
      // Redirect to your logged in landing page here
      redirect('admin/gallery', 'refresh');
    }
    else
    {
      $this->session->set_flashdata('error', 'An error occured while deleting image.');
      // Redirect to your logged in landing page here
      redirect('admin/gallery', 'refresh');
    }
  }

  protected function resize_img($uploaded_file)
  {
    /*
     *$uploaded_file
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
    $config['source_image'] = './media/gallery/'.$uploaded_file['file_name'];
    $config['new_image'] = './media/gallery/thumb/'.$uploaded_file['file_name'];
    $config['maintain_ratio'] = true;
    $config['width'] = 330;
    $config['height'] = 190;
    $this->image_lib->initialize($config);
    $this->image_lib->fit();
    $this->image_lib->clear();

    return TRUE;

  }

  public function save_to_db($file)
  {
    $save['filename'] = $file['file_name'];
    return $this->gallery->insert($save);
  }



}

/* End of file admin.php */
/* Location: .//D/server/htdocs/ciledug-racing/ci/modules/gallery/controllers/admin.php */