<?php

use yii\db\Migration;

/**
 * Handles the creation for table `sound`.
 */
class m160820_153737_create_sound_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('sound', [
            'id'            => $this->primaryKey(),
            'name'          => $this->string()->notNull(),
            'filename'      => $this->string()->notNull(),
            'created_by'    => $this->integer(),
            'updated_by'    => $this->integer(),
            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('sound_fk1','sound','created_by','user','id','SET NULL','CASCADE');
        $this->addForeignKey('sound_fk2','sound','updated_by','user','id','SET NULL','CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('sound_fk1','sound');
        $this->dropForeignKey('sound_fk2','sound');

        $this->dropTable('sound');
    }
}
