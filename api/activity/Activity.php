<?php
/**
 * Created by Aleksei Kucherov <alex.rgb.kiev[at]gmail.com>
 * on 26.02.17.
 */

namespace youtube\api\activity;

use Google_Service_YouTube;
use Google_Service_YouTube_Activity;
use youtube\api\core\BaseResource;
use youtube\helpers\CountryCode;

/**
 * Class Activity
 * @package youtube\api\activity
 */
class Activity extends BaseResource implements ActivityInterface
{

    private const DATE_FORMAT = 'YYYY-MM-DDThh:mm:ss.sZ';

    /**
     * The part parameter specifies a comma-separated list of one or more activity
     * resource properties that the API response will include.
     *
     * @required
     * @var string $part
     */
    protected $part = 'id';

    /**
     * The channelId parameter specifies a unique YouTube channel ID.
     * The API will then return a list of that channel's activities.
     *
     * @var string $channelId
     */
    protected $channelId;

    /**
     * Note: This parameter has been deprecated.
     * For requests that set this parameter,
     * the API response contains items similar to those that a logged-out
     * user would see on the YouTube home page.
     * Note that this parameter can only be used in a
     * properly authorized request.
     *
     * @var bool $home
     */
    protected $home;

    /**
     * This parameter can only be used in a properly authorized request.
     * Set this parameter's value to true to retrieve a feed of the authenticated user's activities.
     *
     * @var bool $mine
     */
    protected $mine;

    /**
     * The maxResults parameter specifies the maximum number of items
     * that should be returned in the result set.
     * Acceptable values are 0 to 50, inclusive. The default value is 5.
     *
     * @var int $maxResults
     */
    protected $maxResults;

    /**
     * The pageToken parameter identifies a specific page
     * in the result set that should be returned. In an API response,
     * the nextPageToken and prevPageToken properties identify other pages
     * that could be retrieved.
     *
     * @var string $pageToken
     */
    protected $pageToken;

    /**
     * The publishedAfter parameter specifies the earliest date and time
     * that an activity could have occurred for that activity to be included
     * in the API response. If the parameter value specifies a day,
     * but not a time, then any activities that occurred that day will be
     * included in the result set. The value is specified in
     * ISO 8601 (YYYY-MM-DDThh:mm:ss.sZ) format.
     *
     * @var \DateTime $publishedAfter
     */
    protected $publishedAfter;

    /**
     * The publishedBefore parameter specifies the date and time before
     * which an activity must have occurred for that activity to be included in the API response.
     * If the parameter value specifies a day, but not a time,
     * then any activities that occurred that day will be excluded from the result set.
     * The value is specified in ISO 8601 (YYYY-MM-DDThh:mm:ss.sZ) format.
     *
     * @var \DateTime $publishedBefore
     */
    protected $publishedBefore;

    /**
     * The regionCode parameter instructs the API to return results for the specified country.
     * The parameter value is an ISO 3166-1 alpha-2 country code.
     * YouTube uses this value when the authorized user's previous activity on YouTube
     * does not provide enough information to generate the activity feed.
     *
     * @var string $regionCode
     */
    protected $regionCode;

    /**
     * @var Google_Service_YouTube $service
     */
    private $service;

    /**
     * Activity constructor.
     *
     * @param array $configuration
     */
    public function __construct( array $configuration )
    {

        $this->setService( $configuration )
             ->setConfiguration( $configuration );
    }

    /**
     * @param string $partName
     *
     * @return \youtube\api\activity\Activity
     */
    public function setPart( string $partName ): self
    {

        if ( in_array( $partName, self::ALLOWED_PARTS, true ) ) {
            $this->part = $partName;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getPart(): string
    {

        return $this->part;
    }

    /**
     * Filter. Will be set only last of set method
     *
     * @param string $channelId
     *
     * @return \youtube\api\activity\Activity
     */
    public function setChannelId( string $channelId ): self
    {

        $this->clearFilters();
        $this->channelId = $channelId;

        return $this;
    }

    /**
     * Filter. Will be set only last of set method
     *
     * @param bool $param
     *
     * @deprecated
     *
     * @return \youtube\api\activity\Activity
     */
    public function setHome( bool $param ): self
    {

        $this->clearFilters();
        $this->home = $param;

        return $this;
    }

    /**
     * Filter. Will be set only last of set method
     *
     * @param bool $param
     *
     * @return \youtube\api\activity\Activity
     */
    public function setMine( bool $param ): self
    {

        $this->clearFilters();
        $this->mine = $param;

        return $this;
    }

    /**
     * @return array
     */
    public function getFilter(): array
    {

        $result = [];
        $filters = $this->getFilterNames();
        foreach ( $filters as $param ) {
            if ( $this->{$param} !== null ) {
                $result = [
                    'name'  => $param,
                    'value' => $this->{$param},
                ];
                break;
            }
        }

        return $result;
    }

    /**
     * Change maxResults param
     *
     * @param int $count
     *
     * @return \youtube\api\activity\Activity
     */
    public function setMaxResults( int $count ): self
    {

        if ( $count > 0 && $count <= 50 ) {
            $this->maxResults = $count;
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getMaxResults(): int
    {

        return $this->maxResults;
    }

    /**
     * @param string $pageToken
     *
     * @return \youtube\api\activity\Activity
     */
    public function setPageToken( string $pageToken ): self
    {

        $this->pageToken = $pageToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getPageToken(): string
    {

        return $this->pageToken;
    }

    /**
     * The correct format is ISO 8601 (YYYY-MM-DDThh:mm:ss.sZ) format
     *
     * @param string $datetime
     *
     * @return \youtube\api\activity\Activity
     */
    public function setPublishedAfter( string $datetime ): self
    {

        $date = new \DateTime( $datetime );
        $this->publishedAfter = $date->format( static::DATE_FORMAT );

        return $this;
    }

    /**
     * @return string
     */
    public function getPublishedAfter(): string
    {

        return $this->publishedAfter;
    }

    /**
     * The correct format is ISO 8601 (YYYY-MM-DDThh:mm:ss.sZ) format
     *
     * @param string $datetime
     *
     * @return \youtube\api\activity\Activity
     */
    public function setPublishedBefore( string $datetime ): self
    {

        $date = new \DateTime( $datetime );
        $this->publishedBefore = $date->format( static::DATE_FORMAT );

        return $this;
    }

    /**
     * @return string
     */
    public function getPublishedBefore(): string
    {

        return $this->publishedBefore;
    }

    /**
     * Set country code. Use ISO 3166-1
     *
     * @param string $regionCode
     *
     * @return \youtube\api\activity\Activity
     */
    public function setRegionCode( string $regionCode ): self
    {

        $code = CountryCode::getAlpha2Code( $regionCode );
        $this->regionCode = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getRegionCode(): string
    {

        return $this->regionCode;
    }

    /**
     * Configure activity resource class through configuration array
     * Format [$paramName => $value]
     * For filter params [$channelId, $home, $mine] use special key 'filter' in next format
     * [
     *   'filter' => [ 'mine' => true ]
     * ]
     *
     * @param array $configuration
     *
     * @return \youtube\api\activity\Activity
     */
    public function setConfiguration( array $configuration ): self
    {

        if ( !empty( $configuration[ 'part' ] ) ) {
            $this->setPart( $configuration[ 'part' ] );
        }
        if ( !empty( $configuration[ 'filter' ] ) ) {
            $filter = key( $configuration[ 'filter' ] );
            if ( in_array( $filter, $this->getFilterNames(), true ) ) {
                $this->{'set' . ucfirst( $filter )}( $configuration[ 'filter' ] );
            }
        }
        if ( !empty( $configuration[ 'maxResults' ] ) ) {
            $this->setMaxResults( $configuration[ 'maxResults' ] );
        }
        if ( !empty( $configuration[ 'pageToken' ] ) ) {
            $this->setPageToken( $configuration[ 'pageToken' ] );
        }
        if ( !empty( $configuration[ 'publishedAfter' ] ) ) {
            $this->setPublishedAfter( $configuration[ 'publishedAfter' ] );
        }
        if ( !empty( $configuration[ 'publishedBefore' ] ) ) {
            $this->setPublishedBefore( $configuration[ 'publishedBefore' ] );
        }
        if ( !empty( $configuration[ 'regionCode' ] ) ) {
            $this->setRegionCode( $configuration[ 'regionCode' ] );
        }

        return $this;
    }

    /**
     * Get activity resource class full configuration
     * @return array
     */
    public function getConfiguration(): array
    {

        return [
            'part'            => $this->part,
            'filter'          => $this->getFilter(),
            'maxResults'      => $this->maxResults,
            'pageToken'       => $this->pageToken,
            'publishedAfter'  => $this->publishedAfter,
            'publishedBefore' => $this->publishedBefore,
            'regionCode'      => $this->regionCode,
        ];
    }

    public function getOptionalParams(): array
    {

        $result = [];
        $filter = $this->getFilter();
        if ( !empty( $filter ) ) {
            $result[ $filter[ 'name' ] ] = $filter[ 'value' ];
        }
        if ( !empty( $this->maxResults ) ) {
            $result[ 'maxResults' ] = (int)$this->maxResults;
        }
        if ( !empty( $this->pageToken ) ) {
            $result[ 'pageToken' ] = (string)$this->pageToken;
        }
        if ( !empty( $this->publishedAfter ) ) {
            $result[ 'publishedAfter' ] = (string)$this->publishedAfter;
        }
        if ( !empty( $this->publishedBefore ) ) {
            $result[ 'publishedBefore' ] = (string)$this->publishedBefore;
        }
        if ( !empty( $this->regionCode ) ) {
            $result[ 'regionCode' ] = (string)$this->regionCode;
        }

        return $result;
    }

    /**
     * @param string $format
     *
     * @return array | string based of set format
     */
    public function list( string $format = self::FORMAT_ARRAY )
    {

        $result = $this->service->activities->listActivities( $this->part, $this->getOptionalParams() );
        if ( $format === static::FORMAT_JSON ) {
            $result = (string)json_encode( $result );
        }

        return $result;
    }

    /**
     * @param \Google_Service_YouTube_Activity $postBody
     * @param string $format
     *
     * @return \Google_Service_YouTube_Activity|string
     */
    public function insert( Google_Service_YouTube_Activity $postBody, string $format = self::FORMAT_ARRAY )
    {

        $result = $this->service->activities->insert( $this->part, $postBody, $this->getOptionalParams() );
        if ( $format === static::FORMAT_JSON ) {
            $result = (string)json_encode( $result );
        }

        return $result;
    }

    /**
     * Clears all filter params
     *
     * @return \youtube\api\activity\Activity
     */
    private function clearFilters(): self
    {

        $this->channelId = null;
        $this->home = null;
        $this->mine = null;

        return $this;
    }

    /**
     * @return array
     */
    private function getFilterNames(): array
    {

        return [
            'channelId', 'home', 'mine',
        ];
    }

    /**
     * @param array $configuration
     *
     * @return \youtube\api\activity\Activity
     */
    private function setService( array $configuration ): self
    {

        if ( empty( $configuration[ 'service' ] )
             || !( $configuration[ 'service' ] instanceof Google_Service_YouTube )
        ) {
        }
        $this->service = $configuration[ 'service' ];

        return $this;
    }
}