<?php

/*
 * Plugin Name:       Who viewed
 * Plugin URI:        https://github.com/RaresRech/Who_Viewed
 * Description:       Display a !FAKE! viewer count for your posts, announcements, product pages, etc.
 * Version:           1.1
 * Requires at least: 5.0
 * Requires PHP:      7.4
 * Author:            Rares Rechesan
 * Author URI:        https://github.com/RaresRech/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       who-viewed
 * Domain Path:       /languages
 */

/*
 * REQUIRED FILES:
 */

define("WV_PLUGIN_URI", plugin_dir_url(__FILE__));
require_once("includes/wv-init.php");
require_once("includes/wv-enqueued.php");
require_once("includes/wv-viewcount.php");
require_once("includes/wv-utils.php");

/*
 * Initialization function: Creating an option page when the plugin is activated, (tbc).
 */

function who_viewed_init() {
    new ENQUEUED_SCRIPTS;                                  // Enqueue the styles and scripts
    $optionsPage = new WV_OPTIONS_PAGE();                  // Create an options page object
    $optionsPage->who_viewed_activation_function();        // Create (Or destroy) options page
    $utils = new UTILS();

    /*
     * Get settings from the options page
     */
    $settings = $optionsPage->get_all_settings();

    /*
     * Add HTML to the selected post types
     */

    if ($settings['who_viewed_enabled']) {
        foreach ($settings['who_viewed_post_types'] as $postType) {

            $viewcountParamArray = array(
                'postType'          => $postType,
                'scale'             => $settings["who_viewed_scale"],
                'timeZone'          => $settings["who_viewed_timeZone"],
                'displayedText'     => $settings['who_viewed_text'],
                'accentColor'       => $settings['who_viewed_acc_color'],
                "backgroundColor"   => $settings['who_viewed_bg_color'],
                'faIcon'            => $settings['who_viewed_icon'],
                'useThumbnail'      => $settings['who_viewed_useThumbnail'],
                'hAlign'            => $settings['who_viewed_h_alignment'],
                'vAlign'            => $settings['who_viewed_v_alignment'],
                'hasExit'           => $settings['who_viewed_hasExit'],
                'interval'          => $settings['who_viewed_timeInterval'],
                'weights'           => $settings['who_viewed_timeWeights'],
                'selectedIcon'      => $settings['who_viewed_selectedIcon']
            );

            $viewCount = new WV_VIEWCOUNT($viewcountParamArray);
        }
    }
}

/*
 * Initialize plugin
 */

add_action('init', 'who_viewed_init');
