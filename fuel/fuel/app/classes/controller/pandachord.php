<?php

use Fuel\Core\Controller_Template;
use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\View;

    class Controller_Pandachord extends Controller_Template{
        public $template = 'layout';

        public function action_index() {
            // create the view object
            $view = View::forge('pandachord/index');
            $view->set('pageTitle', 'pandaChord Home', true);

            $data = array();
            $data['artists'] = Model_Artists::find('all');
            $view->set('data', $data);

            $this->template->content = $view;
        }

        public function action_artist($artist) {
            $view = view::forge('pandachord/artist');
            $view->set('pageTitle', $artist, true);

            $data = array();
            $data['songs'] = Model_Songs::find('all', array(
                'where' => array(
                    array('artist_name', $artist),
                ),
                'order_by' => array ('id' => 'desc'),
            ));
            $view->set('data', $data);

            $this->template->content = $view;
        }

        public function action_song($id) {
            $view = View::forge('pandachord/song');
            // $view->set('pageTitle', 'Chord and Lyrics', true);

            $data = array();
            $data['songs'] = Model_Songs::find($id);
            $view->set('data', $data);

            $this->template->content = $view;
        }

        public function action_tag() {
            $view = View::forge('pandachord/tag');
            $view->set('pageTitle', '#tagName', true);
            $this->template->content = $view;
        }

        public function get_create_chord() {
            $view = View::forge('pandachord/create_chord');
            $view->set('pageTitle', 'Create Original Chord', true);

            $action = 'pandachord/create_chord';
            $view->set('action', $action);
            
            // $artists = array('test', 'test2', 'test3');
            $data = array();
            $data['artists'] = Model_Artists::find('all');
            foreach ($data['artists'] as $artist) {
                $artist_names[$artist['id']] = $artist['artist_name'];
            }
            $view->set('artist_names', $artist_names);

            $default = array(
                'title' => '',
                'artist_name' => '',
                'lyrics' => '',
                'chord' => '',
                'memo' => ''
            );

            $view->set('song', $default);

            $this->template->content = $view;
        }

        public function post_create_chord() {
            $data = array(
                'title' => Input::post('title'),
                'artist_name' => Input::post('artist_name'),
                'lyrics' => Input::post('lyrics'),
                'chord' => Input::post('chord'),
                'memo' => Input::post('memo'),
            );

            $existing_artist = Model_Artists::find('first', array(
                'where' => array(
                    array('artist_name', '=', $data['artist_name'])
                )
            ));

            if (!$existing_artist) {
                $new_artist = Model_Artists::forge(array(
                    'artist_name' => $data['artist_name']
                ));
                $new_artist->save();
            }
            
            $model = new Model_Songs($data);
            $model->save();

            $latest_id = $model->id;
            Response::redirect('pandachord/song/'.$latest_id);
        }

        public function get_edit($id) {
            if (isset($id)) {
                $action = 'pandachord/edit/'.$id;
            } else {
                $action = 'pandachord/create_chord';
            }

            $song = Model_Songs::find($id);

            $view = View::forge('pandachord/create_chord');
            $view->set('pageTitle', 'Edit Chord', true);
            $view->set('song', $song);
            $view->set('action', $action);
            // Log::error(print_r($song), true);

            $data = array();
            $data['artists'] = Model_Artists::find('all');
            foreach ($data['artists'] as $artist) {
                $artist_names[$artist['id']] = $artist['artist_name'];
            }
            $view->set('artist_names', $artist_names);

            $this->template->content = $view;

        }

        public function post_edit($id) {
            $song = Model_Songs::find($id);
            $edited = array(
                'title' => Input::post('title'),
                'artist_name' => Input::post('artist_name'),
                'lyrics' => Input::post('lyrics'),
                'chord' => Input::post('chord'),
                'memo' => Input::post('memo'),
            );

            $existing_artist = Model_Artists::find('first', array(
                'where' => array(
                    array('artist_name', '=', $edited['artist_name'])
                )
            ));

            if (!$existing_artist) {
                $new_artist = Model_Artists::forge(array(
                    'artist_name' => $edited['artist_name']
                ));
                $new_artist->save();
            }

            $song->set($edited);

            // $song->save();
            if ($song->save()) {
                // Log::error('save success');
                Response::redirect('pandachord/song/'.$id);
            }
        }

    }