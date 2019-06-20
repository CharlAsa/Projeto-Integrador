<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use yiibr\brvalidator\CpfValidator;

/**
 * This is the model class for table "usuario".
 *
 * @property int $id
 * @property string $cpf
 * @property string $rg
 * @property string $sexo
 * @property string $nascimento
 * @property string $data_cadastro
 * @property string $username
 * @property string $password
 * @property string $auth_key_Yii
 * @property string $access_token_Yii
 * @property int $id_Yii
 *
 * @property Contato[] $contatos
 * @property Endereco[] $enderecos
 * @property Medico $medico
 * @property Paciente $paciente
 * @property Secretario $secretario
 */
class Usuario extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cpf', 'rg', 'username', 'password', 'nome', 'nascimento'], 'required'],
            [['nascimento', 'data_cadastro'], 'safe'],
            [['id_Yii'], 'integer'],
            //[['cpf'], 'string', 'max' => 11],
			// cpf validator
			[['cpf'],CpfValidator::className()],
            [['rg'], 'string', 'max' => 9],
            [['sexo'], 'string', 'max' => 1],
            [['username', 'password'], 'string', 'max' => 40],
            [['auth_key_Yii', 'access_token_Yii'], 'string', 'max' => 100],
            [['rg'], 'unique'],
			[['nome'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cpf' => 'CPF',
            'rg' => 'RG',
            'sexo' => 'Sexo',
            'nascimento' => 'Data de nascimento',
            'data_cadastro' => 'Data Cadastro',
            'username' => 'Username',
            'password' => 'Password',
            'auth_key_Yii' => 'Auth Key Yii',
            'access_token_Yii' => 'Access Token Yii',
            'id_Yii' => 'Id Yii',
			'nome' => 'Nome',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContatos()
    {
        return $this->hasMany(Contato::className(), ['id_usuario' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnderecos()
    {
        return $this->hasMany(Endereco::className(), ['id_usuario' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedico()
    {
        return $this->hasOne(Medico::className(), ['id_usuario' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaciente()
    {
        return $this->hasOne(Paciente::className(), ['id_usuario' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSecretario()
    {
        return $this->hasOne(Secretario::className(), ['id_usuario' => 'id']);
    }
	
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
        return static::findOne(['access_token_Yii' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key_Yii;
    }

    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
	
	public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }
	
	public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key_Yii = \Yii::$app->security->generateRandomString();
				$this->data_cadastro = new \yii\db\Expression('NOW()');
				
				$this->nascimento = str_replace('/', '-', $this->nascimento);
				$this->nascimento = date("Y-m-d", strtotime($this->nascimento));
				//Yii::trace($this->nascimento);
				//$this->id_Yii = 1;
            }
            return true;
        }
        return false;
    }
	
	public function validatePassword($pass){
		return $this->password === $pass;
	}
}
