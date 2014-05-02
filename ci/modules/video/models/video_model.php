<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Video_model extends MY_Model {

  public function __construct()
  {
    parent::__construct();
    //Do your magic here

    //model table
    $this->_table = 'videos';

    //model primary key
    $this->primary_key = 'id_video';

    //skip validation
    $this->skip_validation = TRUE;

    //model trigger observer
    // $this->before_create = array( 'created_at' );
    // $this->before_update = array( 'updated_at' );
  }
}

/* End of file banner_model.php */
/* Location: .//D/server/htdocs/ciledug-racing/ci/modules/banner/models/banner_model.php */