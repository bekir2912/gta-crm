<?php

use yii\db\Migration;

/**
 * Handles the creation of table `fb_token_user`.
 */
class m190107_060115_create_fb_token_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('fb_token_user', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'token' => $this->text(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('fb_token_user');
    }
}
