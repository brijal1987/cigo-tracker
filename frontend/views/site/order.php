<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use richardfan\widget\JSRegister;

$this->title = 'Make an Order';
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">

<div class="site-order">
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default box-title">
                <div class="panel-heading"><?= Html::encode($this->title) ?><i class="box-title-icon fas fa-address-card pull-right"></i></div>
                <div class="panel-body">
                <?php $form = ActiveForm::begin([
                        'id' => 'form-order',
                    ]); ?>
                    <div class="col-lg-12">
                        <div class="col-lg-6">
                        <?= $form->field($model, 'first_name')->textInput(['autofocus' => true]) ?>
                        </div>
                        <div class="col-lg-6">
                        <?= $form->field($model, 'last_name') ?>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-6">
                        <?= $form->field($model, 'email') ?>
                        </div>
                        <div class="col-lg-6">
                        <?= $form->field($model, 'phone') ?>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-6">
                        <?php 
                        $listOrderType=ArrayHelper::map($orderTypes,'id','name');
                        echo $form->field($model, 'order_type_id')->dropDownList($listOrderType,
                        ['prompt'=>'Select order type']); ?>
                        </div>
                        <div class="col-lg-6">
                        <?= $form->field($model, 'order_value', [
                            'addon' => [
                                'prepend' => [
                                    'content' => '$'
                                ]
                            ]
                        ]); ?>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label has-star" for="orderform-schedule_date">Schedule Date</label>
                                <?php echo DatePicker::widget([
                                    'model'=>$model,

                                    'name' => 'schedule_date', 
                                    'value' => date('Y-m-d'),
                                    'options' => ['placeholder' => 'Select schedule date ...'],
                                    'pluginOptions' => [
                                        'format' => 'yyyy-mm-dd',
                                        'todayHighlight' => true
                                    ],
                                    'removeButton'=> false
                                ]); ?>
                            </div>
                        </div>
                        <div class="col-lg-6">

                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-12">
                        <?= $form->field($model, 'street_address') ?>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-6">
                        <?= $form->field($model, 'city') ?>
                        </div>
                        <div class="col-lg-6">
                        <?= $form->field($model, 'state') ?>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-6">
                        <?= $form->field($model, 'zip_code') ?>
                        </div>
                        <div class="col-lg-6">
                        <?php 
                        $listData=ArrayHelper::map($countries,'id','name');
                        echo $form->field($model, 'country_id')->dropDownList($listData,
                        ['prompt'=>'Select country']); ?>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-6 pull-left">
                        <?= Html::a('Preview Location', null , ['class' => 'btn btn-default', 'href'=> 'javascript:void(0);', 'onclick' => 'previewmap()']) ?>
                        </div>
                        <div class="col-lg-6 pull-right">
                        <?= Html::resetButton('Cancel', ['class' => 'btn btn-danger', 'name' => 'cancel-button', 'onclick' => 'resetOrder()', 'type'=>'button']) ?>
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-success', 'name' => 'submit-button']) ?>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <div class="panel panel-default box-title">
                <div class="panel-heading">Existing Orders<i class="box-title-icon fas fa-check-square pull-right"></i></div>
                <div class="panel-body" id="order-listing">
                    <div class="loader"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default box-title">
                <div class="panel-heading">Map<i class="box-title-icon fas fa-globe-asia pull-right"></i></div>
                <div class="panel-body">
                    <div id='map'>
                        <div class="loader"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php JSRegister::begin(); ?>
<script>
loadOrders();
$(document).on("beforeSubmit", "#form-order", function () {

    var data = $('#form-order').serialize();
    $.ajax({
        url: $('#form-order').attr('action'),
        type: 'POST',
        data: data,
        success: function (data) {
            if(data.success == true){
                $('#form-order')[0].reset();
                toastr.success('Order Added Successfully');
                loadOrders();
            }
            else {
                if(data.error === "Error"){
                    toastr.error('Something went wrong.');
                } else {
                    toastr.error(data.error);
                }
            }
        }
     });
     return false;
});

</script>
<?php JSRegister::end(); ?>

