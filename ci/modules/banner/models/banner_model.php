<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Banner_model extends MY_Model {

  public function __construct()
  {
    parent::__construct();
    //Do your magic here

    //model table
    $this->_table = 'banners';

    //model primary key
    $this->primary_key = 'id_banner';

    $this->skip_validation = TRUE;

    //model trigger observer
    $this->before_create = array( 'created_at' );
    $this->before_update = array( 'updated_at' );

    /**
     * Model Validation List
     * Set no validation for this 3 fields
     * 1. Image Filename
     * 2. Image Title
     * 3. Image Caption
     * 4. Image Url
     * 5. Image Date enable
     * 6. Image Date disable
     */
    $this->validate = array(

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
  }

  public function delete_banner($id)
  {
    $image = $this->select('filename')->get($id);
    if($image)
    {
      // dump_exit($image);
      $file = './media/banner/'.$image->filename;
      //delete the existing file if needed
      if(file_exists($file))
      {
        unlink($file);
      }

      return $this->delete($id);
    }
    else
    {
      return FALSE;
    }
  }

  function check_date()
  {

      if ($this->input->post('disable_on') != '')
      {
          if ($this->input->post('disable_on') <= $this->input->post('enable_on'))
          {
              $this->form_validation->set_message('check_date', 'The "Disable On" date cannot come on or before the "Enable On" date.');
              return FALSE;
          }
      }

      return TRUE;
  }

}

/* End of file banner_model.php */
/* Location: .//D/server/htdocs/ciledug-racing/ci/modules/banner/models/banner_model.php */