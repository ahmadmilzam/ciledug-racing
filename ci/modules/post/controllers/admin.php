<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Admin Product Module, use admin.php as alias that means it's product module for admin
 */
class Admin extends Admin_Controller {

    public function __construct()
    {
      parent::__construct();
      $this->load->model('product_model', 'product');
      $this->load->model('product_category_model', 'category');
    }

    public function index()
    {
      # code...
      echo "Post List";
    }

    /**
     * Product Form
     * @param  boolean $id [product id]
     */
    public function form($id = FALSE)
    {
      /**
       * define input field for login form
       * 1. product name (text)
       * 2. product excerpt (textarea)
       * 3. product description (textarea)
       * 4. product price (text)
       * 5. product slug (text)
       * 6. product images (hidden text)
       */
      //[1]
      $data['input_name'] = array(
        'class'       => 'form-control',
        'name'        => 'name',
        'type'        => 'text',
        'placeholder' => 'Enter product name',
        'value'       => $this->form_validation->set_value('name'),
        'required'    => 'required'
      );
      //[2]
      $data['input_excerpt'] = array(
        'class'       => 'form-control',
        'name'        => 'excerpt',
        'placeholder' => 'Enter product excerpt',
        'value'       => $this->form_validation->set_value('excerpt'),
        'rows'        => '3',
        'required'    => 'required'
      );
      //[3]
      $data['input_description'] = array(
        'class'       => 'form-control',
        'id'          => 'ckeditor',
        'name'        => 'description',
        'placeholder' => 'Enter product description',
        'value'       => $this->form_validation->set_value('description'),
        'required'    => 'required'
      );
      //[4]
      $data['input_price'] = array(
        'class'       => 'form-control',
        'name'        => 'price',
        'type'        => 'text',
        'placeholder' => 'Enter product price',
        'value'       => $this->form_validation->set_value('price'),
        'required'    => 'required'
      );
      //[5]
      $data['input_slug'] = array(
        'class'       => 'form-control',
        'name'        => 'slug',
        'type'        => 'text',
        'placeholder' => 'Enter product slug',
        'value'       => $this->form_validation->set_value('slug'),
      );
      //[6]
      $data['input_image'] = array(
        'class' => 'form-control',
        'name'  => 'images',
        'type'  => 'hidden',
        'required'
      );
      //[7]
      $data['submit_button'] = [
        'class'   => 'btn btn-primary btn-lg',
        'type'    => 'submit',
        'name'    => 'submit',
        'Value'   => 'Submit',
        'content' => 'Submit'
      ];

      // $category_array = $this->category->dropdown('name');
      // var_dump($category_array); exit;
      // $first_array  = array("0" => 'Select Category');

      $data['dropdown_categories'] = $this->category->dropdown('name');

      //declare empty variable
      $data['id_product']  = '';
      $data['id_category'] = '';
      $data['name']        = '';
      $data['excerpt']     = '';
      $data['description'] = '';
      $data['price']       = '';
      $data['slug']        = '';
      $data['images']      = '';

      if($id)
      {
        //now fetch the product from db
        $product = $this->product->get($id);

        //if result is empty
        if(!$product)
        {
          //set flash error msg and redirect to product index page
          $this->session->set_flashdata('error', 'Error product not found');
          redirect('admin/product');
        }

        //store the product data into empty variables above
        $data['id_product']  = $id;
        $data['id_category'] = $product->id_category;
        $data['name']        = $product->name;
        $data['excerpt']     = $product->excerpt;
        $data['description'] = $product->description;
        $data['slug']        = $product->slug;
        $data['price']       = $product->price;
        $data['images']      = (array)json_decode($product->images);
      }

      if( $this->input->post('submit') )
      {
        $save = array(
          'id_category' => $this->input->post('category'),
          'name'        => $this->input->post('name'),
          'excerpt'     => $this->input->post('excerpt'),
          'description' => $this->input->post('description'),
          'slug'        => url_slug($this->input->post('slug')),
          'price'       => $this->input->post('price'),
          'images'      => $this->input->post('images')
        );
        if($id)
        {
          $product_id = $this->product->update($save);
        }
        else
        {
          $product_id = $this->product->update($save);
        }

        if(!$product_id)
        {
          $this->session->set_flashdata('error', 'An error occured, product could not be saved');
          redirect('admin/product');
        }
      }
      /**
       * define partials css and js only for Dashboard page
       * 1. local js
       * 2. compile assets
       */
      //[1]
      $this->local_js = array(
        array('local/product.js')
      );

      //[2]
      $this->carabiner->group('local_js', array('js'=>$this->local_js) );

      //append breadcrumb link
      $this->breadcrumb->append('Products', 'admin/product');

      //render view
      $data['page_name'] = 'Product List';
      $this->template
           ->title($this->config->item('site_name'), $data['page_name'])
           ->build('admin/view_form', $data);
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