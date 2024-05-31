<?php
use Fuel\Core\Controller_Rest;


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
}