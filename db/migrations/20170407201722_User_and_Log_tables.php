<?php

use Phinx\Migration\AbstractMigration;

class UserAndLogTables extends AbstractMigration
{
    public function change()
    {
		$users = $this->table('users');
		$users->addColumn('username', 'string', array('limit' => 20))
			->addColumn('created', 'datetime')
			->addColumn('log_token', 'string')
			->addIndex(array('username'), array('unique' => true))
			->create();

		$sleepLog = $this->table("sleep_log");
		$sleepLog->addColumn('event_type', 'integer' )
			->addColumn('event_time', 'datetime')
			->addColumn('user_id', 'integer', ['signed' => false, 'null' => false])
			->create();
    }

    public function down()
	{
		$this->dropTable('users');
		$this->dropTable('sleep_log');
	}
}
