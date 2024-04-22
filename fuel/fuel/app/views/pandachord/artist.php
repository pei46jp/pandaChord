<?php

use Fuel\Core\Uri;

?>
<a class="btn btn-outline-secondary" href="<?php echo Uri::create('pandachord/index/'); ?>">< List</a>
<h2 class="pt-4 text-center"><?php echo $pageTitle; ?></h2>
<div class="container py-3 my-5">
    <div class="row">
        <div class="col-sm-10">
            <div class="container">
                <div class="list-group">
                    <?php
                        foreach($data['songs'] as $song) {
                    ?>
                    <a href="<?php echo Uri::create('pandachord/song/'.$song['id']); ?>" class="list-group-item list-group-item-action">
                        <?php echo $song['title']; ?>
                    </a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <p>Search Space</p>
                    </div>
                    <div class="col-xs-12">
                        <p>#tag</p>
                    </div>
                    <div class="col-xs-12">
                        <p>#tag</p>
                    </div>
                    <div class="col-xs-12">
                        <p>#tag</p>
                    </div>
                    <div class="col-xs-12">
                        <p>Detail Infos</p>
                    </div>
                    <div class="col-xs-12">
                        <p>More Function</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>