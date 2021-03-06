<?php
/**
 * MasVideos movie base class.
 *
 * @package MasVideos/Abstracts
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Abstract Movie Class
 *
 * The MasVideos movie class handles individual movie data.
 *
 * @version  1.0.0
 * @package  MasVideos/Abstracts
 */
class MasVideos_Movie extends MasVideos_Data {

    /**
     * This is the name of this object type.
     *
     * @var string
     */
    protected $object_type = 'movie';

    /**
     * Post type.
     *
     * @var string
     */
    protected $post_type = 'movie';

    /**
     * Cache group.
     *
     * @var string
     */
    protected $cache_group = 'movies';

    /**
     * Stores movie data.
     *
     * @var array
     */
    protected $data = array(
        'name'                  => '',
        'slug'                  => '',
        'date_created'          => null,
        'date_modified'         => null,
        'status'                => false,
        'featured'              => false,
        'catalog_visibility'    => 'visible',
        'description'           => '',
        'short_description'     => '',
        'parent_id'             => 0,
        'reviews_allowed'       => true,
        'cast'                  => array(),
        'crew'                  => array(),
        'attributes'            => array(),
        'default_attributes'    => array(),
        'sources'               => array(),
        'menu_order'            => 0,
        'genre_ids'             => array(),
        'tag_ids'               => array(),
        'image_id'              => '',
        'movie_choice'          => '',
        'movie_attachment_id'   => '',
        'movie_embed_content'   => '',
        'movie_url_link'        => '',
        'movie_is_affiliate_link'=> '',
        'gallery_image_ids'     => array(),
        'rating_counts'         => array(),
        'average_rating'        => 0,
        'review_count'          => 0,
        'movie_release_date'    => '',
        'movie_run_time'        => '',
        'movie_censor_rating'   => '',
        'recommended_movie_ids' => array(),
        'related_video_ids'     => array(),
        'imdb_id'               => '',
        'tmdb_id'               => '',
    );

    /**
     * Supported features such as 'ajax_add_to_cart'.
     *
     * @var array
     */
    protected $supports = array();

    /**
     * Get the movie if ID is passed, otherwise the movie is new and empty.
     * This class should NOT be instantiated, but the masvideos_get_movie() function
     * should be used. It is possible, but the masvideos_get_movie() is preferred.
     *
     * @param int|MasVideos_Movie|object $movie Movie to init.
     */
    public function __construct( $movie = 0 ) {
        parent::__construct( $movie );
        if ( is_numeric( $movie ) && $movie > 0 ) {
            $this->set_id( $movie );
        } elseif ( $movie instanceof self ) {
            $this->set_id( absint( $movie->get_id() ) );
        } elseif ( ! empty( $movie->ID ) ) {
            $this->set_id( absint( $movie->ID ) );
        } else {
            $this->set_object_read( true );
        }

        $this->data_store = MasVideos_Data_Store::load( 'movie' );
        if ( $this->get_id() > 0 ) {
            $this->data_store->read( $this );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Getters
    |--------------------------------------------------------------------------
    |
    | Methods for getting data from the movie object.
    */

    /**
     * Get movie name.
     *
     * @since 1.0.0
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return string
     */
    public function get_name( $context = 'view' ) {
        return $this->get_prop( 'name', $context );
    }

    /**
     * Get movie slug.
     *
     * @since 1.0.0
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return string
     */
    public function get_slug( $context = 'view' ) {
        return $this->get_prop( 'slug', $context );
    }

    /**
     * Get movie created date.
     *
     * @since 1.0.0
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return MasVideos_DateTime|NULL object if the date is set or null if there is no date.
     */
    public function get_date_created( $context = 'view' ) {
        return $this->get_prop( 'date_created', $context );
    }

    /**
     * Get movie modified date.
     *
     * @since 1.0.0
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return MasVideos_DateTime|NULL object if the date is set or null if there is no date.
     */
    public function get_date_modified( $context = 'view' ) {
        return $this->get_prop( 'date_modified', $context );
    }

    /**
     * Get movie status.
     *
     * @since 1.0.0
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return string
     */
    public function get_status( $context = 'view' ) {
        return $this->get_prop( 'status', $context );
    }

    /**
     * If the movie is featured.
     *
     * @since 1.0.0
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return boolean
     */
    public function get_featured( $context = 'view' ) {
        return $this->get_prop( 'featured', $context );
    }

    /**
     * Get catalog visibility.
     *
     * @since 1.0.0
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return string
     */
    public function get_catalog_visibility( $context = 'view' ) {
        return $this->get_prop( 'catalog_visibility', $context );
    }

    /**
     * Get movie description.
     *
     * @since 1.0.0
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return string
     */
    public function get_description( $context = 'view' ) {
        return $this->get_prop( 'description', $context );
    }

    /**
     * Get movie short description.
     *
     * @since 1.0.0
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return string
     */
    public function get_short_description( $context = 'view' ) {
        return $this->get_prop( 'short_description', $context );
    }

    /**
     * Get parent ID.
     *
     * @since 1.0.0
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return int
     */
    public function get_parent_id( $context = 'view' ) {
        return $this->get_prop( 'parent_id', $context );
    }

    /**
     * Return if reviews is allowed.
     *
     * @since 1.0.0
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return bool
     */
    public function get_reviews_allowed( $context = 'view' ) {
        return $this->get_prop( 'reviews_allowed', $context );
    }

    /**
     * Returns movie cast.
     *
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return array
     */
    public function get_cast( $context = 'view' ) {
        return $this->get_prop( 'cast', $context );
    }

    /**
     * Returns movie crew.
     *
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return array
     */
    public function get_crew( $context = 'view' ) {
        return $this->get_prop( 'crew', $context );
    }

    /**
     * Returns movie attributes.
     *
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return array
     */
    public function get_attributes( $context = 'view' ) {
        return $this->get_prop( 'attributes', $context );
    }

    /**
     * Get default attributes.
     *
     * @since 1.0.0
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return array
     */
    public function get_default_attributes( $context = 'view' ) {
        return $this->get_prop( 'default_attributes', $context );
    }

    /**
     * Get sources.
     *
     * @since 1.0.0
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return array
     */
    public function get_sources( $context = 'view' ) {
        return $this->get_prop( 'sources', $context );
    }

    /**
     * Get menu order.
     *
     * @since 1.0.0
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return int
     */
    public function get_menu_order( $context = 'view' ) {
        return $this->get_prop( 'menu_order', $context );
    }

    /**
     * Get genre ids.
     *
     * @since 1.0.0
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return array
     */
    public function get_genre_ids( $context = 'view' ) {
        return $this->get_prop( 'genre_ids', $context );
    }

    /**
     * Get tag ids.
     *
     * @since 1.0.0
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return array
     */
    public function get_tag_ids( $context = 'view' ) {
        return $this->get_prop( 'tag_ids', $context );
    }

    /**
     * Returns the gallery attachment ids.
     *
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return array
     */
    public function get_gallery_image_ids( $context = 'view' ) {
        return $this->get_prop( 'gallery_image_ids', $context );
    }

    /**
     * Get main image ID.
     *
     * @since 1.0.0
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return string
     */
    public function get_image_id( $context = 'view' ) {
        return $this->get_prop( 'image_id', $context );
    }

    /**
     * Get main movie choice.
     *
     * @since 1.0.0
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return string
     */
    public function get_movie_choice( $context = 'view' ) {
        return $this->get_prop( 'movie_choice', $context );
    }

    /**
     * Get main movie attachment ID.
     *
     * @since 1.0.0
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return string
     */
    public function get_movie_attachment_id( $context = 'view' ) {
        return $this->get_prop( 'movie_attachment_id', $context );
    }

    /**
     * Get main movie embed content.
     *
     * @since 1.0.0
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return string
     */
    public function get_movie_embed_content( $context = 'view' ) {
        return $this->get_prop( 'movie_embed_content', $context );
    }

    /**
     * Get main movie url.
     *
     * @since 1.0.0
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return string
     */
    public function get_movie_url_link( $context = 'view' ) {
        return $this->get_prop( 'movie_url_link', $context );
    }

    /**
     * If the movie url link is affiliate.
     *
     * @since 1.0.0
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return bool|string
     */
    public function get_movie_is_affiliate_link( $context = 'view' ) {
        return $this->get_prop( 'movie_is_affiliate_link', $context );
    }

    /**
     * Get rating count.
     *
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return array of counts
     */
    public function get_rating_counts( $context = 'view' ) {
        return $this->get_prop( 'rating_counts', $context );
    }

    /**
     * Get average rating.
     *
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return float
     */
    public function get_average_rating( $context = 'view' ) {
        return $this->get_prop( 'average_rating', $context );
    }

    /**
     * Get review count.
     *
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return int
     */
    public function get_review_count( $context = 'view' ) {
        return $this->get_prop( 'review_count', $context );
    }

    /**
     * Get main movie release date.
     *
     * @since 1.0.0
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return string
     */
    public function get_movie_release_date( $context = 'view' ) {
        return $this->get_prop( 'movie_release_date', $context );
    }

    /**
     * Get main movie run time.
     *
     * @since 1.0.0
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return string
     */
    public function get_movie_run_time( $context = 'view' ) {
        return $this->get_prop( 'movie_run_time', $context );
    }

    /**
     * Get main movie censor rating.
     *
     * @since 1.0.0
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return string
     */
    public function get_movie_censor_rating( $context = 'view' ) {
        return $this->get_prop( 'movie_censor_rating', $context );
    }

    /**
     * Get Recommended Movie IDs.
     *
     * @since 3.0.0
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return array
     */
    public function get_recommended_movie_ids( $context = 'view' ) {
        return $this->get_prop( 'recommended_movie_ids', $context );
    }

    /**
     * Get Related Video IDs.
     *
     * @since 3.0.0
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return array
     */
    public function get_related_video_ids( $context = 'view' ) {
        return $this->get_prop( 'related_video_ids', $context );
    }

    /**
     * Get main movie imdb id.
     *
     * @since 1.0.0
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return string
     */
    public function get_imdb_id( $context = 'view' ) {
        return $this->get_prop( 'imdb_id', $context );
    }

    /**
     * Get main movie tmdb id.
     *
     * @since 1.0.0
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return string
     */
    public function get_tmdb_id( $context = 'view' ) {
        return $this->get_prop( 'tmdb_id', $context );
    }

    /*
    |--------------------------------------------------------------------------
    | Setters
    |--------------------------------------------------------------------------
    |
    | Functions for setting movie data. These should not update anything in the
    | database itself and should only change what is stored in the class
    | object.
    */

    /**
     * Set movie name.
     *
     * @since 1.0.0
     * @param string $name Movie name.
     */
    public function set_name( $name ) {
        $this->set_prop( 'name', $name );
    }

    /**
     * Set movie slug.
     *
     * @since 1.0.0
     * @param string $slug Movie slug.
     */
    public function set_slug( $slug ) {
        $this->set_prop( 'slug', $slug );
    }

    /**
     * Set movie created date.
     *
     * @since 1.0.0
     * @param string|integer|null $date UTC timestamp, or ISO 8601 DateTime. If the DateTime string has no timezone or offset, WordPress site timezone will be assumed. Null if their is no date.
     */
    public function set_date_created( $date = null ) {
        $this->set_date_prop( 'date_created', $date );
    }

    /**
     * Set movie modified date.
     *
     * @since 1.0.0
     * @param string|integer|null $date UTC timestamp, or ISO 8601 DateTime. If the DateTime string has no timezone or offset, WordPress site timezone will be assumed. Null if their is no date.
     */
    public function set_date_modified( $date = null ) {
        $this->set_date_prop( 'date_modified', $date );
    }

    /**
     * Set movie status.
     *
     * @since 1.0.0
     * @param string $status Movie status.
     */
    public function set_status( $status ) {
        $this->set_prop( 'status', $status );
    }

    /**
     * Set if the movie is featured.
     *
     * @since 1.0.0
     * @param bool|string $featured Whether the movie is featured or not.
     */
    public function set_featured( $featured ) {
        $this->set_prop( 'featured', masvideos_string_to_bool( $featured ) );
    }

    /**
     * Set catalog visibility.
     *
     * @since 1.0.0
     * @throws MasVideos_Data_Exception Throws exception when invalid data is found.
     * @param string $visibility Options: 'hidden', 'visible', 'search' and 'catalog'.
     */
    public function set_catalog_visibility( $visibility ) {
        $options = array_keys( masvideos_get_movie_visibility_options() );
        if ( ! in_array( $visibility, $options, true ) ) {
            $this->error( 'movie_invalid_catalog_visibility', __( 'Invalid catalog visibility option.', 'masvideos' ) );
        }
        $this->set_prop( 'catalog_visibility', $visibility );
    }

    /**
     * Set movie description.
     *
     * @since 1.0.0
     * @param string $description Movie description.
     */
    public function set_description( $description ) {
        $this->set_prop( 'description', $description );
    }

    /**
     * Set movie short description.
     *
     * @since 1.0.0
     * @param string $short_description Movie short description.
     */
    public function set_short_description( $short_description ) {
        $this->set_prop( 'short_description', $short_description );
    }

    /**
     * Set parent ID.
     *
     * @since 1.0.0
     * @param int $parent_id Movie parent ID.
     */
    public function set_parent_id( $parent_id ) {
        $this->set_prop( 'parent_id', absint( $parent_id ) );
    }

    /**
     * Set if reviews is allowed.
     *
     * @since 1.0.0
     * @param bool $reviews_allowed Reviews allowed or not.
     */
    public function set_reviews_allowed( $reviews_allowed ) {
        $this->set_prop( 'reviews_allowed', masvideos_string_to_bool( $reviews_allowed ) );
    }

    /**
     * Set cast. These will be saved as strings and should map to source values.
     *
     * @since 1.0.0
     * @param array $cast List of cast.
     */
    public function set_cast( $cast ) {
        if ( ! empty( $cast ) && is_array( $cast ) ) {
            array_multisort( array_column( $cast, 'position' ), SORT_ASC, $cast );
        }

        $previous_cast = $this->get_cast( 'edit' );
        if( ! empty( $previous_cast ) ) {
            $previous_cast_ids = $current_cast_ids = array();
            foreach( $previous_cast as $prev_cast ){
                $previous_cast_ids[] = $prev_cast['id'];
            }
            foreach( $cast as $current_cast ){
                $current_cast_ids[] = $current_cast['id'];
            }
            $differs = array_diff( $previous_cast_ids, $current_cast_ids );
            if( ! empty( $differs ) && is_array( $differs ) ) {
                foreach ( $differs as $diff ) {
                    $person = masvideos_get_person( $diff );
                    if( $person && is_a( $person, 'MasVideos_Person' ) ) {
                        $movie_cast = $person->get_movie_cast( 'edit' );
                        $pos = array_search( $this->get_id(), $movie_cast );
                        if( $pos !== false ) {
                            unset( $movie_cast[$pos] );
                            $person->set_movie_cast( $movie_cast );
                            $person->save();
                        }
                    }
                }
            }
        }
        $this->set_prop( 'cast', $cast );
    }

    /**
     * Set crew. These will be saved as strings and should map to source values.
     *
     * @since 1.0.0
     * @param array $crew List of crew.
     */
    public function set_crew( $crew ) {
        if ( ! empty( $crew ) && is_array( $crew ) ) {
            array_multisort( array_column( $crew, 'position' ), SORT_ASC, $crew );
        }

        $previous_crew = $this->get_crew( 'edit' );
        if( ! empty( $previous_crew ) ) {
            $previous_crew_ids = $current_crew_ids = array();
            foreach( $previous_crew as $prev_crew ){
                $previous_crew_ids[] = $prev_crew['id'];
            }
            foreach( $crew as $current_crew ){
                $current_crew_ids[] = $current_crew['id'];
            }
            $differs = array_diff( $previous_crew_ids, $current_crew_ids );
            if( ! empty( $differs ) && is_array( $differs ) ) {
                foreach ( $differs as $diff ) {
                    $person = masvideos_get_person( $diff );
                    if( $person && is_a( $person, 'MasVideos_Person' ) ) {
                        $movie_crew = $person->get_movie_crew( 'edit' );
                        $pos = array_search( $this->get_id(), $movie_crew );
                        if( $pos !== false ) {
                            unset( $movie_crew[$pos] );
                            $person->set_movie_crew( $movie_crew );
                            $person->save();
                        }
                    }
                }
            }
        }
        $this->set_prop( 'crew', $crew );
    }

    /**
     * Set movie attributes.
     *
     * Attributes are made up of:
     *     id - 0 for movie level attributes. ID for global attributes.
     *     name - Attribute name.
     *     options - attribute value or array of term ids/names.
     *     position - integer sort order.
     *     visible - If visible on frontend.
     *     variation - If used for variations.
     * Indexed by unqiue key to allow clearing old ones after a set.
     *
     * @since 1.0.0
     * @param array $raw_attributes Array of MasVideos_Movie_Attribute objects.
     */
    public function set_attributes( $raw_attributes ) {
        $attributes = array_fill_keys( array_keys( $this->get_attributes( 'edit' ) ), null );
        foreach ( $raw_attributes as $attribute ) {
            if ( is_a( $attribute, 'MasVideos_Movie_Attribute' ) ) {
                $attributes[ sanitize_title( $attribute->get_name() ) ] = $attribute;
            }
        }

        uasort( $attributes, 'masvideos_attribute_uasort_comparison' );
        $this->set_prop( 'attributes', $attributes );
    }

    /**
     * Set default attributes. These will be saved as strings and should map to attribute values.
     *
     * @since 1.0.0
     * @param array $default_attributes List of default attributes.
     */
    public function set_default_attributes( $default_attributes ) {
        $this->set_prop( 'default_attributes', array_map( 'strval', array_filter( (array) $default_attributes, 'masvideos_array_filter_default_attributes' ) ) );
    }

    /**
     * Set sources. These will be saved as strings and should map to source values.
     *
     * @since 1.0.0
     * @param array $sources List of sources.
     */
    public function set_sources( $sources ) {
        if ( ! empty( $sources ) && is_array( $sources ) ) {
            array_multisort( array_column( $sources, 'position' ), SORT_ASC, $sources );
        }
        $this->set_prop( 'sources', $sources );
    }

    /**
     * Set menu order.
     *
     * @since 1.0.0
     * @param int $menu_order Menu order.
     */
    public function set_menu_order( $menu_order ) {
        $this->set_prop( 'menu_order', intval( $menu_order ) );
    }

    /**
     * Set the movie genres.
     *
     * @since 1.0.0
     * @param array $term_ids List of terms IDs.
     */
    public function set_genre_ids( $term_ids ) {
        $this->set_prop( 'genre_ids', array_unique( array_map( 'intval', $term_ids ) ) );
    }

    /**
     * Set the movie tags.
     *
     * @since 1.0.0
     * @param array $term_ids List of terms IDs.
     */
    public function set_tag_ids( $term_ids ) {
        $this->set_prop( 'tag_ids', array_unique( array_map( 'intval', $term_ids ) ) );
    }

    /**
     * Set gallery attachment ids.
     *
     * @since 1.0.0
     * @param array $image_ids List of image ids.
     */
    public function set_gallery_image_ids( $image_ids ) {
        $image_ids = wp_parse_id_list( $image_ids );

        if ( $this->get_object_read() ) {
            $image_ids = array_filter( $image_ids, 'wp_attachment_is_image' );
        }

        $this->set_prop( 'gallery_image_ids', $image_ids );
    }

    /**
     * Set main image ID.
     *
     * @since 1.0.0
     * @param int|string $image_id Movie image id.
     */
    public function set_image_id( $image_id = '' ) {
        $this->set_prop( 'image_id', $image_id );
    }

    /**
     * Set main movie choice
     *
     * @since 1.0.0
     * @param int|string $movie_choice Video attachment id.
     */
    public function set_movie_choice( $movie_choice = '' ) {
        $this->set_prop( 'movie_choice', $movie_choice );
    }

    /**
     * Set main movie attachment ID.
     *
     * @since 1.0.0
     * @param int|string $movie_attachment_id Video attachment id.
     */
    public function set_movie_attachment_id( $movie_attachment_id = '' ) {
        $this->set_prop( 'movie_attachment_id', $movie_attachment_id );
    }

    /**
     * Set main movie embed content.
     *
     * @since 1.0.0
     * @param int|string $movie_embed_content Video embed content.
     */
    public function set_movie_embed_content( $movie_embed_content = '' ) {
        $this->set_prop( 'movie_embed_content', $movie_embed_content );
    }

    /**
     * Set main movie url.
     *
     * @since 1.0.0
     * @param int|string $movie_url_link Video embed content.
     */
    public function set_movie_url_link( $movie_url_link = '' ) {
        $this->set_prop( 'movie_url_link', $movie_url_link );
    }

    /**
     * Set if the movie url link is affiliate.
     *
     * @since 1.0.0
     * @param bool|string $movie_is_affiliate_link.
     */
    public function set_movie_is_affiliate_link( $movie_is_affiliate_link = '' ) {
        $this->set_prop( 'movie_is_affiliate_link', $movie_is_affiliate_link );
    }

    /**
     * Set rating counts. Read only.
     *
     * @param array $counts Movie rating counts.
     */
    public function set_rating_counts( $counts ) {
        $this->set_prop( 'rating_counts', array_filter( array_map( 'absint', (array) $counts ) ) );
    }

    /**
     * Set average rating. Read only.
     *
     * @param float $average Movie average rating.
     */
    public function set_average_rating( $average ) {
        $this->set_prop( 'average_rating', masvideos_format_decimal( $average ) );
    }

    /**
     * Set review count. Read only.
     *
     * @param int $count Movie review count.
     */
    public function set_review_count( $count ) {
        $this->set_prop( 'review_count', absint( $count ) );
    }

    /**
     * Set main movie release date content.
     *
     * @since 1.0.0
     * @param int|string $movie_release_date Movie relese date.
     */
    public function set_movie_release_date( $movie_release_date = '' ) {
        $this->set_date_prop( 'movie_release_date', $movie_release_date );
    }

    /**
     * Set main movie run time content.
     *
     * @since 1.0.0
     * @param int|string $movie_run_time Movie run time.
     */
    public function set_movie_run_time( $movie_run_time = '' ) {
        $this->set_prop( 'movie_run_time', $movie_run_time );
    }

    /**
     * Set main movie censor rating content.
     *
     * @since 1.0.0
     * @param int|string $movie_censor_rating Movie censor rating.
     */
    public function set_movie_censor_rating( $movie_censor_rating = '' ) {
        $this->set_prop( 'movie_censor_rating', $movie_censor_rating );
    }

    /**
     * Set Recommended Movie IDs.
     *
     * @since 3.0.0
     * @param array $recommended_movie_ids from the recommended movies.
     */
    public function set_recommended_movie_ids( $recommended_movie_ids ) {
        $this->set_prop( 'recommended_movie_ids', array_filter( (array) $recommended_movie_ids ) );
    }

    /**
     * Set Related Video IDs.
     *
     * @since 3.0.0
     * @param array $related_video_ids from the recommended movies.
     */
    public function set_related_video_ids( $related_video_ids ) {
        $this->set_prop( 'related_video_ids', array_filter( (array) $related_video_ids ) );
    }

    /**
     * Set main movie imdb id content.
     *
     * @since 1.0.0
     * @param int|string $imdb_id Movie imdb id.
     */
    public function set_imdb_id( $imdb_id = '' ) {
        $imdb_id = (string) $imdb_id;
        if ( $this->get_object_read() && ! empty( $imdb_id ) && ! masvideos_movie_has_unique_imdb_id( $this->get_id(), $imdb_id ) ) {
            $imdb_id_found = masvideos_get_movie_id_by_imdb_id( $imdb_id );

            $this->error( 'movie_invalid_imdb_id', __( 'Invalid or duplicated IMDB Id.', 'masvideos' ), 400, array( 'resource_id' => $imdb_id_found ) );
        }
        $this->set_prop( 'imdb_id', $imdb_id );
    }

    /**
     * Set main movie tmdb id content.
     *
     * @since 1.0.0
     * @param int|string $tmdb_id Movie tmdb id.
     */
    public function set_tmdb_id( $tmdb_id = '' ) {
        $tmdb_id = (string) $tmdb_id;
        if ( $this->get_object_read() && ! empty( $tmdb_id ) && ! masvideos_movie_has_unique_tmdb_id( $this->get_id(), $tmdb_id ) ) {
            $tmdb_id_found = masvideos_get_movie_id_by_tmdb_id( $tmdb_id );

            $this->error( 'movie_invalid_tmdb_id', __( 'Invalid or duplicated TMDB Id.', 'masvideos' ), 400, array( 'resource_id' => $tmdb_id_found ) );
        }
        $this->set_prop( 'tmdb_id', $tmdb_id );
    }

    /*
    |--------------------------------------------------------------------------
    | Other Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Ensure properties are set correctly before save.
     *
     * @since 1.0.0
     */
    public function validate_props() {
    }

    /**
     * Save data (either create or update depending on if we are working on an existing movie).
     *
     * @since 1.0.0
     * @return int
     */
    public function save() {
        $this->validate_props();

        if ( $this->data_store ) {
            // Trigger action before saving to the DB. Use a pointer to adjust object props before save.
            do_action( 'masvideos_before_' . $this->object_type . '_object_save', $this, $this->data_store );

            if ( $this->get_id() ) {
                $this->data_store->update( $this );
            } else {
                $this->data_store->create( $this );
            }
            if ( $this->get_parent_id() ) {
                masvideos_deferred_movie_sync( $this->get_parent_id() );
            }
        }
        return $this->get_id();
    }

    /*
    |--------------------------------------------------------------------------
    | Conditionals
    |--------------------------------------------------------------------------
    */

    /**
     * Check if a movie supports a given feature.
     *
     * Movie classes should override this to declare support (or lack of support) for a feature.
     *
     * @param string $feature string The name of a feature to test support for.
     * @return bool True if the movie supports the feature, false otherwise.
     * @since 2.5.0
     */
    public function supports( $feature ) {
        return apply_filters( 'masvideos_movie_supports', in_array( $feature, $this->supports ), $feature, $this );
    }

    /**
     * Returns whether or not the movie post exists.
     *
     * @return bool
     */
    public function exists() {
        return false !== $this->get_status();
    }

    /**
     * Returns whether or not the movie is featured.
     *
     * @return bool
     */
    public function is_featured() {
        return true === $this->get_featured();
    }

    /**
     * Returns whether or not the movie is visible in the catalog.
     *
     * @return bool
     */
    public function is_visible() {
        $visible = 'visible' === $this->get_catalog_visibility() || ( is_search() && 'search' === $this->get_catalog_visibility() ) || ( ! is_search() && 'catalog' === $this->get_catalog_visibility() );

        if ( 'trash' === $this->get_status() ) {
            $visible = false;
        } elseif ( 'publish' !== $this->get_status() && ! current_user_can( 'edit_post', $this->get_id() ) ) {
            $visible = false;
        }

        if ( $this->get_parent_id() ) {
            $parent_movie = masvideos_get_movie( $this->get_parent_id() );

            if ( $parent_movie && 'publish' !== $parent_movie->get_status() ) {
                $visible = false;
            }
        }

        return apply_filters( 'masvideos_movie_is_visible', $visible, $this->get_id() );
    }

    /**
     * Returns whether or not the movie has any sources.
     *
     * @return boolean
     */
    public function has_sources() {
        $sources = $this->get_sources();
        if( ! empty( $sources ) ) {
            foreach ( $sources as $source ) {
                $source_src = '';
                $source_choice = ! empty( $source['choice'] ) ? $source['choice'] : '';

                if ( $source_choice == 'movie_embed' && ! empty( $source['embed_content'] ) ) {
                    $source_src = $source['embed_content'];
                } elseif ( $source_choice == 'movie_url' && ! empty( $source['link'] ) ) {
                    $source_src = $source['link'];
                }

                if( ! empty( $source_src ) ) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Returns whether or not the movie has any visible attributes.
     *
     * @return boolean
     */
    public function has_attributes() {
        foreach ( $this->get_attributes() as $attribute ) {
            if ( $attribute->get_visible() ) {
                return true;
            }
        }
        return false;
    }

    /**
     * Returns whether or not the movie has any child movie.
     *
     * @return bool
     */
    public function has_child() {
        return 0 < count( $this->get_children() );
    }

    /*
    |--------------------------------------------------------------------------
    | Non-CRUD Getters
    |--------------------------------------------------------------------------
    */

    /**
     * Get the movie's title. For movies this is the movie name.
     *
     * @return string
     */
    public function get_title() {
        return apply_filters( 'masvideos_movie_title', $this->get_name(), $this );
    }

    /**
     * Movie permalink.
     *
     * @return string
     */
    public function get_permalink() {
        return get_permalink( $this->get_id() );
    }

    /**
     * Returns the children IDs if applicable. Overridden by child classes.
     *
     * @return array of IDs
     */
    public function get_children() {
        return array();
    }

    /**
     * Returns the main movie image.
     *
     * @param string $size (default: 'masvideos_thumbnail').
     * @param array  $attr Image attributes.
     * @param bool   $placeholder True to return $placeholder if no image is found, or false to return an empty string.
     * @return string
     */
    public function get_image( $size = 'masvideos_thumbnail', $attr = array(), $placeholder = true ) {
        if ( $this->get_image_id() ) {
            $image = wp_get_attachment_image( $this->get_image_id(), $size, false, $attr );
        } elseif ( $this->get_parent_id() ) {
            $parent_movie = masvideos_get_movie( $this->get_parent_id() );
            $image          = $parent_movie->get_image();
        } elseif ( $placeholder ) {
            $image = masvideos_placeholder_img( $size );
        } else {
            $image = '';
        }

        return apply_filters( 'masvideos_movie_get_image', $image, $this, $size, $attr, $placeholder, $image );
    }

    /**
     * Returns a single movie attribute as a string.
     *
     * @param  string $attribute to get.
     * @return string
     */
    public function get_attribute( $attribute ) {
        $attributes = $this->get_attributes();
        $attribute  = sanitize_title( $attribute );

        if ( isset( $attributes[ $attribute ] ) ) {
            $attribute_object = $attributes[ $attribute ];
        } elseif ( isset( $attributes[ 'pa_' . $attribute ] ) ) {
            $attribute_object = $attributes[ 'pa_' . $attribute ];
        } else {
            return '';
        }
        return $attribute_object->is_taxonomy() ? implode( ', ', masvideos_get_movie_terms( $this->get_id(), $attribute_object->get_name(), array( 'fields' => 'names' ) ) ) : masvideos_implode_text_attributes( $attribute_object->get_options() );
    }

    /**
     * Get the total amount (COUNT) of ratings, or just the count for one rating e.g. number of 10 star ratings.
     *
     * @param  int $value Optional. Rating value to get the count for. By default returns the count of all rating values.
     * @return int
     */
    public function get_rating_count( $value = null ) {
        $counts = $this->get_rating_counts();

        if ( is_null( $value ) ) {
            return array_sum( $counts );
        } elseif ( isset( $counts[ $value ] ) ) {
            return absint( $counts[ $value ] );
        } else {
            return 0;
        }
    }
}
