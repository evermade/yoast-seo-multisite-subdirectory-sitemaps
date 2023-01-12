<?php
/**
 * Plugin Name:         Yoast SEO Multisite Subdirectory Sitemaps
 * Plugin URI:          https://evermade.fi
 * Description:         Adds links to all subsite sitemaps to the main site's sitemap index automatically.
 * Version:             1.0.0
 * Author:              Evermade
 * Author URI:          https://evermade.fi
 * License:             GPL-2.0-or-later
 * License URI:         http://www.gnu.org/licenses/gpl-2.0.txt
 * GitHub Plugin URI:   https://github.com/evermade
 * Requires PHP:        7.4
 * Requires WP:         5.6
 */

/**
 * Adds links to all subsite sitemaps to the main site's sitemap index automatically.
 *
 * @param string $sitemap_index The sitemap index.
 * @return string
 */
function em_yoast_seo_multisite_subdirectory_sitemaps( $sitemap_index ) {

	if ( is_multisite() && ! is_subdomain_install() && is_main_site() ) {

		$sitemap_entry = <<<SITEMAP_INDEX_ENTRY
		<sitemap>
			<loc>%s</loc>
			<lastmod>%s</lastmod>
		</sitemap>
		SITEMAP_INDEX_ENTRY;

		$protocol = is_ssl() ? 'https://' : 'http://';

		$raw_blog_list = get_sites(
			[
				'number'       => 9000, // -1 is not supported
				'public'       => 1,
				'site__not_in' => array_merge(
					[ get_main_site_id() ],
					apply_filters( 'em_yoast_seo_multisite_subdirectory_sitemaps/excluded_site_ids', [] ),
				),
			]
		);
		foreach ( $raw_blog_list as $wp_site_object ) {
			if ( $wp_site_object instanceof WP_Site ) {
				$sitemap_index .= sprintf(
					$sitemap_entry,
					$protocol . $wp_site_object->domain . $wp_site_object->path . 'sitemap_index.xml',
					date( DATE_W3C, strtotime( $wp_site_object->last_updated ) )
				);
			}
		}
	}

	return $sitemap_index;
}
add_filter( 'wpseo_sitemap_index', 'em_yoast_seo_multisite_subdirectory_sitemaps' );
