<?php

use Fuel\Core\Controller_Template;
use Fuel\Core\Input;
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

        public function action_song() {
            $view = View::forge('pandachord/song');
            // $view->set('pageTitle', 'Chord and Lyrics', true);

            $data = array();
            $data['songs'] = Model_Songs::find(1);
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
            
            // $artists = array('test', 'test2', 'test3');
            $data = array();
            $data['artists'] = Model_Artists::find('all');
            foreach ($data['artists'] as $artist) {
                $artist_names[$artist['id']] = $artist['artist_name'];
            }
            $view->set('artist_names', $artist_names);

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

            Response::redirect('pandachord/index', 'refresh')->set('pageTitle', 'pandaChord Home', true);
        }

    }