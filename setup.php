<?
date_default_timezone_set('Europe/Moscow');
$local_server		= ( strpos( $_SERVER['HTTP_HOST'], 'dr.ru' ) !== false ? TRUE : FALSE );

if ( $local_server )
    $URL = 'http://www.dr.ru/';
else 
    $URL = 'http://dr.vetko.net/';

error_reporting ( E_ALL );

if( $local_server )
{
	$db_host_name_main	= 'localhost';
	$db_name_main		= 'dr';
	$db_user_name_main	= 'root';
	$db_password_main	= '';

}
else
{
	$db_host_name_main	= 'localhost';
	$db_name_main		= 'db_main';
	$db_user_name_main	= 'ulfdyfz';
	$db_password_main	= 'C1hd2H';
}

if ( !function_exists( 'eu' ) )
{
	function eu( $a, $b, $c ) 		
	{

		$t =  '<span style="color:red;"><b>SQL_Error</b>:</span><br>file: <b>' .
		$a .
		'</b><br> line: <b>'.

		$b .
		'</b><br><b>'.

		$c .
		'</b><br>'.
		mysql_errno().
		'<br>'.
		mysql_error().
		'<br>' ;
		
		$tt = '<span style="color:red;"><hr style="color:red">Sorry, the script was stoped for the MySQL error!!<br>Please, be patient - Mail was send to Administrators of OMS and the Error will be fixed ASAP<br>You will be informed about this<b></b><hr style="color:red"></span>';

			echo $t;
	?><pre>$_POST: 
	<? print_r( $_POST  ) ?></pre><br><?
	?><pre>$_GET:  
	<? print_r( $_GET  ) ?></pre><?

		die;

	}
}
