<?php

namespace App\Migrations;

use App\Core\Abstract\Migration;

class m_001_create_migration_table extends Migration
{
    public function up()
    {
        $sql = 'CREATE TABLE migrations (
            id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255) NOT NULL UNIQUE
          )';

        $this->run($sql);
    }

    public function down()
    {
        $this->run('DROP TABLE migrations');
    }
}
