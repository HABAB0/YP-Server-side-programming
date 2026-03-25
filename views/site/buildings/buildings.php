<h1>Список Зданий</h1>
<ol>
    <?php
    foreach ($buildings as $building) {
        echo '<li>' . $building->name . ' - по адресу: ' . $building->address . '</li>';
    }
    ?>
</ol>