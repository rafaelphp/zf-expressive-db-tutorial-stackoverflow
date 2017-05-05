<?php
/**
 * Created by PhpStorm.
 * User: webmaster
 * Date: 28/03/17
 * Time: 10:58 AM
 */


( !defined('OZZPY_INIT') ) ? die("Can not access this file outside of the project") : null;

if ( isset($_SERVER['HTTP_CF_CONNECTING_IP'])  ) {
    $_SERVER['CF_REMOTE_ADDR']           = $_SERVER['REMOTE_ADDR'];
    $_SERVER['CF_REMOTE_ADDR_PROXY_FOR'] = $_SERVER['HTTP_X_FORWARDED_FOR'];
    $_SERVER['REMOTE_ADDR']              = $_SERVER['HTTP_CF_CONNECTING_IP']; // REWRITE - REMOTE_ADDR
}

function convert($size) {
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

/*
* Global constants
*/
if( strpos($_SERVER['HTTP_HOST'],'localhost') ) {
    $protocol = 'http://';
} else{
    $protocol = 'https://';
}

define('TAG_TITLE'             , 'OZZPY');
define('TAG_KEYWORD'           , '');
define('TAG_DESCRIPTION'       , '');

define('PROJECT_ENV'           , 'development'); // development=show errors,construction=redirect all pages to off-route,production=online site
define('SESSION_NAME'          , 'EXPRESSIVE_WWW1_');

define('PROTOCOL'              , $protocol);
define('DOMAIN'                , $_SERVER['HTTP_HOST'] );
define('SYSTEM'                , '/');
define('URI'                   , $_SERVER['REQUEST_URI']);

define('URL'                   , PROTOCOL . DOMAIN . SYSTEM);
define('SELF'                  , PROTOCOL . DOMAIN . URI);

define('PUBLIC_PATH'           , dirname(__DIR__) . '/public/');
define('TMP_PATH'              , PUBLIC_PATH.'tmp/');


define("OZZPY_PHP_MEMORY",convert(memory_get_usage(true)));
###########################################################################################
define('CLOUDFLARE_HOSTED'    , true);
###########################################################################################
define('ROUTE_V1'              , '/v1/wsapi/');
###########################################################################################

define('FB_APP_ID'             , '');
define('FB_APP_SECRET'         , '');

define('FB_PAGE_ID'            , '');
define('FB_PAGE_LOGIN'         , URL.'fb/');
define('FB_PAGE_LOGIN_CALLBACK', URL.'fb/callback');

define('TW_API_KEY'            , '');
define('TW_API_SECRET'         , '');
define('TW_APP_TOKEN'          , '');
define('TW_APP_SECRET'         , '');
define('TW_PAGE_USER'          , '');
define('TW_PAGE_LOGIN'         , URL.'login/tw');
define('TW_PAGE_CALLBACK'      , URL.'login/tw/callback');

define('RECAPTCHA_PUB'         , '');
define('RECAPTCHA_KEY'         , '');

define('FACEBOOK_SHARE_URL'   , 'https://www.facebook.com/sharer.php?u=');
define('GOOGLE_SHARE_URL'     , 'http://plus.google.com/share?url=');
define('TWITTER_SHARE_URL'    , 'http://twitter.com/home?status=');
define('PINTEREST_SHARE_URL'  , 'http://pinterest.com/pin/create/button/?url=__pinlink__&media=__pinmedia__');



if( PROJECT_ENV == 'development' ) {
    ini_set('display_errors',true);
    ini_set('error_reporting',E_ALL);
}

