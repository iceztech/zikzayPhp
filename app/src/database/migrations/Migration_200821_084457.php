<?php
namespace Zikzay\Database;


class Migration_200821_084457 extends Migration {

    public function up() { 

        $this->createTable("students", "id", "INT NOT NULL ", " AUTO_INCREMENT");
        $this->addColumn("students", "reg_no", "VARCHAR(255) NOT NULL ");
        $this->addColumn("students", "firstname", "VARCHAR(255) NOT NULL ");
        $this->addColumn("students", "surname", "VARCHAR(255) NOT NULL ");
        $this->addColumn("students", "middlename", "VARCHAR(255) NOT NULL ");
        $this->addColumn("students", "phone", "VARCHAR(255) NOT NULL ");
        $this->addColumn("students", "email", "VARCHAR(255) NOT NULL ");
        $this->addColumn("students", "passwoed", "VARCHAR(255) NOT NULL ");
        $this->addColumn("students", "created_at", "TIMESTAMP  NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $this->addColumn("students", "updated_at", "TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");


    }
    
    public function down() { 
        
    }
}