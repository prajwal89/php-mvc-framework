<?php

namespace App\Migrations;

use App\Core\MigrationBase;

class m_002_create_users_table extends MigrationBase
{
    public function up()
    {
        $sql = 'CREATE TABLE users (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );';

        $this->run($sql);
    }

    public function down()
    {
        $this->run('DROP TABLE users');
    }
}
