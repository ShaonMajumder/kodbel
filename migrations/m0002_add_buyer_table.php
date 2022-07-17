<?php

class m0002_add_buyer_table {
    public function up()
    {
        $db = \thecodeholic\phpmvc\Application::$app->db;
        $SQL = "CREATE TABLE buyer (
                id BIGINT(20) AUTO_INCREMENT PRIMARY KEY,
                amount INT(10) NOT NULL,
                buyer VARCHAR(255) NOT NULL,
                receipt_id VARCHAR(20) NOT NULL,
                items VARCHAR(255) NOT NULL,
                buyer_email VARCHAR(50) NOT NULL,
                buyer_ip VARCHAR(20) NOT NULL,
                note TEXT,
                city VARCHAR(20) NOT NULL,
                phone VARCHAR(20) NOT NULL,
                hash_key VARCHAR(255) NOT NULL,
                entry_at DATE DEFAULT(CURRENT_DATE),
                entry_by INT(10),
                FOREIGN KEY (entry_by) REFERENCES users(id)
            )  ENGINE=INNODB;";
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = \thecodeholic\phpmvc\Application::$app->db;
        $SQL = "DROP TABLE buyer;";
        $db->pdo->exec($SQL);
    }
}





