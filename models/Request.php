<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "request".
 *
 * @property int $id
 * @property int $author_id
 * @property int|null $vehicle_id
 * @property int $status
 * @property string $date
 *
 * @property User $author
 * @property Vehicle $vehicle
 */
class Request extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'vehicle_id'], 'required'],
            [['author_id', 'vehicle_id'], 'integer'],
            [['author_id'], 'default', 'value' => Yii::$app->user->identity->id],
            [['date'], 'safe'],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['author_id' => 'id']],
            [['vehicle_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vehicle::class, 'targetAttribute' => ['vehicle_id' => 'id']],
            [['vehicle_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vehicle::class, 'targetAttribute' => ['vehicle_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'Author ID',
            'vehicle_id' => 'Vehicle ID',
            'status' => 'Status',
            'date' => 'Date',
        ];
    }

    public function validateDate()
    {
        if (
            self::find()
                ->where(['date' => $this->date])
                ->andWhere(['in', 'status',  [0, 1]])
                ->exists()
        )
        {
            $this->addError('date', 'Incorrect date.');
            return false;
        }
        return true;
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    /**
     * Gets query for [[Vehicle]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVehicle()
    {
        return $this->hasOne(Vehicle::class, ['id' => 'vehicle_id']);
    }

    public function approve()
    {
        return $this->updateAttributes(['status' => 1]);
    }

    public function cancel()
    {
        return $this->updateAttributes(['status' => 2]);
    }
}
