<?php
/**
 * Created by Aleksei Kucherov <alex.rgb.kiev[at]gmail.com>
 * on 08.03.17.
 */
namespace youtube\api\core;

/**
 * Base interface for all resources classes
 * Interface ResourceInterface
 * @package youtube\api\core
 */
interface ResourceInterface
{

    /**
     * @param string $apiUrl
     */
    public function setBaseUrl(string $apiUrl);

    /**
     * @param string $resourceUrl
     */
    public function setResourceUrl(string $resourceUrl);
}