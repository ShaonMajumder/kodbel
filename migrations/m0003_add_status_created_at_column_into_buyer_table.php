<?php

class m0003_add_status_created_at_column_into_buyer_table {
    public function up()
    {
        $db = \thecodeholic\phpmvc\Application::$app->db;
        $db->pdo->exec("ALTER TABLE buyer ADD COLUMN status TINYINT DEFAULT NULL");
        $db->pdo->exec("ALTER TABLE buyer ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
    }

    public function down()
    {
        $db = \thecodeholic\phpmvc\Application::$app->db;
        $db->pdo->exec("ALTER TABLE buyer DROP COLUMN status TINYINT DEFAULT NULL");
        $db->pdo->exec("ALTER TABLE buyer DROP COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
    }
}