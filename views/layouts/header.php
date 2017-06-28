<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                       aria-expanded="false">
                        <img src="<?php
                        if (Yii::$app->user->identity->genero === 'M') {
                            echo Url::to(Yii::getAlias('@LogoHombreDefault'), '');
                        } else {
                            echo Url::to(Yii::getAlias('@LogoMujerDefault'), '');
                        }
                        ?>" alt="Usuario Default">
                        <?php echo ucwords(Yii::$app->user->identity->nombre . ' ' .
                            Yii::$app->user->identity->apellido); ?>
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="javascript:;"> Configuraciones</a></li>
                        <li><a href="javascript:;"> Ayuda</a></li>
                        <?php
                        if (!Yii::$app->user->isGuest) {
                            echo
                                '<li>'
                                . '<a>'
                                . Html::beginForm(['/site/logout'], 'post')
                                . Html::submitButton(
                                    "<i class='fa fa-sign-out pull-right'></i>"
                                    . 'Cerrar Sesión',
                                    ['class' => 'btn-link']
                                )
                                . Html::endForm()
                                . '</a>'
                                . '</li>';
                        }
                        ?>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>

