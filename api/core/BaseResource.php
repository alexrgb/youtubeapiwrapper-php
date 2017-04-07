<?php
/**
 * Created by Aleksei Kucherov <alex.rgb.kiev[at]gmail.com>
 * on 08.03.17.
 */
namespace youtube\api\core;

/**
 * Common resources functionality
 * Class BaseResource
 * @package youtube\api\core
 */
abstract class BaseResource implements ResourceInterface
{
    /**
     * @todo Create error handler class for handle all errors
     * @var
     */
    protected $errorHandler;


}