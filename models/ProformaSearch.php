<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

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
            [['id', 'cliente_id', 'estado'], 'integer'],
            [
                [
                    'num_proforma',
                    'fecha_ingreso',
                    'fecha_envio',
                ],
                'safe',
            ],
            [['monto_subtotal', 'monto_igv', 'monto_total'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
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
        $query = Proforma::find()->orderBy(['id' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'cliente_id' => $this->cliente_id,
            'monto_total' => $this->monto_total,
            'estado' => $this->estado
        ]);

        $query->andFilterWhere(['like', 'num_proforma', $this->num_proforma]);

        if ($this->fecha_ingreso !== false) {
            $FechaIni = substr($this->fecha_ingreso, 0, 10);
            $FechaFin = substr($this->fecha_ingreso, -10);
            $query->andFilterWhere(['between', 'date(fecha_ingreso)', $FechaIni, $FechaFin]);
        }

        if ($this->fecha_envio !== false) {
            $FechaIni = substr($this->fecha_envio, 0, 10);
            $FechaFin = substr($this->fecha_envio, -10);
            $query->andFilterWhere(['between', 'date(fecha_ingreso)', $FechaIni, $FechaFin]);
        }

        return $dataProvider;
    }

}
