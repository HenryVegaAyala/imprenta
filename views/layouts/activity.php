<?php
use yii\helpers\Url;

?>
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">

                <div class="navbar nav_title" style="border: 0;">
                    <a href="<?php echo Url::home() ?>" class="site_title"></i>
                        <span class="pull-center">Empresa Branusac</span>
                    </a>
                </div>

                <div class="clearfix"></div>

                <div class="profile clearfix">
                    <div class="profile_pic">
                        <img src="<?php
                        if (Yii::$app->user->identity->genero === 'M') {
                            echo Url::to(Yii::getAlias('@LogoHombreDefault'), '');
                        } else {
                            echo Url::to(Yii::getAlias('@LogoMujerDefault'), '');
                        }
                        ?>" alt="Usuario Default"
                             class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span>Bienvenido,</span>
                        <h2><?php echo ucwords(Yii::$app->user->identity->nombre); ?></h2>
                    </div>
                </div>

                <br/>

                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section">
                        <h3>Menú General</h3>
                        <ul class="nav side-menu">
                            <li><a><i class="fa fa-list-alt"></i> Proforma <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="<?php echo Url::to(['/proforma/create']) ?>">Registrar Proforma</a>
                                    </li>
                                    <li><a href="<?php echo Url::to(['/proforma/index']) ?>">Lista de Proformas</a></li>
                                </ul>
                            </li>
                            <li><a><i class="fa fa-list-alt"></i> Factura <span
                                            class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="<?php echo Url::to(['/factura/create']) ?>">Registrar Factura</a></li>
                                    <li><a href="<?php echo Url::to(['/factura/index']) ?>">Lista de Facturas</a></li>
                                </ul>
                            </li>
                            <li><a><i class="fa fa-list-alt"></i> Guía de Remisión <span class="fa fa-chevron-down">
                                    </span></a>
                                <ul class="nav child_menu">
                                    <li><a href="<?php echo Url::to(['/guia/index']) ?>">Lista de Guías de Remisión</a>
                                    </li>
                                </ul>
                            </li>
                            <?php if (Yii::$app->user->identity->privilegio === 'G') { ?>
                                <li><a><i class="fa fa-list-alt"></i> Reportes <span
                                                class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="#">Generar Reporte PDF</a></li>
                                        <li><a href="#">Generar Reporte Dashboard</a></li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-list-alt"></i> Usuario <span
                                                class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="<?php echo Url::to(['/user/create']) ?>">Registrar Usuario</a></li>
                                        <li><a href="<?php echo Url::to(['/user/index']) ?>">Listar Privilegios</a></li>
                                    </ul>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="sidebar-footer hidden-small">
                        <a data-toggle="tooltip" data-placement="top" title="Settings">
                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Lock">
                            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
