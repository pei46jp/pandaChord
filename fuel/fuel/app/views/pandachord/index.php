<?php

use Fuel\Core\Uri;

?>
<h2 class="pt-4 text-center"><?php echo $pageTitle; ?></h2>
<div class="container py-3 my-5">
    <div class="row">
        <div class="col-sm-10">
            <div class="container">
                <div class="list-group">
                    <?php
                    foreach ($data['artists'] as $artist) {
                    ?>
                        <a href="<?php echo Uri::create('pandachord/artist/' . $artist['artist_name']); ?>" class="list-group-item list-group-item-action">
                            <?php echo $artist['artist_name']; ?>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="container">
                <div class="row">
                    <div class="container my-2" class="col-xs-12">
                        <div class="list-group">
                            <?php
                            foreach ($data['tags'] as $tag) {
                            ?>
                                <a href="<?php echo Uri::create('pandachord/tag/' . $tag['tag_name']); ?>" class="list-group-item list-group-item-action">
                                    # <?php echo $tag['tag_name']; ?>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>