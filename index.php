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
  <title> Наш день рождения! </title>
  <meta name="Generator" content="EditPlus">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <META http-equiv="content-type" content="text/html; charset=utf-8"> 
 </head>

 <body>

 <? if ( isset ( $_COOKIE['cookie_pass'] ) ): ?>
  <a href="index.php">Главная страница</a> | <a href="admin.php">Админка</a>  | <a href="admin.php?act=exit">Выйти</a> | <a href="admin.php?act=clear">Очистить куки</a>  <br>
 <?= isset ( $message ) ? '<h1 style="color:red;">'.$message.'</h1>' : '' ?>
 <? endif; ?>
 
 
<?

if ( isset( $UA ) &&  $UA )
{

    echo 'Привет' . ( isset ( $UA['user_name'] ) ? ', ' . $UA['user_name'] : '' );
?>

<?= isset ( $message ) ? '<h1 style="color:red;">'.$message.'</h1><br>' : '' ?>

<br>
Нам очень надо знать, куда и во сколько ты собираешься приехать, чтобы вручить нам подарок.
Для этого надо будет выбрать варианты ниже:

<form name="form" method="POST" action="./">

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
<span title="<?= $row['ent_descr']?>">
<?= $row['ent_title']?>(<?= $row['ent_time_begin'] ?>)</span><br>

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

<?
}
else
{
    echo 'Чтобы просматривать эту страницу вы должны были получить письмо. Пройдите по ссылке из письма';
}



?>

 </body>
</html>
