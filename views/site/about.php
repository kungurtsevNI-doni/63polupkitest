<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use app\models\Offices;

$of = new Offices();
$arrayOfOpenOffices = $of -> getOpenOffices();
$dateNow = date('H:m:s');

$this->title = 'Открытые офисы';
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="js/script-for-table.js"></script>
<div class="site-about">
    <h2>Время сейчас: <?=$dateNow?></h2>
    <table class="table table-my-open-offices">
        <thead>
        <tr>
            <td>Название</td>
            <td>Адрес</td>
            <td>Будет работать</td>
        </tr>
        </thead>
        <tbody>
        <?php
            foreach ($arrayOfOpenOffices as $key => $value) {
                echo "<tr><td>".$value['title_office']."</td><td>".$value['address']."</td><td style='text-align:center;'>".$value['jobtime']."ч.</td></tr>";
            }
        ?>
        </tbody>
    </table>
</div>
