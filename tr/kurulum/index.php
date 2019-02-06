<title>WebCOP Firewall - Kurulum</title>
<link rel="stylesheet" type="text/css" href="stil.css" />
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
<meta name="robots" content="noindex">
<body>
<div role="sayfa">
<?php
@session_start();
	
ini_set('display_errors', 1);
ini_set('log_errors', 1);
error_reporting(-1);
error_reporting(E_ALL);
	
	
if(file_exists("../wcp_config.php")){
die('<b>WebCOP Firewall</b> zaten kurulu, kurulumu tekrar gerçekleştiremezsiniz.');
}

$engelle = array("'", ";", '"', "\\", "<", ">");
$dizin = $_SERVER['DOCUMENT_ROOT'];
$siteurl = strip_tags(str_replace($engelle, "", $_SERVER['SERVER_NAME']));	
	
	
	 if(@$_POST['ilk']){
$sunucu = $_SESSION['sunucu'] = strip_tags(str_replace($engelle, "", $_POST['sunucu']));
$dbadi = $_SESSION['dbadi'] = strip_tags(str_replace($engelle, "", $_POST['dbadi']));
$dbkul = $_SESSION['dbkul'] = strip_tags(str_replace($engelle, "", $_POST['dbkul']));
$dbsif = $_SESSION['dbsif'] = strip_tags(str_replace($engelle, "", $_POST['dbsif']));
		 
try {
     $dbbagla = new PDO("mysql:host=$sunucu;dbname=$dbadi;charset=utf8", $dbkul, $dbsif);
} catch ( PDOException $e ){
    die('Veritabanıyla bağlantı kurulamadı.');
}	 

$_SESSION['ikinciadim'] = true; 
header("Location: ?s=2");

    }else{
		if(!@$_GET['s']){
		echo '
<b>WebCOP Firewall\'un</b> kurulumuna hoşgeldiniz. Yazılımın kurulabilmesi için lütfen aşağıdaki alanları doldurun.<br><br>
<form action="" method="post">
Veritabanı sunucusu:
<input type="text" value="localhost" class="form-control is-valid" name="sunucu" required><br>
Veritabanı adı:
<input type="text" class="form-control is-valid" name="dbadi" required><br>
Veritabanı kullanıcısı:
<input type="text" class="form-control is-valid" name="dbkul" required><br>
Veritabanı şifresi:
<input type="password" class="form-control is-valid" name="dbsif" required><br>
<center><input type="submit" class="btn btn-primary" name="ilk" value="Sonraki Adıma Geç"></center></form>';
		}
    }
	
	
	
if(@$_GET['s'] == "2" && @$_SESSION['ikinciadim']){
             echo '
Veritabanına bağlanıldı. Şimdi yönetici bilgilerini ve yazılım ayarlarını belirleyelim.<br><br>
<form action="" method="post">
Kullanıcı adı:
<input type="text" class="form-control is-valid" name="kadi" required><br>
Şifre:
<input type="password" class="form-control is-valid" name="sifre" required><br>
E-mail:
<input type="text" class="form-control is-valid" name="email" required><br>
Ad Soyad:
<input type="text" class="form-control is-valid" name="adsoyad" required><br>
Entegre Edilecek Yazılımın Bulunduğu Dizin:
<input type="text" value="'.$dizin.'" class="form-control is-valid" name="dizinent" required><br>
Firewall\'un Kurulacağı Dizin:
<input type="text" value="'.dirname(__DIR__).'" class="form-control is-valid" name="dizinwcp" required><br>
<center><input type="submit" class="btn btn-primary" name="son" value="Kurulumu Bitir"></center></form>';

if(@$_POST['son']){
$kadi = $_SESSION['kadi'] = strip_tags(str_replace($engelle, "", $_POST['kadi']));
$sifre = $_SESSION['sifre'] = md5(md5(strip_tags(str_replace($engelle, "", $_POST['sifre']))));
$email = $_SESSION['email'] = strip_tags(str_replace($engelle, "", $_POST['email']));
$adsoyad = $_SESSION['adsoyad'] = strip_tags(str_replace($engelle, "", $_POST['adsoyad']));
$dizinent = $_SESSION['dizinent'] = strip_tags(str_replace($engelle, "", $_POST['dizinent']));
$dizinwcp = $_SESSION['dizinwcp'] = strip_tags(str_replace($engelle, "", $_POST['dizinwcp']));
$wcpconffile = $_SESSION['wcpconffile'] = $dizinwcp."/wcp_config.php";
if(filter_var($email, FILTER_VALIDATE_EMAIL)){
$_SESSION['ucuncuadim'] = true; 
header("Location: ?s=3");
}else{
echo "<center><b>Gerçeli bir e-mail adresi girmediniz.</b></center>";
}
}
        

    
}
	
if(@$_GET['s'] == "3" && @$_SESSION["ucuncuadim"]){ 
	
$tasarim = '
<p style="text-align:center">&nbsp;<img height="147px" src="https://lh3.googleusercontent.com/SvWy5CygTEGjNaHXo8G3qXKez6rIev314KyvI6cLAwiCDZeaAchvanwOHyX-US2_iZSQN272gNE5xwdin8xK6bpqS-qYyIyEeK7pLSkB6cmvZzeDTTqaLiMVF-4nOoSZdaQEp0gcIg=w947-h430-no" width="324px" /></p>

<p style="text-align:center"><strong><span style="font-family:Courier New,Courier,monospace">Sitemiz şu an bakımdadır, l&uuml;tfen daha sonra tekrar ziyaret edin.</span></strong></p>

<p style="text-align:center"><strong><span style="color:#16a085"><span style="font-family:Courier New,Courier,monospace">WebCOP Firewall ile koruma altına alınmıştır.</span></span></strong></p>
';
	try {
    $dbbagla = new PDO("mysql:host=".$_SESSION['sunucu'].";dbname=".$_SESSION['dbadi'].";charset=utf8", $_SESSION['dbkul'], $_SESSION['dbsif']);
	$dbbagla->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbbagla->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);	
	$sorgu1 = $dbbagla->exec("CREATE TABLE ayar(adminkadi VARCHAR(50) NOT NULL , adminsifre VARCHAR(100) NOT NULL , adminemail VARCHAR(100) NOT NULL , adminadsoyad VARCHAR(100) NOT NULL , dizinent VARCHAR(300) NOT NULL , dizinwcp VARCHAR(300) NOT NULL , siteurl VARCHAR(100) NOT NULL ) CHARSET=utf8 COLLATE utf8_turkish_ci;");
	$sorgu2 = $dbbagla->prepare("insert into ayar (adminkadi, adminsifre, adminemail, adminadsoyad, dizinent, dizinwcp, siteurl)value(?, ?, ?, ?, ?, ?, ?)");
    $costur = $sorgu2->execute(array($_SESSION["kadi"], $_SESSION["sifre"], $_SESSION["email"], $_SESSION["adsoyad"], $_SESSION["dizinent"], $_SESSION["dizinwcp"], $siteurl));
    $sorgu3 = $dbbagla->exec("CREATE TABLE guvenlik(mirrorkorumasi INT(1) NOT NULL , saldirganizleme INT(1) NOT NULL , saldirgantespit INT(1) NOT NULL , anasayfaguvenligi INT(1) NOT NULL , urlyonlendir INT(1) NOT NULL , bakimmodu INT(1) NOT NULL ) CHARSET=utf8 COLLATE utf8_turkish_ci;");			
	$sorgu4 = $dbbagla->exec("insert into guvenlik (mirrorkorumasi, saldirganizleme, saldirgantespit, anasayfaguvenligi, urlyonlendir, bakimmodu)value('0', '0', '0', '0', '0', '0')");
	$sorgu5 = $dbbagla->exec("CREATE TABLE ipban(ip VARCHAR(100) NOT NULL , aciklama VARCHAR(100) NOT NULL  ) CHARSET=utf8 COLLATE utf8_turkish_ci;");
	$sorgu6 = $dbbagla->exec("CREATE TABLE ekstra(yeniurl VARCHAR(200) NOT NULL , bakimindex TEXT NOT NULL ) CHARSET=utf8 COLLATE utf8_turkish_ci;");	
	$sorgu7 = $dbbagla->exec("insert into ekstra (yeniurl, bakimindex)value('https://google.com', '".$tasarim."')");	
} catch ( Exception $e ){
     echo 'Bağlantı esnasında hata meydana geldi, firewall kurulumu iptal edildi: <br><br>';
     print $e->getMessage();
}	
if(!is_dir($_SESSION['dizinwcp'])){
mkdir($_SESSION['dizinwcp'], 0755, true);
}
$dizinolus = rename(dirname(__DIR__), $_SESSION['dizinwcp']);	
$dosya = fopen($_SESSION['wcpconffile'], "w");
$icerik = "<?php \n \$dbadi = '".$_SESSION['dbadi']."'; \n \$sunucu = '".$_SESSION['sunucu']."'; \n \$dbkul = '".$_SESSION['dbkul']."'; \n \$dbsif = '".$_SESSION['dbsif']."'; \n 
try {
     \$dbbaglan = new PDO('mysql:host='.\$sunucu.';dbname='.\$dbadi.';charset=utf8', \$dbkul, \$dbsif);
} catch ( PDOException \$e ){
    die('<h1>Veritabanıyla bağlantı kurulamadı.</h1>');
}";
$yazdir = fwrite($dosya, $icerik);
fclose($dosya);
rename("../admin", "../admin-".rand(11111111111, 99999999999));
	
if($dosya && $yazdir && $dizinolus){
	
die('
Kurulum başarıyla tamamlandı.<br><br>
Kurulum bittikten sonra ekstra güvenlik için /kurulum klasörünü silebilirsiniz.<br>
Admin paneli güvenlik nedeniyle rastgele isimlendirilmiştir. FTP\'den admin panelinizi öğrenebilirsiniz. <br>
Ayrıca, anasayfa güvenliğini sağlayan bileşenin aktif olabilmesi için, dakikada bir çalışan cron job eklenmelidir. Cron job eklenirken WebCOP firewall\'un kurulu olduğu dizine göre ayarlanmalıdır. Örnek komut:
<pre><b>php -q /home/user/public_html/wcp/lib/index-guvenligi.php</b></pre>
Ayrıca, başlangıçta tüm güvenlik ayarları kapalıdır, bunları admin panelinizden etkinleştirmeyi unutmayın.<br><br>
<center><b><a href="https://infinitumit.com.tr">InfinitumIT - Power of Integrated Security</a>
<br>
<a href="https://www.cybermagonline.com">CyberMag - Türkiye\'nin İlk Siber Güvenlik Dergisi</a>
<img src="https://webcop.org/wcpfirewall/wcp.php">
</b></center>
');
}else{
die('<b>Kritik Hata:</b> Firewall kurulamadı, beklenmedik bir hata oluştu!');	
}	
}

?>
</div>