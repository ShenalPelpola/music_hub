<?php

class User_music_model extends CI_Model
{
    public function get_by_genre($genre_id, $user_id)
    {
        $sql = "SELECT user.id, user.username, 
        user.avatar, user.first_name, user.last_name, music_genre.genre
        FROM user 
        inner join user_music
        ON user_music.user_id=user.id
        inner join music_genre
        ON user_music.genre_id = music_genre.id
        WHERE genre_id = $genre_id
        AND user.id NOT LIKE $user_id;";

        $query = $this->db->query($sql);
        if (!$query) {
            return [];
        }
        return $query->result();
    }

    public function insert($data)
    {
        if (!isset($data)) {
            return false;
        }
        $success = false;
        $this->db->trans_start();

        // Update the user table
        $success = $this->db->where('id', $data['user_id']);
        $success = $this->db->update(
            'user',
            [
                "first_name" => $data['first_name'],
                "last_name" => $data['last_name'],
                "avatar" => $data['avatar'],
            ]
        );
        // insert data into user_music table
        foreach ($data['music_genes'] as $genre_id) {
            $success = $this->db->insert(
                'user_music',
                [
                    "user_id" => $data['user_id'],
                    "genre_id" => $genre_id
                ]
            );
        }
        $this->db->trans_complete();
        return $success;
    }
}
