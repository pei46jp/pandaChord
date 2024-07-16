<?php
use Fuel\Core\Controller_Rest;
use Fuel\Core\DB;
use Fuel\Core\Log;
use Fuel\Core\Validation;

class Controller_Api extends Controller_Rest {
    protected $format = 'json';

    public function post_update($id) {
        try {
            $input = json_decode(file_get_contents('php://input'), true);

            // Validation 
            // 特に制限はないのでつけるだけつけてみる。
            // 必要なものがあればその都度追加
            $validation = Validation::forge();
            $validation->add('lyrics', 'Lyrics')
                ->add_rule('min_length', 0);
            $validation->add('chord', 'Chord')
                ->add_rule('min_length', 0);
            $validation->add('memo', 'Memo')
                ->add_rule('min_length', 0)
                ->add_rule('max_length', 100);
            
            if ($validation->run($input)) {
                $song = Model_Songs::find($id);
                if ($song) {
                    $song->set($input);
                    $song->save();
                    return $this->response($song->to_array());
                } else {
                    return $this->response(['error' => 'Song not found'], 404);
                }
            } else {
                $errors = $validation->error();
                return $this->response(['error' => $errors], 400);
            }
        } catch (Exception $e) {
            return $this->response(['error' => $e->getMessage()], 500);
        }
    }

    public function get_songs_by_tag($tag) {
        $tag_id = Model_Tags::get_id_by_tag($tag);
        $song_ids = Model_HaveTags::get_song_id_by_tag_id($tag_id);
        if (!empty($song_ids)) {
            $songs = Model_Songs::get_songs_by_ids($song_ids);
            $songs = array_values($songs);
        } else {
            // ひとまずログに残すように
            // 今後必要な時に必要な分岐処理を作成
            Log::error('No data in #' . $tag);
        }
        return $this->response($songs);
    }
}