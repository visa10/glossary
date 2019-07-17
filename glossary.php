<?php
    require "model.php";

    session_start();

    include "components/header.php";

    $model = new Model();

    if (isset($_GET['s'])) {
        $search = stripcslashes(strip_tags(trim($_GET['s'])));
        $cards = $model->getSearchCards($search);
    } else {
        $cards = $model->getCards();
    }

?>

<main role="main" class="inner cover">
    <div class="container">
        <div class="row">
            <h2 class="cover-heading">Glossary</h2>
            <p class="lead ml-auto">
                <?php  if($login): ?>
                    <a href="/add-glossary.php" class="btn btn-secondary ml-5">Create glossary</a>
                <?php endif; ?>
            </p>
        </div>


        <ul class="list-rectangle">
            <?php if (count($cards)):?>
                <?php foreach ($cards as $card): ?>
                    <li><a href="view-glossary.php?id=<?= $card['id'] ?>"><?= $card['theme'] ?></a></li>
                <?php  endforeach;?>
            <?php else: ?>
                <?php  if (isset($_GET['s']) && !count($cards)) echo "Nothing found for this request." ?>
            <?php endif; ?>
        </ul>
    </div>

</main>

<?php
    include "components/footer.php"
?>
