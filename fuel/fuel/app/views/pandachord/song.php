<?php

use Fuel\Core\Uri;

?>
<div class="container" id="songDetails">
    <a class="btn btn-outline-secondary" data-bind="attr: { href: baseUrl + 'pandachord/artist/' + song().artist_name }, text: song().artist_name"></a>

    <h2 class="pt-4 text-center" data-bind="text: song().title"></h2>
    <h3 class="pt-2 text-center" data-bind="text: song().artist_name"></h3>

    <div class="container py-3 my-5">
        <div class="row">
            <div class="col-lg-10">
                <div class="container">
                    <div class="row">
                        <div class="col-6">
                            <p data-bind="newLineToBr: song().lyrics"></p>
                            <!-- <span data-bind="visible: !isEditing(), newLineToBr: song().lyrics, click: enableEditing"></span>
                            <input data-bind="visible: isEditing(), newLineToBr: song().lyrics, hasFocus: isEditing"></input> -->
                        </div>
                        <div class="col-6">
                            <p data-bind="newLineToBr: song().chord"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <p data-bind="newLineToBr: song().memo"></p>
                        </div>
                        <a class="btn btn-secondary mt-3" data-bind="attr: { href: baseUrl + 'pandachord/edit/' + song().id }">Edit</a>
                        <a class="btn btn-danger my-3" data-bind="attr: { href: baseUrl + 'pandachord/delete_song/' + song().id }">Delete this song.</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    function SongViewModel() {
        var self = this;
        self.songData = <?php echo json_encode($song->to_array(), JSON_UNESCAPED_UNICODE); ?>;
        self.song = ko.observable(self.songData);


        self.isEditing = ko.observable(false);

        self.enableEditing = function() {
            self.isEditing(true);
        };

        self.save = function() {
            self.isEditing(false);
        };

        self.cancel = function() {
            self.isEditing(false);
        };
    }

    var viewModel = new SongViewModel();
    var baseUrl = "<?php echo Uri::base(); ?>";

    ko.bindingHandlers.newLineToBr = {
        update: function(element, valueAccessor) {
            var text = ko.unwrap(valueAccessor());
            var html = text.replace(/\r\n/g, '<br>').replace(/\n/g, '<br>').replace(/\r/g, '<br>');
            element.innerHTML = html;
        }
    };

    ko.applyBindings(viewModel, document.getElementById("songDetails"));
</script>