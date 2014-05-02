<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller {
  protected $validate = array(
    array( 'field' => 'title',/*[2*/
           'label' => 'Title',
           'rules' => 'trim|required|max_lenght[100]' ),
    array( 'field' => 'url',/*[1]*/
           'label' => 'Embed Url',
           'rules' => 'trim|required' )
  );

  function __construct()
  {
    parent::__construct();
    $this->load->model('video/video_model', 'video');
  }

  function form()
  {
    $video = $this->video->limit(1)->get_all();

    // dump($video); exit;

    //append breadcrumb link
    $this->breadcrumb->append('Video Form', 'admin/video/form');

    $data['page_name'] = 'Video Form';

    //declare empty variable
    $data['id_video'] = '';
    $data['title']    = '';
    $data['url']      = '';

    if(count($video) > 0)
    {
      //now fetch the video's data from db

      //store video data into empty variables above
      $data['id_video'] = $video[0]->id_video;
      $data['title']    = $video[0]->title;
      $data['url']      = $video[0]->url;
    }

    /**
     * define input field for login form
     * 1. video title (text)
     * 2. video caption (textarea)
     * 3. video link (text url)
     * 4. video enable (text)
     * 5. video disable (text)
     * 6. video file (select dropdown)
     */

    //[1]
    $data['input_title'] = array(
      'class'       => 'form-control',
      'name'        => 'title',
      'type'        => 'text',
      'placeholder' => 'Enter video title',
      'required'    => 'required'
    );
    //[2]
    $data['input_url'] = array(
      'class'       => 'form-control',
      'name'        => 'url',
      'placeholder' => 'Enter embeded url',
      'rows'        => '3',
      'required'    => 'required'
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
      $save = array(
        'title' => $this->input->post('title'),
        'url' => $this->input->post('url')
      );

      if(count($video) > 0)
      {
        $video_id = $this->video->update($video[0]->id_video, $save);
      }
      else
      {
        $video_id = $this->video->insert($save);
      }

      if($video_id)
      {
        $this->session->set_flashdata('success', 'Video has been saved successfully');
      }
      else
      {
        $this->session->set_flashdata('error', 'An error occured while saving video');
      }
      redirect('admin/video/form');
    }

  }

  function delete($id)
  {
    if($this->video->delete_video($id))
    {
      $this->session->set_flashdata('success', 'video has been deleted.');
      // Redirect to your logged in landing page here
      redirect('admin/video', 'refresh');
    }
    else
    {
      $this->session->set_flashdata('error', 'An error occured.');
      // Redirect to your logged in landing page here
      redirect('admin/video', 'refresh');
    }
  }

}

/* End of file admin.php */
/* Location: .//D/server/htdocs/ciledug-racing/ci/modules/video/controllers/admin.php */