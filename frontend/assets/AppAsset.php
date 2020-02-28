<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/toastr.min.css',
        'css/site.css',
        'css/developer.css',
        'css/leaflet.css',
        'css/MarkerCluster.css',
        'css/MarkerCluster.Default.css'
    ];
    public $js = [
        'js/toastr.min.js',
        'js/common.js',
        'js/leaflet-src.js',
        'js/leaflet.markercluster-src.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
