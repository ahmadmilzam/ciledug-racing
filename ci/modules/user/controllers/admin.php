<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller {

    function __construct()
    {
        parent::__construct();
    }

    //redirect if needed, otherwise display the user list
    public function index()
    {
        if (!$this->ion_auth->is_admin()) //remove this elseif if you want to enable this for non-admins
        {
            //redirect them to the home page because they must be an administrator to view this
            return show_error('You must be an administrator to view this page.');
        }

        $count = $this->db->count_all_results('users');
        $limit = 10;

        if ($count > $limit )
        {
            $this->load->library('pagination');
            $config['base_url'] = base_url('admin/user/index/page');
            $config['total_rows'] = $count;
            $config['per_page'] = $limit;
            $config['uri_segment'] = 5;
            $config['num_links'] = 3;
            $this->pagination->initialize($config);

            $data['pagination'] =  $this->pagination->create_links();
            $offset = $this->uri->segment(5);
        }
        else
        {
            $data['pagination'] = '';
            $offset = 0;
        }

        // if( $this->input->post('search_term') && $this->input->post('search_term') !== '' )
        // {
        //     // dump($this->input->post('search_term'));
        //     $term = strtolower($this->input->post('search_term', TRUE));
        //     $this->db->like('username', $term);
        //     $this->db->or_like('first_name', $term);
        //     // $this->db->or_like('last_name', $term);
        //     $data['pagination'] = '';
        // }

        //list the users with limit and offset if exist
        $this->db->limit($limit, $offset);

        // $data['users'] = $this->ion_auth->users()->result();
        $data['users'] = $this->ion_auth->get_all_users_with_group();

        $data['page_name'] = 'User List';
        $this->breadcrumb->append('Users', 'admin/auth');

        $this->template
             ->title($this->config->item('site_name'), $data['page_name'])
             ->build('admin/view_index', $data);
    }

    //create a new user
    public function create_user()
    {
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            redirect('auth', 'refresh');
        }

        //validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'required|xss_clean|is_natural');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[conf_password]');
        $this->form_validation->set_rules('conf_password', $this->lang->line('create_user_validation_password_confirm_label'), 'required');
        $this->form_validation->set_rules('groups', $this->lang->line('create_user_validation_groups_label'), 'xss_clean');

        if ($this->form_validation->run() == true)
        {
            $username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
            $email    = strtolower($this->input->post('email'));
            $password = $this->input->post('password');
            $groups   = $this->input->post('groups');
            // dump($groups); exit;
            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
                'phone'      => $this->input->post('phone')
            );
        }

        if ($this->form_validation->run() === TRUE && $this->ion_auth->register($username, $password, $email, $additional_data, $groups))
        {
            //check to see if we are creating the user
            //redirect them back to the admin page
            $this->session->set_flashdata('success', $this->ion_auth->messages());
            redirect("admin/user", 'refresh');
        }
        else
        {
            //display the create user form
            $data['first_name'] = $this->form_validation->set_value('first_name');
            $data['last_name']  = $this->form_validation->set_value('last_name');
            $data['email']      = $this->form_validation->set_value('email');
            $data['phone']      = $this->form_validation->set_value('phone');
            $data['groups']     = $this->input->post('groups');

            // dump($data['groups']);
            $data['all_groups'] = $this->ion_auth->groups()->result_array();

            $data['page_name'] = 'Create User';
            $this->breadcrumb->append('Users', 'admin/auth');
            $this->breadcrumb->append('Create User', 'admin/auth/create_user');

            $this->template
                 ->title($this->config->item('site_name'), $data['page_name'])
                 ->build('admin/view_create_user', $data);
        }
    }

    //edit a user
    public function edit_user($id = FALSE)
    {
        if(!$id)
        {
            $this->session->set_flashdata('error', 'User not found');
            redirect('admin/user');
        }

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            $this->session->set_flashdata('error', "You don't have privilage to edit user");
            redirect('admin/user', 'refresh');
        }

        $user   = $this->ion_auth->user($id)->row();
        $groups = $this->ion_auth->groups()->result_array();
        $currentGroups = $this->ion_auth->get_users_groups($id)->result();

        //validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('email', $this->lang->line('edit_user_validation_email_label'), 'required|valid_email');
        $this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'required|xss_clean');
        $this->form_validation->set_rules('groups', $this->lang->line('edit_user_validation_groups_label'), 'xss_clean');

        if (isset($_POST) && !empty($_POST))
        {
            $data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
                'email'      => $this->input->post('email'),
                'phone'      => $this->input->post('phone'),
            );

            // Only allow updating groups if user is admin
            if ($this->ion_auth->is_admin())
            {
                //Update the groups user belongs to
                $groupData = $this->input->post('groups');

                if (isset($groupData) && !empty($groupData)) {

                    $this->ion_auth->remove_from_group('', $id);

                    foreach ($groupData as $grp)
                    {
                        $this->ion_auth->add_to_group($grp, $id);
                    }
                }
            }

            //update the password if it was posted
            if ($this->input->post('password'))
            {
                $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
                $this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
                $data['password'] = $this->input->post('password');
            }

            if ($this->form_validation->run() === TRUE)
            {
                $this->ion_auth->update($user->id, $data);

                //check to see if we are creating the user
                //redirect them back to the admin page
                $this->session->set_flashdata('success', "Data has been saved");
                redirect("admin/user", 'refresh');
            }

        }

        //pass the user to the view
        $data['user'] = $user;
        $data['groups'] = $groups;
        $data['currentGroups'] = $currentGroups;

        $data['first_name'] = array(
            'name'  => 'first_name',
            'class' => 'form-control',
            'id'    => 'first_name',
            'type'  => 'text',
            'required' => 'required',
            'value' => $this->form_validation->set_value('first_name', $user->first_name),
        );
        $data['last_name'] = array(
            'name'  => 'last_name',
            'class' => 'form-control',
            'id'    => 'last_name',
            'type'  => 'text',
            'required' => 'required',
            'value' => $this->form_validation->set_value('last_name', $user->last_name),
        );
        $data['email'] = array(
            'name'  => 'email',
            'class' => 'form-control',
            'id'    => 'email',
            'type'  => 'email',
            'required' => 'required',
            'value' => $this->form_validation->set_value('email', $user->email),
        );
        $data['phone'] = array(
            'name'  => 'phone',
            'class' => 'form-control',
            'id'    => 'phone',
            'type'  => 'text',
            'required' => 'required',
            'value' => $this->form_validation->set_value('phone', $user->phone),
        );
        $data['password'] = array(
            'name' => 'password',
            'class' => 'form-control',
            'id'   => 'password',
            'type' => 'password'
        );
        $data['password_confirm'] = array(
            'name' => 'password_confirm',
            'class' => 'form-control',
            'id'   => 'password_confirm',
            'type' => 'password'
        );

        $data['page_name'] = 'Edit User';
        $this->breadcrumb->append('Users', 'admin/user');
        $this->breadcrumb->append('Edit User', 'admin/user/edit_user');

        $this->template
             ->title($this->config->item('site_name'), $data['page_name'])
             ->build('admin/view_edit_user', $data);

    }

    // create a new group
    function create_group()
    {
        $data['title'] = $this->lang->line('create_group_title');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            redirect('auth', 'refresh');
        }

        //validate form input
        $this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'required|alpha_dash|xss_clean');
        $this->form_validation->set_rules('description', $this->lang->line('create_group_validation_desc_label'), 'xss_clean');

        if ($this->form_validation->run() == TRUE)
        {
            $new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
            if($new_group_id)
            {
                // check to see if we are creating the group
                // redirect them back to the admin page
                $this->session->set_flashdata('success', $this->ion_auth->messages());
                redirect("auth", 'refresh');
            }
        }
        else
        {
            //display the create group form
            //set the flash data error message if there is one
            $data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $data['group_name'] = array(
                'name'  => 'group_name',
                'id'    => 'group_name',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('group_name'),
            );
            $data['description'] = array(
                'name'  => 'description',
                'id'    => 'description',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('description'),
            );
            $data['page_name'] = 'Edit User';
            $this->breadcrumb->append('Users', 'admin/auth');
            $this->breadcrumb->append('Create Group', 'admin/auth/create_group');

            $this->template
                 ->title($this->config->item('site_name'), $data['page_name'])
                 ->build('admin/view_create_group', $data);

        }
    }

    //edit a group
    function edit_group($id)
    {
        // bail if no group id given
        if(!$id || empty($id))
        {
            redirect('auth', 'refresh');
        }

        $data['title'] = $this->lang->line('edit_group_title');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            redirect('auth', 'refresh');
        }

        $group = $this->ion_auth->group($id)->row();

        //validate form input
        $this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash|xss_clean');
        $this->form_validation->set_rules('group_description', $this->lang->line('edit_group_validation_desc_label'), 'xss_clean');

        if (isset($_POST) && !empty($_POST))
        {
            if ($this->form_validation->run() === TRUE)
            {
                $group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

                if($group_update)
                {
                    $this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
                }
                else
                {
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                }
                redirect("auth", 'refresh');
            }
        }

        //set the flash data error message if there is one
        $data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        //pass the user to the view
        $data['group'] = $group;

        $data['group_name'] = array(
            'name'  => 'group_name',
            'id'    => 'group_name',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('group_name', $group->name),
        );
        $data['group_description'] = array(
            'name'  => 'group_description',
            'id'    => 'group_description',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('group_description', $group->description),
        );

        $this->_render_page('auth/edit_group', $data);
    }

    //activate the user
    function activate($id)
    {
        if ($this->ion_auth->activate($id))
        {
            //redirect them to the auth page
            $this->session->set_flashdata('success', $this->ion_auth->messages());
        }
        else
        {
            //redirect them to the forgot password page
            $this->session->set_flashdata('error', $this->ion_auth->errors());
        }
            redirect("admin/user", 'refresh');
    }

    //deactivate the user
    function deactivate($id = NULL)
    {
        // do we have the right userlevel?
        if ($this->ion_auth->deactivate($id))
        {
            $this->session->set_flashdata('success', $this->ion_auth->messages());
        }
        else
        {
            $this->session->set_flashdata('error', $this->ion_auth->errors());
        }
        //redirect them back to user list page
        redirect('admin/user', 'refresh');
    }

    public function delete_user($id = FALSE)
    {
        if(!$id)
        {
            $this->session->set_flashdata('error', 'An error occured, user not found');
            redirect('admin/user', 'refresh');
        }

        if($this->ion_auth->delete_user($id))
        {
            $this->session->set_flashdata('success', 'User has been deleted');
        }
        else
        {
            $this->session->set_flashdata('error', 'An error occured while deleting an user');
        }
        redirect('admin/user', 'refresh');
    }

    // protected function check_edit_email($email)
    // {
    //     $id = $this->uri->segment(4);
    //     $this->db->where('id !=', $id);
    //     if (!$this->ion_auth->email_check($email))
    //     {
    //         $this->ion_auth->register($username, $password, $email, $additional_data, $group_name)
    //     }
    // }

}

/* End of file admin.php */
/* Location: ./modules/auth/controllers/admin.php */