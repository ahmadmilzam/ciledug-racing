<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends MY_Controller {

  public function __construct()
  {
    //set template
    $this->template->set_theme('admin')
                   ->set_layout('layout_modal');

    parent::__construct();
    // Load user/auth/ library only for admin section, it depends on your application
    $this->load->library('user/ion_auth');

    //set assets
    $this->main_css = array(
      array('css/bootstrap.css'),
      array('css/font-awesome.css'),
      array('css/ionicons.css'),
      array('css/admin.css')
    );
    $this->carabiner->group('main_css', array('css'=>$this->main_css) );
  }

  /**
   * Login Page
      TODO:
      - check if user already logged in
      - if logged in, return to dashboard
      - if not logged in, collect the credentials data
      - if data is valid, redirect to dashboard
  **/
  public function login()
  {
    //redirect them to dashboard if already logged in
    if ($this->ion_auth->logged_in())
    {
        redirect('admin', 'refresh');
    }

    //validate form input
    $this->form_validation->set_rules('email', 'Email', 'trim|required');
    $this->form_validation->set_rules('password', 'Password', 'trim|required');

    if ($this->form_validation->run() === TRUE)
    {
        //check to see if the user is logging in
        //check for "remember me"
        $remember = (bool) $this->input->post('remember');

        if ($this->ion_auth->login($this->input->post('email'), $this->input->post('password'), $remember))
        {
            //if the login is successful
            //redirect them back to the home page
            $this->session->set_flashdata('success', $this->ion_auth->messages());
            redirect('admin', 'refresh');
        }
        else
        {
            //if the login was un-successful
            //redirect them back to the login page
            $this->session->set_flashdata('error', $this->ion_auth->errors());
            redirect('user/auth/login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
        }
    }
    else
    {
      /**
       * define input field for login form
       * 1. email
       * 2. password
       * 3. submit button
       */
      //[1]
      $data['input_email'] = array(
        'class' => 'form-control input-lg',
        'name'     => 'email',
        'type'     => 'email',
        'placeholder' => 'Enter your email',
        'value'    => $this->form_validation->set_value('email'),
        'required' => 'required'
      );

      //[2]
      $data['input_password'] = array(
        'class' => 'form-control input-lg',
        'name' => 'password',
        'type' => 'password',
        'placeholder' => 'Enter your password',
        'value' => $this->form_validation->set_value('password'),
        'required' => 'required'
      );

      //[3]
      $data['submit_button'] = array(
        'class' => 'btn btn-primary btn-lg btn-block',
        'type' => 'submit',
        'name' => 'submit',
        'content' => 'Log In'
      );
      /**
       * define partials css and js only for login page
       * 1. local js
       * 2. compile assets
       */
      //[1]
      $this->local_js = array(
        array('js/jquery-2.1.0.js'),
        array('js/bootstrap.min.js'),
        array('js/local/login.js')
      );

      //[2]
      $this->carabiner->group('local_js', array('js'=>$this->local_js) );

      //render view
      $this->template
           ->title($this->config->item('site_name'), 'Login')
           ->build('auth/view_login', $data);
    }

  }

  //forgot password
  private function forgot_password()
  {
    //redirect them to dashboard if already logged in
    if ($this->ion_auth->logged_in())
    {
        redirect('admin', 'refresh');
    }

    $this->form_validation->set_rules('email', $this->lang->line('forgot_password_validation_email_label'), 'required');

    if ($this->form_validation->run() === FALSE)
    {
      /**
       * define input field for forgot password form
       * 1. password
       * 2. submit button
       */
      //[1]
      $data['input_email'] = array(
        'class'       => 'form-control input-lg',
        'name'        => 'email',
        'type'        => 'email',
        'placeholder' => 'Enter your email',
        'value'       => $this->form_validation->set_value('email'),
        'required'    => 'required'
      );
      //[2]
      $data['submit_button'] = array(
        'type'    => 'submit',
        'name'    => 'submit',
        'class'   => 'btn btn-primary btn-lg btn-block',
        'content' => 'Submit'
      );
      /**
       * define partials css and js only for login page
       * 1. local js
       * 2. compile assets
       */
      //[1]
      $this->local_js = array(
        array('jquery-2.1.0.js'),
        array('bootstrap.min.js')
      );

      //[2]
      $this->carabiner->group('local_js', array('js'=>$this->local_js) );

      //render template
      $this->template
           ->title($this->config->item('site_name'), 'Forgot Password')
           ->build('view_forgot_password', $data);
    }
    else
    {
      // get identity for that email
      $check = $this->ion_auth_model->email_check($this->input->post('email'));

      if(!$check)
      {
          $this->ion_auth->set_message('forgot_password_email_not_found');
          $this->session->set_flashdata('error', $this->ion_auth->messages());
          redirect("user/auth/forgot_password", 'refresh');
      }

      //run the forgotten password method to email an activation code to the user
      $forgotten = $this->ion_auth->forgotten_password($this->input->post('email'));

      if ($forgotten)
      {
          //if there were no errors
          $this->session->set_flashdata('success', $this->ion_auth->messages());
          redirect("user/auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
      }
      else
      {
          $this->session->set_flashdata('error', $this->ion_auth->errors());
          redirect("user/auth/forgot_password", 'refresh');
      }
    }
  }

  //reset password - final step for forgotten password
  private function reset_password($code = FALSE)
  {
    // var_dump($code);exit;

    if (!$code)
    {
      show_404();
    }

    $user = $this->ion_auth->forgotten_password_check($code);

    if($user)
    {
      //if the code is valid then display the password reset form

      $this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
      $this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

      if ($this->form_validation->run() == false)
      {
        $data['code'] = $code;
        $data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
        //display the form
        /**
         * define input field for forgot password form
         * 1. new password (text)
         * 2. new confirm password (text)
         * 3. user id (hidden)
         * 4. submit button (submit)
         */

        //[1]
        $data['new_password'] = array(
            'class'     => 'form-control input-lg',
            'name'      => 'new',
            'type'      => 'password',
            'placeholder'      => 'Insert your new password',
            'pattern'   => '^.{'.$data['min_password_length'].'}.*$',
        );

        //[2]
        $data['new_password_confirm'] = array(
            'class'   => 'form-control input-lg',
            'name'    => 'new_confirm',
            'type'    => 'password',
            'placeholder'      => 'Insert your new password confirm',
            'pattern' => '^.{'.$data['min_password_length'].'}.*$',
        );

        //[3]
        $data['user_id'] = array(
            'name'  => 'user_id',
            'type'  => 'hidden',
            'value' => $user->id,
        );

        //[4]
        $data['submit_button'] = array(
          'type'    => 'submit',
          'name'    => 'submit',
          'class'   => 'btn btn-primary btn-lg btn-block',
          'content' => $this->lang->line('reset_password_submit_btn')
        );
        /**
         * define partials css and js only for login page
         * 1. local js
         * 2. compile assets
         */
        //[1]
        $this->local_js = array(
          array('jquery-2.1.0.js'),
          array('bootstrap.min.js')
        );

        //[2]
        $this->carabiner->group('local_js', ['js'=>$this->local_js] );

        //render template
        $this->template
             ->title($this->config->item('site_name'), 'Reset Password')
             ->build('view_reset_password', $data);
      }
      else
      {
        // finally change the password
        $identity = $user->{$this->config->item('identity', 'ion_auth')};

        $change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

        if ($change)
        {
            //if the password was successfully changed
            $this->session->set_flashdata('success', $this->ion_auth->messages());
            $this->logout();
        }
        else
        {
            $this->session->set_flashdata('error', $this->ion_auth->errors());
            redirect('user/auth/reset_password/' . $code, 'refresh');
        }
      }
    }
    else
    {
      //if the code is invalid then send them back to the forgot password page
      $this->session->set_flashdata('error', $this->ion_auth->errors());
      redirect("user/auth/forgot_password", 'refresh');
    }
  }

  //log the user out
  public function logout()
  {
      //log the user out
      $logout = $this->ion_auth->logout();

      //redirect them to the login page
      $this->session->set_flashdata('success', $this->ion_auth->messages());
      redirect('user/auth/login', 'refresh');
  }
}

/* End of file user/auth/.php */
/* Location: ./application/modules/user/auth/controllers/user/auth/.php */