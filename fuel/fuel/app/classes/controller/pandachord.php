<?php

use Fuel\Core\Controller_Template;
use Fuel\Core\View;

    class Controller_Pandachord extends Controller_Template{
        public $template = 'layout';

        public function action_index() {
            // create the view object
            $view = View::forge('pandachord/index');
            $view->set('pageTitle', 'pandaChord Home', true);
            $this->template->content = $view;
        }

        public function action_song() {
            $view = View::forge('pandachord/song');
            $view->set('pageTitle', 'Chord and Lyrics', true);
            $this->template->content = $view;
        }

        public function action_tag() {
            $view = View::forge('pandachord/tag');
            $view->set('pageTitle', '#tagName', true);
            $this->template->content = $view;
        }

        public function action_create_chord() {
            $view = View::forge('pandachord/create_chord');
            $view->set('pageTitle', 'Create Original Chord', true);
            $this->template->content = $view;
        }

    }