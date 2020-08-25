<?php
namespace Zikzay\Database;


class Migration_200818_113508 extends Migration {

    public function up() { 

        $this->createTable("paystack", "id", "INT NOT NULL ", " AUTO_INCREMENT");
        $this->addColumn("paystack", "reference", "VARCHAR(255) NOT NULL ");
        $this->addColumn("paystack", "confirm", "INT NOT NULL ");
        $this->addColumn("paystack", "amount", "INT NOT NULL ");
        $this->addColumn("paystack", "created_at", "TIMESTAMP  NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $this->addColumn("paystack", "updated_at", "TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");


    }
    
    public function down() { 
        
    }
}