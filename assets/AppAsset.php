<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'repository/bootstrap/dist/css/bootstrap.min.css',
        'repository/font-awesome/css/font-awesome.min.css',
        'repository/animate.css/animate.min.css',
        'repository/bootstrap-daterangepicker/daterangepicker.css',
        'css/custom.min.css',
        'css/custom.css',
    ];
    public $js = [
        'repository/bootstrap/dist/js/bootstrap.min.js',
        'repository/Chart.js/dist/Chart.min.js',
        'repository/gauge.js/dist/gauge.min.js',
        'repository/bootstrap-progressbar/bootstrap-progressbar.min.js',
        'repository/Flot/jquery.flot.js',
        'repository/Flot/jquery.flot.time.js',
        'repository/Flot/jquery.flot.resize.js',
        'repository/flot-spline/js/jquery.flot.spline.min.js',
        'repository/DateJS/build/date.js',
        'repository/jqvmap/examples/js/moment.min.js',
        'repository/bootstrap-daterangepicker/daterangepicker.js',
        'js/custom.min.js',
        'js/branusac.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
