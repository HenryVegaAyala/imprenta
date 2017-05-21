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
        'repository/nprogress/nprogress.css',
        'repository/animate.css/animate.min.css',
        'repository/iCheck/skins/flat/green.css',
        'repository/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css',
        'repository/jqvmap/dist/jqvmap.min.css',
        'repository/bootstrap-daterangepicker/daterangepicker.css',
        'css/custom.min.css',
        'css/custom.css',
    ];
    public $js = [
        'repository/jquery/dist/jquery.min.js',
        'repository/bootstrap/dist/js/bootstrap.min.js',
        'repository/fastclick/lib/fastclick.js',
        'repository/nprogress/nprogress.js',
        'repository/Chart.js/dist/Chart.min.js',
        'repository/gauge.js/dist/gauge.min.js',
        'repository/bootstrap-progressbar/bootstrap-progressbar.min.js',
        'repository/iCheck/icheck.min.js',
        'repository/skycons/skycons.js',
        'repository/Flot/jquery.flot.js',
        'repository/Flot/jquery.flot.pie.js',
        'repository/Flot/jquery.flot.time.js',
        'repository/Flot/jquery.flot.stack.js',
        'repository/Flot/jquery.flot.resize.js',
        'repository/flot.orderbars/js/jquery.flot.orderBars.js',
        'repository/flot-spline/js/jquery.flot.spline.min.js',
        'repository/flot.curvedlines/curvedLines.js',
        'repository/DateJS/build/date.js',
        'repository/jqvmap/dist/jquery.vmap.js',
        'repository/jqvmap/dist/maps/jquery.vmap.world.js',
        'repository/jqvmap/examples/js/jquery.vmap.sampledata.js',
        'repository/jqvmap/examples/js/moment.min.js',
        'repository/bootstrap-daterangepicker/daterangepicker.js',
        'js/custom.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
