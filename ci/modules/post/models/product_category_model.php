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

      array( 'field' => 'img_alt',/*[1]*/
             'label' => 'Alt',
             'rules' => '' ),
      array( 'field' => 'img_caption',/*[2]*/
             'label' => 'Caption',
             'rules' => '' ),
      array( 'field' => 'img_primary',/*[3]*/
             'label' => 'Primary',
             'rules' => '' ),
    );
  }

}

/* End of file product_category_model.php */
/* Location: .//D/server/htdocs/project_cldr/modules/product/models/product_category_model.php */