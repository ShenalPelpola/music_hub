<?php

class Post_model extends CI_Model
{
    private $entity = 'post';

    public function create($data)
    {
        if (!isset($data)) {
            return false;
        }
        // if succesfully inserted retrive the user from the table
        if ($this->db->insert($this->entity, $data)) {
            return true;
        }
    }

    public function get_post_by_user($user_id)
    {
        $sql = "SELECT 
            p.description AS post_description, 
            p.created_at AS created_at,
            u.username AS username, 
            u.first_name AS first_name, 
            u.last_name As last_name,
            u.avatar As avatar 
            FROM post p
            INNER JOIN 
            user u ON p.user_id = u.id WHERE u.id=$user_id
            ORDER BY p.created_at DESC;";

        $query = $this->db->query($sql);
        if (!$query) {
            return [];
        }
        return $query->result();
    }

    public function get_post_by_following($user_id)
    {
        $sql = "(SELECT 
        p.description AS post_description, p.created_at AS created_at,u.id, 
        u.username AS username, u.first_name AS first_name, u.last_name As last_name,
        u.avatar As avatar FROM user_following 
        inner join user u On user_following.following_id = u.id
        inner join post p On user_following.following_id = p.user_id
        where user_following.user_id=$user_id)
        UNION
        (SELECT 
        p.description AS post_description, p.created_at AS created_at,
        u.id, u.username AS username, u.first_name AS first_name, 
        u.last_name As last_name, u.avatar As avatar 
        FROM post p INNER JOIN 
        user u ON p.user_id = u.id WHERE u.id=$user_id) ORDER BY created_at DESC;";

        $query = $this->db->query($sql);
        if (!$query) {
            return [];
        }
        return $query->result();
    }
}
