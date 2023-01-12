# Yoast SEO Multisite Subdirectory Sitemaps

Adds links to all subsite sitemaps to the main site's sitemap index automatically.

## When to use this plugin?

* You have a multisite that is not subdomain `subsite.mainsite.fi` installation but subdirectory installation `mainsite.fi/subsite`.
* You are using [Yoast SEO](https://wordpress.org/plugins/wordpress-seo/)

## Installation

* Insert this directory into `/wp-content/plugins/` (you can also download it as zip file through WordPress Plugin view)
* Activate

Notice that this plugin won't save anything to your installation so you need to keep this plugin active to keep inclusions working.

## Customization

You can exclude sites by adding site ids as an array to filter `em_yoast_seo_multisite_subdirectory_sitemaps/excluded_site_ids`. Note that sites where `public` is not set to `1` are automatically excluded.
