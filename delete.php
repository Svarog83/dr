<?
if ( !isset ( $_COOKIE['cookie_pass'] ) || $_COOKIE['cookie_pass'] != 'just_pass' )
    header( "Location: admin.php?act=exit" );

require_once( 'config_main.php' );

if ( isset ( $user_id ) )
{
    $user_id = (int)$user_id;
    $query = "DELETE FROM user WHERE user_id = $user_id";
    $result = mysql_query( $query ) or eu( __FILE__, __LINE__, $query );
    
     header( "Location: admin.php?message=Удалено");
}
else 
     header( "Location: admin.php");