<?php

    /**
     *   Template Name: STAQQ / App / Verwaltung / Sub-User
     */

    get_header();
    
    if ($wpUserRole == "dienstleister"){
        
        $users = $api->get("dienstleister/$wpUserSTAQQId/user", [])->decode_response();
        $user_anz = 1;

?>
    <seciton class="section">
        <div class="section__overlay">
            <div class="section__wrapper">
                <article class="gd gd--12 info-box">
                    <h2>Verfügbare User: <span><?php echo $user_anz; ?></span></h2>
                    <?php if ($user_anz <= 0): ?><a href="/app/verwaltung/pakete" class="button" style="float:right;">Zu den Paketen</a><?php else: ?><a href="/app/verwaltung/benutzer/details/?id=new" class="button" style="float:right;">Neuen Benutzer anlegen</a><?php endif; ?>
                </article>
            </div>
            <div class="section__wrapper">
                <article class="gd gd--12">
                    <?php if(count($users) > 0){ ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Vorname</th>
                                    <th>Nachname</th>
                                    <th>E-Mail</th>
                                    <th>Bearbeiten</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($users as $user){ ?>
                                <tr>
                                    <td><?php echo $user->vorname; ?></td>
                                    <td><?php echo $user->nachname; ?></td>
                                    <td><?php echo $user->email; ?></td>
                                    <td><a class="button" href="/app/verwaltung/benutzer/?id=<?php echo $user->id; ?>">bearbeiten</a></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } else { ?>
                        <p>Es sind noch keine Benutzer angelegt!</p>
                    <?php } ?>
                </article>
            </div>
        </div>
    </seciton>

<?php
        
    } elseif ($wpUserRole == "kunde"){
        
        $users = $api->get("kunde/$wpUserSTAQQId/user", [])->decode_response();
        $user_anz = 1;

?>
    <seciton class="section">
        <div class="section__overlay">
            <div class="section__wrapper">
                <article class="gd gd--12 info-box">
                    <h2>Verfügbare User: <span><?php echo $user_anz; ?></span></h2>
                    <?php if ($user_anz <= 0): ?><a href="/app/verwaltung/pakete" class="button" style="float:right;">Zu den Paketen</a><?php else: ?><a href="/app/verwaltung/benutzer/details/?id=new" class="button" style="float:right;">Neuen Benutzer anlegen</a><?php endif; ?>
                </article>
            </div>
            <div class="section__wrapper">
                <article class="gd gd--12">
                    <?php if(count($users) > 0){ ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Vorname</th>
                                    <th>Nachname</th>
                                    <th>E-Mail</th>
                                    <th>Bearbeiten</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($users as $user){ ?>
                                <tr>
                                    <td><?php echo $user->vorname; ?></td>
                                    <td><?php echo $user->nachname; ?></td>
                                    <td><?php echo $user->email; ?></td>
                                    <td><a class="button" href="/app/verwaltung/benutzer/details/?id=<?php echo $user->id; ?>">bearbeiten</a></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } else { ?>
                        <p>Es sind noch keine Benutzer angelegt!</p>
                    <?php } ?>
                </article>
            </div>
        </div>
    </seciton>

<?php
        
    }

    get_footer();

?>

                        