<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gallery_model extends MY_Model {

  public function __construct()
  {
    parent::__construct();
    //Do your magic here

    //model table
    $this->_table = 'image_gallery';

    //model primary key
    $this->primary_key = 'id_img';

    //skip validation
    $this->skip_validation = TRUE;

    //model trigger observer
    // $this->before_create = array( 'created_at' );
    // $this->before_update = array( 'updated_at' );

  }

  public function delete_img($id)
  {
    $image = $this->select('filename')->get($id);
    if($image)
    {
      // dump_exit($image);
      $file       = './media/gallery/'.$image->filename;
      $file_thumb = './media/gallery/thumb/'.$image->filename;
      //delete the existing file if needed
      if(file_exists($file))
      {
        unlink($file);
        unlink($file_thumb);
      }

      return $this->delete($id);
    }
    else
    {
      return FALSE;
    }
  }

}

/* End of file banner_model.php */
/* Location: .//D/server/htdocs/ciledug-racing/ci/modules/banner/models/banner_model.php */