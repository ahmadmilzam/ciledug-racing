<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_category_model extends MY_Model {

  public function __construct()
  {
    parent::__construct();
    //Do your magic here

    //model table
    $this->_table = 'product_categories';

    //model primary key
    $this->primary_key = 'id_category';

    //model trigger observer
    $this->before_create = array( 'created_at' );
    $this->before_update = array( 'updated_at' );

    /**
     * Model Validation List
     * Set no validation for this 3 fields
     */
    $this->validate = array(

      array( 'field' => 'id_parent',/*[1]*/
             'label' => 'Parent Category',
             'rules' => 'trim' ),
      array( 'field' => 'name',/*[2]*/
             'label' => 'Category Name',
             'rules' => 'required|callback_check_category' ),
      array( 'field' => 'slug',/*[3]*/
             'label' => 'Category Slug',
             'rules' => 'trim' ),
    );
  }

}

/* End of file product_category_model.php */
/* Location: .//D/server/htdocs/project_cldr/modules/product/models/product_category_model.php */