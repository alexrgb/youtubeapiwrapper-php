<?php
/**
 * Created by Aleksei Kucherov <alex.rgb.kiev[at]gmail.com>
 * on 26.02.17.
 */
namespace youtube\api;

use youtube\api\activity\Activity;
use youtube\api\activity\ActivityInterface;
use youtube\api\channel\Channel;
use youtube\api\channel\ChannelInterface;
use youtube\api\i18n\I18n;
use youtube\api\i18n\InternationalizationInterface;
use youtube\api\playlist\Playlist;
use youtube\api\playlist\PlaylistInterface;
use youtube\api\search\Search;
use youtube\api\search\SearchInterface;
use youtube\api\subscription\Subscription;
use youtube\api\subscription\SubscriptionInterface;
use youtube\api\video\Video;
use youtube\api\video\VideoInterface;

/**
 * Class Main
 * @package youtube\api
 */
class Main
{

    public const ACTIVITY = 'activity';

    public const CHANNEL = 'channel';

    public const I18N = 'i18n';

    public const PLAYLIST = 'playlist';

    public const SEARCH = 'search';

    public const SUBSCRIPTION = 'subscription';

    public const VIDEO = 'video';

    /**
     * @var ActivityInterface $activity
     */
    private $activity;

    /**
     * @var ChannelInterface $channel
     */
    private $channel;

    /**
     * @var InternationalizationInterface $i18n
     */
    private $i18n;

    /**
     * @var PlaylistInterface $playlist
     */
    private $playlist;

    /**
     * @var SearchInterface $search
     */
    private $search;

    /**
     * @var SubscriptionInterface $subscription
     */
    private $subscription;

    /**
     * @var VideoInterface $video
     */
    private $video;

    /**
     * @var array $instances holds all instances class names with namespaces
     */
    private $instances = [];

    /**
     * Main constructor.
     *
     * @param array $instances
     */
    public function __construct( array $instances )
    {

        $this->setDefaultInstances();
        $this->setInstances( $instances );
    }

    /**
     * Populates @var array $instances with custom class names of main resources classes
     *
     * @param array $instances
     */
    public function setInstances( array $instances ): void
    {

        if ( !empty( $instances[ static::ACTIVITY ] ) ) {
            $this->setInstance( static::ACTIVITY, $instances[ static::ACTIVITY ] );
        }
        if ( !empty( $instances[ static::CHANNEL ] ) ) {
            $this->setInstance( static::CHANNEL, $instances[ static::CHANNEL ] );
        }
        if ( !empty( $instances[ static::I18N ] ) ) {
            $this->setInstance( static::I18N, $instances[ static::I18N ] );
        }
        if ( !empty( $instances[ static::PLAYLIST ] ) ) {
            $this->setInstance( static::PLAYLIST, $instances[ static::PLAYLIST ] );
        }
        if ( !empty( $instances[ static::SEARCH ] ) ) {
            $this->setInstance( static::SEARCH, $instances[ static::SEARCH ] );
        }
        if ( !empty( $instances[ static::SUBSCRIPTION ] ) ) {
            $this->setInstance( static::SUBSCRIPTION, $instances[ static::SUBSCRIPTION ] );
        }
        if ( !empty( $instances[ static::VIDEO ] ) ) {
            $this->setInstance( static::VIDEO, $instances[ static::VIDEO ] );
        }
    }

    /**
     * @param string $name
     * @param $class
     */
    public function setInstance( string $name, $class ): void
    {

        if ( in_array( $name, $this->getAcceptableResourceNames() ) ) {
            if ( is_object( $class ) ) {
                $this->instances[ $name ] = get_class( $class );
            }
            elseif ( is_string( $class ) && class_exists( $class ) ) {
                $this->instances[ $name ] = $class;
            }
        }
    }

    /**
     * @return array acceptable api resources
     */
    private function getAcceptableResourceNames(): array
    {

        return [
            static::ACTIVITY,
            static::CHANNEL,
            static::I18N,
            static::PLAYLIST,
            static::SEARCH,
            static::SUBSCRIPTION,
            static::VIDEO,
        ];
    }

    /**
     * Set default classes of main api resources
     * Populates @var array $instances
     */
    private function setDefaultInstances(): void
    {

        $this->instances = [
            'activity'     => Activity::class,
            'channel'      => Channel::class,
            'i18n'         => I18n::class,
            'playlist'     => Playlist::class,
            'search'       => Search::class,
            'subscription' => Subscription::class,
            'video'        => Video::class,
        ];
    }
}