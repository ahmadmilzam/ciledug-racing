<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller {

  public function index()
  {
    /**
     * define partials css and js only for login page
     * 1. local css
     * 2. local js
     * 3. compile assets
     */
    //[1]
    $this->local_css = array(
      array('lib/dropzone/dropzone.css')
    );

    //[2]
    $this->local_js = array(
      array('lib/dropzone/dropzone.js'),
      array('js/local/dropzone.option.js')
    );

    //[3]
    $this->carabiner->group('local_css', array('css'=>$this->local_css) );
    $this->carabiner->group('local_js', array('js'=>$this->local_js) );

    $data['page_name'] = 'Image Uploader';

    $this->template
     ->title($this->config->item('site_name'), 'Browse File')
     ->build('admin/view_dropzone', $data);
  }

  public function upload()
  {
    if (!empty($_FILES))
    {
      $category = $this->input->post('category');

      $config = array(
        'upload_path' => FCPATH . 'media/'.$category.'/',
        'allowed_types' => 'gif|jpg|jpeg|png',
        'max_size' => '1024',
        'encrypt_name' => true,
        'remove_spaces' => true
      );

      $this->load->library('upload', $config);
      if(!$this->upload->do_upload('file'))
      {
        $error = $this->upload->display_errors('','');
        $this->output->set_status_header('400', $error);
        header('Content-type: text/plain');
        echo $error;
        exit;
        // echo json_encode(array('error' => $error));
        // echo json_encode(array($error));
        // $this->output
        // ->set_content_type('application/json')
        // ->set_output(json_encode(array('error' => $error)));
        // exit;
      }
      else
      {
        $uploaded = $this->upload->data();
        $this->resize_img($uploaded, $category);

        header('Content-type: application/json');
        echo json_encode(array('newname'=>$uploaded['file_name'], 'category'=>$category));
        exit;
      }

    }
    else
    {
      $this->output->set_status_header('404', 'Not Found');
    }
  }

  protected function resize_img($uploaded_file, $category)
  {
    /*
     *$uploaded_file
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
    $config['source_image'] = './media/'.$category.'/'.$uploaded_file['file_name'];
    $config['new_image'] = './media/'.$category.'/thumb/'.$uploaded_file['file_name'];
    $config['maintain_ratio'] = true;
    $config['width'] = 100;
    $config['height'] = 100;
    $this->image_lib->initialize($config);
    $this->image_lib->fit();
    $this->image_lib->clear();

    return TRUE;

  }

  public function unlink()
  {
    $filename = $this->input->post('filename');
    $category = $this->input->post('category');

    unlink(FCPATH.'/media/'.$category.'/'.$filename);
    unlink(FCPATH.'/media/'.$category.'/thumb/'.$filename);
    # code...
  }

}

/* End of file admin.php */
/* Location: .//D/server/htdocs/ciledug-racing/ci/modules/media/controllers/admin.php */