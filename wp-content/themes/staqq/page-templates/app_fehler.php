<?php

    /**
     *   Template Name: STAQQ / App / Fehler
     */

    get_header();

?>
    <seciton class="section">
        <div class="section__overlay">
            <div class="section__wrapper">
                <article class="gd gd--12">
                    <h1>Fehler</h1>
                </article>
                <?php if ($_GET['e'] == 1): ?>
                <article class="gd gd--12">
                    <p>Ihr Zugang ist auf einem gewissen Zeitraum eingeschränkt. Sie haben dadurch keine Zugang zum STAQQ-System.</p>
                </article>
                <?php endif; ?>
            </div>
        </div>
    </section>

<?php
    
    get_footer();

?>                     