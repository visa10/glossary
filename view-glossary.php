<?php

session_start();

if ($_GET) {


    if ($_GET['id']) {
        require "model.php";

        $model = new Model();

        $id = strip_tags(trim($_GET['id']));

        $card = $model->getCard($id);
        $data = [];

        // transform data card
        foreach ($card as $item) {

            if (!array_key_exists($item['theme'], $data)) $data[$item['theme']] = [];
            if (!array_key_exists($item['term'], $data[$item['theme']])) {
                $data[$item['theme']][$item['term']] = [];
            }
            if (!array_key_exists($item['lang'], $data[$item['theme']][$item['term']])) $data[$item['theme']][$item['term']][$item['lang']] = [];

            array_push($data[$item['theme']][$item['term']][$item['lang']], $item['value']);
        }
    }

//    echo "<pre>";
//    print_r($data); exit;
}

include "components/header.php";

?>
    <main role="main" class="inner cover">
        <?php foreach ($data as $cardName => $terms): ?>
            <h3 class="cover-heading pb-5 "><?= $cardName ?></h3>
            <div class="pd-tabs-content" id="myTabContent">
                <dl class="row">
                    <?php foreach ($terms as $term => $languages): ?>
                        <dt class="col-sm-3"><?= $term ?></dt>

                            <dd class="col-sm-9">
                                <ul class="list-group">
                                    <?php foreach ($languages as $lang => $translates): ?>
                                        <li class="list-group-item active">
                                            <b><?= "[ $lang ]" ?></b>
                                            <button class="btn btn-dark add-translate ml-auto mr-5"
                                                    data-toggle="modal"
                                                    data-target="#addTranslate"
                                                    data-lang="<?= $lang ?>"
                                                    data-term="<?= $term ?>" >
                                                Add translate
                                            </button>
                                        </li>
                                    <li class="list-group-item text-secondary"><?= implode(', ', $translates) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </dd>

                    <?php endforeach; ?>
                </dl>
            </div>
        <?php endforeach; ?>

        <div class="modal" id="addTranslate" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <input type="hidden" name="term">
                                <input type="hidden" name="lang">
                                <label for="recipient-name" class="col-form-label">Translate:</label>
                                <input type="text" class="form-control" id="translate" required >
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button id="submit-add-translate" type="button" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $('#addTranslate').on('shown.bs.modal', function (event) {
                const button = $(event.relatedTarget);
                const lang = button.data('lang');
                const term = button.data('term');

                const modal = $(this);

                modal.find('.modal-title').text('New translate to ' + `[ ${lang} ] - ${term}`);
                modal.find('input[name=term]').val(term);
                modal.find('input[name=lang]').val(lang);
            })

            $("#submit-add-translate").click(function () {
                var formElement = document.querySelector("form");
                var formData = new FormData(formElement);

                $.ajax({
                    url: '/add-translate.php',
                    data: formData,
                    processData: false,
                    type: 'POST',
                    success: function ( data ) {
                        alert( data );
                    }
                });

                /*$.post('/add-translate.php', formData, function(data) {
                    if (data.status === 'success') {
                        header("Refresh:0");
                    } else {
                        // todo show alert error
                    }
                })*/
            })
        </script>
    </main>





<?php
    include "components/footer.php"
?>