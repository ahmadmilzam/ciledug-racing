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

    //model trigger observer
    $this->before_create = array( 'created_at' );
    $this->before_update = array( 'updated_at' );

    /**
     * Model Validation List
     * Set no validation for this 3 fields
     * 1. Image Alt Tag
     * 2. Image Caption
     * 3. Image Primary
     */
    $this->validate = array(

      array( 'field' => 'img_alt',/*[1]*/
             'label' => 'Alt',
             'rules' => '' ),
      array( 'field' => 'img_caption',/*[2]*/
             'label' => 'Caption',
             'rules' => '' ),
      array( 'field' => 'img_primary',/*[3]*/
             'label' => 'Primary',
             'rules' => 'callback_check_img' ),
      array( 'field' => 'category_id',
             'label' => 'Product Category',
             'rules' => 'trim' ),
      array( 'field' => 'name',
             'label' => 'Product Name',
             'rules' => 'trim|required|max_length[50]' ),
      array( 'field' => 'excerpt',
             'label' => 'Product Excerpt',
             'rules' => 'trim|required|max_length[100]' ),
      array( 'field' => 'description',
             'label' => 'Product Description',
             'rules' => 'trim|required' ),
      array( 'field' => 'price',
             'label' => 'Product Price',
             'rules' => 'trim|numeric|floatval|required|greater_than[0]' ),
      array( 'field' => 'images',
             'label' => 'Product Images',
             'rules' => 'callback_check_img' ),
      array( 'field' => 'slug',
             'label' => 'Product Slug',
             'rules' => 'trim|max_length[100]' ),
    );
  }

  function check_img()/*callback function for check any uploaded img for product*/
  {
    $img = $this->input->post('images');
    //if img empty, warn user for upload
    if(empty($img) || $img =='')
    {
      $this->form_validation->set_message('check_img', 'Image product is required, please upload some');
      return false;
    }
    else
    {
      return true;
    }
  }

}

/* End of file product_model.php */
/* Location: .//D/server/htdocs/project_cldr/modules/product/models/product_model.php */