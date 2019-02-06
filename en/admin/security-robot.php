<title>WebCOP Firewall Administration Panel</title>
<meta name="robots" content="noindex">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
error_reporting(0);
session_start();
if(!file_exists("../wcp_config.php")){
	header('Location: ../install');
}
require_once __DIR__ . '/../wcp_config.php';
require_once __DIR__ . '/../lib/ip_al.php';
ini_set('session.cookie_httponly', 1);
// giris kontrol

if($_SESSION['wcpacp'] != "wcp-".$ip_adresi){
header('Location: index.php');
}else{
	
$uisorgu = $dbbaglan->query('SELECT * FROM ayar', PDO::FETCH_ASSOC);
if ( $uisorgu->rowCount() ){
foreach( $uisorgu as $ayartbl ){
// version kontrol - version check
if(file_get_contents("https://webcop.org/wcpfirewall/version.php")){
$wcpver = "V1";
if($wcpver != file_get_contents("https://webcop.org/wcpfirewall/version.php")){
echo "<script>var guncel = 'Your software is not up to date! You should update to latest version as soon as possible.'; alert(guncel);</script>";	
}
}
echo '
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>WebCOP Firewall Administration Panel</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="ltemp/html5shiv.min.js"></script>
  <script src="ltemp/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">

    <!-- Logo -->
    <a href="" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>W</b>CP</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Web</b>COP</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Navigasyon</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
        
          <!-- Notifications: style can be found in dropdown.less -->
         
          <!-- Tasks: style can be found in dropdown.less -->
        
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs">
			 </span>
            </a>
          </li>
          <!-- Control Sidebar Toggle Button -->
        </ul>
      </div>

    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>'.strip_tags($ayartbl['adminadsoyad']).'</p>
          <a href="//'.strip_tags($_SERVER['SERVER_NAME']).'"><i class="fa fa-circle text-success"></i> '.strip_tags($_SERVER['SERVER_NAME']).'</a>
        </div>
      </div>
      <!-- search form -->

      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Navigation</li>
        
		  <li>
          <a href="index.php">
            <i class="fa fa-home"></i> <span>Main Page</span>
          
          </a>
        </li>

		 <li class="treeview">
          <a href="#">
            <i class="fa fa-shield"></i> <span>Security</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="mirror-protection.php"><i class="fa fa-circle-o"></i>Mirror - Zone Protection</a></li>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Attacker Detecting
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="flood-attacks.php"><i class="fa fa-circle-o"></i> Flooding Attacks</a></li>
                <li><a href="attack-attempts.php"><i class="fa fa-circle-o"></i> Attacking Attempts</a></li>
              </ul>
            </li>
            <li><a href="block-attacker.php"><i class="fa fa-circle-o"></i> Blocking Attacker</a></li>
			<li><a href="webshell-scanner.php"><i class="fa fa-circle-o"></i> Webshell Scanner</a></li>
			<li><a href="homepage-security.php"><i class="fa fa-circle-o"></i> Anasayfa Güvenliği</a></li>
			<li><a href="security-robot.php"><i class="fa fa-circle-o"></i> Security Robot</a></li>
          </ul>
        </li>
		
				 <li class="treeview">
          <a href="#">
            <i class="fa fa-star"></i> <span>Extra</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="url-redirecting.php"><i class="fa fa-circle-o"></i>URL Yönlendirme</a></li>
            <li><a href="maintenance-mode.php"><i class="fa fa-circle-o"></i>Maintenance Mode</a></li>
			<li><a href="have-i-been-hacked.php"><i class="fa fa-circle-o"></i>Have I Been Hacked?</a></li>
          </ul>
        </li>
		
        <li>
          <a href="https://infinitumit.com.tr">
            <i class="fa fa-envelope"></i> <span>Support</span>
          
          </a>
        </li>
        
    
        <li><a href="https://www.cybermagonline.com"><i class="fa fa-book"></i> <span>Cyber Security Magazine</span></a></li>
        <li class="header">WebCOP Firewall</li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Security Robot
      </h1>
      
    </section>

    <!-- Main content -->
   
   
   
   
   
   
   
   
   
   
   <section class="content">
  
  <center>		  
  <div style="width: 70%" class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Security Robot</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Küçült">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Kapat">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div style="text-align: left; margin-left: 10px;" class="box-body">
		<form action="" method="post">
		<li>Security Robot can create php.ini file and change permissions of configuration files for better security.<br>
		<li>Gives chmod 0440 to wp-config.php, config.php, settings.php, init.php, sql.php, db.php, sql_connect.php, db_connect.php, options.php, configuration.php, ayar.php, ayarlar.php, connect.php, baglan.php, veritabani.php, database.php, wcp_config.php files.
		<br>
		<li>Aşağıdaki alana gerekli işlemlerin yapılacağı dizini girin. Enter the path that you will work on. If you dont want to set chmod settings, you may tick the option below.
		<br><br>
<center><input type="text" name="dizin" class="form-control" style="width: 40%" value="'.htmlspecialchars($_SERVER['DOCUMENT_ROOT']).'"><br>
<div class="form-group">
<div class="custom-control custom-checkbox">
      <input name="nochmod" type="checkbox" class="custom-control-input" id="customCheck1">
      <label class="custom-control-label" for="customCheck1">Dont set the chmod settings.</label>
    </div>
		<input name="calistir" type="submit" style="width: 40%" class="btn bg-purple btn-flat margin" value="Run the Robot"><br>
		';
		if($_POST['calistir'] and $_POST['csrftoken'] == $_SESSION['csrftoken']){		
$dizincek = $_POST['dizin'];
$ini = fopen($dizincek.'/php.ini', 'a');
$icerik = 
"\ndisabled_functions=symlink,system,shell_exec,exec,popen,passthru,proc_open,readfile,eval\nallow_url_include=Off\nexpose_php=Off\ndisplay_errors=Off\n";
$yazdir = fwrite($ini, $icerik);
fclose($ini);	
if(!$_POST['nochmod']){
		$izin = array($dizincek."/wp-config.php", $dizincek."/config.php", $dizincek."/settings.php", $dizincek."/init.php", $dizincek."/sql.php", $dizincek."/db.php", $dizincek."/sql_connect.php", $dizincek."/db_connect.php", $dizincek."/options.php", $dizincek."/configuration.php", $dizincek."/ayar.php", $dizincek."/ayarlar.php", $dizincek."/connect.php", $dizincek."/baglan.php", $dizincek."/veritabani.php", $dizincek."/database.php");
foreach($izin as $v) {
	if(file_exists($v)){
		$permver = chmod($v, 0440);
		}
	}
		if($permver and $ini and $yazdir){
echo 'Process completed <b><font color="green">successfully.</font></b>';	
}else{
echo 'An unknown <b><font color="red">error</font></b> is occured.';
}	
	
}else{
	if($ini and $yazdir){
echo 'Process completed <b><font color="green">successfully.</font></b>';	
}else{
echo 'An unknown <b><font color="red">error</font></b> is occured.';
}	
}

		}else{
		$_SESSION['csrftoken'] = md5(rand());	
		echo '<input type="hidden" name="csrftoken" value="'.$_SESSION['csrftoken'].'">';		
		}
		echo '
		</div></center>
		</div>
        <!-- /.box-body -->
        <!-- /.box-footer-->
      </div></center></form>
 
  
    </section>
   
   
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      V<b>1</b>
    </div>
    <strong>Copyright &copy; 2019 <a href="https://infinitumit.com.tr">InfinitumIT - Power of Integrated Security.</a></strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->

  <!-- /.control-sidebar -->
  <!-- Add the sidebar\'s background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- Sparkline -->
<script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap  -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS -->
<script src="bower_components/Chart.js/Chart.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard2.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>

';
}
}
}