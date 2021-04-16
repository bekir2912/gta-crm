<?php

use yii\db\Migration;

/**
 * Handles the creation of table `questions`.
 */
class m181108_111440_create_questions_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('questions', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'question' => $this->text(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
        ],$tableOptions);
        $this->addForeignKey('fk-questions-user_id-user-id',
            'questions',
            'user_id',
            'user',
            'id',
            'CASCADE');

        $this->createTable('answers', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'question_id' => $this->integer(11)->notNull(),
            'answer' => $this->text(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
        ],$tableOptions);

        $this->addForeignKey('fk-answers-user_id-user-id',
            'answers',
            'user_id',
            'user',
            'id',
            'CASCADE');
        $this->addForeignKey('fk-answers-question_id-questions-id',
            'answers',
            'question_id',
            'questions',
            'id',
            'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('answers');
        $this->dropTable('questions');
    }
}
