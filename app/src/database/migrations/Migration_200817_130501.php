<?php
namespace Zikzay\Database;


class Migration_200817_130501 extends Migration {

    public function up() { 

        $this->createTable("products", "id", "INT NOT NULL ", " AUTO_INCREMENT");
        $this->addColumn("products", "name", "VARCHAR(255) NOT NULL ");
        $this->addColumn("products", "category", "VARCHAR(255) NOT NULL ");
        $this->addColumn("products", "unit", "VARCHAR(255) NOT NULL ");
        $this->addColumn("products", "cost", "INT NOT NULL ");
        $this->addColumn("products", "delivery", "INT NOT NULL ");
        $this->addColumn("products", "created_at", "TIMESTAMP  NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $this->addColumn("products", "updated_at", "TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");

        $this->createTable("purchase", "id", "INT NOT NULL ", " AUTO_INCREMENT");
        $this->addColumn("purchase", "order_id", "INT NOT NULL ");
        $this->addColumn("purchase", "products", "TEXT NOT NULL ");
        $this->addColumn("purchase", "amount", "INT NOT NULL ");
        $this->addColumn("purchase", "refernce", "VARCHAR(255) NOT NULL ");
        $this->addColumn("purchase", "order_status", "INT NOT NULL ");
        $this->addColumn("purchase", "created_at", "TIMESTAMP  NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $this->addColumn("purchase", "updated_at", "TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");


    }
    
    public function down() { 
        
    }
}