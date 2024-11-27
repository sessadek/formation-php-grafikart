<?php 
require 'functions.php';
redirect_to_login();
add_view();
$year = (int)date('Y');
require 'header.php';
$months = [];
for ($i = 1; $i <= 12; $i++) {
    $key = str_pad($i, 2, "0", STR_PAD_LEFT);
    $months[$key] = date('F', mktime(0, 0, 0, $i, 10));
}
$getYear = !empty($_GET['year']) ? $_GET['year'] : null;
$getYear = (int)$getYear;
$getMonth = !empty($_GET['month']) ? $_GET['month'] : null;


if($getYear && $getMonth) {
    $total = show_view_per_month($getYear, $getMonth);
    $views = detail_views($getYear, $getMonth);
} else {
    $total = show_view();
}

?>
    <div class="row">
        <div class="col-sm-4">
            <div class="list-group">
                <?php for($i = 0; $i < 5; $i++) : ?>
                    <?php $item = $year - $i; ?>
                    <a class="list-group-item <?php if($getYear === $item ) {echo 'active';}?>" href="/dashbord.php?year=<?= $item; ?>"><?= $item; ?></a>
                    <?php if ($getYear === $item) : ?>
                        <?php foreach($months as $key => $month) : ?>
                            <a class="list-group-item <?php if($getYear === $item && $getMonth == $key) {echo 'active';}?>" href="/dashbord.php?year=<?= $item; ?>&month=<?= $key;?>"><?= $month ?></a>
                        <?php endforeach ?>
                    <?php endif ?>
                <?php endfor ?>
            </div>
        </div>
        <div class="col-sm-8">
            <div>visites  : <?= $total; ?></div>
            <?php if(isset($views) && !empty($views)) : ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Year</th>
                            <th scope="col">Month</th>
                            <th scope="col">Day</th>
                            <th scope="col">Views</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($views as $view): ?>
                            <tr>
                                <td scope="row"><?= $view['year']; ?></td>
                                <td><?= $view['month']; ?></td>
                                <td><?= $view['day']; ?></td>
                                <td><?= $view['views']; ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php endif ?>
        </div>
    </div>
<?php require 'footer.php';?>