<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Media extends MY_Controller {

    public function __construct()
    {
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

      if (!$this->upload->do_upload())
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

    public function get_files()
    {
      $files = array();

      $dir = opendir(FCPATH . 'media/images/');
      while ($file = readdir($dir)) {
          if ($file == '.' || $file == '..') {
              continue;
          }
          $files[] = array(
            'image' =>'/media/images/'.$file,
            'thumb' =>'/media/images/'.$file,
            'folder' => ''
          );
      }
      // $fp = fopen('results.json', 'w');
      // fwrite($fp, json_encode($files));
      // fclose($fp);

      header('Content-type: application/json');
      echo json_encode($files);
      exit;
    }

  public function ckupload()
  {
    $this->load->model('BlogModel'); // the model that communicate with blog

    $config['upload_path'] = './media/images/';
    $config['allowed_types'] = 'gif|jpg|jpeg|png';
    $config['overwrite'] = FALSE;
    $this->load->library('upload');

    $ckeditor = $this->input->get('CKEditor');
    $lang_code = $this->input->get('langCode');
    $func_num = $this->input->get('CKEditorFuncNum'); //$_GET['CKEditorFuncNum']
    $this->upload->initialize($config);

    if (!$this->upload->do_upload('upload')){ // upload the file, 'upload' is the name of the field from CKEditor
         // failed upload
        $message = "Upload failed on server.";
        $url = '';

    }else{ // success copy to wp server
        $upload_result = base_url('media/images'.$this->upload->data()['file_name']);
        // $upload_name = $this->upload->data()['file_name'];

        // after finished uploading, it will receive a URL
        // $url = $this->BlogModel->UploadImage($blogID, $upload_result, $upload_name);

        $message = 'Upload success!';
    }
    echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$upload_result', '$message');</script>";
  }



}

/* End of file media.php */
/* Location: .//F/Server/htdocs/ciledug-racing/ci/modules/media/controllers/media.php */