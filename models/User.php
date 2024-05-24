<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $phone
 * @property string $FIO
 * @property string $email
 * @property string $password
 * @property string $licence
 * @property int $role
 *
 * @property Request[] $requests
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $password_repeat;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'phone', 'FIO', 'email', 'password', 'licence'], 'required'],
            [['username', 'phone', 'FIO', 'email', 'password', 'licence'], 'string', 'max' => 255],
            [['username'], 'unique'],
            ['password', 'string', 'length' => [3, 255]],
            ['password', 'match', 'pattern' => '/^[A-Za-z 0-9]\w*$/i'],
            [['email'], 'unique'],
            [['email'], 'email'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'password_repeat' => 'Повторение пароля',
            'phone' => 'Телефон',
            'FIO' => 'ФИО',
            'email' => 'Почта',
            'password' => 'Пароль',
            'licence' => 'Права',
        ];
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return self::findOne(['username' => $username]);
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string|null current user auth key
     */
    public function getAuthKey()
    {
        return null;
    }

    /**
     * @param string $authKey
     * @return bool|null if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return false;
    }

    /**
     * Gets query for [[Requests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequests()
    {
        return $this->hasMany(Request::class, ['author_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        $this->password = md5($this->password);
        return parent::beforeSave($insert);
    }

    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }

    public function isAdmin(): bool
    {
        return $this->role == 1;
    }
}
