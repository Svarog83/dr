<?

if ( $act == 'exit' )
{
    unset ( $_COOKIE['cookie_pass'] );
    setcookie("cookie_pass", '', time()-3600*6000 ); 
    header( "Location: admin.php" );
    $auth = false;
    exit();
}

else if ( $act == 'clear' )
{
    unset ( $_COOKIE['cookie_hash'] );
    setcookie("cookie_hash", '', time()-3600*6000 ); 
}

if ( isset ( $pass ) )
{
    if ( $pass == 'wearethebest' )
    {
        $auth = true;
        setcookie("cookie_pass", 'just_pass', time()+3600*6000 ); 
    }
    else
    {
        header( "Location: admin.php?message=Неправильный пароль" );
    }
    
}
else if ( isset ( $_COOKIE['cookie_pass'] ) && $_COOKIE['cookie_pass'] == 'just_pass' )
    $auth = true;


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
 
 <a href="index.php">Главная страница</a> | <a href="admin.php">Админка</a>  | <a href="admin.php?act=exit">Выйти</a> | <a href="admin.php?act=clear">Очистить куки</a>  <br>
 <?= isset ( $message ) ? '<h1 style="color:red;">'.$message.'</h1>' : '' ?>
 
<? 

if ( isset ( $sort_by ) )
	$sort_by_old = $sort_by;
	
$sort_by = ( isset ( $sort_by ) && $sort_by == 'ASC' ? 'DESC' : 'ASC' );

if ( isset ( $auth ) && $auth )
{
    
?>



<table width="90%" border="1">
<tr>
<td>No</td>
<td><a href="admin.php?sort_field=name&sort_by=<?= $sort_by?>" title="Сортировать по <?= $sort_by == 'ASC' ? 'Возрастанию' : 'Убыванию' ?>">Имя</a></td>

<td>E-mail</td>
<td>Мероприятия</td>
<td>Машина</td>
<td title="Отправлено?"><a href="admin.php?sort_field=sent&sort_by=<?= $sort_by?>" title="Сортировать по <?= $sort_by == 'ASC' ? 'Возрастанию' : 'Убыванию' ?>">Отп.</a></td>
<td  title="Подтверждено?"><a href="admin.php?sort_field=confirm&sort_by=<?= $sort_by?>" title="Сортировать по <?= $sort_by == 'ASC' ? 'Возрастанию' : 'Убыванию' ?>">Подтв.</a></td>
<td>Пожелания</td>
<td>Редактировать</td>
<td>Удалить</td>
<td>Выбрать</td>
</tr>
<?
require_once( 'config_main.php' );

$EntArr  = array();
$query = "SELECT * FROM ent";
$result = mysql_query( $query ) or eu( __FILE__, __LINE__, $query );
while ( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) )
    $EntArr[$row['ent_id']] = $row;



$arr_sort = array();
$arr_sort['name'] = 'user_name';
$arr_sort['sent'] = 'user_email_sent';
$arr_sort['confirm'] = 'user_confirm';

$add_query = '';
if ( isset ( $sort_field ) && isset ( $arr_sort[$sort_field] )  && isset( $sort_by_old ) )
	$add_query .= " ORDER BY {$arr_sort[$sort_field]} $sort_by_old";
    
$query = "SELECT * FROM user" .  $add_query;
$result = mysql_query( $query ) or eu( __FILE__, __LINE__, $query );

$UserEntReal = $UserEnt = $UserCars = array();

$i = 1;
while ( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) )
{
	if ( $row['user_car_use'] == 1 )
		$UserCars[] = $row['user_name'];
	else if ( $row['user_confirm'] )
		$UserNoCars[] = $row['user_name'];


?>
    
<tr>
<td><?= $i++?></td>
<td><?= $row['user_name']?></td>
<td><?= $row['user_email']?></td>
<td>
<?

$ent = '';
if ( $row['user_ent'] )
{
    $arr_t = explode( ',', $row['user_ent'] );
    
    $arr_t_real  = array();
    if ( $row['user_ent_real'] )
        $arr_t_real = explode( ',', $row['user_ent_real'] );
        
    foreach ( $arr_t_real AS $ent_id )
    	$UserEntReal[$ent_id][] = $row['user_name'];
    
    foreach ( $arr_t AS $ent_id )
    {
        $UserEnt[$ent_id][] = $row['user_name'];
    	$ent .= '<nobr>' . $EntArr[$ent_id]['ent_title'] . ( in_array( $ent_id, $arr_t_real ) ? '<span title="Участвует" style="color:green; font-size:18; cursor:pointer;">(+)</span>' : '' ) . '</nobr><br>';
    }
    
}

if ( $ent == '' )
	$ent = '&nbsp;';

echo $ent;
?></td>
<td><?= $row['user_car_exist'] ? 'Есть' : 'Нет'?><?= $row['user_car_exist'] ? ( $row['user_car_use'] == 1 ? '<font color="green">, на машине</font>' : '<font color="red">, без машины</font>' ) : '' ?></td>
<td><?= $row['user_email_sent'] ? 'Да' : 'Нет' ?></td>
<td><?= $row['user_confirm'] ? 'Да' : 'Нет' ?></td>
<td><?= $row['user_remarks'] ? htmlspecialchars( stripslashes( $row['user_remarks'] ) ) : 'Нет' ?></td>
<td><input type="button" onclick="location.href='user.php?user_id=<?= $row['user_id']?>';" value="Редактировать"></td>
<td><input type="button" onclick="location.href='delete.php?user_id=<?= $row['user_id']?>';" value="Удалить"></td>
<td><input type="checkbox" name="user_check[]" value="<?= $row['user_id']?>" <?= !$row['user_email_sent'] ? 'checked' : ''?>></td>
</tr>    
    
<?   
}

?>
</table>
<br>

<script language="JavaScript">
<!--
	
function SendEmail( check_name )
{
    var sel = Array();
    var obj2 = document.all(check_name);
	if ( obj2 )
	{
		if ( obj2.value == undefined) 
		{
			for (i = 0; i < obj2.length; i++)
			{
				var item=obj2[i];
				if ( item.checked )
					sel[sel.length] = item.value;
					
			}
		}
		else
		{
		      if ( obj2.checked )
			     sel[sel.length] = obj2.value;
		}
	}
	location.href='send_email.php?users='+sel.join(':')+'';
	
}

//-->
</script>



<input type="button" onclick="location.href='user.php'" value="Добавить пользователя">
<input type="button" onclick="SendEmail('user_check[]');" value="Послать письмо выбранным пользователям">
<?
?>

<br>
<br>

<table width="600" border="1">
<tr>
<td>Название мероприятия</td>
<td>Приглашенны</td>
<td>Подтвердили участие</td>
</tr>
<?
	foreach ( $EntArr AS $ent_id => $ent_row )
	{
?>

<tr>
<td><b><?= $EntArr[$ent_id]['ent_title']?></b></td>
<td>

<?
	if ( is_array( $UserEnt[$ent_id] ) )
	{
		asort( $UserEnt[$ent_id] );
		$i = 1;
		foreach ( $UserEnt[$ent_id]  AS $k => $name )
		{
			echo $i . ' ' . $name . '<br>';
			$i++;
		}
		
	}
?>
&nbsp;
</td>

<td>

<?
	if ( is_array( $UserEntReal[$ent_id] ) )
	{
		asort( $UserEntReal[$ent_id] );
		$i = 1;
		foreach ( $UserEntReal[$ent_id] AS $k => $name )
		{
			echo $i . ' ' . $name . '<br>';
			$i++;
		}
		
	}
?>
&nbsp;
</td>

</tr>

<?
	}
?>

</table>
<br>

<b>На машине будут:</b><br>
<?
	asort( $UserCars );
	$i = 1;
	foreach ( $UserCars AS $k => $name )
	{		
		echo $i . ' ' . $name . '<br>';
		$i++;
	}

?>
<br>
<b>Без машины:</b>	<br>

<?
	asort( $UserNoCars );
	$i = 1;
	foreach ( $UserNoCars AS $k => $name )
	{		
		echo $i . ' ' . $name . '<br>';
		$i++;
	}
	
}
else 
{
?>
<br>

<form method="POST" name="form" action="admin.php">

Введите пароль: <input type="password" size="30" value="" name="pass">

<input type="submit" value="Ввести">
</form>
<?
}
?>
 </body>
</html>