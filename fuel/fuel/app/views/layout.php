<?php
use Fuel\Core\Asset;
use Fuel\Core\Uri;

?>

<!DOCTYPE html>

<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width initial-scale=1.0">
        <title>pandachord</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.5.1/knockout-latest.min.js" integrity="sha512-vs7+jbztHoMto5Yd/yinM4/y2DOkPLt0fATcN+j+G4ANY2z4faIzZIOMkpBmWdcxt+596FemCh9M18NUJTZwvw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-light py-3" style="background-color: #008F7E;">
                <div class="container-fluid">
                    <a class="navbar-brand" href="<?php echo Uri::create('pandachord/'); ?>">PandaChord</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse me-auto" id="navbarNav">
                        <ul class='navbar-nav me-auto mb-2 mb-lg-0'>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo Uri::create('pandachord'); ?>">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo Uri::create('pandachord/create_chord'); ?>">Create Chord</a>
                            </li>
                        </ul>
                        <ul class='navbar-nav mb-2 mb-lg-0'>
                            <?php 
                                foreach ($nav_info as $nav) {
                                    echo '<li class="nav-item">';
                                    echo '<a class="nav-link" href="'. $nav[1] .'">'. $nav[0].'</a>';
                                    echo '</li>';
                                }
                            ?>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <main class="container" style="min-height: 90vh;">
            <div class="container py-3">
                <?php echo $content; ?>
            </div>
        </main>

        <footer class="footer mt-auto text-center p-1" style="background-color: #008F7E;">
            <div class="container my-2">
                <p class="text-center" style="color: #ffffff;">
                    ©︎ 2024 pei46jp<br>
                </p>
            </div>
        </footer>
    </body>
</html>
