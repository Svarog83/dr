<?
if ( !isset ( $_COOKIE['cookie_pass2009'] ) || $_COOKIE['cookie_pass2009'] != 'just_pass' )
    header( "Location: admin.php?act=exit" );

require_once( 'config_main.php' );
if ( isset ( $users ) && $users )
{
    $users = explode( ':', $users );
    $query = "SELECT * FROM user WHERE user_id IN ('" . implode ( "','", $users ) . "') && user_email != ''";
    $result = mysql_query( $query ) or eu( __FILE__, __LINE__, $query );
    
    $message = '
Привет!
    
Мы приглашаем тебя на празднование наших дней рождений.
Подробности можно узнать по адресу:
' . $URL . '?user_hash=REPLACE_HASH

Большая просьба отметиться!

Спасибо.

Ждем с подарками:)
    
';
    
    while ( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) )
    {
        $hash = md5 ( $row['user_id'] . $row['user_name'] );
       
        $headers = 'From: Sergey&Igor <urod_i_hohol@vetko.net>' . "\r\n" .
'Reply-To: urod_i_hohol@vetko.net' . "\r\n" .
'Content-type: text/plain; charset=utf-8';
       
         mail ( $row['user_email'], 'Приглашение на день рождения!', str_replace( "REPLACE_HASH", $hash, $message ), $headers );
         $query_upd = "UPDATE user SET user_hash='$hash', user_email_sent=1 WHERE user_id={$row['user_id']}";
         $result_upd = mysql_query( $query_upd ) or eu( __FILE__, __LINE__, $query_upd );
         
         header( "Location: admin.php?message=Сообщения отправлены");
    }
}
else 
     header( "Location: admin.php");