<?php
/**
 * Created by Aleksei Kucherov <alex.rgb.kiev[at]gmail.com>
 * on 26.02.17.
 */
namespace youtube\api;

/**
 * Class for static shortcuts of main api class
 * Class Facade
 * @package youtube\api
 */
final class Facade
{

    /**
     * @var Main $api instance
     */
    private static $api;

    /**
     * @return \youtube\api\Main
     */
    private static function getInstance(): Main
    {

        if ( empty( static::$api ) ) {
            static::$api = new Main();
        }

        return static::$api;
    }

    /**
     * Set access to api main class methods through shortcuts
     *
     * @param string $method
     * @param array $arguments
     */
    public static function __callStatic( string $method, array $arguments )
    {

        $api = static::getInstance();

        return $api->{$method}($arguments[1]);
    }
}