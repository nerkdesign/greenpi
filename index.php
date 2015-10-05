<?php
require_once('configuration.php');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN">
<HTML>
 <HEAD>
  <STYLE type="text/css">
        .titre{
        color:#FFFFFF;
        border-radius: 30px;
        background-color:#008A85;
        padding:5px;
        margin:20px;
        }
        .contenu{
        color:#000000;
        border-radius: 20px;
        background-color:#FFFFFF;
        padding:20px;
        margin:20px;
        }
        body{
        background-color:#E8E8E8;
        margin: auto;
        }

        a.action {
          background: #3498db;
          background-image: -webkit-linear-gradient(top, #3498db, #2980b9);
          background-image: -moz-linear-gradient(top, #3498db, #2980b9);
          background-image: -ms-linear-gradient(top, #3498db, #2980b9);
          background-image: -o-linear-gradient(top, #3498db, #2980b9);
          background-image: linear-gradient(to bottom, #3498db, #2980b9);
          -webkit-border-radius: 18;
          -moz-border-radius: 18;
          border-radius: 10px;
          text-shadow: 1px 1px 3px #666666;
          -webkit-box-shadow: 0px 1px 3px #666666;
          -moz-box-shadow: 0px 1px 3px #666666;
          box-shadow: 0px 1px 3px #666666;
          font-family: Arial;
          color: #ffffff;
          font-size: 12px;
          padding: 9px 20px 10px 20px;
          text-decoration: none;
        }

a.action:hover, a.action:focus, a.action:active, a.action:visited {
  background: #3cb0fd;
  background-image: -webkit-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -moz-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -ms-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -o-linear-gradient(top, #3cb0fd, #3498db);
  background-image: linear-gradient(to bottom, #3cb0fd, #3498db);
  text-decoration: none;
}
  </STYLE>
</HEAD>
<BODY>
<?php
if ($_GET['start_pompe']) {
shell_exec('gpio write '.$gpio_pompe.' 1');
}
if ($_GET['stop_pompe']) {
shell_exec('gpio write '.$gpio_pompe.' 0');
}
if ($_GET['start_lampe']) {
shell_exec('gpio write '.$gpio_lumiere.' 1');
}
if ($_GET['stop_lampe']) {
shell_exec('gpio write '.$gpio_lumiere.' 0');
}
?>

<div class="titre"><center><h1>GreenPi</h1></center></div>
<div class="contenu">
<center><img src="./img/plante.png" width=50px></center>
<h3>Temp&eacute;rature</h3><hr>
<?php
$temp = shell_exec("find /sys/bus/w1/devices/ -name '28-*' -exec cat {}/w1_slave \; | grep 't=' | cut -f2 -d= | awk '{print $1/1000}'");

if ($temp < 18) {
$temp = '<span style="color: blue;">'.$temp;
$message = "<span style='color: blue;'>Temperature trop Basse, baiser la ventillation ou temperature ambiante</span>";
} elseif ($temp > 26) {
$temp = '<span style="color: red;">'.$temp;
$message = "<span style='color: red;'>Temperature trop Haute, augmenter la ventillation ou temperature ambiante</span>";
} else {
$temp = '<span style="color: green;">'.$temp;
$message = "<span style='color: green;'>Temperature OK</span>";
}
echo '<img src="./img/thermometre.png" width="30px"> Temp&eacute;rature : '.$temp.' &deg;C</span><br/>';
echo $message;

?>
<br/>
<h3>Humidit&eacute;</h3><hr>
<?php
$humidite = shell_exec('gpio mode '.$gpio_humidite.' in && gpio read '.$gpio_humidite);
if ($humidite == 1)
{
$pompestate="<span style='color: red;'>La plante est s&egrave;che, activer la pompe &agrave; eau</span>";
}else {
$pompestate="<span style='color: green;'>La plante est humide, RAS</span>";
}

echo '<img src="./img/humidite.png" width="30px"> Humidit&eacute; : '.$pompestate;
?>
<h3>Eclairage</h3><hr>
<?php
$lumiere = shell_exec('gpio read '.$gpio_lumiere);
if ($lumiere == 0)
{
$lumstate="<span style='color: red;'>&eacute;teintes</span>";
}else {
$lumstate="<span style='color: green;'>allum&eacute;es</span>";
}

echo '<img src="./img/ampoule.png" width="30px"> Les lumi&egrave;res sont actuellement '.$lumstate;
echo '<br/><br/><center><a href="?start_lampe=true" class="action">Allumer la lumi&egrave;re</a>';
echo '<a href="?stop_lampe=true" class="action">Stop la lumi&egrave;re</a></center>';

echo '<h3>Pompe</h3><hr>';
$pompe = shell_exec('gpio read '.$gpio_pompe);
if ($pompe == 0)
{
$pompestate="<span style='color: red;'>&eacute;teinte</span>";
}else {
$pompestate="<span style='color: green;'>allum&eacute;e</span>";
}

echo '<img src="./img/pompe.png" width="30px"> La pompe est actuellement '.$pompestate;
echo '<br/><br/><center><a href="?start_pompe=true" class="action">Allumer la pompe</a>';
echo '<a href="?stop_pompe=true" class="action">Stop la pompe</a></center>';

?>
</div>
</BODY>
</HTML>
