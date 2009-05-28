<?
if ( !isset ( $_COOKIE['cookie_pass'] ) || $_COOKIE['cookie_pass'] != 'just_pass' )
    header( "Location: admin.php?act=exit" );

require_once( 'config_main.php' );
if ( isset ( $users ) && $users )
{
    $users = explode( ':', $users );
    $query = "SELECT * FROM user WHERE user_id IN ('" . implode ( "','", $users ) . "') && user_email != ''";
    $result = mysql_query( $query ) or eu( __FILE__, __LINE__, $query );
    
    $message = '
Привет!
    
Спасибо, что поздравили нас! Было очень приятно и весело.
Замечательные фотографии этого сногсшибательного действа можно взять здесь:

1. Сергей - http://gallery.vetko.net/den-rojdeniya-2008/ (на этой странице есть ссылка Download in ZIP).
2. Андрей - http://r-marathon2007.by.ru/misc/Sergan.birthday (далее по ссылкам)
3. Эля - http://gallery.vetko.net/elia_small.zip

Также были подведены финансовые итоги пейнтбола. Получилось, что каждый участвующий остался нам должен по 600 р.
Деньги можно передавать любому из именинников(дальше мы уж сами разберемся).

Спасибо за поздравления и подарки, обещаем не подвести и в следующем году!
Hohol & Urod. 
    
';
    
    while ( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) )
    {
        $hash = md5 ( $row['user_id'] . $row['user_name'] );
       
        $headers = 'From: Sergey&Igor <urod_i_hohol@vetko.net>' . "\r\n" .
'Reply-To: urod_i_hohol@vetko.net' . "\r\n" .
'Content-type: text/plain; charset=utf-8';
       
         mail ( $row['user_email'], 'Фотографии с дня рождения.', $message, $headers );
         $query_upd = "UPDATE user SET user_hash='$hash', user_email_sent=1 WHERE user_id={$row['user_id']}";
//         $result_upd = mysql_query( $query_upd ) or eu( __FILE__, __LINE__, $query_upd );
         
         header( "Location: admin.php?message=Сообщения отправлены");
    }
}
else 
     header( "Location: admin.php");