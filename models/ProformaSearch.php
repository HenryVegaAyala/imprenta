<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\caching\DbDependency;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

/**
 * ProformaSearch represents the model behind the search form about `app\models\Proforma`.
 */
class ProformaSearch extends Proforma
{
    const CACHE_TIMEOUT = 3600;
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
        $db = Yii::$app->db;
        $dep = new DbDependency();
        $query = Proforma::getDb()->cache(function ($db) {
            $expressions = "
          CASE proforma.estado
          WHEN 1
            THEN 'Creado'
          WHEN 2
            THEN 'En Proceso'
          WHEN 3
            THEN 'Despachadado / Atendido'
          WHEN 0
            THEN 'Anulado' END                   AS proforma_estado
        ";

            return Proforma::find()
                ->select([
                    'proforma.id                              AS id',
                    'proforma.num_proforma                    AS num_proforma',
                    'cliente.desc_cliente                     AS cliente_name',
                    'date_format(fecha_ingreso, \'%d-%m-%Y\') AS fecha_ingreso',
                    'date_format(fecha_envio, \'%d-%m-%Y\')   AS fecha_envio',
                    'monto_total                              AS monto_total',
                ])
                ->addSelect([new Expression($expressions)])
                ->leftJoin('cliente', 'proforma.cliente_id = cliente.id')
                ->orderBy(['proforma.id' => SORT_DESC]);
        }, self::CACHE_TIMEOUT, $dep);

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
            'proforma.estado' => $this->estado,
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
