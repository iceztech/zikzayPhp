<?php
namespace Zikzay\Database;


class Migration_200821_101727 extends Migration {

    public function up() { 

        $this->createTable("student_department", "id", "INT NOT NULL ", " AUTO_INCREMENT");
        $this->addColumn("student_department", "student", "INT NOT NULL ");
        $this->addColumn("student_department", "department", "INT NOT NULL ");
        $this->addColumn("student_department", "created_at", "TIMESTAMP  NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $this->addColumn("student_department", "updated_at", "TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");


    }
    
    public function down() { 
        
    }
}