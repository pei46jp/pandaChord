<?php

use Auth\Auth;
use Fuel\Core\Config;
use Fuel\Core\Controller_Template;
use Fuel\Core\DB;
use Fuel\Core\Input;
use Fuel\Core\Log;
use Fuel\Core\Response;
use Fuel\Core\Security;
use Fuel\Core\Session;
use Fuel\Core\Uri;
use Fuel\Core\View;

    class Controller_Pandachord extends Controller_Template{
        public $template = 'layout';

        public function before() {
            parent::before();

            Config::load('pandachord');
            $app_info = Config::get('app');

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

            $this->template->set_global('app_info', $app_info);
            $this->template->set_global('nav_info', $right_nav);
        }
        public function get_register() {
            $view = View::forge('auth/register');
            $view->set('pageTitle', 'Sign Up', true);

            $action = 'pandachord/register';
            $view->set('action', $action);

            $token_key = Config::get('security.csrf_token_key');
            $view->set('token', $token_key);

            $this->template->content = $view;
        }
        public function post_register() {

            if (!Security::check_token()) {
                Session::set_flash('error', 'Token mismatch.');
                Response::redirect('pandachord/register');
            }

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

            $token_key = Config::get('security.csrf_token_key');
            $view->set('token', $token_key);

            $this->template->content = $view;
        }
        public function post_login() {

            if (!Security::check_token()) {
                Session::set_flash('error', 'Token mismatch.');
                Response::redirect('pandachord/login');
            }

            if (Input::method() == 'POST') {
                $username = Input::post('username');
                $password = Input::post('password');
                if (empty($username) || empty($password)) {
                    Session::set_flash('message', '入力が足りません');
                }
                try {
                    if (Auth::login($username, $password)) {
                        Response::redirect('pandachord/index');
                    } else {
                        Session::set_flash('message', 'Failed.');
                        Response::redirect('pandachord/login');
                    }
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

            $token_key = Config::get('security.csrf_token_key');
            $view->set('token', $token_key);

            $this->template->content = $view;
        }
        public function post_logout() {

            if (!Security::check_token()) {
                Session::set_flash('error', 'Token mismatch.');
                Response::redirect('pandachord/logout');
            }

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

        public function action_index() {
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

            $song = Model_Songs::find($id);
            $view->set('song', $song);

            // 変数名
            $add_song_user = $song['user_name'];
            $logged_in_user = Auth::get_screen_name();
            $author_check = ($add_song_user == $logged_in_user);
            $view->set('author_check', $author_check);

            $this->template->content = $view;
        }

        public function action_delete_song($id) {
            $song = Model_Songs::find($id);
            $song_artist_name = $song['artist_name'];

            $logged_in_user = Auth::get_screen_name();
            $song_create_user = $song['user_name'];

            if ($logged_in_user == $song_create_user) {
                // DB::delete('songs')->where('id', '=', $id)->execute();
                $deleted = Model_Songs::delete_song_by_id($id);
                if ($deleted) {
                    Session::set_flash('message', 'Deleted.');
                    Response::redirect('pandachord/artist/'.$song_artist_name);
                } else {
                    Session::set_flash('message', 'Failed.');
                    Response::redirect('pandachord/song/'.$id);
                }
            } else {
                Session::set_flash('message', 'この楽曲を削除する権限がありません．');
                Response::redirect('pandachord/song/'.$id);
            }
        }

        public function action_tag($tag) {
            $view = View::forge('pandachord/tag');

            $data = array();
            $data['pageTitle'] = $tag;

            $tags = Model_Tags::find('all');
            $data['tags'] = array_map(function($tg) {
                return $tg->to_array();
            }, $tags);

            // $tag_id = DB::select('id')->from('tags')->where('tag_name', '=', $tag)->execute()->current();
            $tag_id = Model_Tags::get_id_by_tag($tag);
            // $song_ids = DB::select('song_id')->from('have_tags')->where('tag_id', '=', $tag_id)->execute()->current();
            $song_ids = Model_HaveTags::get_song_id_by_tag_id($tag_id);
            if (!empty($song_ids)) {
                // $songs = DB::select()->from('songs')->where('id', 'in', $song_ids)->execute()->as_array();
                $songs = Model_Songs::get_songs_by_ids($song_ids);

                // 一応 foreach で回せるようにも。
                // $songs = array();
                // foreach ($song_ids as $song_id) {
                //     $song = Model_Songs::get_song_by_id($song_id);
                //     if (!empty($song)) {
                //         array_push($songs, $song);
                //     }
                // }
            } else {
                $songs = [];
                // Session::set_flash("No data in #" . $tag);
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
            
            $data = array();
            $data['artists'] = Model_Artists::find('all');
            foreach ($data['artists'] as $artist) {
                $artist_names[$artist['id']] = $artist['artist_name'];
            }
            $view->set('artist_names', $artist_names);

            // $tags = DB::select('tag_name')->from('tags')->execute();
            $tags = Model_Tags::get_tag_names();
            $view->set('tags', $tags);

            $default = array(
                'title' => 'Untitled',
                'artist_name' => 'Unknown',
                'lyrics' => 'Type Lyrics',
                'chord' => 'Create Chord',
                'memo' => ''
            );

            $view->set('song', $default);

            $token_key = Config::get('security.csrf_token_key');
            $view->set('token', $token_key);

            $this->template->content = $view;
        }

        public function post_create_chord() {

            if (!Security::check_token()) {
                Session::set_flash('error', 'Token mismatch.');
                Response::redirect('pandachord/create_chord');
            }

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
                        // $tag_id = DB::select('id')->from('tags')->where('tag_name', '=', $tag)->execute()->current();
                        $tag_id = Model_Tags::get_id_by_tag($tag);
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

            // $tags = DB::select('tag_name')->from('tags')->execute();
            $tags = Model_Tags::get_tag_names();
            // Log::error(print_r($tags, true));
            $view->set('tags', $tags);

            $data = array();
            $data['artists'] = Model_Artists::find('all');
            foreach ($data['artists'] as $artist) {
                $artist_names[$artist['id']] = $artist['artist_name'];
            }
            $view->set('artist_names', $artist_names);

            $token_key = Config::get('security.csrf_token_key');
            $view->set('token', $token_key);

            $this->template->content = $view;

        }

        public function post_edit($id) {

            if (!Security::check_token()) {
                Session::set_flash('error', 'Token mismatch.');
                Response::redirect('pandachord/song/'.$id);
            }

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
            $song->save();

            $selected_tags = Input::post('tags', array());
            // 新たにタグがセレクトされていたら
            if (!empty($selected_tags)) {
                $query = Model_HaveTags::delete_by_song_id($id);

                try {
                    if (is_array($selected_tags) && !empty($selected_tags)) {
                        foreach ($selected_tags as $tag) {
                            $tag_id = Model_Tags::get_id_by_tag($tag);
                            if ($tag_id) {
                                $add_tag = array(
                                    'tag_id' => $tag_id['id'],
                                    'song_id' => $id,
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
            }
            
            Response::redirect('pandachord/song/'.$id);

        }

    }