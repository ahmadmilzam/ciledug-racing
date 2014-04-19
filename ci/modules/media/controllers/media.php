<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Media extends Admin_Controller {

  public function __construct()
  {
    //set template
    $this->template->set_theme('admin');
    parent::__construct();
  }

  public function index()
  {
    $this->load->view('view_index', array('error' => ''));
  }


  public function upload($type = '')
  {
    if(!$type OR !in_array($type, array('product', 'gallery', 'images')) )
    {
      show_404();
    }

    $upload_path_url = base_url() . $type . '/';

    $config['upload_path'] = FCPATH . 'media/'.$type.'/';
    $config['allowed_types'] = 'jpg|jpeg|png|gif';
    $config['max_size'] = '30000';

    $this->load->library('upload', $config);
    // dump_exit($config['upload_path']);

    if (!$this->upload->do_upload('file'))
    {
      //$error = array('error' => $this->upload->display_errors());
      //$this->load->view('upload', $error);

      //Load the list of existing files in the upload directory
      $existingFiles = get_dir_file_info($config['upload_path']);
      $foundFiles = array();
      $f=0;
      foreach ($existingFiles as $fileName => $info)
      {
        if($fileName!='thumbs'){//Skip over thumbs directory
          //set the data for the json array
          $foundFiles[$f]['name'] = $fileName;
          $foundFiles[$f]['size'] = $info['size'];
          $foundFiles[$f]['url'] = $upload_path_url . $fileName;
          $foundFiles[$f]['thumbnailUrl'] = $upload_path_url . 'thumbs/' . $fileName;
          $foundFiles[$f]['deleteUrl'] = base_url() . 'upload/deleteImage/' . $fileName;
          $foundFiles[$f]['deleteType'] = 'DELETE';
          $foundFiles[$f]['error'] = null;

          $f++;
        }
      }
      $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode(array('files' => $foundFiles)));
    }
    else
    {
      $data = $this->upload->data();
      /*
       * Array
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
      // to re-size for thumbnail images un-comment and set path here and in json array
      $config = array();
      $config['image_library'] = 'gd2';
      $config['source_image'] = $data['full_path'];
      $config['create_thumb'] = TRUE;
      $config['new_image'] = $data['file_path'] . 'thumbs/';
      $config['maintain_ratio'] = TRUE;
      $config['thumb_marker'] = '';
      $config['width'] = 75;
      $config['height'] = 50;
      $this->load->library('image_lib', $config);
      $this->image_lib->fit();


      //set the data for the json array
      $info = new StdClass;
      $info->name = $data['file_name'];
      $info->size = $data['file_size'] * 1024;
      $info->type = $data['file_type'];
      $info->url = $upload_path_url . $data['file_name'];
      // I set this to original file since I did not create thumbs.  change to thumbnail directory if you do = $upload_path_url .'/thumbs' .$data['file_name']
      $info->thumbnailUrl = $upload_path_url . 'thumbs/' . $data['file_name'];
      $info->deleteUrl = base_url() . 'media/'.$type.'/deleteImage/' . $data['file_name'];
      $info->deleteType = 'DELETE';
      $info->error = null;

      $files[] = $info;
      //this is why we put this in the constants to pass only json data
      if (IS_AJAX)
      {
          echo json_encode(array("files" => $files));
          //this has to be the only data returned or you will get an error.
          //if you don't give this a json array it will give you a Empty file upload result error
          //it you set this without the if(IS_AJAX)...else... you get ERROR:TRUE (my experience anyway)
          // so that this will still work if javascript is not enabled
      }
      else
      {
          $file_data['upload_data'] = $this->upload->data();
          $this->load->view('view_upload_success', $file_data);
      }
    }
  }

  public function delete($type, $file)
  {//gets the job done but you might want to add error checking and security
    if(!$type OR !in_array($type, array('product', 'gallery', 'images')) )
    {
      show_404();
    }

    $success = unlink(FCPATH . 'media/' . $type . '/' . $file);
    $success = unlink(FCPATH . 'media/' . $type . '/thumbs/' . $file);

    //info to see if it is doing what it is supposed to
    $info = new StdClass;
    $info->sucess = $success;
    $info->path = base_url() . 'media/' . $type . '/' . $file;
    $info->file = is_file(FCPATH . 'media/' . $type . '/' . $file);

    if (IS_AJAX)
    {
      //I don't think it matters if this is set but good for error checking in the console/firebug
      echo json_encode(array($info));
    }
    else
    {
      //here you will need to decide what you want to show for a successful delete
      $file_data['delete_data'] = $file;
      $this->load->view('view_delete_success', $file_data);
    }
  }

  public function get_files($type = FALSE)
  {
    $files = array();
    if(!$type)
    {
      show_404();
    }

    switch ($type)
    {
      case 'product':
        # code...
        $dir = opendir(FCPATH . 'media/product/thumb');
        break;

      default:
        # code...
        $dir = opendir(FCPATH . 'media/images/');
        break;
    }

    while ($file = readdir($dir))
    {
        if ($file == '.' || $file == '..') {
            continue;
        }
        if($type == 'ckeditor')
        {
          $files[] = array(
            'image' =>'/media/images/'.$file,
            'thumb' =>'/media/images/thumb/'.$file,
            'folder' => ''
          );
        }
        if($type == 'product')
        {
          $files[] = array(
            'filename' =>$file,
            'original' =>'media/product/'.$file,
            'thumb' =>'media/product/thumb/'.$file,
          );
        }

    }

    header('Content-type: application/json');
    echo json_encode($files);
    exit;
  }

  public function browse()
  {
    /**
     * define partials css and js only for login page
     * 1. local css
     * 2. local js
     * 3. compile assets
     */
    //[1]
    $this->local_css = array(
      array('css/bootstrap.css'),
      array('css/admin.css')
    );

    //[2]
    $this->local_js = array(
      array('js/jquery-2.1.0.js'),
      array('js/bootstrap.min.js'),
      array('lib/bootbox/bootbox.min.js'),
      array('js/local/media.js')
    );

    //[3]
    $this->carabiner->group('local_css', array('css'=>$this->local_css) );
    $this->carabiner->group('local_js', array('js'=>$this->local_js) );

    //render view
    $this->template
         ->set_layout('layout_blank')
         ->title($this->config->item('site_name'), 'Browse File')
         ->build('view_browse');
  }

  // public function resize()
  // {
  //   // basic info
  //   $oldpath = $this->uri->uri_string();

  //   $array = explode('/', $oldpath);
  //   $key = array_search("media", $array);
  //   $newarray = array_splice($array, $key);

  //   $path = implode("/", $newarray);

  //   $pathinfo = pathinfo($path);
  //   // dump_exit($pathinfo);

  //   $size = end(explode("-", $pathinfo["filename"]));
  //   $original = $pathinfo["dirname"] . "/" . str_ireplace("-" . $size, "", $pathinfo["basename"]);

  //   // original image not found, show 404
  //   if (!file_exists($original))
  //   {
  //     show_404($original);
  //   }

  //   // load the allowed image sizes
  //   $this->load->config("images");
  //   $sizes = $this->config->item("image_sizes");
  //   $allowed = FALSE;

  //   if (stripos($size, "x") !== FALSE)
  //   {
  //     // dimensions are provided as size
  //     @list($width, $height) = explode("x", $size);

  //     // security check, to avoid users requesting random sizes
  //     foreach ($sizes as $s) {
  //       if ($width == $s[0] && $height == $s[1])
  //       {
  //           $allowed = TRUE;
  //           break;
  //       }
  //     }
  //   }
  //   else if (isset($sizes[$size]))
  //   {
  //     // optional, the preset is provided instead of the dimensions
  //     // NOTE: the controller will be executed EVERY time you request the image this way
  //     @list($width, $height) = $sizes[$size];
  //     $allowed = TRUE;

  //     // set the correct output path
  //     $path = str_ireplace($size, $width . "x" . $height, $path);
  //   }

  //   // only continue with a valid width and height
  //   if ($allowed && $width >= 0 && $height >= 0)
  //   {
  //     // initialize library
  //     $config["source_image"] = $original;
  //     $config['new_image'] = $path;
  //     $config["width"] = $width;
  //     $config["height"] = $height;
  //     $config["dynamic_output"] = FALSE; // always save as cache

  //     $this->load->library('image_lib');
  //     $this->image_lib->initialize($config);

  //     $this->image_lib->fit();
  //   }

  //   // check if the resulting image exists, else show the original
  //   if (file_exists($path)) {
  //       $output = $path;
  //   } else {
  //       $output = $original;
  //   }

  //   $info = getimagesize($output);
  //   // dump($output);
  //   // dump_exit($info);
  //   // output the image
  //   // $this->output
  //   // ->set_content_type($info['mime']) // You could also use ".jpeg" which will have the full stop removed before looking in config/mimes.php
  //   // ->set_output(readfile(FCPATH.$output))
  //   // ->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');

  //   header("Content-Disposition: filename={$output};");
  //   header("Content-Type: {$info["mime"]}");
  //   header('Content-Transfer-Encoding: binary');
  //   header('Last-Modified: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');

  //   readfile(FCPATH$output);

  // }



}

/* End of file media.php */
/* Location: .//F/Server/htdocs/ciledug-racing/ci/modules/media/controllers/media.php */