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
                        <?php foreach ($languages as $lang => $translates): ?>
                            <dd class="col-sm-9">
                                <ul class="list-group">
                                    <li class="list-group-item active"><?= "[ $lang ]" ?></li>
                                    <li class="list-group-item text-secondary"><?= implode(', ', $translates) ?></li>
                                </ul>
                            </dd>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </dl>
            </div>
        <?php endforeach; ?>
    </main>

<?php
    include "components/footer.php"
?>