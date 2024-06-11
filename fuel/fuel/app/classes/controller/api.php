<?php
use Fuel\Core\Controller_Rest;
use Fuel\Core\DB;

class Controller_Api extends Controller_Rest {
    protected $format = 'json';

    public function post_update($id) {
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            $song = Model_Songs::find($id);
            if ($song) {
                $song->set($input);
                $song->save();
                return $this->response(($song->to_array()));
            } else {
                return $this->response(['error' => 'Song not found'], 404);
            }
        } catch (Exception $e) {
            return $this->response(['error' => $e->getMessage()], 500);
        }
    }

    public function get_songs_by_tag($tag) {
        $tag_id = DB::select('id')->from('tags')->where('tag_name', '=', $tag)->execute()->current();
        $song_ids = DB::select('song_id')->from('have_tags')->where('tag_id', '=', $tag_id)->execute()->current();
        
        $songs = DB::select()->from('songs')->where('id', 'in', $song_ids)->execute()->as_array();
        $songs = array_values($songs);

        return $this->response($songs);
    }
}