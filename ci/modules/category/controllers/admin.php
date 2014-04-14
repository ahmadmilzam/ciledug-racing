<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Admin Product Module, use admin.php as alias that means it's product module for admin
 */
class Admin extends Admin_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('product_category_model', 'product');
    $this->load->model('post_category_model', 'post');
  }

  /**
   * Category list
   * @param  string $type [default type is Post]
   */
  public function index($type = FALSE)
  {

    $data['page_name'] = ucfirst($type) . ' Category List';
    $data['categories'] = $this->$type->get_parent_child_tree();
    //append breadcrumb link
    $this->breadcrumb->append('Categories', 'admin/category/index');

    //render view
    $this->template
         ->title($this->config->item('site_name'), $data['page_name'])
         ->build('admin/view_index', $data);
  }

  /**
   * Product Form
   * @param  string $type [Category type, product | post]
   * @param  boolean $id [category id]
   */
  public function form($type = FALSE, $id = FALSE)
  {
    // dump_exit($type);
    /**
     *if no type pass
     *redirect to admin dashboard with error
     *
     *current registered type:
     *1. product
     *2. post
     */
    if(!$type)
    {
      $this->session->set_flashdata('error', 'An Error Occured');
      redirect('admin');
    }

    /**
     * fect all categories from db
     * and reformat to associative from form_dropdown helper
     * with first key is default value or parent category
     * @var array
     */
    $categories = $this->$type->dropdown('name');
    $array = array( 0 => 'Root Category' );

    foreach ($categories as $key => $value) {
      $array[$key] = $value;
    }

    //fetch category
    switch ($type) {
      case 'product':
        # code...
        $data['page_name'] = 'Product Category Form';
        break;
      case 'post':
      default:
        # code...
        break;
    }
    $data['page_name'] = ucfirst($type).' Category Form';

    $data['dropdown_categories'] = $this->$type->dropdown('name');
    //declare default variable
    $data['id_category'] = '';
    $data['id_parent']   = 0;
    $data['name']        = '';
    $data['slug']        = '';

    if($id)
    {
      //now fetch the product from db
      $category = $this->$type->limit(1)->get($id);

      //if result is empty
      if(!$category)
      {
        //set flash error msg and redirect to $type index page
        $this->session->set_flashdata('error', 'Error '. $type .' not found');
        redirect('admin/'.$type);
      }

      //store the data into empty variables above
      $data['id_category'] = $id;
      $data['id_parent']   = $category->id_parent;
      $data['name']        = $category->name;
      $data['slug']        = $category->slug;
    }

    if( $this->input->post('submit') )
    {
      if ($this->input->post('slug') == '')
      {
        $slug = url_slug($this->input->post('name'));
      }
      else
      {
        $slug = url_slug($this->input->post('slug'));
      }

      $save = array(
        'name' => $this->input->post('name'),
        'slug' => $slug,
        'id_parent' => $this->input->post('id_parent')
      );
      if($id)
      {
        $category_id = $this->$type->update($id, $save);
      }
      else
      {
        $category_id = $this->$type->insert($save);
      }

      if($category_id)
      {
        $this->session->set_flashdata('success', ucfirst($type) . ' Has been saved successfully');
        redirect('admin/category/index/'.$type);
      }
    }

    /**
     * define input field for login form
     * 1. category name (text)
     * 2. category slug (textarea)
     * 3. category parent (select dropdown)
     */
    //[1]
    $data['input_name'] = array(
      'class'       => 'form-control',
      'name'        => 'name',
      'type'        => 'text',
      'placeholder' => 'Enter category name',
      'value'       => $this->form_validation->set_value('name', $data['name']),
      'required'    => 'required'
    );
    //[2]
    $data['input_slug'] = array(
      'class'       => 'form-control',
      'name'        => 'slug',
      'type'        => 'text',
      'placeholder' => 'Enter category slug',
      'value'       => $this->form_validation->set_value('slug', $data['slug']),
    );
    //[3]
    $data['input_dropdown_categories'] = $array;

    //[4]
    $data['submit_button'] = [
      'class'   => 'btn btn-primary btn-lg',
      'type'    => 'submit',
      'name'    => 'submit',
      'Value'   => 'Submit',
      'content' => 'Submit'
    ];

    //if there is no post or
    //form validation is return false
    //then show the view form
    //with error if there exist
    if($this->form_validation->run() === FALSE)
    {
      //append breadcrumb link
      $this->breadcrumb->append('Categories', 'admin/category');

      //render view
      $this->template
           ->title($this->config->item('site_name'), $data['page_name'])
           ->build('admin/view_form', $data);
    }


  }

  public function test()
  {
    $data = array();
    $this->template
         ->title($this->config->item('site_name'), 'Test')
         ->build('admin/view_test', $data);
  }

}

/* End of file product.php */
/* Location: .//D/server/htdocs/project_cldr/modules/product/controllers/product.php */