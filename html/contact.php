<?php
date_default_timezone_set('Africa/Casablanca');
$page_title = "Page Contact";
require_once 'header.php';
require_once 'functions.php';
require_once 'config.php';
$hour = (int) date('G');
$creneau_day = CRENEAUX[date('N') - 1];
$is_open = in_creneau($hour, $creneau_day);
$color = $is_open ? 'green' : 'red';

if(isset($_POST) && !empty($_POST['hour']) && !empty($_POST['day'])) {
    $schedule_open = in_creneau((int)$_POST['hour'], CRENEAUX[(int)$_POST['day']]);
}
?>
    <div class="row">
        <div class="col-md-8">
            <h1>Nous contacter</h1>
            <p class="fs-5 col-md-8">
                <?php if($schedule_open) : ?>
                    Le magasin ça sera ouvert
                <?php else : ?>
                    Le magasin ça sera fermé
                <?php endif ?>
            </p>
            
            <form action="contact.php" method="POST">
                <div>
                    <select name="day" id="">
                        <?php foreach(JOURS as $key => $jour) : ?>
                            <?php
                                if((isset($_POST['day']) && ((int)$_POST['day'] === $key)) || (date('N') - 1 === $key)) {
                                    $attributes = 'selected';
                                }
                            ?>
                            <option value="<?= $key; ?>" <?= $attributes; ?>>
                                <?= $jour; ?>
                            </option>
                            <?php $attributes = '';?>
                        <?php endforeach ?>
                    </select>
                    <input type="number" name="hour" min="0" max="23" value=<?php echo isset($_POST['hour']) ? $_POST['hour'] : $hour; ?>>
                    <input type="submit" value="Valider">
                </div>
            </form>
        </div>
        <div class="col-md 4">
            <?php if($is_open) : ?>
                <div class="alert alert-success">Le magasin est ouvert</div>
            <?php else : ?>
                <div class="alert alert-danger">Le magasin est fermé</div>
            <?php endif ?>
            <ul>
                <?php foreach(JOURS as $key => $jour) : ?>
                    <li <?php if(date('N') - 1 === $key) {?>style="color:<?= $color;?>"<?php }?>>
                        <?= $jour;?> - <?= html_creneaux(CRENEAUX[$key]); ?>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
<?php require 'footer.php'; ?>