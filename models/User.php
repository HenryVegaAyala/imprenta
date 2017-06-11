<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\web\IdentityInterface;
use yii\db\Expression;
use yii\db\Query;

/**
 * This is the model class for table "usuario".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $apellido
 * @property string $telefono
 * @property string $dni
 * @property string $correo
 * @property string $privilegio
 * @property string $contrasena
 * @property string $authKey
 * @property string $accessToken
 * @property string $fecha_digitada
 * @property string $fecha_modificada
 * @property string $fecha_eliminada
 * @property string $usuario_digitado
 * @property string $usuario_modificado
 * @property string $usuario_eliminado
 * @property string $ip
 * @property string $host
 * @property integer $estado
 * @property string $genero
 * @property string $fecha_inicio
 * @property string $fecha_cumpleanos
 *
 * @property null|string|false $idTable
 * @property Ruta[] $rutas
 */
class User extends ActiveRecord implements IdentityInterface
{

    public $contrasena_desc;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha_digitada', 'fecha_modificada', 'fecha_eliminada', 'fecha_inicio', 'fecha_cumpleanos'], 'safe'],
            [['estado'], 'integer'],
            [['nombre', 'apellido'], 'string', 'max' => 80],
            [['telefono'], 'string', 'max' => 15],
            [['dni'], 'string', 'max' => 8],
            [['correo'], 'string', 'max' => 40],
            [['privilegio', 'genero'], 'string', 'max' => 1],
            [['contrasena', 'authKey', 'accessToken', 'host'], 'string', 'max' => 150],
            [['usuario_digitado', 'usuario_modificado', 'usuario_eliminado'], 'string', 'max' => 50],
            [['ip'], 'string', 'max' => 30],

            [
                ['dni', 'nombre', 'apellido', 'privilegio', 'contrasena', 'contrasena_desc', 'correo', 'estado'],
                'required',
            ],

            [['correo'], 'match', 'pattern' => "/^.{3,45}$/", 'message' => 'Mínimo 3 caracteres del correo.'],
            [['correo'], 'email', 'message' => 'Ingrese un email válido'],

            [['telefono'], 'match', 'pattern' => "/^.{3,15}$/", 'message' => 'Mínimo 5 caracteres'],
            [['dni', 'telefono'], 'integer', 'message' => 'Debe ser tipo númerico.'],

            [
                'dni',
                'match',
                'pattern' => "/^.{8,8}$/",
                'message' => 'El DNI requiere 8 digitos.',
            ],
            [
                'contrasena',
                'match',
                'pattern' => "/^.{6,255}$/",
                'message' => 'Mínimo 6 digitos para la contraseña',
            ],

            [
                'contrasena_desc',
                'match',
                'pattern' => "/^.{6,255}$/",
                'message' => 'Mínimo 6 digitos para la contraseña',
            ],

            [
                'contrasena_desc',
                'compare',
                'compareAttribute' => 'contrasena',
                'message' => 'Las contraseñas no coinciden.',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'telefono' => 'Telefono',
            'dni' => 'DNI',
            'correo' => 'Correo',
            'privilegio' => 'Privilegio',
            'contrasena' => 'Contraseña',
            'contrasena_desc' => 'Repetir Contraseña',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
            'fecha_digitada' => 'Fecha Digitada',
            'fecha_modificada' => 'Fecha Modificada',
            'fecha_eliminada' => 'Fecha Eliminada',
            'usuario_digitado' => 'Usuario Digitado',
            'usuario_modificado' => 'Usuario Modificado',
            'usuario_eliminado' => 'Usuario Eliminado',
            'ip' => 'Ip',
            'host' => 'Host',
            'estado' => 'Estado',
            'genero' => 'Genero',
            'fecha_inicio' => 'Fecha Inicio',
            'fecha_cumpleanos' => 'Fecha Cumpleanos',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRutas()
    {
        return $this->hasMany(Ruta::className(), ['usuario_id' => 'id']);
    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example,[[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @param $username
     * @return static
     */
    public static function findByUsername($username)
    {
        return self::findOne(['correo' => $username]);
    }

    /**
     * @param $password
     * @return bool
     */
    public function validatePassword($password)
    {
        return $this->contrasena === $password;
    }

    /**
     * @return array
     */
    public static function status()
    {
        $status = [
            '1' => 'Activo',
            '0' => 'Inactivo',
        ];

        return $status;
    }

    /**
     * @return array
     */
    public static function genero()
    {
        $genero = [
            'M' => 'Masculino',
            'F' => 'Femenino',
        ];

        return $genero;
    }

    /**
     * @return array
     */
    public static function rol()
    {
        $rol = [
            'G' => 'Administrador',
            'S' => 'Secretaria',
        ];

        return $rol;
    }

    /**
     * @return false|null|string
     */
    public function getIdTable()
    {
        $query = new Query();
        $sentence = new Expression('IFNULL(MAX(id), 0) + 1');
        $query->select($sentence)->from('usuario');
        $command = $query->createCommand();
        $value = $command->queryScalar();

        return $value;
    }

    /**
     * @param $value
     * @return string
     */
    public function getRol($value)
    {
        switch ($value) {
            case 'G':
                return 'Administrador';
                break;
            case 'S':
                return 'Secretaria';
                break;
        }
    }

    /**
     * @param $status
     * @return string
     */
    public function getStatus($status)
    {
        switch ($status) {
            case 1:
                return 'Activo';
                break;
            case 0:
                return 'Inactivo';
                break;
        }
    }

    /**
     * @param $id
     * @param $password
     * @return \yii\db\Transaction
     * @throws Exception
     */
    public function encryptPassword($id, $password)
    {
        //$db = Yii::$app->db;
        //$transaction = $db->beginTransaction();
        //try {
        //    $db->createCommand("UPDATE usuario SET contrasena ='" . md5($password) . "' WHERE id = '" . $id . "';");
        //    $transaction->commit();
        //} catch (Exception $e) {
        //    $transaction->rollBack();
        //    throw $e;
        //}

        $transaction = Yii::$app->db;
        $transaction->createCommand()
            ->update('usuario',
                [   'contrasena' => $password,
                ],
                'id = ' . $id)
            ->execute();
    }
}
