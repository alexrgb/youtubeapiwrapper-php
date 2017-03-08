<?php
/**
 * Created by Aleksei Kucherov <alex.rgb.kiev[at]gmail.com>
 * on 26.02.17.
 */
namespace youtube\api;

use youtube\api\{
    activity\Activity,
    activity\ActivityInterface,
    channel\Channel,
    channel\ChannelInterface,
    i18n\I18n,
    i18n\InternationalizationInterface,
    playlist\Playlist,
    playlist\PlaylistInterface,
    search\Search,
    search\SearchInterface,
    subscription\Subscription,
    subscription\SubscriptionInterface,
    video\Video,
    video\VideoInterface
};

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
     * @var string $apiUrl
     */
    private $apiUrl = 'https://www.googleapis.com/youtube/v3';

    /**
     * Main constructor.
     * Through array $instances you can overwrite main resource instance to yours implementation, which have to
     * implement corresponding default interface.
     * @example MyActivity have to implement ActivityInterface and so on.
     *
     * @param array $instances
     */
    public function __construct( array $instances = [] )
    {

        $this->setDefaultInstances();
        $this->setInstances( $instances );
    }

    /**
     * Populates @var array $instances with custom class names of main resources classes
     *
     * @param array $instances
     */
    public function setInstances( array $instances = [] ): void
    {

        if ( empty( $instances ) ) {
            return;
        }
        if ( !empty( $instances[ static::ACTIVITY ] ) && $instances[ static::ACTIVITY ] instanceof ActivityInterface ) {
            $this->setInstance( static::ACTIVITY, $instances[ static::ACTIVITY ] );
        }
        if ( !empty( $instances[ static::CHANNEL ] ) && $instances[ static::ACTIVITY ] instanceof ChannelInterface ) {
            $this->setInstance( static::CHANNEL, $instances[ static::CHANNEL ] );
        }
        if ( !empty( $instances[ static::I18N ] )
             && $instances[ static::ACTIVITY ] instanceof InternationalizationInterface
        ) {
            $this->setInstance( static::I18N, $instances[ static::I18N ] );
        }
        if ( !empty( $instances[ static::PLAYLIST ] ) && $instances[ static::ACTIVITY ] instanceof PlaylistInterface ) {
            $this->setInstance( static::PLAYLIST, $instances[ static::PLAYLIST ] );
        }
        if ( !empty( $instances[ static::SEARCH ] ) && $instances[ static::ACTIVITY ] instanceof SearchInterface ) {
            $this->setInstance( static::SEARCH, $instances[ static::SEARCH ] );
        }
        if ( !empty( $instances[ static::SUBSCRIPTION ] )
             && $instances[ static::ACTIVITY ] instanceof SubscriptionInterface
        ) {
            $this->setInstance( static::SUBSCRIPTION, $instances[ static::SUBSCRIPTION ] );
        }
        if ( !empty( $instances[ static::VIDEO ] ) && $instances[ static::ACTIVITY ] instanceof VideoInterface ) {
            $this->setInstance( static::VIDEO, $instances[ static::VIDEO ] );
        }
    }

    /**
     * @return \youtube\api\activity\ActivityInterface
     */
    public function getActivity(): ActivityInterface
    {

        return $this->activity;
    }

    /**
     * @param \youtube\api\activity\ActivityInterface $activity
     */
    public function setActivity( ActivityInterface $activity )
    {

        $this->activity = $activity;
    }

    /**
     * @return \youtube\api\channel\ChannelInterface
     */
    public function getChannel(): ChannelInterface
    {

        return $this->channel;
    }

    /**
     * @param \youtube\api\channel\ChannelInterface $channel
     */
    public function setChannel( ChannelInterface $channel )
    {

        $this->channel = $channel;
    }

    /**
     * @return \youtube\api\i18n\InternationalizationInterface
     */
    public function getI18n(): InternationalizationInterface
    {

        return $this->i18n;
    }

    /**
     * @param \youtube\api\i18n\InternationalizationInterface $i18n
     */
    public function setI18n( InternationalizationInterface $i18n )
    {

        $this->i18n = $i18n;
    }

    /**
     * @return \youtube\api\playlist\PlaylistInterface
     */
    public function getPlaylist(): PlaylistInterface
    {

        return $this->playlist;
    }

    /**
     * @param \youtube\api\playlist\PlaylistInterface $playlist
     */
    public function setPlaylist( PlaylistInterface $playlist )
    {

        $this->playlist = $playlist;
    }

    /**
     * @return \youtube\api\search\SearchInterface
     */
    public function getSearch(): SearchInterface
    {

        return $this->search;
    }

    /**
     * @param \youtube\api\search\SearchInterface $search
     */
    public function setSearch( SearchInterface $search )
    {

        $this->search = $search;
    }

    /**
     * @return \youtube\api\subscription\SubscriptionInterface
     */
    public function getSubscription(): SubscriptionInterface
    {

        return $this->subscription;
    }

    /**
     * @param \youtube\api\subscription\SubscriptionInterface $subscription
     */
    public function setSubscription( SubscriptionInterface $subscription )
    {

        $this->subscription = $subscription;
    }

    /**
     * @return \youtube\api\video\VideoInterface
     */
    public function getVideo(): VideoInterface
    {

        return $this->video;
    }

    /**
     * @param \youtube\api\video\VideoInterface $video
     */
    public function setVideo( VideoInterface $video )
    {

        $this->video = $video;
    }

    /**
     * @return string
     */
    public function getApiUrl(): string
    {

        return $this->apiUrl;
    }

    /**
     *
     * @param string $apiUrl
     *
     * @return \youtube\api\Main
     */
    public function setApiUrl( string $apiUrl ): self
    {

        $this->apiUrl = $apiUrl;
        //change api url for all resources
        $this->activity->setBaseUrl( $this->apiUrl );
        $this->channel->setBaseUrl( $this->apiUrl );
        $this->i18n->setBaseUrl( $this->apiUrl );
        $this->playlist->setBaseUrl( $this->apiUrl );
        $this->search->setBaseUrl( $this->apiUrl );
        $this->subscription->setBaseUrl( $this->apiUrl );
        $this->video->setBaseUrl( $this->apiUrl );

        return $this;
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