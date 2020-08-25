<?php
namespace Zikzay\Database;


class Migration_200821_101926 extends Migration {

    public function up() { 
        $this->createTable("departments", "id", "INT NOT NULL ", " AUTO_INCREMENT");
        $this->addColumn("departments", "name", "VARCHAR(255) NOT NULL ");
        $this->addColumn("departments", "code", "VARCHAR(255) NOT NULL ");
        $this->addColumn("departments", "serial", "INT NOT NULL ");
        $this->addColumn("departments", "created_at", "TIMESTAMP  NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $this->addColumn("departments", "updated_at", "TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");

        $this->createTable("faculty", "id", "INT NOT NULL ", " AUTO_INCREMENT");
        $this->addColumn("faculty", "name", "VARCHAR(255) NOT NULL ");
        $this->addColumn("faculty", "code", "VARCHAR(255) NOT NULL ");
        $this->addColumn("faculty", "serial", "INT NOT NULL ");
        $this->addColumn("faculty", "created_at", "TIMESTAMP  NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $this->addColumn("faculty", "updated_at", "TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");


    }
    
    public function down() { 
        
    }
}