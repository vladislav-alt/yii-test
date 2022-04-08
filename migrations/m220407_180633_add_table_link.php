<?php

use yii\db\Migration;

/**
 * Class m220407_180633_add_table_link
 */
class m220407_180633_add_table_link extends Migration
{

	public $tableName = 'link';

	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$collation = null;
		if ($this->db->driverName === 'mysql') {
			// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
			$collation = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}

		$this->createTable($this->tableName, [
			'id' => $this->primaryKey()->notNull(),
			'url' => $this->text()->notNull(),
			'code' => $this->string('32')->notNull(),
			'counter' => $this->bigInteger()->notNull()->defaultValue(0),
		], $collation);

		$this->createIndex('un_link_code', $this->tableName, ['code'], true);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		echo "m220407_180633_add_table_link cannot be reverted.\n";
		$this->remove->dropTable($this->tableName);
		return false;
	}

	/*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220407_180633_add_table_link cannot be reverted.\n";

        return false;
    }
    */
}
