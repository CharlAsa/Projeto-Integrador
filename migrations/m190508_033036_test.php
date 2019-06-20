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
		$auth = Yii::$app->authManager;
		
		$admin = $auth->createRole('admin');
		
		$auth->add($admin);
		
		$createConsulta = $auth->createPermission('consulta/create');
        $createConsulta->description = 'Criar consulta';
        $auth->add($createConsulta);
		
		$auth->addChild($admin, $createConsulta);
		
		$auth->assign($admin, 1);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
		$auth = Yii::$app->authManager;

        $auth->removeAll();
		
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
