<?php 
$parfums = [
    'Fraise' => 4,
    'Chocolat' => 5,
    'Vanille' => 3
];
$cornets = [
    'Pot' => 2,
    'Cornet' => 3
];

$suplements = [
    'Pepite de chocolat' => 1,
    'Chantilly' => 0.5
];

$ingredients = [];
$total = 0;

foreach(['parfums', 'suplements', 'cornets'] as $name) {
    if(isset($_POST[$name])) {
        $choix = $_POST[$name];
        if(is_array($choix )) {
            foreach($choix  as $value) {
                if(isset($$name[$value])) {
                    $ingredients[] = $value;
                    $total += $$name[$value];
                }
            }
        } else {
            if(isset($$name[$choix ])) {
                $ingredients[] = $choix ;
                $total += $$name[$choix ];
            }
        }
    }
}

require 'header.php';
?>
    <div>
        <h3>Votre glace : </h3>
        <?php if(!empty($ingredients)) : ?>
        <ul>
            <?php foreach($ingredients as $ingredient) : ?>
                <li><?= $ingredient; ?></li>
            <?php endforeach?>
        </ul>
        <?php endif ?>
        <?php if($total > 0) : ?>
            <p><strong>Prix</strong> : <?= $total; ?></p>
        <?php endif ?>
    </div>

    <form action="jeu.php" method="POST">
        <fieldset>
            <legend>Parfums</legend>
            <?php foreach ($parfums as $parfum => $prix) : ?>
                <?php
                    $attributes = '';
                    if(isset($_POST['parfums']) && in_array($parfum, $_POST['parfums'])) {
                        $attributes = 'checked';
                    }
                ?>
                <div>
                    <label>
                        <?php echo checkbox('parfums', $parfum, $_POST); ?>
                        <?= $parfum;?> - <?= $prix?>€
                    </label>
                </div>
            <?php endforeach?>
        </fieldset>
        <fieldset>
            <legend>Cornets</legend>
            <?php foreach ($cornets as $cornet => $prix) : ?>
                <div>
                    <label>
                        <?php echo radio('cornets', $cornet, $_POST); ?>
                        <?= $cornet;?> - <?= $prix?>€
                    </label>
                </div>
            <?php endforeach?>
        </fieldset>
        <fieldset>
            <legend>Suplements</legend>
            <?php foreach ($suplements as $suplement => $prix) : ?>
                <div>
                    <label>
                        <?php echo checkbox('suplements', $suplement, $_POST); ?>
                        <?= $suplement;?> - <?= $prix?>€
                    </label>
                </div>
            <?php endforeach?>
        </fieldset>
        <div><input type="submit" value="Sum"></div>
    </form>
<?php require 'footer.php'; ?>