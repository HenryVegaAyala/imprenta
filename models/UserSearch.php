<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form about `app\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'estado'], 'integer'],
            [
                [
                    'nombre',
                    'apellido',
                    'telefono',
                    'dni',
                    'correo',
                    'privilegio',
                    'contrasena',
                    'contrasena_desc',
                    'authKey',
                    'accessToken',
                    'fecha_digitada',
                    'fecha_modificada',
                    'fecha_eliminada',
                    'usuario_digitado',
                    'usuario_modificado',
                    'usuario_eliminado',
                    'ip',
                    'host',
                    'genero',
                ],
                'safe',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'fecha_digitada' => $this->fecha_digitada,
            'fecha_modificada' => $this->fecha_modificada,
            'fecha_eliminada' => $this->fecha_eliminada,
            'estado' => $this->estado,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'apellido', $this->apellido])
            ->andFilterWhere(['like', 'telefono', $this->telefono])
            ->andFilterWhere(['like', 'dni', $this->dni])
            ->andFilterWhere(['like', 'correo', $this->correo])
            ->andFilterWhere(['like', 'privilegio', $this->privilegio])
            ->andFilterWhere(['like', 'contrasena', $this->contrasena])
            ->andFilterWhere(['like', 'contrasena_desc', $this->contrasena_desc])
            ->andFilterWhere(['like', 'authKey', $this->authKey])
            ->andFilterWhere(['like', 'accessToken', $this->accessToken])
            ->andFilterWhere(['like', 'usuario_digitado', $this->usuario_digitado])
            ->andFilterWhere(['like', 'usuario_modificado', $this->usuario_modificado])
            ->andFilterWhere(['like', 'usuario_eliminado', $this->usuario_eliminado])
            ->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'host', $this->host])
            ->andFilterWhere(['like', 'genero', $this->genero]);

        return $dataProvider;
    }
}
