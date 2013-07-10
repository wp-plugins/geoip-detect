=== GeoIP Detection ===
Contributors: benjaminpick
Tags: geoip, ip, locator, latitude, longitude
Requires at least: 3.5
Tested up to: 3.5.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Retrieving Geo-Information using the Maxmind GeoIP (Lite) Database.

== Description ==

Provide geographic information detected by an IP adress. This can be used in themes or other plugins.

**Features:**

* Provide 2 functions to lookup Geo-Information: 
  * geoip_detect_get_info_from_ip($ip)
  * geoip_detect_get_info_from_current_ip()
* Auto-Update the GeoIP database once a week
* See results of a specific IP in the wordpress backend.

This product includes GeoLite data created by MaxMind, available from http://www.maxmind.com.

== Installation ==

This plugin does not contain the database itself, so it has to be loaded before first use.
2 alternative ways of doing this:

= Automatic Installation =

Go to Tools > GeoIP Detect and click on the button `"Update now"`.
The database is written into the `/uploads`-Folder.

= Manual Installation =

1. Download the database at http://geolite.maxmind.com/download/geoip/database/GeoLiteCity.dat.gz
2. extract it and 
3. put it into the plugin directory.

== Screenshots ==

1. Backend options

== Changelog ==

= 1.1 =
* Add function geoip_detect_get_external_ip_adress(): Ask a webservice to tell me the external IP of the webserver.
* New filter: When developing locally, the external IP is used to determine the geographic location.

= 1.0 =

* First working release.
