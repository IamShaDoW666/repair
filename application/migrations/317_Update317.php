<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Update317 extends CI_Migration {

    public function up() {

        $this->dbforge->add_column('reparation', array(
            'invoice_sign' => array('type' => 'VARCHAR', 'constraint' => '250', 'null' => TRUE ),
        ));
    }

    public function down() { }

}
