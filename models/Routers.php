<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "routers".
 *
 * @property int $id
 * @property string $type
 * @property string $sapid
 * @property string $hostname
 * @property string $loopback
 * @property string $mac_address
 * @property int $status
 * @property string $created
 */
class Routers extends \yii\db\ActiveRecord
{
    const ACTIVE = 1;
    const INACTIVE = 0;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'routers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'sapid', 'hostname', 'loopback', 'mac_address'], 'required'],
            ['hostname', 'ip', 'ipv6' => false],
            [['status'], 'integer'],
            [['created'], 'safe'],
            ['mac_address', 'string', 'max' => 17],
            [['sapid', 'hostname', 'loopback'], 'string', 'max' => 20],
            [['sapid', 'hostname', 'loopback', 'mac_address'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'sapid' => 'Sapid',
            'hostname' => 'Hostname',
            'loopback' => 'Loopback',
            'mac_address' => 'Mac Address',
            'status' => 'Status',
            'created' => 'Created',
        ];
    }
}
