<?php

use Fuel\Core\Form;
use Fuel\Core\Security;
use Fuel\Core\Session;

echo Form::open(array('action' => $action, 'method' => 'post'));
echo Security::js_fetch_token();

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
        <div class="input-group">
            <?php
                echo Form::label('Email (Option)', 'email');
                echo Form::input('email', null, array('id' => 'password','class' => 'form-control'));
            ?>
        </div>
        <?php echo Form::hidden($token, '', array('id' => 'csrf_token')); ?>
        <?php echo Form::button('submit', 'Sign Up', array('class' => 'btn btn-secondary')); ?>
        <?php echo Form::close(); ?>
    </div>
</div>

<script type="text/javascript">
    let current_token = fuel_csrf_token();
    document.getElementById('csrf_token').value = current_token;
</script>