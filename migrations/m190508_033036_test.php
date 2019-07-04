<?php

use yii\db\Migration;

/**
 * Class m190508_033036_test
 */
class m190508_033036_test extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->insert('usuario', [
            'cpf' => '12323',
            'rg' => '12323',
            'username' => 'alfa',
            'password' => Yii::$app->getSecurity()->generatePasswordHash('alfa'),
            'id_Yii' => 1,
        ]);
        $this->insert('endereco', [
            'id_usuario' => 1,
            'logradouro' => '1',
            'bairro' => '1',
            'cidade' => '1',
            'uf' => '1',
            'cep' => '1',
            'numero_casa' => '1',
        ]);
        $this->insert('contato', [
            'id_usuario' => 1,
            'numero_telefone' => '12323',
        ]);
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('endereco', ['id_usuario' => 1]);
        $this->delete('contato', ['id_usuario' => 1]);
        $this->delete('usuario', ['username' => 'alfa']);
		//$auth = Yii::$app->authManager;

        //$auth->removeAll();
		
        //echo "m190508_033036_test cannot be reverted.\n";

        //return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190508_033036_test cannot be reverted.\n";

        return false;
    }
    */
}
