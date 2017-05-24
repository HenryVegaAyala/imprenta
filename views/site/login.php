<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Branusac - Iniciar Sesión';
?>
<div>
    <a class="hiddenanchor" id="signin"></a>
    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <?php $form = ActiveForm::begin(); ?>
                <h1>Imprenta Branusac</h1>
                <div>
                    <?= $form->field($model, 'username')->textInput([
                        'autofocus' => true,
                        'class' => 'form-control ',
                        'placeholder' => 'Usuario',
                    ])->label(false) ?>
                </div>
                <div>
                    <?= $form->field($model, 'password')->passwordInput([
                        'class' => 'form-control',
                        'placeholder' => 'Contraseña',
                    ])->label(false) ?>
                </div>
                <div>
                    <?= Html::submitButton('Iniciar Sesión',
                        ['class' => 'btn btn-default submit', 'name' => 'login-button']) ?>
                </div>
                <?php ActiveForm::end(); ?>
                <div class="clearfix"></div>
                <div class="separator">
                    <div class="clearfix"></div>
                    <br/>
                    <div>
                        <p>©2017 Todos los Derechos Reservador por Branusac.</p>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>