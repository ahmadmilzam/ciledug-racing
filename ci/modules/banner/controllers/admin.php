<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller {
  protected $validate = array(
    array( 'field' => 'image',/*[1]*/
           'label' => 'Image',
           'rules' => 'trim' ),
    array( 'field' => 'title',/*[2*/
           'label' => 'Title',
           'rules' => 'trim|required' ),
    array( 'field' => 'caption',/*[3]*/
           'label' => 'Caption',
           'rules' => 'trim' ),
    array( 'field' => 'url',/*[4]*/
           'label' => 'Link URL',
           'rules' => 'trim|valid_url' ),
    array( 'field' => 'enable_on',/*[5]*/
           'label' => 'Enable On',
           'rules' => 'trim' ),
    array( 'field' => 'disable_on',/*[6]*/
           'label' => 'Enable On',
           'rules' => 'trim|callback_check_date' )
  );

  function __construct()
  {
    parent::__construct();
    $this->load->model('banner/banner_model', 'banner');
  }

  function index()
  {
    $count = $this->banner->count_all();
    $limit = $this->config->item('record_per_page');
    $page = (int) $this->uri->segment(5);
    $page == 0 ? $page = 1 : $page = $page;

    if ($count > $limit )
    {
      $this->load->library('pagination');
      $config['base_url'] = base_url('admin/banner/index/page/');
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

    $data['banners'] = $this->banner->limit($limit, $offset)->get_all();
    //append breadcrumb link
    $this->breadcrumb->append('Banners', 'admin/banner');

    //render view
    $data['page_name'] = 'Banner List';
    $this->template
         ->title($this->config->item('site_name'), $data['page_name'])
         ->build('admin/view_index', $data);

  }

  function form($id = false)
  {
    //append breadcrumb link
    $this->breadcrumb->append('Banners', 'admin/banner');
    //append breadcrumb link
    $this->breadcrumb->append('Form', 'admin/banner/form');

    $data['page_name'] = 'Banner Form';
    /**
     * define partials css and js only for Dashboard page
     * 1. local css
     * 1. local js
     * 2. compile assets
     */
    //[1]
    $this->local_css = array(
      array('lib/datepicker/datepicker.css'),
    );

    //[1]
    $this->local_js = array(
      array('lib/bootstrap-file-input/bs-file-input.js'),
      array('lib/datepicker/datepicker.js'),
      array('js/local/banner.js')
    );

    //[3]
    $this->carabiner->group('local_css', array('css'=>$this->local_css) );
    $this->carabiner->group('local_js', array('js'=>$this->local_js) );

    //declare empty variable
    $data['id_banner']   = $id;
    $data['title']       = '';
    $data['caption']     = '';
    $data['enable_on']   = '';
    $data['disable_on']  = '';
    $data['link']        = '';
    $data['filename']    = '';

    if($id)
    {
      //now fetch the product from db
      $banner = $this->banner->get($id);

      //if result is empty
      if(!$banner)
      {
        //set flash error msg and redirect to product index page
        $this->session->set_flashdata('error', 'Error banner not found');
        redirect('admin/banner');
      }

      //store banner data into empty variables above
      $data['id_banner']   = $id;
      $data['title']       = $banner->title;
      $data['caption']     = $banner->caption;
      $data['enable_on']   = $banner->enable_on;
      $data['disable_on']  = $banner->disable_on;
      $data['link']        = $banner->link;
      $data['filename']    = $banner->filename;
    }

    /**
     * define input field for login form
     * 1. banner title (text)
     * 2. banner caption (textarea)
     * 3. banner link (text url)
     * 4. banner enable (text)
     * 5. banner disable (text)
     * 6. banner file (select dropdown)
     */

    //[1]
    $data['input_title'] = array(
      'class'       => 'form-control',
      'name'        => 'title',
      'type'        => 'text',
      'placeholder' => 'Enter banner title',
      'required'    => 'required'
    );
    //[2]
    $data['input_caption'] = array(
      'class'       => 'form-control',
      'name'        => 'caption',
      'placeholder' => 'Enter banner caption',
      'rows'        => '3',
      'required'    => 'required'
    );
    //[3]
    $data['input_link'] = array(
      'type'        => 'url',
      'class'       => 'form-control',
      'name'        => 'link',
      'placeholder' => 'Enter banner link',
    );
    //[4]
    $data['input_enable'] = array(
      'name'        => 'enable_on',
      'class'       => 'form-control',
      'id'          => 'date1',
      'placeholder' => 'Enter Enable Date',
      'required'    => 'required'
    );
    //[5]
    $data['input_disable'] = array(
      'name'        => 'disable_on',
      'class'       => 'form-control',
      'id'          => 'date2',
      'placeholder' => 'Enter Disable Date',
      'required'    => 'required'
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

    //[7]
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
      $uploaded = FALSE;

      $config['upload_path']      = FCPATH.'media/banner/';
      $config['allowed_types']    = 'jpeg|jpg|png';
      $config['max_size']         = '2048';
      $config['max_width']        = '1024';
      $config['encrypt_name']     = true;
      $config['remove_spaces']    = true;
      $this->load->library('upload', $config);

      $uploaded   = $this->upload->do_upload('file');

      $save = array(
        'title'      => $this->input->post('title'),
        'caption'    => $this->input->post('caption'),
        'enable_on'  => $this->input->post('enable_on'),
        'disable_on' => $this->input->post('disable_on'),
        'link'       => $this->input->post('link')
      );

      if($uploaded)
      {
        $image             = $this->upload->data();
        $save['filename']  = $image['file_name'];
      }
      else
      {
        $data['errors']  = $this->upload->display_errors();
        //render view
        $this->template
             ->title($this->config->item('site_name'), $data['page_name'])
             ->build('admin/view_form', $data);
        return; //end script here if there is an error
      }

      if($id)
      {
        if($uploaded)
        {
          if($data['filename'] != '')
          {
            $file = './media/banner/'.$data['filename'];
            //delete the existing file if needed
            if(file_exists($file))
            {
              unlink($file);
            }
          }
        }
        $banner_id = $this->banner->update($id, $save);
      }
      else
      {
        $banner_id = $this->banner->insert($save);
      }
      if($banner_id)
      {
        $this->session->set_flashdata('success', 'Banner has been saved successfully');
        redirect('admin/banner');
      }

    }

  }

  function delete($id)
  {
    if($this->banner->delete_banner($id))
    {
      $this->session->set_flashdata('success', 'Banner has been deleted.');
      // Redirect to your logged in landing page here
      redirect('admin/banner', 'refresh');
    }
    else
    {
      $this->session->set_flashdata('error', 'An error occured.');
      // Redirect to your logged in landing page here
      redirect('admin/banner', 'refresh');
    }
  }

}

/* End of file admin.php */
/* Location: .//D/server/htdocs/ciledug-racing/ci/modules/banner/controllers/admin.php */