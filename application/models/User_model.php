<?php

class User_model extends CI_Model
{
    private $entity = 'user';

    /**
     * Insert user data to the user table onece registered
     *
     * @param       Array  $data-A array containing username and password
     * @return      Object  The user record
     */
    public function create($data)
    {
        if (!isset($data)) {
            return null;
        }
        // password encryption
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        // if succesfully inserted retrive the user from the table
        if ($this->db->insert($this->entity, $data)) {
            return $this->get_user_by_username($data['username']);
        }
    }

    /**
     * Check the availablity of the user and retreives the 
     * user when the user logs in.
     *
     * @param       Array  $data-A array containing username and password
     * @return      Object  The user record
     */
    public function authenticate($data)
    {
        $res = $this->db->get_where($this->entity, array('username' => $data['username']));

        if ($res->num_rows() != 1) {
            return null;
        } else {
            $row = $res->row(0);
            // decrypt and verifies the password
            if (password_verify($data["password"], $row->password)) {
                return $row;
            } else {
                return null;
            }
        }
    }

    /**
     * Check the availablity of the user and retreives the 
     * user when the user logs in.
     *
     * @param       Array  $data-A array containing username and password
     * @return      Object  The user record
     */
    public function get_user($user_id)
    {
        $res = $this->db->get_where($this->entity, array('id' => $user_id));
        // check if the user exits if not return false
        if ($res->num_rows() != 1) {
            return null;
        } else {
            return $res->row(0);
        }
    }

    /**
     * Helper function to reteive user by name
     *
     * @param       string  username
     * @return      Object  The user record
     */
    private function get_user_by_username($username)
    {
        $res = $this->db->get_where($this->entity, array('username' => $username));
        // check if the user exits if not return false
        if ($res->num_rows() != 1) {
            return null;
        } else {
            return $res->row(0);
        }
    }
}
