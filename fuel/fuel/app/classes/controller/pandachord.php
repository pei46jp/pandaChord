<?php

use Fuel\Core\Controller_Template;
use Fuel\Core\View;

    class Controller_Pandachord extends Controller_Template{
        public $template = 'layout';

        public function action_index() {
            // create the view object
            $view = View::forge('pandachord/index');

            // set the template variables
            $this->template->title = "PandaChord";
            $this->template->content = $view;
        }
    }