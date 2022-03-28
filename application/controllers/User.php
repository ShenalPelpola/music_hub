<?php

class User extends CI_Controller
{
    // laod the models in the constructor
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Music_genre_model');
        $this->load->model('User_music_model');
        $this->load->model('Post_model');
        $this->load->model('User_model');
        $this->load->model('User_friend_model');
    }

    /**
     * For displaying the public home page of the user
     *
     * @param       none
     * @return      renders public_profile
     */
    public function index()
    {
        // fetch incoming data from the get request
        $user_id = $this->input->get('user_id', TRUE);
        $posts = $this->Post_model->get_post_by_user($user_id);
        $user_info = $this->User_model->get_user($user_id);
        $follow_status = $this->User_friend_model->get_follow_status($this->session->userdata('user_id'), $user_id);
        $stats = $this->User_friend_model->get_stats($user_id);

        $data['posts'] = $posts;
        $data['user_info'] = $user_info;
        $data['follow_status'] = $follow_status;
        $data['stats'] = $stats;

        $this->load->view('includes/header');
        $this->load->view('user/public_profile', $data);
        $this->load->view('includes/footer');
    }

    /**
     * For displaying the private home page(timeline) of the user
     *
     * @param       none
     * @return      renders private_profile
     */
    public function timeline_view()
    {
        // validate if the user is logged in
        if (!($this->session->userdata('authorized'))) {
            redirect("/Home");
        } else if (!($this->session->userdata('profile_created'))) {
            redirect('User/create_profile_view');
        }

        // retreive data from models
        $user_id = $this->session->userdata('user_id');
        $posts = $this->Post_model->get_post_by_following($user_id);
        $user_info = $this->User_model->get_user($user_id);
        $stats = $this->User_friend_model->get_stats($user_id);

        $data['posts'] = $posts;
        $data['user_info'] = $user_info;
        $data['stats'] = $stats;

        $this->load->view('includes/header');
        $this->load->view('user/private_home', $data);
        $this->load->view('includes/footer');
    }

    /**
     * For displaying the page to create user profile.
     *
     * @param       none
     * @return      renders create_profile_view
     */
    public function create_profile_view()
    {
        if (!($this->session->userdata('authorized'))) {
            redirect("/Home");
        } else if ($this->session->userdata('authorized') && $this->session->userdata('profile_created')) {
            redirect("User/timeline_view");
        }

        // Get music genres
        $music_genres = $this->Music_genre_model->get_music_genres();
        $data['music_genres'] = $music_genres;

        // validation rule for the sign up form.
        $this->form_validation->set_rules('avatar', 'User avatar', 'required');
        $this->form_validation->set_rules('fname', 'First name', 'required');
        $this->form_validation->set_rules('lname', 'Last name', 'required');
        $this->form_validation->set_rules('music-genre[]', 'music genre', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('includes/create_profile_header');
            $this->load->view('user/create_profile', $data);
            $this->load->view('includes/create_profile_footer');
        } else {

            $form_data = [
                'avatar' => $this->input->post('avatar', TRUE),
                'user_id' => $this->session->userdata('user_id'),
                'first_name' => $this->input->post('fname', TRUE),
                'last_name' => $this->input->post('lname', TRUE),
                'music_genes' => $this->input->post('music-genre[]'),
            ];

            $res = $this->User_music_model->insert($form_data);

            if ($res) {
                $this->session->set_userdata('profile_created', True);
                redirect('User/timeline_view');
            } else {
                $this->load->view('includes/create_profile_header');
                $this->load->view('user/create_profile', $data);
                $this->load->view('includes/create_profile_footer');
            }
        }
    }
}
