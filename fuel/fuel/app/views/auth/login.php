<?php

use Fuel\Core\Form;
use Fuel\Core\Session;

echo Form::open(array('action' => $action, 'method' => 'post'));
echo Form::hidden($token['key'], $token['token']);

?>

<p><?php echo Session::get_flash('error') ?></p>

<h2 class="pt-4 text-center"><?php echo $pageTitle; ?></h2>
<p><?php echo Session::get_flash('message') ?></p>

<div class="container py-3 my-5">
    <div class="container">
        <div class="input-group">
            <?php
                echo Form::label('Username', 'username');
                echo Form::input('username', null, array('id' => 'username', 'class' => 'form-control'));
            ?>
        </div>
        <div class="input-group">
            <?php
                echo Form::label('Password', 'password');
                echo Form::input('password', null, array('id' => 'password','class' => 'form-control'));
            ?>
        </div>
        <?php echo Form::button('submit', 'Log in', array('class' => 'btn btn-secondary')); ?>
        <?php echo Form::close(); ?>
    </div>
</div>