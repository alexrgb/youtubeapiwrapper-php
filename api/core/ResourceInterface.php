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

    const FORMAT_JSON = 'json';

    const FORMAT_ARRAY = 'array';

    /**
     * @param string $format
     *
     * @return mixed
     */
    public function request( string $format = self::FORMAT_ARRAY );
}