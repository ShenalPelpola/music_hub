<?php

class Posts extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Post_model');
    }

    /**
     * View for creating posts
     * 
     * @param       none  
     * @return      redirect /User/timeline_view
     */
    public function create_post()
    {
        // validation rule for the sign up form.
        $this->form_validation->set_rules('post-message', 'Post description', 'required');

        if ($this->form_validation->run() == FALSE) {
            redirect('User/timeline_view');
        } else {
            $form_data = [
                'user_id' => $this->session->userdata('user_id'),
                'description' => $this->input->post('post-message', TRUE),
                'created_at' => date("Y-m-d H:i:s"),
            ];

            $this->Post_model->create($form_data);
            redirect('User/timeline_view');
        }
    }
}
