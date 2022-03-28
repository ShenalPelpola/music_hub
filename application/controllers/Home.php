<?php

class Home extends CI_Controller
{

	public function index()
	{
		// redirect users based on session data.
		if ($this->session->userdata('authorized') && $this->session->userdata('profile_created')) {
			redirect("User/timeline_view");
		} elseif ($this->session->userdata('authorized') && !$this->session->userdata('profile_created')) {
			redirect("User/create_profile_view");
		}

		$data['display_sign_up'] = False;
		$data['display_log_in'] = False;

		$this->load->view('includes/header');
		$this->load->view('forms/log_in_form', $data);
		$this->load->view('forms/sign_up_form', $data);
		$this->load->view('main/home', $data);
		$this->load->view('includes/footer');
	}
}
