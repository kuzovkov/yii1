<?php

namespace app\models;

use Yii;
use yii\base\Model;


/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class ImportForecastsForm extends Model
{
    public $analyst_id;
    public $file;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
           // [['analyst_id'], 'required'],
           // ['analyst_id', 'integer', 'message' => 'You must choose analyst_id'],
            [['file'], 'file', 'extensions' => 'csv'],
            [['file'], 'string', 'max' => 200]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'analyst_id' => Yii::t('app', 'Analyst'),
            'file' => Yii::t('app', 'CSV file')
        ];
    }

}
