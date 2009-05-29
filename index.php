<?
require_once( 'config_main.php' );

$EntArr  = array();
$query = "SELECT * FROM ent";
$result = mysql_query( $query ) or eu( __FILE__, __LINE__, $query );
while ( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) )
    $EntArr[$row['ent_id']] = $row;
    
unset ( $row );

if ( !isset ( $user_hash ) && isset( $_COOKIE['cookie_hash'] ) )
    $user_hash = $_COOKIE['cookie_hash'];

if ( isset ( $user_hash ) )
{
    $query = "SELECT * FROM user WHERE user_hash='" . mysql_real_escape_string( $user_hash ) . "'";
    $result = mysql_query( $query ) or eu( __FILE__, __LINE__, $query );
    $UA = mysql_fetch_array( $result, MYSQL_ASSOC );
    
    if ( isset ( $_POST ) && count ( $_POST ) && $UA )
    {
        $user_ent = ( is_array ( $user_ent ) ? implode ( ',', $user_ent ) : '' );
        $query = "
            UPDATE
        user
            SET
        user_confirm = 1,
        user_remarks    = '" . mysql_real_escape_string( $user_remarks ) . "',
        user_ent_real   = '" . mysql_real_escape_string( $user_ent ) . "',
        user_car_use    = '" . mysql_real_escape_string( isset ( $use_car ) && $use_car == 1 ? 1 : 2 ) . "'
            WHERE 
        user_id = '{$UA['user_id']}'
        ";
        $result = mysql_query( $query ) or eu( __FILE__, __LINE__, $query );
        
        $headers = 'From: Sergey&Igor <urod_i_hohol@vetko.net>' . "\r\n" .
'Reply-To: urod_i_hohol@vetko.net' . "\r\n" .
'Content-type: text/plain; charset=utf-8';

$message = '
Привет!

' . $UA['user_name'] . ' подтвердил(а) свое участие!'  . '

' . ( isset ( $use_car ) && $use_car == 1 ? 'Приедет НА машине ' : 'Приедет БЕЗ машины' ) . '

Подробности можно посмотреть на

' . $URL . 'admin.php

Пожелания пользователя:
=================

' . $user_remarks . '

=================


Спасибо.

   
';
       
         mail ( 'urod_i_hohol@vetko.net', $UA['user_name'] . ' подтвердил(а) свое участие!', $message, $headers );
        
        header( "Location: /?message=Изменения внесены, спасибо");
    }
    
    setcookie("cookie_hash", $UA['user_hash'], time()+3600*6000 ); 
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
 <head>
  <title> Фильм 26-й... </title>
  
  <style  type="text/css">
<!--
body {
 font-family: tahoma, verdana, arial, sans-serif; 
 margin: 0px;
 color: #FF0000;
 background-color: #000000;
}
.contentandstuff {
	padding: 10 40 0 40;
	background-color: #000000;
}
.top_menu {
	background-color: #000000;
}
.topbox {
	background-color: #000000;
	color: #FF0000;
	font-size: 1.5em;
	text-transform: uppercase;
}
h1 {
	color: #FF0000;
	text-transform: bold;
	font-size: 1.2em;
	margin-bottom: 0px;
	margin-top: 8px;
}
.toplink {
	color: 999999;
	padding-right: 5px;
	padding-left: 5px;
	border-right: 1px solid #999999;
}
.toplink:hover {
	color: #CCFF00;
}
.line {
	border-bottom: 1px solid #999999;
	margin: 0px;
	padding-left: 20px;
}
a {
	color: #0000CC;
	text-decoration: none;
}
a:hover {
	color: #FFFFFF;
	text-decoration: none;
}
p.text {
	margin: 0px;
	padding-left: 5px;
}
.style1 {color: #C1FF64}
-->
    </style>
  
  <meta name="Author" content="">
  <meta name="Keywords" content="Ветко Сергей Исайчев Игорь день рождения 26 лет">
  <meta name="Description" content="Ветко Сергей и Исайчев Игорь отмечают 52 на двоих!">
  <META http-equiv="content-type" content="text/html; charset=utf-8"> 
 </head>

 <body text="#000000" link="#0000CC" alink="#0000CC" vlink="#666666">

 <div style="padding-left: 30px;" class="top_menu">
	<a class="toplink" href="/">Домой</a>
<? if ( isset ( $_COOKIE['cookie_pass2009'] ) ): ?>
  <a href="admin.php" class="toplink">Админка</a>  
  <a href="admin.php?act=exit" class="toplink">Выйти</a> 
  <a href="admin.php?act=clear" class="toplink">Очистить куки</a>
 
 <? endif; ?>
	
</div>
 <br>
<br><br><br>
<table align="center" border="0" cellpadding="2" cellspacing="2" width="80">
<tr>
<td>

<div class="topbox" align="center" style="width:800px; text-align:center;">
	<img src="/images/new1.jpg" width="800" id="header_image" height="360"><br>
	 <div id="upper_text"></div>

</div>
<div class="line"></div>

<br />

<?= isset ( $message ) ? '<h1>'.$message.'</h1>' : '' ?>

<table class="contentandstuff" width="800" border="1" style="color:red; border: 1px solid red; border-collapse: collapse;">
<tr>
<td>
 
<?

if ( isset( $UA ) &&  $UA )
{
	if ( isset (  $UA['user_name'] ) )
		list ( $name, $fam ) = explode ( ' ', $UA['user_name'] ); 
?>

<div style=" background-color: #CCFF00; color: #333333; padding-left: 30px; border-bottom: 2px #000000 solid;"><b><? echo 'Здравствуйте, глубокоуважаемый' . ( isset ( $name ) ? ', ' . $name : '' )?>!</b></div>


<p class="text">
<img src="/images/cake2.jpg" width="102" height="96">
<!--<img src="/images/cake4.gif" width="325" height="225">-->
Мы, Ветко Сергей Александрович и Исайчев Игорь Владимирович, хотели бы пригласить Вас на торжественное мероприятие, посвященное отмечанию дней рождений двух вышеназванных господ.
<br>
<br>



<div class="line"></div>

<form name="form" method="POST" action="./index.php">

<table width="800" border="1" style="border-collapse:collapse;">
<tr>
<td width="300">Выбери мероприятие:</td>
<td>
<?

$arr_t_real  = array();
if ( $UA['user_ent_real'] )
    $arr_t_real = explode( ',', $UA['user_ent_real'] );
    
$arr_t  = array();
if ( $UA['user_ent'] )
    $arr_t = explode( ',', $UA['user_ent'] );

$query = "SELECT * FROM ent WHERE ent_id IN ('" . implode ( "','", $arr_t ) . "') ORDER BY ent_id";
$result = mysql_query( $query ) or eu( __FILE__, __LINE__, $query );
while ( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) )
{
?>

<input type="checkbox" name="user_ent[]" value="<?= $row['ent_id']?>"  <?= in_array( $row['ent_id'], $arr_t_real ) ? ' checked' : '' ?>>
<b><?= $row['ent_title']?></b>(<?= $row['ent_time_begin'] ?>)<br>
<span style="padding-left: 20px; margin-left: 20px;"><i><?= $row['ent_descr']?><i></span>

<div class="line"></div>

<?
}
?>
</td>
</tr>

<? if ( $UA['user_car_exist'] ): ?>
<tr>
<td>На машине?</td>
<td><input type="radio" name="use_car" value="1" <?= isset ( $UA['user_car_use'] ) && $UA['user_car_use'] == 1 ? 'checked' : '' ?>>Да<br>
<input type="radio" name="use_car" value="2" <?= isset ( $UA['user_car_use'] ) && $UA['user_car_use'] == 2 ? 'checked' : '' ?>>Нет<br>
</td>
</tr>
<? endif; ?>

<tr>
<td>Комментарии<br>
(время прибытия,<br> пожелания и т.п.)</td>
<td>
<textarea name="user_remarks" rows="8" cols="70"><?= htmlspecialchars( $UA['user_remarks'] )?></textarea>
</td>
</tr>

</table>

</form>
<script language="JavaScript">
<!--
function CheckForm()
{
    var ok = true;
    
    var obj = document.form.use_car;
    if ( obj )
    {
        ok = false;
        for ( var i = 0 ; i < obj.length; i++)
          if ( document.form.use_car[i].checked)
          {
             ok = true;
             break;
          }
    }
    
    if ( !ok )
    {
        alert ( 'Укажи, плиз, собираешься ли ты на машине или нет!' );
    }
    else
        document.form.submit();
}
//-->
</script>

<br>
<input type="button" value="Я буду!" onclick="CheckForm();">

</p>
	<br>
		
	
</td>
</tr>
</table>

<br />

</td>
</tr>
</table>

<?
}
else
{
    echo 'Чтобы просматривать эту страницу вы должны были получить письмо. Пройдите по ссылке из письма';
}



?>

<!--<div style="position:absolute;left:345px;top:140px;"><img src="/images/PartyDrink4.gif" width="161" height="231"></div>

<div style="position:absolute;left:638px;top:-5px;"><img src="/images/Party10.gif" width="74" height="120"></div>-->

<script language="JavaScript">
<!--


obj_img = document.getElementById('header_image');
obj_text = document.getElementById('upper_text');
function PreLoadNextImg( i )
{
    next_img = new Image();
    next_img.src = "/images/header"+i+".jpg";
    return true;
}

function SetImg( i )
{
	var texts = new Array();
	texts[0] = "";
	texts[1] = "Прошлым летом элитные бойцы";
	texts[2] = "Получили секретное задание";
	texts[3] = "Поздравить и уничтожить двух особо опасных";
	texts[4] = "и очень непристойных мерзавцев.";
	texts[5] = "Были использованы всевозможные способы";
	texts[6] = "Но злодеям удалось скрыться в неизвестном направлении";
	texts[7] = "Только в этом июне! Они возвращаются!";
	texts[8] = "Этому должен быть положен конец!";
//	texts[9] = "Раз и навсегда!";
	texts[9] = "Ищите в боулинге вашего города!";
	texts[10] = "Самое значимое событие этого года!";
	
	//    alert ( 'next_img = ' + next_img.src );
        obj_img.src = "/images/new"+i+".jpg";
        obj_text.innerHTML = texts[i];
//    obj_img.src = "/images/header2.jpg";
//    alert ( 'obj_img = ' + obj_img.src );
}


var i = 2;
while ( i < 8 )
{
    PreLoadNextImg ( i );
    i++;
}
   
var steps = new Array();
steps[steps.length] = "SetImg(1);";
steps[steps.length] = "SetImg(2);";
steps[steps.length] = "SetImg(3);";
steps[steps.length] = "SetImg(4);";
steps[steps.length] = "SetImg(5);";
steps[steps.length] = "SetImg(6);";
steps[steps.length] = "SetImg(7);";

steps[steps.length] = "SetImg(8);";
steps[steps.length] = "SetImg(9);";
steps[steps.length] = "SetImg(10);";

    


var currentStep = 0;
var cycles = 0;
function execute()
{
    
    /*alert ( currentStep);
    alert ( 'len = ' + steps.length );*/
    if (currentStep == steps.length )
    { 
        if ( cycles < 10 )
        {
            currentStep = 0;
            cycles++
        }
        else
        {
            return;
        }
        
    }
//    return;
    
    window.eval(steps[currentStep]);
    currentStep++;
    
    var time = 2500;
    
    if ( currentStep >= 8 )
    	time = 1400;
    	
    if (currentStep == steps.length )	
    	time = 5000;
    
    window.setTimeout('execute()', time);
}

/*for ( var i = 0; i < 10; i ++ )
{
    currentStep = 0;*/
    execute();
//}

//-->
</script>

 </body>
</html>
