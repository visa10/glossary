<?php
    error_reporting(E_ALL);
    session_start();

    if(!isset($_SESSION['username'])) {
        header("Location: index.php");
    }

    if ($_POST) {
        require "model.php";

        $model = new Model();
        $userId = $_SESSION['userId'];

        if ($_POST['theme']) {
            $cardId = $model->addCard($_POST['theme'], $userId);
        }

        $translate = [];
        for ($l = 1; $l < 999; $l++) {
            if (array_key_exists("lang-{$l}", $_POST) && $_POST["lang-{$l}"]) {
                $lang = $_POST["lang-" . $l];
                for ($t = 1; $t < 999; $t++) {
                    if (array_key_exists("term-{$t}", $_POST) && $_POST["term-{$t}"]) {
                        $term = $_POST["term-{$t}"];
                        if (!array_key_exists($term, $translate)) $translate[$term] = [];
                        if (!array_key_exists($lang, $translate[$term])) $translate[$term][$lang] = [];

                        for ($i = 1; $i < 999; $i++) {
                            if (array_key_exists("lang-{$l}_term-{$t}_translate-{$i}", $_POST) && $_POST["lang-{$l}_term-{$t}_translate-{$i}"]) {
                                $tr = $_POST["lang-{$l}_term-{$t}_translate-{$i}"];
                                array_push($translate[$term][$lang], $tr);
                            } else {
                                break;
                            }
                        }
                    } else {
                        break;
                    }
                }
            } else {
                break;
            }
        }


        foreach ($translate as $term => $data) {
            $termId = $model->addTerm($cardId, $term);
            foreach ($data as $lang => $trans) {
                foreach ($trans as $tran) {
                    $resId = $model->addTranslate($termId, $lang, $tran, $userId);
                }
            }
        }
        header("Location: view-glossary.php?id=$cardId");
    }


    include "components/header.php";
?>

<main role="main" class="inner cover">
    <h1 class="cover-heading title-add-glossary">New glossary</h1>
    <form method="post" action="">
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Theme or subject</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="theme" id="inputEmail3" required>
            </div>
        </div>

        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="lang-1-tab"  href="#lang_1" data-toggle="tab">New</a>
            </li>
            <li class="add-language">
                <a href="#" >+ Add Lang</a>
            </li>
        </ul>


        <div class="tabs-content" id="myTabContent">
            <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab">
                <div class="col-md-9 ">
                    <div class="row align-items-center ">
                        <div class="col-md-1 font-weight-bold">#</div>
                        <div class="col-md-5 font-weight-bold">Term</div>
                        <div class="col-md-5 font-weight-bold select-box">
                            <div class="pd-flag-select pd-flag-primary pd-search-select translate lang-1" tab-leng="1">
                                <select class="pd-languages lang-1" name="lang-1" onchange="onChangeLanguage(this)" ></select>
                            </div>
                        </div>
                    </div>
                    <div class="row translate-container">
                        <div class="col-md-1">1*</div>
                        <div class="col-md-5 term"><input class="col-md-12" type="text" name="term-1" required></div>
                        <div class="col-md-5 translate" tab-leng="1" tab-term-translate="1">
                            <input class="col-md-12" type="text" name="lang-1_term-1_translate-1" required>
                            <a href="#" class="add-translate"><i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="row translate-container">
                        <div class="col-md-1">2*</div>
                        <div class="col-md-5 term"><input class="col-md-12" type="text" name="term-2" required></div>
                        <div class="col-md-5 translate" tab-leng="1" tab-term-translate="2">
                            <input class="col-md-12" type="text" name="lang-1_term-2_translate-1" required>
                            <a href="#" class="add-translate"><i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="row translate-container">
                        <div class="col-md-1">3*</div>
                        <div class="col-md-5 term"><input class="col-md-12" type="text" name="term-3" required></div>
                        <div class="col-md-5 translate" tab-leng="1" tab-term-translate="3">
                            <input class="col-md-12" type="text" name="lang-1_term-3_translate-1" required>
                            <a href="#" class="add-translate"><i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>

                    </div>
                    <div class="row translate-container">
                        <div class="col-md-1">4</div>
                        <div class="col-md-5 term"><input class="col-md-12" type="text" name="term-4"></div>
                        <div class="col-md-5 translate" tab-leng="1" tab-term-translate="4">
                            <input class="col-md-12" type="text" name="lang-1_term-4_translate-1">
                            <a href="#" class="add-translate"><i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="row translate-container">
                        <div class="col-md-1">5</div>
                        <div class="col-md-5 term"><input class="col-md-12" type="text" name="term-5"></div>
                        <div class="col-md-5 translate" tab-leng="1" tab-term-translate="5">
                            <input class="col-md-12" type="text" name="lang-1_term-5_translate-1">
                            <a href="#" class="add-translate"><i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row text-right">
            <div class="col-sm-8">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>

    <script src="/assets/js/add-glossary.js"></script>
</main>

<?php
    include "components/footer.php"
?>

