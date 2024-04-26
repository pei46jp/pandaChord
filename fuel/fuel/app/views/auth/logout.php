<?php

use Fuel\Core\Form;
use Fuel\Core\Session;

echo Form::open(array('action' => $action, 'method' => 'post'));
?>
<h2 class="pt-4 text-center"><?php echo $pageTitle; ?></h2>
<p><?php echo Session::get_flash('message') ?></p>

<div class="container py-3 my-5">
    <div class="container">
        <?php echo Form::button('submit', 'Log out', array('class' => 'btn btn-secondary')); ?>
        <?php echo Form::close(); ?>
    </div>
</div>