<?php

class Authentication extends CI_Controller
{
    private $validation_rules_signup;
    private $validation_rules_login;

    public function __construct()
    {
        parent::__construct();

        // validation rules for the signup form.
        $this->validation_rules_signup = [
            [
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'required|is_unique[user.username]|min_length[3]|max_length[255]',
                'errors' => [
                    'required' => 'Please provide a %s.',
                    'is_unique' => 'This %s already existes',
                    'min_length' => '%s should be at least 3 characters',
                    'maxx_length' => '%s should be less 20 characters'
                ]
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|min_length[8]|max_length[255]',
                'errors' => [
                    'required' => 'Please provide a %s.',
                    'min_length' => '%s should be at least 8 characters',
                    'maxx_length' => '%s should be less 255 characters'
                ]
            ],

            [
                'field' => 'confirmPassword',
                'label' => 'Confirm Password',
                'rules' => 'matches[password]',
                'errors' => [
                    'matches' => 'Password does not match',
                ]
            ],
        ];

        // validation rules for the signup process
        $this->validation_rules_login = [
            [
                'field' => 'loginusername',
                'label' => 'Username',
                'rules' => 'required',
                'errors' => ['required' => 'Please provide a %s.']
            ],
            [
                'field' => 'loginpassword',
                'label' => 'Password',
                'rules' => 'required',
                'errors' => ['required' => 'Please provide the %s.']
            ],
        ];
    }

    /**
     * Handles functionalities related to registering a user
     *
     * @param       null
     * @return      null renders the form and record details to register a user.
     */
    public function register_user()
    {
        // validation rule for the sign up form.
        $this->form_validation->set_rules($this->validation_rules_signup);

        // status of the popup login and signup
        $data['display_sign_up'] = False;
        $data['display_log_in'] = False;

        if ($this->form_validation->run() == FALSE) {
            $data['display_sign_up'] = TRUE;
            $this->load->view('includes/header', $data);
            $this->load->view('forms/log_in_form', $data);
            $this->load->view('forms/sign_up_form', $data);
            $this->load->view('main/home', $data);
            $this->load->view('includes/footer');
        } else {

            // recoded data from the sign up form
            $form_data = [
                'username' => $this->input->post('username', TRUE),
                'password' => $this->input->post('password', TRUE),
            ];

            $this->load->model('User_model');

            // retrive user info from the model
            $res = $this->User_model->create($form_data);

            if (!is_null($res)) {
                $user_data = array(
                    'user_id' => $res->id,
                    'username' => $res->username,
                    'authorized' => True,
                    'profile_created' => False,
                );

                $this->session->set_userdata($user_data);
                redirect('User/create_profile_view');
            } else {
                redirect("/Home");
            }
        }
    }

    /**
     * Handles functionalities related logging in a user.
     *
     * @param       null
     * @return      null logsin user and redirect user to timeline
     */
    public function login_user()
    {
        // validation rule for the log in form.
        $this->form_validation->set_rules($this->validation_rules_login);

        // status of the popup login and signup
        $data['display_sign_up'] = False;
        $data['display_log_in'] = False;

        // check if the validation rules
        if ($this->form_validation->run() == FALSE) {
            $data['display_log_in'] = True;
            $this->load->view('includes/header');
            $this->load->view('forms/log_in_form', $data);
            $this->load->view('forms/sign_up_form', $data);
            $this->load->view('main/home', $data);
            $this->load->view('includes/footer');
        } else {
            // recoded data from the sign up form
            $form_data = [
                'username' => $this->input->post('loginusername', TRUE),
                'password' => $this->input->post('loginpassword', TRUE)
            ];

            $this->load->model('User_model');
            $res = $this->User_model->authenticate($form_data);

            if (!is_null($res)) {
                // set user session
                $user_data = array(
                    'user_id' => $res->id,
                    'username' => $res->username,
                    'authorized' => True,
                    'profile_created' => True,
                );

                $this->session->set_userdata($user_data);
                redirect('User/timeline_view');
            } else {
                redirect('Home');
            }
        }
    }

    /**
     * Handles functionalities related logging out a user.
     *
     * @param       null
     * @return      null removes the user session and redirect user to home
     */

    public function logout()
    {
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('authorized');
        $this->session->unset_userdata('profile_created');
        redirect("/Home");
    }
}
