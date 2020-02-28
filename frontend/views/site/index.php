<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
$this->title = 'Cigo Tracker Interview';
?>
<div class="site-index">
    <div class="jumbotron">
        <p class="lead">Welcome to Cigo Tracker Coding Assessment!</p>
        <p><?= Html::a('Add an Order', ['site/order'], ['class'=> 'btn btn-lg btn-success']) ?></p>
    </div>
</div>
