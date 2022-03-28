<?php

class People extends CI_Controller
{
    // Load the models in contrictor
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Music_genre_model');
        $this->load->model('User_music_model');
        $this->load->model('User_friend_model');
    }

    /**
     * For displaying following, followers and friends
     *
     * @param       none
     * @return      renders /people/index page
     */
    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $type = $this->input->get('type', TRUE);

        if ($type === "following") {
            $following =  $this->User_friend_model->get_following($user_id);
            $data["status"] = "followed";
            $data["users"] = $following;
        } elseif ($type === "followers") {
            $followers = $this->User_friend_model->get_followers($user_id);
            $data["status"] = "follower";
            $data["users"] = $followers;
        } elseif ($type === "friends") {
            $friends = $this->User_friend_model->get_friends($user_id);
            $data["status"] = "friend";
            $data["users"] = $friends;
        }

        $this->load->view('includes/header');
        $this->load->view('people/people_list', $data);
        $this->load->view('includes/footer');
    }

    /**
     * For displaying people that following different music genres
     *
     * @param       none
     * @return      renders /people/search
     */
    public function search()
    {
        // Retrive music genres
        $music_genres = $this->Music_genre_model->get_music_genres();
        $data['music_genres'] = $music_genres;

        // get user id from session
        $user_id = $this->session->userdata('user_id');

        // set initial state to the first genre
        $users = $this->insert_follower_status($this->User_music_model->get_by_genre(1, $user_id));
        $data['users'] = $users;

        $this->insert_follower_status($users);

        $this->form_validation->set_rules('searched-music-genre', 'Music Genre', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('includes/header');
            $this->load->view('people/search_people', $data);
            $this->load->view('includes/footer');
        } else {
            $genre_id = $this->input->post('searched-music-genre');
            $users = $this->insert_follower_status($this->User_music_model->get_by_genre($genre_id, $user_id));
            $data['users'] = $users;

            $this->load->view('includes/header');
            $this->load->view('people/search_people', $data);
            $this->load->view('includes/footer');
        }
    }

    /**
     * Handles the follow process
     *
     * @param       none
     * @return      renders /people/search
     */
    public function follow_user()
    {
        $user_id = $this->session->userdata('user_id');
        $following_id = $this->input->post('following_id');
        $submitted_page = $this->input->post('submitted_page');

        if (!isset($following_id) || !isset($submitted_page)) {
            redirect("/User/timeline_view");
        }
        if ($submitted_page === "profile") {
            $this->User_friend_model->follow($user_id, $following_id);
            redirect("/User?user_id=$following_id");
        } else if ($submitted_page === "search") {
            $this->User_friend_model->follow($user_id, $following_id);
            redirect("/People/search");
        }
    }

    private function insert_follower_status($users)
    {
        foreach ($users as $user) {
            $user->follow_status = $this->get_follower_status($this->session->userdata('user_id'), $user->id);
        }
        return $users;
    }

    private function get_follower_status($user_id, $following_id)
    {
        $this->load->model('User_friend_model');
        return $this->User_friend_model->get_follow_status($user_id, $following_id);
    }
}
