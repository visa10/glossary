<?php
    require "model.php";

    session_start();

    include "components/header.php";

    $model = new Model();
    $cards = $model->getCards();
?>

<main role="main" class="inner cover">
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
            ыы
        <?php endif; ?>
    </ul>
</main>

<?php
    include "components/footer.php"
?>
