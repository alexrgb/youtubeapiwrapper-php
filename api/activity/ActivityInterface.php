<?php
/**
 * Created by Aleksei Kucherov <alex.rgb.kiev[at]gmail.com>
 * on 26.02.17.
 */

namespace youtube\api\activity;

/**
 * Interface ActivityInterface
 * @package youtube\api\activity
 */
interface ActivityInterface
{
    const ALLOWED_PARTS = [
        'contentDetails', 'id', 'snippet'
    ];

    /**
     * @param string $partName
     */
    public function setPart( string $partName );

    /**
     * @return string
     */
    public function getPart(): string;

    /**
     * Filter. Will be set only last of set method
     *
     * @param string $channelId
     */
    public function setChannelId( string $channelId );

    /**
     * Filter. Will be set only last of set method
     *
     * @param bool $param
     *
     * @deprecated
     */
    public function setHome( bool $param );

    /**
     * Filter. Will be set only last of set method
     *
     * @param bool $param
     */
    public function setMine( bool $param );

    /**
     * Returns array in format ['name' => $filterName, 'value' => $filterValue]
     *
     * @return array
     */
    public function getFilter(): array;

    /**
     * Change maxResults param
     *
     * @param int $count
     */
    public function setMaxResults( int $count );

    /**
     * @return int
     */
    public function getMaxResults(): int;

    /**
     * @param string $pageToken
     */
    public function setPageToken( string $pageToken );

    /**
     * @return string
     */
    public function getPageToken(): string;

    /**
     * The correct format is ISO 8601 (YYYY-MM-DDThh:mm:ss.sZ) format
     *
     * @param string $datetime
     */
    public function setPublishedAfter( string $datetime );

    /**
     * @return string
     */
    public function getPublishedAfter(): string;

    /**
     * The correct format is ISO 8601 (YYYY-MM-DDThh:mm:ss.sZ) format
     *
     * @param string $datetime
     */
    public function setPublishedBefore( string $datetime );

    /**
     * @return string
     */
    public function getPublishedBefore(): string;

    /**
     * Set country code. Use ISO 3166-1
     *
     * @param string $regionCode
     */
    public function setRegionCode( string $regionCode );

    /**
     * @return string
     */
    public function getRegionCode(): string;

    /**
     * Configure activity resource class through configuration array
     * Format [$paramName => $value]
     * For filter params [$channelId, $home, $mine] use special key 'filter' in next format
     * [
     *   'filter' => [ 'mine' => true ]
     * ]
     *
     * @param array $configuration
     */
    public function setConfiguration( array $configuration );

    /**
     * Get activity resource class full configuration
     * @return array
     */
    public function getConfiguration(): array;
}