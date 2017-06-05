# clientflow
Plugin shortcode Form will hold information that can be used to aquire basic website building strategies

Plugin Name: ClientFlow

Plugin URI: http://themes.tradesouthwest.com/wordpress/plugins/client

Description: Form from custom post type to handle new website client information.

Version: 0.1.0

Author: tradesouthwest

Author URI: http://tradesouthwest.com/

License: GPLv3

License URI: http://www.gnu.org/licenses/gpl-3.0.html


== Description ==
Creates a form which can be inserted on any page using shortcode. Form will hold information that can be used
to aquire basic website building strategies and helps provide a starting point for client and developer.
Demo at: https://leadspilot.com/website/website-form/

== Features ==
* Hard Coded form but very sufficient overview entries.
* Uses wp_mail and core functions for mail.
* Options to change title and set admin email to any email address.

== Installation ==
1. Upload clientflow.zip to the /wp-content/plugins/ directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Look for link to plugin from the "Tools" Menu

== Frequently Asked Questions ==
Q.: I see a custom post type called "Client" on my admin menu, what is this?
A.: CPT "Client" has a taxonomy for categories and can be used to build a post manager for you clients. This is done
as a keen way to save important clients to WPdatabase without having every email sent clutterring the wpdb.
Simply copy and paste the email to your custom post and save. You can also create a master index to display client
by refferal source by creating a category for each referral source.
Q.: Why is there a few lines of code commented out in the enqueue scripts?
A.: Form is not submitted using Ajax, but should be. Next version may do this but I left theoption for more advanced developers to do so.

== Screenshots ==
1. Admin panel sets email and title
2. Sent email sample from a gmail account
3. Page top half of form
4. Bottom half of form
5. Client custom post page

== Change Log ==
June 3rd 2017
0.1.0
*first release - original version

== Plugin License ==
This plugin compatible with the GNU General Public License v3.
