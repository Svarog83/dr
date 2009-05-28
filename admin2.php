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
        header( "Location: admin.php?message=РќРµРїСЂР°РІРёР»СЊРЅС‹Р№ РїР°СЂРѕР»СЊ" );
    }
    
}
else if ( isset ( $_COOKIE['cookie_pass'] ) && $_COOKIE['cookie_pass'] == 'just_pass' )
    $auth = true;


?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
 <head>
  <title> РќР°С€ РґРµРЅСЊ СЂРѕР¶РґРµРЅРёСЏ! </title>
  <meta name="Generator" content="EditPlus">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <META http-equiv="content-type" content="text/html; charset=utf-8"> 
 </head>

 <body>
 
 <a href="index.php">Р“Р»Р°РІРЅР°СЏ СЃС‚СЂР°РЅРёС†Р°</a> | <a href="admin.php">РђРґРјРёРЅРєР°</a>  | <a href="admin.php?act=exit">Р’С‹Р№С‚Рё</a> | <a href="admin.php?act=clear">РћС‡РёСЃС‚РёС‚СЊ РєСѓРєРё</a>  <br>
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
<td><a href="admin.php?sort_field=name&sort_by=<?= $sort_by?>" title="РЎРѕСЂС‚РёСЂРѕРІР°С‚СЊ РїРѕ <?= $sort_by == 'ASC' ? 'Р’РѕР·СЂР°СЃС‚Р°РЅРёСЋ' : 'РЈР±С‹РІР°РЅРёСЋ' ?>">Р?РјСЏ</a></td>
<td>E-mail</td>
<td>РњРµСЂРѕРїСЂРёСЏС‚РёСЏ</td>
<td>РњР°С€РёРЅР°</td>
<td title="РћС‚РїСЂР°РІР»РµРЅРѕ?"><a href="admin.php?sort_field=sent&sort_by=<?= $sort_by?>" title="РЎРѕСЂС‚РёСЂРѕРІР°С‚СЊ РїРѕ <?= $sort_by == 'ASC' ? 'Р’РѕР·СЂР°СЃС‚Р°РЅРёСЋ' : 'РЈР±С‹РІР°РЅРёСЋ' ?>">РћС‚Рї?</a></td>
<td  title="РџРѕРґС‚РІРµСЂРґРёР»?"><a href="admin.php?sort_field=confirm&sort_by=<?= $sort_by?>" title="РЎРѕСЂС‚РёСЂРѕРІР°С‚СЊ РїРѕ <?= $sort_by == 'ASC' ? 'Р’РѕР·СЂР°СЃС‚Р°РЅРёСЋ' : 'РЈР±С‹РІР°РЅРёСЋ' ?>">РџРѕРґС‚?</a></td>
<td>РџРѕР¶РµР»Р°РЅРёСЏ</td>
<td>Р РµРґР°РєС‚РёСЂРѕРІР°С‚СЊ</td>
<td>РЈРґР°Р»РёС‚СЊ</td>
<td>Р’С‹Р±СЂР°С‚СЊ</td>
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

$UserEntReal = $UserEnt = $UserCars = $UserNoCars = array();

$i = 1;
while ( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) )
{
	if ( $row['user_car_use'] == 1 )
		$UserCars[] = $row['user_name'];
	else 
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
    	$ent .= '<nobr>' . $EntArr[$ent_id]['ent_title'] . ( in_array( $ent_id, $arr_t_real ) ? '<span title="РЈС‡Р°СЃС‚РІСѓРµС‚" style="color:green; font-size:18; cursor:pointer;">(+)</span>' : '' ) . '</nobr><br>';
    }
    
}

if ( $ent == '' )
	$ent = '&nbsp;';

echo $ent;
?></td>
<td><?= $row['user_car_exist'] ? 'Р•СЃС‚СЊ' : 'РќРµС‚'?><?= $row['user_car_exist'] && $row['user_confirm'] ? ( $row['user_car_use'] == 1 ? '<font color="green">, РЅР° РјР°С€РёРЅРµ</font>' : '<font color="red">, Р±РµР· РјР°С€РёРЅС‹</font>' ) : '' ?></td>
<td><?= $row['user_email_sent'] ? 'Р”Р°' : 'РќРµС‚' ?></td>
<td><?= $row['user_confirm'] ? 'Р”Р°' : 'РќРµС‚' ?></td>
<td><?= $row['user_remarks'] ? htmlspecialchars( stripslashes( $row['user_remarks'] ) ) : 'РќРµС‚' ?></td>
<td><input type="button" onclick="location.href='user.php?user_id=<?= $row['user_id']?>';" value="Р РµРґР°РєС‚РёСЂРѕРІР°С‚СЊ"></td>
<td><input type="button" onclick="location.href='delete.php?user_id=<?= $row['user_id']?>';" value="РЈРґР°Р»РёС‚СЊ"></td>
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



<input type="button" onclick="location.href='user.php'" value="Р”РѕР±Р°РІРёС‚СЊ РїРѕР»СЊР·РѕРІР°С‚РµР»СЏ">
<input type="button" onclick="SendEmail('user_check[]');" value="РџРѕСЃР»Р°С‚СЊ РїРёСЃСЊРјРѕ РІС‹Р±СЂР°РЅРЅС‹Рј РїРѕР»СЊР·РѕРІР°С‚РµР»СЏРј">
<?
?>

<br>
<br>

<table width="600" border="1">
<tr>
<td>РќР°Р·РІР°РЅРёРµ РјРµСЂРѕРїСЂРёСЏС‚РёСЏ</td>
<td>РџСЂРёРіР»Р°С€РµРЅРЅС‹</td>
<td>РџРѕРґС‚РІРµСЂРґРёР»Рё СѓС‡Р°СЃС‚РёРµ</td>
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

РќР° РјР°С€РёРЅРµ Р±СѓРґСѓС‚:<br>
<?
	asort( $UserCars );
	$i = 1;
	foreach ( $UserCars AS $k => $name )
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

Р’РІРµРґРёС‚Рµ РїР°СЂРѕР»СЊ: <input type="password" size="30" value="" name="pass">

<input type="submit" value="Р’РІРµСЃС‚Рё">
</form>
<?
}
?>
 </body>
</html>