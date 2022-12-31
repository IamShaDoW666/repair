<?php

/************************************
*   @author       Usman Sher        *
*   @package      LMSn              *
*   @subpackage   install           *
************************************/

$installFile = "../RMS";
$indexFile = "../index.php";
$configFolder = "../application/config";
$configFile = "../application/config/config.php";
$dbFile = "../application/config/database.php";
if (is_file($installFile)) { 

  $step = isset($_GET['step']) ? $_GET['step'] : '';
  switch ($step) {
    default: ?>
    <ul class="steps">
      <li class="active pk">Checklist</li>
      <li>Verify</li>
      <li>Database</li>
      <li>Site Config</li>
      <li class="last">Done!</li>
    </ul>
    <h3>Pre-Install Checklist</h3>
    <?php 
    $error = FALSE;
    if(!is_writeable($indexFile)){$error = TRUE; echo "<div class='alert alert-error'><i class='icon-remove'></i> Index Filer (index.php) is not writeable!</div>"; }
    if(!is_writeable($configFolder)){$error = TRUE; echo "<div class='alert alert-error'><i class='icon-remove'></i> Config Folder (app/config/) is not writeable!</div>"; }
    if(!is_writeable($configFile)){$error = TRUE; echo "<div class='alert alert-error'><i class='icon-remove'></i> Config File (app/config/config.php) is not writeable!</div>"; }
    if(!is_writeable($dbFile)){$error = TRUE; echo "<div class='alert alert-error'><i class='icon-remove'></i> Database File (app/config/production/database.php) is not writeable!</div>"; }
    if(phpversion() < "5.3"){$error = TRUE; echo "<div class='alert alert-error'><i class='icon-remove'></i> Your PHP version is ".phpversion()."! PHP 5.3 or higher required!</div>";}else{echo "<div class='alert alert-success'><i class='icon-ok'></i> You are running PHP ".phpversion()."</div>";} 
    if(!extension_loaded('mysqli')){$error = TRUE; echo "<div class='alert alert-error'><i class='icon-remove'></i> Mysqli PHP extension missing!</div>";}else{echo "<div class='alert alert-success'><i class='icon-ok'></i> Mysqli PHP extension loaded!</div>";}
    if(!extension_loaded('mbstring')){$error = TRUE; echo "<div class='alert alert-error'><i class='icon-remove'></i> MBString PHP extension missing!</div>";}else{echo "<div class='alert alert-success'><i class='icon-ok'></i> MBString PHP extension loaded!</div>";}
    if(!extension_loaded('gd')){$error = TRUE; echo "<div class='alert alert-error'><i class='icon-remove'></i> GD PHP extension missing!</div>";}else{echo "<div class='alert alert-success'><i class='icon-ok'></i> GD PHP extension loaded!</div>";}
    if(!extension_loaded('curl')){$error = TRUE; echo "<div class='alert alert-error'><i class='icon-remove'></i> CURL PHP extension missing!</div>";}else{echo "<div class='alert alert-success'><i class='icon-ok'></i> CURL PHP extension loaded!</div>";}
    ?>      
    <div class="bottom">
      <?php if($error){ ?>
      <a href="#" class="btn btn-primary disabled">Next Step</a>
      <?php }else{ ?>
      <a href="<?=$base_url;?>index.php?step=1" class="btn btn-primary">Next Step</a>
      <?php } ?>
    </div>

    <?php
    break;
  case "1": ?>
  <ul class="steps">
    <li class="ok"><i class="icon icon-ok"></i>Checklist</li>
    <li class="ok"><i class="icon icon-ok"></i>Verify</li>
    <li class="active">Database</li>
    <li>Site Config</li>
    <li class="last">Done!</li>
  </ul>
  <h3>Database Config</h3>
  <p>If the database does not exist the system will try to create it.</p>
  <form action="<?=$base_url;?>index.php?step=2" method="POST" class="form-horizontal">
    <div class="control-group">
      <label class="control-label" for="dbhost">Database Host</label>
      <div class="controls">
        <input id="dbhost" type="text" name="dbhost" class="input-large" required data-error="DB Host is required" placeholder="DB Host" value="localhost" />
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="dbusername">Database Username</label>
      <div class="controls">
        <input id="dbusername" type="text" name="dbusername" class="input-large" required data-error="DB Username is required" placeholder="DB Username" />
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="dbpassword">Database Password</a></label>
      <div class="controls">
        <input id="dbpassword" type="password" name="dbpassword" class="input-large" data-error="DB Password is required" placeholder="DB Password" />
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="dbname">Database Name</label>
      <div class="controls">
        <input id="dbname" type="text" name="dbname" class="input-large" required data-error="DB Name is required" placeholder="DB Name" />
      </div>
    </div>
    
    <div class="bottom">
      <input type="submit" class="btn btn-primary" value="Next Step"/>
    </div>
  </form>
  <?php 
  break;
  case "2":
  ?>
  <ul class="steps">
    <li class="ok"><i class="icon icon-ok"></i>Checklist</li>
    <li class="ok"><i class="icon icon-ok"></i>Verify</li>
    <li class="active">Database</li>
    <li>Site Config</li>
    <li class="last">Done!</li>
  </ul>
  <h3>Saving database config</h3>
  <?php
  if($_POST){
    $dbhost = $_POST["dbhost"];
    $dbusername = $_POST["dbusername"];
    $dbpassword = $_POST["dbpassword"];
    $dbname = $_POST["dbname"];
    $link = new mysqli($dbhost, $dbusername, $dbpassword);
    if (mysqli_connect_errno()) {
        echo "<div class='alert alert-error'><i class='icon-remove'></i> Could not connect to MYSQL!</div>";
    } else {
        echo '<div class="alert alert-success"><i class="icon-ok"></i> Connection to MYSQL successful!</div>';
        $db_selected = mysqli_select_db($link, $dbname);
        if (!$db_selected) {
            if (!mysqli_query($link, "CREATE DATABASE IF NOT EXISTS `$dbname`")) {
                echo "<div class='alert alert-error'><i class='icon-remove'></i> Database " . $dbname . " does not exist and could not be created. Please create the Database manually and retry this step.</div>";
                return FALSE;
            } else {
                echo "<div class='alert alert-success'><i class='icon-ok'></i> Database " . $dbname . " created</div>";
            }
        }
        mysqli_select_db($link, $dbname);
      
      require_once('includes/core_class.php');
      $core = new Core();
      $dbdata = array(
        'hostname' => $dbhost,
        'username' => $dbusername,
        'password' => $dbpassword,
        'database' => $dbname
        );
      
      if ($core->write_database($dbdata) == false) {
        echo "<div class='alert alert-error'><i class='icon-remove'></i> Failed to write database details to ".$dbFile."</div>";
      } else { 
        echo "<div class='alert alert-success'><i class='icon-ok'></i> Database config written to the database file.</div>"; 
      }
      
    }
  } else { echo "<div class='alert alert-success'><i class='icon-question-sign'></i> Nothing to do...</div>"; }
  ?>
  <div class="bottom">
    
    <form action="<?=$base_url;?>index.php?step=3" method="POST" class="form-horizontal">
      <input id="submit" type="hidden" name="username" value="ok" />
      <input id="submit" type="hidden" name="dbhost" value="<?php echo $_POST["dbhost"]; ?>" />
      <input id="submit" type="hidden" name="dbusername" value="<?php echo $_POST["dbusername"]; ?>" />
      <input id="submit" type="hidden" name="dbpassword" value="<?php echo $_POST["dbpassword"]; ?>" />
      <input id="submit" type="hidden" name="dbname" value="<?php echo $_POST["dbname"]; ?>" />
      <input id="submit" type="hidden" name="username" value="ok" />
      <input type="submit" class="btn btn-primary pull-right" value="Next Step">
    </form>
    <br clear="all">
  </div>
  <?php
  break;
  case "3":
  ?>
  <ul class="steps">
    <li class="ok"><i class="icon icon-ok"></i>Checklist</li>
    <li class="ok"><i class="icon icon-ok"></i>Verify</li>
    <li class="ok"><i class="icon icon-ok"></i>Database</li>
    <li class="active">Site Config</li>
    <li class="last">Done!</li>
  </ul>
  <h3>Site Config</h3>
  <?php if($_POST){ ?>
  <form action="<?=$base_url;?>index.php?step=4" method="POST" class="form-horizontal">
    <div class="control-group">
      <label class="control-label" for="domain">Base URL</label>
      <div class="controls">
        <input type="text" id="domain" name="domain" class="xlarge" required data-error="Base URL is required" value="<?php echo "http://".$_SERVER["SERVER_NAME"].substr($_SERVER["REQUEST_URI"], 0, -24); ?>" />
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="domain">SECRET KEY</label>
      <div class="controls">
        <?php $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; ?>
        <input type="text" id="enckey" name="enckey" class="xlarge" required data-error="SECRET KEY is required" value="<?php echo substr(str_shuffle($characters), 25); ?>" />
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="domain">Your Timezone</a></label>
      <div class="controls">
        <?php 
        $timezones = DateTimeZone::listIdentifiers();
        echo '<select name="timezone" required="required" data-error="TimeZone is required">';
        foreach ($timezones as $tz){
          echo '<option value="'.$tz.'">'.$tz.'</option>';
        }
        echo '</select>'; ?>
      </div>
    </div>    
      <input id="submit" type="hidden" name="username" value="ok" />
      <input id="submit" type="hidden" name="username" value="ok" />
      <input id="submit" type="hidden" name="dbhost" value="<?php echo $_POST["dbhost"]; ?>" />
      <input id="submit" type="hidden" name="dbusername" value="<?php echo $_POST["dbusername"]; ?>" />
      <input id="submit" type="hidden" name="dbpassword" value="<?php echo $_POST["dbpassword"]; ?>" />
      <input id="submit" type="hidden" name="dbname" value="<?php echo $_POST["dbname"]; ?>" />
    <div class="bottom">
      <a href="index.php?step=2" class="btn pull-left">Previous Step</a>
      <input type="submit" class="btn btn-primary" value="Next Step"/>
    </div>
  </form>
  
  <?php }
  break;
  case "4":
  ?>
  <ul class="steps">
    <li class="ok"><i class="icon icon-ok"></i>Checklist</li>
    <li class="ok"><i class="icon icon-ok"></i>Verify</li>
    <li class="ok">Database</li>
    <li class="active">Site Config</li>
    <li class="last">Done!</li>
  </ul>
  <h3>Saving site config</h3>
  <?php
  if($_POST){
    $domain = $_POST['domain'];
    $enckey = $_POST['enckey'];
    $timezone = $_POST['timezone'];

    require_once('includes/core_class.php');
    $core = new Core();
    
    if ($core->write_config($domain, $enckey) == false) {
      echo "<div class='alert alert-error'><i class='icon-remove'></i> Failed to write config details to ".$configFile."</div>";
    } elseif ($core->write_index($timezone) == false) {
      echo "<div class='alert alert-error'><i class='icon-remove'></i> Failed to write timezone details to ".$indexFile."</div>";
    } else { 
      echo "<div class='alert alert-success'><i class='icon-ok'></i> Config details written to the config file.</div>"; 
    }
    
    
  } else { echo "<div class='alert alert-success'><i class='icon-question-sign'></i> Nothing to do...</div>"; }
  ?>
  <div class="bottom">
    <form action="<?=$base_url;?>index.php?step=2" method="POST" class="form-horizontal">
      <input id="submit" type="hidden" name="username" value="ok" />
      <input id="submit" type="hidden" name="dbhost" value="<?php echo $_POST["dbhost"]; ?>" />
      <input id="submit" type="hidden" name="dbusername" value="<?php echo $_POST["dbusername"]; ?>" />
      <input id="submit" type="hidden" name="dbpassword" value="<?php echo $_POST["dbpassword"]; ?>" />
      <input id="submit" type="hidden" name="dbname" value="<?php echo $_POST["dbname"]; ?>" />
      <input type="submit" class="btn pull-left" value="Previous Step"/>
    </form>
    <form action="<?=$base_url;?>index.php?step=5" method="POST" class="form-horizontal">
      <input id="submit" type="hidden" name="username" value="ok" />
      <input id="submit" type="hidden" name="dbhost" value="<?php echo $_POST["dbhost"]; ?>" />
      <input id="submit" type="hidden" name="dbusername" value="<?php echo $_POST["dbusername"]; ?>" />
      <input id="submit" type="hidden" name="dbpassword" value="<?php echo $_POST["dbpassword"]; ?>" />
      <input id="submit" type="hidden" name="dbname" value="<?php echo $_POST["dbname"]; ?>" />
    
      <input type="submit" class="btn btn-primary pull-right" value="Next Step">
    </form>
    <br clear="all">
  </div>

  <?php
  break;
  case "5": ?>
  <ul class="steps">
    <li class="ok"><i class="icon icon-ok"></i>Checklist</li>
    <li class="ok"><i class="icon icon-ok"></i>Verify</li>
    <li class="ok"><i class="icon icon-ok"></i>Database</li>
    <li class="ok"><i class="icon icon-ok"></i>Site Config</li>
    <li  class="active">Done!</li>
  </ul>

  <?php if($_POST){
    
    define("BASEPATH", "install/");
    include("../application/config/database.php");
   
      $dbdata = array(
        'hostname' => $_POST["dbhost"],
        'username' => $_POST["dbusername"],
        'password' => $_POST["dbpassword"],
        'database' => $_POST["dbname"],
        'dbtables' => $object->database
        );
      require_once('includes/database_class.php');
      $database = new Database();
      if ($database->create_tables($dbdata) == false) {
        $finished = FALSE;
        echo "<div class='alert alert-warning'><i class='icon-warning'></i> The database tables could not be created, please try again.</div>";
      } else {
        $finished = TRUE;
        if(!@unlink('../RMS')){
          echo "<div class='alert alert-warning'><i class='icon-warning'></i> Please remove the LMS file from the main folder in order to lock the installer.</div>";
        }
        
      }

   
    
  } 
  if($finished) {
    ?>
    
    <h3><i class='icon-ok'></i> Installation completed!</h3>
    <div class="alert alert-info"><i class='icon-info-sign'></i> You can login now using the following credential:<br /><br />
      Username: <span style="font-weight:bold; letter-spacing:1px;">admin@admin.com</span><br />Password: <span style="font-weight:bold; letter-spacing:1px;">password</span><br /><br /></div>
      <div class="alert alert-warning"><i class='icon-warning-sign'></i> Please don't forget to change username and password.</div>
      <div class="bottom">
        <a href="<?php echo "http://".$_SERVER["SERVER_NAME"].substr($_SERVER["REQUEST_URI"], 0, -24); ?>/panel" class="btn btn-primary">Go to Login</a>
        <a href="<?php echo "http://".$_SERVER["SERVER_NAME"].substr($_SERVER["REQUEST_URI"], 0, -24); ?>" class="btn btn-primary">Go to Main Pgae</a>
      </div>
      
      <?php 
    }
  }

}else{
  echo "<div style='width: 100%; font-size: 10em; color: #757575; text-shadow: 0 0 2px #333, 0 0 2px #333, 0 0 2px #333; text-align: center;'><i class='icon-lock'></i></div><h3 class='alert-text text-center'>Installer is locked!<br><small style='color:#666;'>Please contact your developer/support.</small></h3>";
}
?>

