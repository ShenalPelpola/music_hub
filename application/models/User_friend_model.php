<?php

class User_friend_model extends CI_Model
{
    public function follow($user_id, $following_id)
    {
        $success = $this->db->insert(
            'user_following',
            [
                "user_id" => $user_id,
                "following_id" => $following_id,
            ]
        );
        return $success;
    }

    public function get_follow_status($user_id, $following_id)
    {
        $this->db->trans_start();
        $following = $this->db->get_where('user_following', [
            'user_id' => $user_id,
            'following_id' => $following_id
        ]);

        $followed = $this->db->get_where('user_following', [
            'user_id' => $following_id,
            'following_id' => $user_id
        ]);
        $this->db->trans_complete();

        if ($following->num_rows() == 1 && $followed->num_rows() == 1) {
            return 2;
        } elseif ($following->num_rows() == 1) {
            return 1;
        } elseif ($followed->num_rows() == 1) {
            return 0;
        } else {
            return -1;
        }
    }

    public function get_following($user_id)
    {
        $sql = "SELECT 
        u.id, u.username AS username, u.first_name AS first_name, 
        u.last_name As last_name,
        u.avatar As avatar FROM user_following 
        inner join user u On user_following.following_id = u.id
        where user_following.user_id=$user_id;";

        $query = $this->db->query($sql);
        if (!$query) {
            return [];
        }
        return $query->result();
    }

    public function get_followers($user_id)
    {
        $sql = "SELECT 
        u.id, u.username AS username, u.first_name AS first_name, 
        u.last_name As last_name,
        u.avatar As avatar FROM user_following 
        inner join user u On user_following.user_id = u.id
        where user_following.following_id=$user_id;";

        $query = $this->db->query($sql);
        if (!$query) {
            return [];
        }
        return $query->result();
    }

    public function get_friends($user_id)
    {
        $sql = "SELECT DISTINCT user.id, user.first_name, 
        user.username, user.last_name, user.avatar
        FROM user
        JOIN user_following ON user_following.following_id = user.id
        INNER JOIN user_following f ON user_following.following_id = f.following_id 
        AND user_following.following_id = f.following_id where user_following.user_id = $user_id;";

        $query = $this->db->query($sql);
        if (!$query) {
            return [];
        }
        return $query->result();
    }


    public function get_stats($user_id)
    {
        $this->db->trans_start();

        $following_query = $this->get_following($user_id);
        $followers_query = $this->get_followers($user_id);
        $friends_query =  $this->get_friends($user_id);

        return [
            "following" => count($following_query),
            "followers" => count($followers_query),
            "friends" => count($friends_query),
        ];
    }
}
