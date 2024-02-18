<?php

    /**
     *   Template Name: STAQQ Home
     */

    get_header('pre');
    get_header();

    the_post();
    $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'original')[0];

?>
    <seciton class="section section--home-hero" style="background-image: url('<?php echo $image; ?>')">
        <div class="section__overlay">
            <div class="section__wrapper section__wrapper--full-width">
                <article class="gd gd--12">
                    <?php
                        the_content();
                    ?>
                </article>
            </div>
        </div>
    </seciton>

<?php

    get_footer();

?>
