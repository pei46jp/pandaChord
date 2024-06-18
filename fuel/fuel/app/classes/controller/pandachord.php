<?php

use Auth\Auth;
use Fuel\Core\Controller_Template;
use Fuel\Core\DB;
use Fuel\Core\Input;
use Fuel\Core\Log;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\Uri;
use Fuel\Core\View;

    class Controller_Pandachord extends Controller_Template{
        public $template = 'layout';

        public function get_register() {
            $view = View::forge('auth/register');
            $view->set('pageTitle', 'Sign Up', true);

            $action = 'pandachord/register';
            $view->set('action', $action);

            $this->template->content = $view;
        }
        public function post_register() {
            if (Input::method() == 'POST') {
                $username = Input::post('username');
                $password = Input::post('password');
                $email = Input::post('email');
                if (empty($email)) {
                    $email = $username.'@nothing.com';
                }
                if (empty($username) || empty($password)) {
                    Session::set_flash('message', '入力が足りません');
                }

                try {
                    Auth::create_user($username, $password, $email, 1);
                    Response::redirect('pandachord/login');
                } catch (Exception $e) {
                    Session::set_flash('message', $e->getMessage());
                    Response::redirect('pandachord/register');
                }
            }
        }

        public function get_login() {
            $view = View::forge('auth/login');
            $view->set('pageTitle', 'Log In', true);

            $action = 'pandachord/login';
            $view->set('action', $action);

            $this->template->content = $view;
        }
        public function post_login() {
            if (Input::method() == 'POST') {
                $username = Input::post('username');
                $password = Input::post('password');
                if (empty($username) || empty($password)) {
                    Session::set_flash('message', '入力が足りません');
                }
                try {
                    Auth::login($username, $password);
                    Response::redirect('pandachord/index');
                } catch (Exception $e) {
                    Session::set_flash('message', $e->getMessage());
                    Response::redirect('pandachord/login');
                }
            }
        }

        public function get_logout() {
            $view = View::forge('auth/logout');
            $view->set('pageTitle', 'Log out', true);

            $action = 'pandachord/logout';
            $view->set('action', $action);

            $this->template->content = $view;
        }
        public function post_logout() {
            if (Input::method() == 'POST') {
                try {
                    Auth::logout();
                    Response::redirect('pandachord/index');
                } catch (Exception $e) {
                    Session::set_flash('message', $e->getMessage());
                    Response::redirect('pandachord/logout');
                }
            }
        }

        public function before() {
            parent::before();

            if (Auth::check()) {
                $right_nav = array(
                    array(
                        Auth::get_screen_name(),
                        Uri::create('pandachord/index/')
                    ),
                    array(
                        'logout',
                        Uri::create('pandachord/logout/')
                    )
                );
            } else {
                $right_nav = array(
                    array(
                        'Sign Up',
                        Uri::create('pandachord/register')
                    ),
                    array(
                        'Log in',
                        Uri::create('pandachord/login/')
                    )
                );
            }

            $this->template->set_global('nav_info', $right_nav);
        }

        public function action_index() {
            // create the view object
            $view = View::forge('pandachord/index');
            $view->set('pageTitle', 'pandaChord Home', true);

            $data = array();
            $data['artists'] = Model_Artists::find('all');
            $data['tags'] = Model_Tags::find('all');
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
            $data['tags'] = Model_Tags::find('all');

            $view->set('data', $data);

            $this->template->content = $view;
        }

        public function action_song($id) {
            $view = View::forge('pandachord/song');
            // $view->set('pageTitle', 'Chord and Lyrics', true);

            // $data = array();
            // $data['songs'] = Model_Songs::find($id);
            // $view->set('data', $data);

            $song = Model_Songs::find($id);
            $view->set('song', $song);

            $addSongUser = $song['user_name'];
            $loggedInUser = Auth::get_screen_name();
            $LoggedInCheck = ($addSongUser == $loggedInUser);
            $view->set('LoggedInCheck', $LoggedInCheck);

            $this->template->content = $view;
        }

        public function action_delete_song($id) {
            $song = Model_Songs::find($id);
            $mem_artist = $song['artist_name'];

            $loggedInUser = Auth::get_screen_name();
            $songCreateUser = $song['user_name'];

            if ($loggedInUser == $songCreateUser) {
                if (!$song) {
                    Session::set_flash('message', 'Song not found');
                    Response::redirect('pandachord/song/'.$id);
                }

                DB::delete('songs')->where('id', '=', $id)->execute();

                Session::set_flash('success', 'Deleted');
                Response::redirect('pandachord/artist/'.$mem_artist);
            } else {
                Session::set_flash('message', 'この楽曲を削除する権限がありません．');
                Response::redirect('pandachord/song/'.$id);
            }
            
        }

        public function action_tag($tag) {
            $view = View::forge('pandachord/tag');
            // $view->set('pageTitle', '#tagName', true);

            $data = array();
            $data['pageTitle'] = $tag;

            $tags = Model_Tags::find('all');
            $data['tags'] = array_map(function($tg) {
                return $tg->to_array();
            }, $tags);

            $tag_id = DB::select('id')->from('tags')->where('tag_name', '=', $tag)->execute()->current();
            $song_ids = DB::select('song_id')->from('have_tags')->where('tag_id', '=', $tag_id)->execute()->current();
            if (!empty($song_ids)) {
                $songs = DB::select()->from('songs')->where('id', 'in', $song_ids)->execute()->as_array();
            } else {
                $songs = [];
                Session::set_flash("No data in #" . $tag);
            }
            $data['songs'] = array_values($songs);

            $view->set('data', $data);

            $this->template->content = $view;
        }

        public function get_create_chord() {

            if (!Auth::check()) {
                Session::set_flash('message', 'ユーザ登録及びログインが必要なページです．');
                Response::redirect('pandachord/login');
            }

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

            $tags = DB::select('tag_name')->from('tags')->execute();
            $view->set('tags', $tags);

            $default = array(
                'title' => 'Untitled',
                'artist_name' => 'Unknown',
                'lyrics' => 'Type Lyrics',
                'chord' => 'Create Chord',
                'memo' => ''
            );

            $view->set('song', $default);

            $this->template->content = $view;
        }

        public function post_create_chord() {

            $addSongUser = Auth::get_screen_name();

            $data = array(
                'title' => Input::post('title'),
                'artist_name' => Input::post('artist_name'),
                'user_name' => $addSongUser,
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

            $selected_tags = Input::post('tags', array());

            try {
                if (is_array($selected_tags) && !empty($selected_tags)) {
                    foreach ($selected_tags as $tag) {
                        $tag_id = DB::select('id')->from('tags')->where('tag_name', '=', $tag)->execute()->current();
                        if ($tag_id) {
                            $add_tag = array(
                                'tag_id' => $tag_id['id'],
                                'song_id' => $latest_id,
                            );

                            $haveTag = new Model_HaveTags();
                            $haveTag->tag_id = $add_tag['tag_id'];
                            $haveTag->song_id = $add_tag['song_id'];
                            $haveTag->save();
                        } else {
                            Log::error('tag not found: ' . $tag);
                        }
                    }
                } else {
                    Log::error('selected tags are null or empty');
                }
            } catch (Exception $e) {
                Log::error('An error occurred:' . $e->getMessage());
                throw $e;
            }

            
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

            $tags = DB::select('tag_name')->from('tags')->execute();
            // Log::error(print_r($tags, true));
            $view->set('tags', $tags);

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