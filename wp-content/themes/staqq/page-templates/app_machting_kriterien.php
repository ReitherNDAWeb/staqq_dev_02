<?php

    /**
     *   Template Name: STAQQ / App / Matching Kriterien
     */

    get_header();

    if (!($wpUserSTAQQUser && $wpUserState)) //wp_redirect('Location: /', 302);

?>
    <seciton class="section">
        <div class="section__overlay">
            <div class="section__wrapper">
                <article class="gd gd--12">
                    <h1>Matching Kriterien</h1>
                </article>
                <article class="gd gd--6">
                    <label for="berufsfelder">Berfsfelder (mind. 1)</label>
                    <select multiple="multiple" name="berufsfelder" id="berufsfelder">
                        <?php
                            foreach ($berufsfelder as $f){
                                echo '<option value="'.$f->id.'">'.$f->name.'</option>';
                            }
                        ?>
                    </select>

                    <label for="berufsgruppen">Berufsgruppen (mind. 1)</label>
                    <select multiple="multiple" name="berufsgruppen" id="berufsgruppen">
                        <?php
                            foreach ($berufsgruppen as $g){
                                echo '<option value="'.$g->id.'">'.$g->name.'</option>';
                            }
                        ?>
                    </select>
                </article>
                        
                <article class="gd gd--6">

                    <label for="skills">Skills (mind. 1)</label>
                    <select multiple="multiple" name="skills" id="skills">
                        <?php
                            foreach ($skills as $s){
                                echo '<option value="'.$s->id.'">'.$s->skills_kategorien_name.' - '.$s->name.'</option>';
                            }
                        ?>
                    </select>

                    <label for="regionen">Region Jobannahme (mind. 1)</label>
                    <select multiple="multiple" name="regionen" id="regionen">
                        <?php
                            foreach ($bezirke as $b){
                                echo '<option value="'.$b->id.'">'.$b->bundeslaender_name.' - '.$b->name.'</option>';
                            }
                        ?>
                    </select>
                </article>
            </div>
        </div>
    </seciton>

<?php get_footer(); ?>

                        