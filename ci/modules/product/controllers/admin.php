<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Admin Product Module, use admin.php as alias that means it's product module for admin
 */
class Admin extends Admin_Controller {

  /**
   * Model Validation List
   * Set no validation for this 3 fields
   * 1. Image Alt Tag
   * 2. Image Caption
   * 3. Image Primary
   */
  protected $validate = array(

    array( 'field' => 'img_alt',/*[1]*/
           'label' => 'Alt',
           'rules' => '' ),
    array( 'field' => 'img_caption',/*[2]*/
           'label' => 'Caption',
           'rules' => '' ),
    array( 'field' => 'img_primary',/*[3]*/
           'label' => 'Primary',
           'rules' => ''),
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

  public function __construct()
  {
    parent::__construct();

    if (!$this->ion_auth->is_admin()) //remove this elseif if you want to enable this for non-admins
    {
        //redirect them to the home page because they must be an administrator to view this
        return show_error('You must be an administrator to view this page.');
    }

    $this->load->model('product_model', 'product');
    $this->load->model('category/product_category_model', 'category');

  }

  /**
   * Product List
   */
  public function index()
  {
    $data['page_name'] = 'Product List';

    $count = $this->product->count_all();
    $limit = $this->config->item('record_per_page');
    $page = (int) $this->uri->segment(5);

    $page == 0 ? $page = 1 : $page = $page;

    if ($count > $limit )
    {
      $this->load->library('pagination');
      $config['base_url'] = base_url('admin/product/index/page/');
      $config['total_rows'] = $count;
      $config['per_page'] = $limit;
      $config['uri_segment'] = 5;
      $config['num_links'] = 5;
      $this->pagination->initialize($config);

      $data['pagination'] =  $this->pagination->create_links();
      $offset = ($page - 1) * $limit;
    }
    else
    {
      $data['pagination'] = '';
      $offset = 0;
    }

    if($this->input->post('search'))
    {
      $this->db->like('name', $this->input->post('name', TRUE));
      $data['pagination'] = '';
    }

    $data['products']  = $this->product->select('id_product, name, price, created_at')->limit($limit, $offset)->get_all();

    $this->template
         ->title($this->config->item('site_name'), $data['page_name'])
         ->build('admin/view_index', $data);
  }

  /**
   * Product Form
   * @param  boolean $id [product id]
   */
  public function form($id = FALSE)
  {
    /**
     * define partials css and js only for Dashboard page
     * 1. local js
     * 2. compile assets
     */
    //[1]
    $this->local_js = array(
      array('lib/bootstrap-file-input/bs-file-input.js'),
      array('lib/ajaxfileupload/ajaxfileupload.js'),
      array('js/local/product.js')
    );

    //[2]
    $this->carabiner->group('local_js', array('js'=>$this->local_js) );

    //append breadcrumb link
    $this->breadcrumb->append('product', 'admin/product');

    //render view
    $data['page_name'] = 'Product Form';

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

    /**
     * fect all categories from db
     * and reformat to associative from form_dropdown helper
     * with first key is default value or parent category
     * @var array
     */
    $array = array( '' => 'Select Category' );
    $categories = $this->category->dropdown('name');
    foreach ($categories as $key => $value) {
      $array[$key] = $value;
    }

    $data['dropdown_categories'] = $array;

    $this->form_validation->set_rules($this->validate);

    /**
     * define input field for login form
     * 1. product name (text)
     * 2. product excerpt (textarea)
     * 3. product description (textarea)
     * 4. product price (text)
     * 5. product slug (text)
     * 6. product categories (select dropdown)
     * 7. product images array (in view_form)
     * 8. product image file upload
     */
    //[1]
    $data['input_name'] = array(
      'class'       => 'form-control',
      'name'        => 'name',
      'type'        => 'text',
      'placeholder' => 'Enter product name',
      'required'    => 'required'
    );
    //[2]
    $data['input_excerpt'] = array(
      'class'       => 'form-control',
      'name'        => 'excerpt',
      'placeholder' => 'Enter product excerpt',
      'rows'        => '3',
      'required'    => 'required'
    );
    //[3]
    $data['input_description'] = array(
      'class'       => 'form-control',
      'id'          => 'ckeditor',
      'name'        => 'description',
      'placeholder' => 'Enter product description',
      'required'    => 'required'
    );
    //[4]
    $data['input_price'] = array(
      'class'       => 'form-control',
      'name'        => 'price',
      'type'        => 'number',
      'min'         => 0,
      'placeholder' => 'Enter product price',
      'required'    => 'required'
    );
    //[5]
    $data['input_slug'] = array(
      'class'       => 'form-control',
      'name'        => 'slug',
      'type'        => 'text',
      'placeholder' => 'Enter product slug',
    );
    //[6]
    $data['input_dropdown_categories'] = $array;

    //[8]
    $data['input_file'] = array(
      'type'    => 'file',
      'class'   => 'file-input',
      'id'      => 'file',
      'name'    => 'file',
      'title'   => 'Select for a file to upload',
      'data-filename-placement' => 'inside'
    );

    //[9]
    $data['submit_button'] = array(
      'class'   => 'btn btn-primary btn-lg',
      'type'    => 'submit',
      'name'    => 'submit',
      'Value'   => 'Submit',
      'content' => 'Submit'
    );

    //[10]
    $data['upload_button'] = array(
      'class' => 'btn btn-info',
      'type'=>'buttom',
      'name'=>'upload',
      'content' => 'Upload',
      'id'=>'js-upload-button'
    );

    if(!$this->form_validation->run($this))
    {
      $this->template
           ->title($this->config->item('site_name'), $data['page_name'])
           ->build('admin/view_form', $data);
    }
    else
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
        'id_category' => $this->input->post('category_id'),
        'name'        => $this->input->post('name'),
        'excerpt'     => $this->input->post('excerpt'),
        'description' => $this->input->post('description'),
        'slug'        => $slug,
        'price'       => $this->input->post('price'),
      );

      $upload_images       = $this->input->post('images');

      if($primary = $this->input->post('primary'))
      {
        if($upload_images)
        {
          foreach($upload_images as $key => &$pi)
          {
              if($primary == $key)
              {
                  $pi['primary']  = true;
                  continue;
              }
          }
        }
      }

      $save['images'] = json_encode($upload_images);

      if($id)
      {
        $product_id = $this->product->update($id, $save);
      }
      else
      {
        $product_id = $this->product->insert($save);
      }

      if($product_id)
      {
        $this->session->set_flashdata('success', 'Product has been saved successfully.');
      }
      else
      {
        $this->session->set_flashdata('error', 'An error occured.');
      }

      redirect('admin/product');

    }

  }

  function upload()
  {
    //init var
    $status = "500";
    $msg = "";
    $file = "";

    $config = array(
      'upload_path' => './media/product/',
      'allowed_types' => 'jpg|jpeg|png',
      'max_size' => '1024',
      'encrypt_name' => true,
      'remove_spaces' => true
    );
    //initialize upload lib with config
    $this->load->library('upload', $config);

    if (! $this->upload->do_upload('file'))
    {
      $msg = $this->upload->display_errors('', '');
    }
    else
    {
      $uploaded = $this->upload->data();
      /*
       *Array
        (
        [file_name] => png1.jpg
        [file_type] => image/jpeg
        [file_path] => /home/ipresupu/public_html/uploads/
        [full_path] => /home/ipresupu/public_html/uploads/png1.jpg
        [raw_name] => png1
        [orig_name] => png.jpg
        [client_name] => png.jpg
        [file_ext] => .jpg
        [file_size] => 456.93
        [is_image] => 1
        [image_width] => 1198
        [image_height] => 1166
        [image_type] => jpeg
        [image_size_str] => width="1198" height="1166"
        )
       */

      $this->load->library('image_lib');

      //resize large image to thumb image
      $config['image_library'] = 'gd2';
      $config['source_image'] = './media/product/'.$uploaded['file_name'];
      $config['new_image'] = './media/product/thumb/'.$uploaded['file_name'];
      $config['maintain_ratio'] = true;
      $config['width'] = 200;
      $config['height'] = 200;
      $this->image_lib->initialize($config);
      $this->image_lib->fit();
      $this->image_lib->clear();

      $status = "200";
      $msg = "File successfully uploaded";
      $file = $uploaded['file_name'];
    }

    echo json_encode(array('status' => $status, 'msg' => $msg, 'file' => $file));
    exit;
  }

  public function delete($id)
  {
    if($this->product->delete_product($id))
    {
        $this->session->set_flashdata('success', 'Product has been deleted.');
        // Redirect to your logged in landing page here
        redirect('admin/post', 'refresh');
    }
    else
    {
        $this->session->set_flashdata('error', 'An error occuredwhile deleting product.');
        // Redirect to your logged in landing page here
        redirect('admin/product', 'refresh');
    }
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

/* End of file product.php */
/* Location: .//D/server/htdocs/project_cldr/modules/product/controllers/product.php */