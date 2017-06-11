<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Proforma;

/**
 * ProformaSearch represents the model behind the search form about `app\models\Proforma`.
 */
class ProformaSearch extends Proforma
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'estado'], 'integer'],
            [['num_proforma', 'fecha_ingreso', 'fecha_envio', 'fecha_digitada', 'fecha_modificada', 'fecha_eliminada', 'usuario_digitado', 'usuario_modificado', 'usuario_eliminado', 'ip', 'host'], 'safe'],
            [['monto_subtotal', 'monto_igv', 'monto_total'], 'number'],
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
        $query = Proforma::find();

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
            'fecha_ingreso' => $this->fecha_ingreso,
            'fecha_envio' => $this->fecha_envio,
            'monto_subtotal' => $this->monto_subtotal,
            'monto_igv' => $this->monto_igv,
            'monto_total' => $this->monto_total,
            'fecha_digitada' => $this->fecha_digitada,
            'fecha_modificada' => $this->fecha_modificada,
            'fecha_eliminada' => $this->fecha_eliminada,
            'estado' => $this->estado,
        ]);

        $query->andFilterWhere(['like', 'num_proforma', $this->num_proforma])
            ->andFilterWhere(['like', 'usuario_digitado', $this->usuario_digitado])
            ->andFilterWhere(['like', 'usuario_modificado', $this->usuario_modificado])
            ->andFilterWhere(['like', 'usuario_eliminado', $this->usuario_eliminado])
            ->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'host', $this->host]);

        return $dataProvider;
    }
}
