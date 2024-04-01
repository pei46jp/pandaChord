<?php
use Fuel\Core\Form;
echo Form::open(array('action' => 'pandachord/create_chord', 'method' => 'post'));
?>

<h2 class="pt-4 pb-4 mb-4 text-center"><?php echo $pageTitle; ?></h2>

<h3 class="input-group">
    <?php
        echo Form::label('Title:', 'title');
        echo Form::input('title', '', array('class' => 'form-control'));
    ?>
</h3>
<h4 class="pt-2 text-center">
    <?php
        echo Form::input('artist_name', '', array('id' => 'artistsList', 'class' => 'form-control', 'placeholder' => 'Select or Type Some Artist'));

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
        <div class="col-sm-10">
            <div class="container">
                    <div class="row">
                        <div class="col-6">
                            <?php
                                echo Form::label('Lyrics:', 'lyrics');
                                echo Form::textarea('lyrics', '', array('class' => 'form-control'));
                            ?>
                        </div>
                        <div class="col-6">
                            <?php
                                echo Form::label('Chord:', 'chord');
                                echo Form::textarea('chord', '', array('class' => 'form-control'));
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        <div class="col-sm-2">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <?php
                            echo Form::label('Memo:', 'memo');
                            echo Form::textarea('memo', '', array('class' => 'form-control'));
                        ?>
                    </div>
                    <div class="py-4 col-xs-12">
                        <p>Input More Function</p>
                    </div>
                    <div class="col-sm-12">
                        <?php
                            echo Form::button('frmbutton', 'Submit', array('class' => 'btn btn-secondary'));
                        ?>

                        <?php echo Form::close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>