<?php
/**
 * Created by PhpStorm.
 * User: Kévin
 * Date: 06/02/2016
 * Time: 14:46
 */

namespace Core\Components\Logger;


class Logger
{

    public function __construct()
    {
    }

    public static function accessLog($server)
    {
        if (LOGS_ACTIVE) {
            $date = date('Y-m-d H:i:s');
            $ip = self::get_client_ip();
            $uri = $server['REQUEST_URI'];
            $domain = $server["HTTP_HOST"];
            $method = $server["REQUEST_METHOD"];

            $fileContent = "";

            if (file_exists(ACCESS_LOG_FILE)) {
                $fileContent = file_get_contents(ACCESS_LOG_FILE);
            }

            $fileContent .= $date." ".$ip." access to ".$uri." with ".$method." method on domain ".$domain."\n";

            file_put_contents(ACCESS_LOG_FILE, $fileContent);
        }

    }

    public static function errorLog($error)
    {
        if (LOGS_ACTIVE) {
            $date = date('Y-m-d H:i:s');

            $fileContent = "";

            if (file_exists(ERROR_LOG_FILE)) {
                $fileContent = file_get_contents(ERROR_LOG_FILE);
            }

            $fileContent .= $date." ".$error."\n";

            file_put_contents(ERROR_LOG_FILE, $fileContent);
        }
    }

    public static function get_client_ip()
    {
        $ipaddress = null;

        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(!empty($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(!empty($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(!empty($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(!empty($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }
}