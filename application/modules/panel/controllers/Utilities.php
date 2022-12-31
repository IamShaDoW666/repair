<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Utilities extends Auth_Controller {

    private $mLatestSqlFile;
    private $mBackupSqlFiles;

    public function __construct()
    {
        parent::__construct();
        $sql_path = FCPATH.'sql';
        $files = preg_grep("/.(.sql)$/", scandir($sql_path.'/backup', SCANDIR_SORT_DESCENDING));
        $this->mBackupSqlFiles = $files;
        $this->mLatestSqlFile = $sql_path.'/latest.sql';
        $this->mPageTitle = lang('database_utility');
        $this->data['backup_sql_files'] = $this->mBackupSqlFiles;
        $this->data['latest_sql_file'] = $this->mLatestSqlFile;
    }

    public function index()
    {
        $this->repairer->checkPermissions();
        if (DEMO) {
            $this->session->set_flashdata('error', "Disabled in Demo");
            redirect("panel");
        }
        redirect('panel/utilities/list_db');
    }
    public function list_db()
    {
        if (DEMO) {
            $this->session->set_flashdata('error', "Disabled in Demo");
            redirect("panel");
        }
        $this->repairer->checkPermissions('index');
        $this->render('util/list_db');
    }
    

    // Backup current database version
    public function backup_db()
    {
        if (DEMO) {
            $this->session->set_flashdata('error', "Disabled in Demo");
            redirect("panel");
        }
        $this->repairer->checkPermissions();
        $this->load->dbutil();
        $this->load->helper('file');

        $prefs = array('format' => 'txt');
        $backup = $this->dbutil->backup($prefs);
        $file_path_1 = FCPATH.'sql/backup/'.date('d.m.Y_h-i-s').'.sql';
        $result_1 = write_file($file_path_1, $backup);
        
        // overwrite latest.sql
        $save_latest = $this->input->get('save_latest');
        if ( !empty($save_latest) )
        {
            $file_path_2 = FCPATH.'sql/latest.sql';
            $result_2 = write_file($file_path_2, $backup);  
        }

         $this->settings_model->addLog('backup', 'database', 0, json_encode(array(
            'path' => $file_path_1,
        )));
        redirect('panel/utilities/list_db');
    }

    // Restore specific version of database
    public function restore_db($file)
    {
        $this->repairer->checkPermissions();

        if (DEMO) {
            $this->session->set_flashdata('error', "Disabled in Demo");
            redirect("panel");
        }
        $path = '';
        if ($file=='latest')
            $path = FCPATH.'sql/latest.sql';
        else if ( in_array($file, $this->mBackupSqlFiles) )
            $path = FCPATH.'sql/backup/'.$file;

        // proceed to execute SQL queries
        if ( !empty($path) && file_exists($path) )
        {
            $sql = file_get_contents($path);
            $sqls = explode(';', $sql);
            array_pop($sqls);
            foreach($sqls as $statement){
                $statment = $statement . ";";
                $this->db->query($statement);    
            }
            
        }

         $this->settings_model->addLog('restore', 'database', 0, json_encode(array(
            'path' => $path,
        )));
        redirect('panel/utilities/list_db');
    }

    // Remove specific database version
    public function remove_db($file)
    {   
        $this->repairer->checkPermissions();
        if (DEMO) {
            $this->session->set_flashdata('error', "Disabled in Demo");
            redirect("panel");
        }
        if ( in_array($file, $this->mBackupSqlFiles) )
        {
            $path = FCPATH.'sql/backup/'.$file;

            $this->load->helper('file');
            unlink($path);
            $result = delete_files($path);
        }

         $this->settings_model->addLog('remove', 'database', 0, json_encode(array(
            'path' => $path,
        )));
        redirect('panel/utilities/list_db');
    }

}