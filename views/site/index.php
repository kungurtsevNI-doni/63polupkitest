<?php
use app\models\Offices as Offices;

$of = new Offices();

$arrayOfAll = $of -> getAllOffices();
$arrayOfOnlyOffice = $arrayOfAll['office'];
$arrayOfOfficeAndTime = $arrayOfAll['officeAndTime'];

/* @var $this yii\web\View */

$this->title = 'Все офисы';
?>
<script src="js/script-for-table.js"></script>
<div class="site-index">
    <div class="content-container">
        <h1>Наши офисы</h1>
        <table class="table table-my">
            <thead>
                <tr>
                    <td rowspan="2">Название</td>
                    <td rowspan="2">Адрес</td>
                    <td colspan="2">График работы</td>
                </tr>
                <tr>
                    <td>День недели</td>
                    <td>Время работы</td>
                </tr>
            </thead>
            <tbody>
            <?php
               foreach ($arrayOfOnlyOffice as $key=>$value){
                   echo '<tr>
                         <td rowspan="8">'.$value['title_office'].'</td>
                         <td rowspan = "8">'.$value['address'].'</td>
                         </tr>';
                   foreach ($arrayOfOfficeAndTime as $key1 => $value1) {
                       if ($value1['title_office'] == $value['title_office']) {
                           echo '<tr>
                             <td>' . $value1['name_weekday'] . '</td>';

                           if ($value1['start_time'] == $value1['end_time']) {
                               echo '<td>Выходной</td>';
                           } else echo '<td>' . $value1['time'] . '</td>';

                           echo '</tr>';
                       }
                   }
               }
            ?>
            </tbody>
        </table>
    </div>
</div>
