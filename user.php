<?

if ( !isset ( $_COOKIE['cookie_pass2009'] ) || $_COOKIE['cookie_pass2009'] != 'just_pass' )
    header( "Location: admin.php?act=exit" );
require_once( 'config_main.php' );

if ( !isset( $todo ) )
{
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
 <head>
  <title> Редактирование пользователя! </title>
  <meta name="Generator" content="EditPlus">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <META http-equiv="content-type" content="text/html; charset=utf-8"> 
 </head>

 <body>
 <a href="index.php">Главная страница</a> | <a href="admin.php">Админка</a><br>

 <form name="form" method="POST" action="user.php">
 <input type="hidden" name="user_id" value="<?= isset( $user_id ) ? $user_id : ''?>">
 <input type="hidden" name="todo" value="save">
<?
  
    if ( isset ( $user_id ) )
    {
        $user_id = (int)$user_id;
        $query = "SELECT * FROM user WHERE user_id = $user_id";
        $result = mysql_query( $query ) or eu( __FILE__, __LINE__, $query );
        $row = mysql_fetch_array( $result, MYSQL_ASSOC );
    }
?>

<table width="80%" border="1">
<tr>
<td>Имя</td> <td><input type="text" size="80" name="user_name" value="<?= isset ( $row['user_name'] ) ? $row['user_name'] : '' ?>"> (Сначала имя, потом фамилия!)</td>
</tr>
<tr>
<td>E-mail</td> <td><input type="text" size="80" name="user_email" value="<?= isset ( $row['user_email'] ) ? $row['user_email'] : '' ?>"></td>
</tr>
<tr>
<td>Машина есть?</td> <td><input type="checkbox" name="user_car_use" value="1" <?= isset ( $row['user_car_exist'] ) && $row['user_car_exist'] ? 'checked' : '' ?>></td>
</tr>
<tr>
<td>Пара есть?</td> <td><input type="checkbox" name="user_pair_exist" value="1" <?= isset ( $row['user_pair_exist'] ) && $row['user_pair_exist'] ? 'checked' : '' ?>></td>
</tr>
<tr>
<td>Допущен к:</td>
<td>
<?

$arr_t  = array();
if ( isset ( $row['user_ent'] ) )
{
    $arr_t = explode( ',', $row['user_ent'] );
}

$query = "SELECT * FROM ent ORDER BY ent_id";
$result = mysql_query( $query ) or eu( __FILE__, __LINE__, $query );
while ( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) )
{
?>

<input type="checkbox" name="user_ent[]" value="<?= $row['ent_id']?>"  <?= in_array( $row['ent_id'], $arr_t ) ? ' checked' : '' ?>><?= $row['ent_title']?>(<?= $row['ent_time_begin'] ?>)<br>

<?
}
?>
</td>
</tr>
</table>
<input type="submit" value="Сохранить">
</form>


 </body>
</html>
<?
}
else 
{
    $user_id = ( isset ( $user_id ) ? (int)$user_id : '' );
    $user_ent = ( isset ( $user_ent ) && is_array ( $user_ent ) ? implode ( ',', $user_ent ) : '' );
    $query = "
    " . ( $user_id ? "UPDATE" : "INSERT INTO" ) . "
    user
        SET
    user_name       = '" . mysql_real_escape_string( $user_name ) . "',
    user_email      = '" . mysql_real_escape_string( $user_email ) . "',
    user_ent        = '" . mysql_real_escape_string( $user_ent ) . "',
    user_car_exist    = '" . mysql_real_escape_string( isset ( $user_car_use ) && $user_car_use ? 1 : 0 ) . "',
    user_pair_exist   = '" . mysql_real_escape_string( isset ( $user_pair_exist ) && $user_pair_exist ? 1 : 0 ) . "'
    
    " . ( $user_id ? "WHERE user_id = $user_id " : "" )  . "
    ";
    $result = mysql_query( $query ) or eu( __FILE__, __LINE__, $query );
    header( "Location: admin.php?message=Все Сделано");
}
