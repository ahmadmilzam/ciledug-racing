<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends MY_Model {

  public function __construct()
  {
    parent::__construct();
    //Do your magic here

    //model table
    $this->_table = 'users';

    //model primary key
    $this->primary_key = 'id';

    //skip validation
    $this->skip_validation = TRUE;

    //model trigger observer
    // $this->before_create = array( 'created_at' );
    // $this->before_update = array( 'updated_at' );
  }
}

/* End of file user_model.php */
/* Location: .//D/server/htdocs/ciledug-racing/ci/modules/user/models/user_model.php */