<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\models\Offices as Offices;
use app\models\Address;
use app\models\Schedule;

$of = new Offices();

$arrayOfAll = $of -> getAllOffices();
$arrayOfOnlyOffice = $arrayOfAll['office'];
$arrayOfOfficeAndTime = $arrayOfAll['officeAndTime'];

$this->title = 'Администраторская панель';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <?php foreach (Yii::$app->session->getAllFlashes() as $type => $message): ?>
        <?php if (in_array($type, ['success', 'danger', 'warning', 'info'])): ?>
            <?= Alert::widget([
                'options' => ['class' => 'alert-dismissible alert-'.$type],
                'body' => $message
            ]) ?>
        <?php endif ?>
    <?php endforeach ?>
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="content-container">
        <div class="row">
            <div class="col-lg-4">
                <?php ?>
                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'title_office')->label('Название нового офиса') ?>
                <?= $form->field($address, 'city')->label('Город') ?>
                <?= $form->field($address, 'street')->label('Улица') ?>
                <?= $form->field($address, 'house_number')->label('Номер дома') ?>


                <div class="form-group">
                    <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="col-lg-8">
                <table class="table table-my-open-offices">
                    <thead>
                    <tr>
                        <td>Название</td>
                        <td>Город</td>
                        <td>Улица</td>
                        <td>Номер дома</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($arrayOfOnlyOffice as $key=>$value){
                        echo '<tr><td>'.$value['title_office'].'</td><td>'.$value['city'].'</td><td>'.$value['street'].'</td><td>'.$value['house_number'].'</td></tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
