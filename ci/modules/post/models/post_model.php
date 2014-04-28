<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Post_model extends MY_Model {

  public function __construct()
  {
    parent::__construct();
    //Do your magic here

    //model table
    $this->_table = 'posts';

    //model primary key
    $this->primary_key = 'id_post';

    //model trigger observer
    $this->before_create = array( 'created_at' );
    $this->before_update = array( 'updated_at' );

    //skip validation
    $this->skip_validation = TRUE;

    /**
     * Model Validation List
     * Set no validation for this 3 fields
     * 1. Image Alt Tag
     * 2. Image Caption
     * 3. Image Primary
     */
    $this->validate = array(

      array( 'field' => 'title',/*[1]*/
             'label' => 'Post Title',
             'rules' => 'trim|required|max_length[100]' ),
      array( 'field' => 'slug',/*[2]*/
             'label' => 'Post Slug',
             'rules' => 'trim|required|max_length[100]' ),
      array( 'field' => 'excerpt',/*[3]*/
             'label' => 'Post Excerpt',
             'rules' => 'trim|required|max_length[255]' ),
      array( 'field' => 'description',
             'label' => 'Post Description',
             'rules' => 'trim|required' ),
      array( 'field' => 'category_id',
             'label' => 'Post Category',
             'rules' => 'trim|required' ),
      array( 'field' => 'pubdate',
             'label' => 'Publish Date',
             'rules' => 'trim|required' ),
      array( 'field' => 'thumbnail',
             'label' => 'Post Thumbnail',
             'rules' => 'trim|required|max_length[100]' ),
    );
  }

  public function get_all_post_with_user()
  {
    $users = $this->db->select(
      $this->_table.'.*, '.
      'users.username as username'
    )
    ->join('users', 'users.id='.$this->_table.'.id_user');
    $result = $this->get_all();
    return $result;
  }

  public function delete_post($id)
  {
    $image = $this->select('thumbnail')->get($id);
    if($image)
    {
      // dump_exit($image);
      $file_ori = './media/post/'.$image->thumbnail;
      $file_thumb = './media/post/thumb/'.$image->thumbnail;
      //delete the existing file if needed
      if(file_exists($file_ori) && file_exists($file_thumb))
      {
        unlink($file_ori);
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

/* End of file product_model.php */
/* Location: .//D/server/htdocs/project_cldr/modules/product/models/product_model.php */