<?php

class Music_genre_model extends CI_Model
{
    /**
     * Retrives the list of music genres.
     *
     * @param       null
     * @return      Object  Music geres
     */
    public function get_music_genres()
    {
        $query = $this->db->get('music_genre');
        if ($query->result() <= 0) {
            return [];
        }
        return $query->result();
    }
}
