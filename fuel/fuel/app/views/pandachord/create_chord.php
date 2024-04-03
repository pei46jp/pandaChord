<?php
use Fuel\Core\Form;
echo Form::open(array('action' => 'pandachord/create_chord', 'method' => 'post'));
?>

<h2 class="pt-4 pb-4 mb-4 text-center"><?php echo $pageTitle; ?></h2>

<h3 class="input-group">
    <?php
        echo Form::label('Title:', 'title');
        echo Form::input('title', $song['title'], array('class' => 'form-control'));
    ?>
</h3>
<h4 class="pt-2 text-center">
    <?php
        echo Form::input('artist_name', $song['artist_name'], array('id' => 'artistsList', 'class' => 'form-control', 'placeholder' => 'Select or Type Some Artist'));

        // JavaScriptを使用してdatalistを追加
        echo '
            <script>
                var datalist = document.createElement("datalist");
                datalist.id = "artists";
                
                var artists = ' . json_encode($artist_names) . ';
                console.log(artists);
                artists.forEach(function(artist) {
                    var option = document.createElement("option");
                    option.value = artist;
                    datalist.appendChild(option);
                });
                
                document.getElementById("artistsList").setAttribute("list", "artists");
                document.getElementById("artistsList").parentNode.appendChild(datalist);
            </script>
        ';

        // 改行を追加
        echo '<br>';
    ?>
</h4>
<div class="container py-3 my-5">
    <div class="row">
        <div class="col-lg-10">
            <div class="container">
                    <div class="row">
                        <div class="col-6">
                            <?php
                                echo Form::label('Lyrics:', 'lyrics');
                                echo Form::textarea('lyrics', $song['lyrics'], array('class' => 'form-control', 'rows' => 20));
                            ?>
                        </div>
                        <div class="col-6">
                            <?php
                                echo Form::label('Chord:', 'chord');
                                echo Form::textarea('chord', $song['chord'], array('class' => 'form-control', 'rows' => 20));
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        <div class="col-lg-2">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 pb-4">
                        <?php
                            echo Form::label('Memo:', 'memo');
                            echo Form::textarea('memo', $song['memo'], array('class' => 'form-control', 'rows' => 10));
                        ?>
                    </div>
                    <?php echo Form::button('frmbutton', 'Submit', array('class' => 'btn btn-secondary')); ?>
                    <?php echo Form::close() ?>
                </div>
            </div>
        </div>
    </div>
</div>