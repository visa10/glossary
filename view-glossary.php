<?php

session_start();


include "components/header.php";

?>

    <main role="main" class="inner cover">
        <h1 class="cover-heading">Cover your page.</h1>
        <div class="pd-tabs-content" id="myTabContent">
            <dl class="row">
                <dt class="col-sm-3">User Agent</dt>
                <dd class="col-sm-9">An HTML user agent is any device that interprets HTML documents.</dd>
                <dt class="col-sm-3 text-truncate">Client-side Scripting</dt>
                <dd class="col-sm-9">Client-side scripting generally refers to the category of computer programs on the web that are executed by the user's web browser.</dd>
                <dt class="col-sm-3">Document Tree</dt>
                <dd class="col-sm-9">The tree of elements encoded in the source document.</dd>
            </dl>
    </main>

<?php
    include "components/footer.php"
?>