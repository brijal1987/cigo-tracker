<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Make an Order';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading"><?= Html::encode($this->title) ?></div>
                        <div class="panel-body">
                        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                            <div class="col-lg-6">
                            <?= $form->field($model, 'first_name')->textInput(['autofocus' => true]) ?>
                            </div>
                            <div class="col-lg-6">
                            <?= $form->field($model, 'last_name') ?>
                            </div>
                            <div class="col-lg-6">
                            <?= $form->field($model, 'email') ?>
                            </div>
                            <div class="col-lg-6">
                            <?= $form->field($model, 'phone') ?>
                            </div>
                            <div class="col-lg-6">
                            <?= $form->field($model, 'order_type') ?>
                            </div>
                            <div class="col-lg-6">
                            <?= $form->field($model, 'order_value') ?>
                            </div>
                            <div class="col-lg-12">
                            <?= $form->field($model, 'schedule_date') ?>
                            </div>
                            <div class="col-lg-12">
                            <?= $form->field($model, 'street_address') ?>
                            </div>
                            <div class="col-lg-6">
                            <?= $form->field($model, 'city') ?>
                            </div>
                            <div class="col-lg-6">
                            <?= $form->field($model, 'state') ?>
                            </div>
                            <div class="col-lg-6">
                            <?= $form->field($model, 'zip_code') ?>
                            </div>
                            <div class="col-lg-6">
                            <?= $form->field($model, 'country') ?>
                            </div>
                            <div class="col-lg-6">
                            <?= $form->field($model, 'city') ?>
                            </div>
                            <div class="col-lg-6">
                            <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">LISTING</div>
                        <div class="panel-body">Panel Content</div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">MAP</div>
                        <div class="panel-body">MAP Content</div>
                    </div>
                </div>
            </div>
</div>
