<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 1/20/18
 * Time: 2:42 PM
 */

namespace App\SM;

use Illuminate\Support\Facades\Cache;
use Barryvdh\Debugbar\Facade as Debugbar;


trait SM_Cache {
	public static function getCache( $key, $callback, $tags = [] ) {
//		echo "<pre>";
//		print_r($callback);
//		echo "</pre>";
//		exit();
		$isEnableCaching = (int) SM::get_setting_value( 'is_cache_enable', 1 );
		if ( $isEnableCaching === 1 ) {
//			Debugbar::info( "Cache isEnableCaching = $isEnableCaching, key = $key, tags = " );
			$ctm = SM::get_setting_value( 'cache_update_time', config( 'constant.cachingTimeInMinutes' ) );
			if ( count( $tags ) > 0 ) {
				$driver = Cache::getDefaultDriver();

				if ( $driver === 'redis' || $driver === 'memcached' ) {
					return Cache::tags( $tags )
					            ->remember( $key, $ctm, $callback );
				} else {
					return Cache::remember( $key, $ctm, $callback );
				}
			} else {
				return Cache::remember( $key, $ctm, $callback );
			}
		} else {
			return $callback();
		}
	}

	public static function removeCache( $keyOrTags, $isTaggableCache = 0 ) {
		if ( $isTaggableCache === 1 ) {
			if ( count( $keyOrTags ) > 0 ) {
				$driver = Cache::getDefaultDriver();

				if ( $driver === 'redis' || $driver === 'memcached' ) {
					Cache::tags( $keyOrTags )->flush();
				} else {
					Cache::flush();
				}
			}
		} else {
			if ( Cache::has( $keyOrTags ) ) {
				Cache::forget( $keyOrTags );
			}
		}
	}

	public static function getPartialCache( $key, $view ) {
		if ( Cache::has( $key ) ) {
			return Cache::get( $key );
		} else {
			return Cache::rememberForever( $key, function () use ( $view ) {
				return \View::make( 'partials.' . $view )->render();
			} );
		}
	}
}