<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_model extends MY_Model {

  public function __construct()
  {
    parent::__construct();
    //Do your magic here

    //model table
    $this->_table = 'products';

    //model primary key
    $this->primary_key = 'id_product';

    //skip validation
    $this->skip_validation = TRUE;

    //model trigger observer
    $this->before_create = array( 'created_at' );
    $this->before_update = array( 'updated_at' );
  }


  public function delete_product($id)
  {
    $json_image = $this->select('images')->get($id);
    if($json_image)
    {
      $images = (array)json_decode($json_image->images);
      foreach($images as $img_id => $img_obj)
      {
        if (!empty($img_obj))
        {
          $img = (array)$img_obj;
        }
        // dump_exit($image);
        $file_ori = './media/product/'.$img['filename'];
        $file_thumb = './media/product/thumb/'.$img['filename'];
        //delete the existing file if needed
        if(file_exists($file_ori) && file_exists($file_thumb))
        {
          unlink($file_ori);
          unlink($file_thumb);
        }
      }

      return $this->delete($id);
    }
    else
    {
      return FALSE;
    }
  }

}

/* End of file product_model.php */
/* Location: .//D/server/htdocs/project_cldr/modules/product/models/product_model.php */