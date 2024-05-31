<?php

use Fuel\Core\Uri;

?>
<div class="container" id="songDetails">
    <a class="btn btn-outline-secondary" data-bind="attr: { href: baseUrl + 'pandachord/artist/' + song().artist_name() }, text: song().artist_name"></a>

    <h2 class="pt-4 text-center" data-bind="text: song().title"></h2>
    <h3 class="pt-2 text-center" data-bind="text: song().artist_name"></h3>

    <div class="container py-3 my-5">
        <div class="row">
            <div class="col-lg-10">
                <div class="container">

                    <div class="row">
                        <div class="col-6">

                            <div data-bind="if: !isEditingLyrics()">
                                <button data-bind="click: startEditingLyrics" class="mb-3">Edit only Lyrics</button>
                                <p data-bind="newLineToBr: song().lyrics"></p>
                            </div>

                            <div data-bind="if: isEditingLyrics">
                                <button data-bind="click: saveTempLyrics" class="mb-3">Temporary Save</button>
                                <button data-bind="click: cancelEditLyrics" class="mb-3">Cancel</button>
                                <br>
                                <textarea id="editLyrics" data-bind="value: song().lyrics" style="width: 100%; height:40vh"></textarea>
                            </div>

                        </div>
                        <div class="col-6">
                            <div data-bind="if: !isEditingChord()">
                                <button data-bind="click: startEditingChord" class="mb-3">Edit only Chord</button>
                                <p data-bind="newLineToBr: song().chord"></p>
                            </div>

                            <div data-bind="if: isEditingChord">
                                <button data-bind="click: saveTempChord" class="mb-3">Temporary Save</button>
                                <button data-bind="click: cancelEditChord" class="mb-3">Cancel</button>
                                <br>
                                <textarea id="editChord" data-bind="value: song().chord" style="width: 100%; height: 40vh"></textarea>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-2">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">

                            <div data-bind="if: !isEditingMemo()">
                                <button data-bind="click: startEditingMemo" class="mb-3">Edit only Memo</button>
                                <p data-bind="newLineToBr: song().memo"></p>
                            </div>

                            <div data-bind="if: isEditingMemo">
                                <button data-bind="click: saveTempMemo" class="mb-3">Temporary Save</button>
                                <button data-bind="click: cancelEditMemo" class="mb-3">Cancel</button>
                                <br>
                                <textarea id="editMemo" data-bind="value: song().memo" rows="5" style="width: 100%"></textarea>
                            </div>

                        </div>
                        
                        <button data-bind="click: save" class="my-5">Save All Changes</button>
                        <a class="btn btn-secondary mt-3" data-bind="attr: { href: baseUrl + 'pandachord/edit/' + song().id() }">Edit</a>
                        <a class="btn btn-danger my-3" data-bind="attr: { href: baseUrl + 'pandachord/delete_song/' + song().id() }">Delete this song.</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">

    ko.bindingHandlers.newLineToBr = {
        update: function(element, valueAccessor) {
            var text = ko.unwrap(valueAccessor());
            var html = text.replace(/\r\n/g, '<br>').replace(/\n/g, '<br>').replace(/\r/g, '<br>');
            element.innerHTML = html;
        }
    };

    var baseUrl = "<?php echo Uri::base(); ?>";
    console.log(baseUrl); 


    function SongViewModel(initialData) {
        var self = this;

        self.song = ko.observable(ko.mapping.fromJS(initialData));
        self.originalData = ko.observable();
        // console.log(self.song());

        self.isEditingLyrics = ko.observable(false);
        self.isEditingChord = ko.observable(false);
        self.isEditingMemo = ko.observable(false);


        self.startEditingLyrics = function() {
            self.originalData(ko.mapping.toJS(self.song));
            self.isEditingLyrics(true);
            // console.log('startEditingLyrics');
        };

        self.saveTempLyrics = function() {
            self.originalData().lyrics = self.song().lyrics();
            self.isEditingLyrics(false);
            // console.log('saveTempLyrics');
        };

        self.cancelEditLyrics = function() {
            self.song().lyrics(self.originalData().lyrics);
            self.isEditingLyrics(false);
            // console.log('cancelEditLyrics');
        };



        self.startEditingChord = function() {
            self.originalData(ko.mapping.toJS(self.song));
            self.isEditingChord(true);
            // console.log('startEditingChord');
        };

        self.saveTempChord = function() {
            self.originalData().chord = self.song().chord();
            self.isEditingChord(false);
            // console.log('saveTempChord');
        };

        self.cancelEditChord = function() {
            self.song().chord(self.originalData().chord);
            self.isEditingChord(false);
            // console.log('cancelEditChord');
        };


        self.startEditingMemo = function() {
            self.originalData(ko.mapping.toJS(self.song));
            self.isEditingMemo(true);
        };

        self.saveTempMemo = function() {
            self.originalData().memo = self.song().memo();
            self.isEditingMemo(false);
        };

        self.cancelEditMemo = function() {
            self.song().memo(self.originalData().memo);
            self.isEditingMemo(false);
        };


        self.save = function() {
            $.ajax({
                url: '/api/update/' + self.song().id(),
                type: 'POST',
                data: ko.mapping.toJSON(self.song),
                contentType: 'application/json',
                success: function(response) {
                    self.song(ko.mapping.fromJS(response));
                    alert('Data saved successfully..');
                },
                error: function() {
                    alert('Error saving song data');
                }
            });
        };
    }

    $(document).ready(function() {
        var initialData = <?php echo json_encode($song->to_array(), JSON_UNESCAPED_UNICODE); ?>;
        // console.log(initialData);
        var viewModel = new SongViewModel(initialData);
        ko.applyBindings(viewModel, document.getElementById("songDetails"));
    });

</script>