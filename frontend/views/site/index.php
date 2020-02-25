<?php

/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = 'Cigo Tracker Interview';
print "<pre>";
print_r(Yii::$app->user->isGuest);
//die;
?>
<div class="site-index">

    <div class="jumbotron">

        <p class="lead">Welcome to Cigo Tracker Coding Assessment!</p>

        <p><?= Html::a('Add an Order', ['site/order'], ['class'=> 'btn btn-lg btn-success']) ?></p>
    </div>

    <div class="body-content">


    </div>
</div>
