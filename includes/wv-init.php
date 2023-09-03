<?php

class WV_OPTIONS_PAGE
{
    /*
     * The constructor is only responsible for linking the activation and deactivation functions.
     */

    public $isActive = false;

    function __construct()
    {
        register_activation_hook(__FILE__, array($this, 'who_viewed_activation_function'));
        register_deactivation_hook(__FILE__, function ()
        {
            remove_menu_page('who-viewed-options');
        });

        $this->isActive = true;
    }

    /*
     * Options
     */

    public function who_viewed_options_page()
    {
        add_options_page(
            'Who Viewed',                               // Page Title
            'Who Viewed',                               // Menu Title
            'manage_options',                           // Capability
            'who_viewed',                               // Menu Slug
            array($this, 'who_viewed_render_page')      // Callback function to render the page
        );
    }

    /*
     * Activation function, adding the menu
     */

    public function who_viewed_activation_function()
    {
        add_action('admin_menu', array($this, 'who_viewed_options_page'));
    }

    /*
     * Rendering the page
     */

    public function who_viewed_render_page()
    {
        ?>
        
        <div class="wrap">
            <?php //settings_errors(); ?>
            <h2>My Plugin Settings</h2>
            <form method="post" action="options.php">
                <?php
                settings_fields('who_viewed_group');
                do_settings_sections('who_viewed_page');
                submit_button();
                ?>
            </form>
        </div>
        
        <?php
    }

    /*
     * Initialize and register settings
     */

    public function who_viewed_settings_init()
    {
        add_settings_field(
            'who_viewed_post_types',
            'Select Post Types',
            array($this, 'who_viewed_post_types_callback'),
            'who_viewed_page',
            'who_viewed_section'
        );
        add_settings_section(
            'who_viewed_section',
            'Enable Feature',
            array($this, 'who_viewed_section_callback'),
            'who_viewed_page'
        );

        add_settings_field(
            'who_viewed_enabled',
            'Enable the feature',
            array($this, 'who_viewed_enabled_callback'),
            'who_viewed_page',
            'who_viewed_section'
        );
        add_settings_field(
            'who_viewed_bg_color',
            'Select Background Color (HEX)',
            array($this, 'who_viewed_bg_color_callback'),
            'who_viewed_page',
            'who_viewed_section'
        );
        add_settings_field(
            'who_viewed_acc_color',
            'Select Accent Color (HEX)',
            array($this, 'who_viewed_acc_color_callback'),
            'who_viewed_page',
            'who_viewed_section'
        );
        add_settings_field(
            'who_viewed_text',
            'Custom Text',
            array($this, 'who_viewed_text_callback'),
            'who_viewed_page',
            'who_viewed_section'
        );
        add_settings_field(
            'who_viewed_icon',
            'Icon',
            array($this, 'who_viewed_icon_callback'),
            'who_viewed_page',
            'who_viewed_section'
        );
        add_settings_field(
            'who_viewed_useThumbnail',
            'Display post thumbnail in the accent',
            array($this, 'who_viewed_useThumbnail_callback'),
            'who_viewed_page',
            'who_viewed_section'
        );
        add_settings_field(
            'who_viewed_timeZone',
            'Time zone',
            array($this, 'who_viewed_timeZone_callback'),
            'who_viewed_page',
            'who_viewed_section'
        );
        add_settings_field(
            'who_viewed_scale',
            'Scale',
            array($this, 'who_viewed_scale_callback'),
            'who_viewed_page',
            'who_viewed_section'
        );
        add_settings_field(
            'who_viewed_h_alignment',
            'Horizontal allignment',
            array($this, 'who_viewed_h_alignment_callback'),
            'who_viewed_page',
            'who_viewed_section'
        );
        add_settings_field(
            'who_viewed_v_alignment',
            'Vertical allignment',
            array($this, 'who_viewed_v_alignment_callback'),
            'who_viewed_page',
            'who_viewed_section'
        );
        add_settings_field(
            'who_viewed_hasExit',
            'Exit button',
            array($this, 'who_viewed_hasExit_callback'),
            'who_viewed_page',
            'who_viewed_section'
        );
        add_settings_field(
            'who_viewed_timeIntervals',
            'Time intervals',
            array($this, 'who_viewed_timeIntervals_callback'),
            'who_viewed_page',
            'who_viewed_section'
        );
        add_settings_field(
            'who_viewed_timeIntervalsWeights',
            'Time interval weights',
            array($this, 'who_viewed_timeIntervalsWeights_callback'),
            'who_viewed_page',
            'who_viewed_section'
        );

        register_setting('who_viewed_group', 'who_viewed_enabled');
        register_setting('who_viewed_group', 'who_viewed_bg_color');
        register_setting('who_viewed_group', 'who_viewed_acc_color');
        register_setting('who_viewed_group', 'who_viewed_text');
        register_setting('who_viewed_group', 'who_viewed_icon');
        register_setting('who_viewed_group', 'who_viewed_useThumbnail');
        register_setting('who_viewed_group', 'who_viewed_timeZone');
        register_setting('who_viewed_group', 'who_viewed_scale');
        register_setting('who_viewed_group', 'who_viewed_h_alignment');
        register_setting('who_viewed_group', 'who_viewed_v_alignment');
        register_setting('who_viewed_group', 'who_viewed_post_types');
        register_setting('who_viewed_group', 'who_viewed_hasExit');
        register_setting('who_viewed_group', 'who_viewed_timeIntervals', array($this, 'sanitize_time_intervals'));
        register_setting('who_viewed_group', 'who_viewed_timeIntervalWeights', array($this, 'sanitize_weights'));
    }

    /*
     * Post Types field callback
     */

    public function who_viewed_post_types_callback()
    {
         $selected_post_types = get_option('who_viewed_post_types', array());
 
         $post_types = get_post_types(array('public' => true), 'objects');
         ?>
         <fieldset>
             <legend class="screen-reader-text"><span>Post Types</span></legend>
             <?php
             foreach ($post_types as $post_type) {
                 ?>
                 <label>
                     <input type="checkbox" name="who_viewed_post_types[]" value="<?php echo esc_attr($post_type->name); ?>" <?php checked(in_array($post_type->name, $selected_post_types)); ?>>
                     <?php echo esc_html($post_type->label); ?>
                 </label><br>
                 <?php
             }
             ?>
         </fieldset>
         <?php
    }

    /*
     * Section callback
     */

    public function who_viewed_section_callback()
    {
        echo 'We do not know your website. Please configure the plugin to your liking and to the scale of your audience: ';
    }

    /*
     * Checkbox field callback
     */

    public function who_viewed_enabled_callback()
    {
        $enabled = get_option('who_viewed_enabled', false);
        ?>
        <label for="who_viewed_enabled">
            <input type="checkbox" id="who_viewed_enabled" name="who_viewed_enabled" value="1" <?php checked($enabled); ?>>
            Enable
        </label>
        <pre><p><b>Must be enabled</b></p></pre>
        <?php
    }
    public function who_viewed_hasExit_callback()
    {
        $enabled = get_option('who_viewed_hasExit', false);
        ?>
        <label for="who_viewed_hasExit">
            <input type="checkbox" id="who_viewed_hasExit" name="who_viewed_hasExit" value="1" <?php checked($enabled); ?>>
            Enable
        </label>
        <?php
    }

    /*
     * Color picker field callback
     */

     public function who_viewed_bg_color_callback()
     {
         $color = get_option('who_viewed_bg_color', '#000000');
         ?>
         <input type="text" id="who_viewed_bg_color" name="who_viewed_bg_color" value="<?php echo esc_attr($color); ?>" class="color-picker" />

         <pre><p><b><u><a href = "https://g.co/kgs/eDQmVt">HEX</a></u></b>    The color you wish to be displayed in the notification <b>body</b></p></pre>
         <?php
     }

     public function who_viewed_acc_color_callback()
     {
         $color = get_option('who_viewed_acc_color', '#000000');
         ?>
         <input type="text" id="who_viewed_acc_color" name="who_viewed_acc_color" value="<?php echo esc_attr($color); ?>" class="color-picker" />

         <pre><b><u><a href = "https://g.co/kgs/eDQmVt">HEX</a></u></b>    The color you wish to be displayed in the notification <b>accent</b></p></pre>
         <?php
     }

    /*
     * Text field callback
     */

    public function who_viewed_text_callback()
    {
        $text = get_option('who_viewed_text', '');
        ?>
        <input type="text" id="who_viewed_text" name="who_viewed_text" value="<?php echo esc_attr($text); ?>" class="regular-text" />
        <pre><p><b><u>TEXT</u></b>    The text you wish to be displayed in the notification <b>body</b></p></pre>
        <?php
    }
    public function who_viewed_icon_callback()
    {
        $text = get_option('who_viewed_icon', '');
        ?>
        <input type="text" id="who_viewed_icon" name="who_viewed_icon" value="<?php echo esc_attr($text); ?>" class="regular-text" />
        <pre><p><b><u><a href ="https://fontawesome.com/icons">TEXT</a></u></b>    <div style="color:red"><b>NOT FUNCTIONAL YET</b></div>The icon you wish to be displayed in the notification <b>accent</b>. Example: <i>fas fa-eye</i>. Leave empty for solid color</p></pre>
        <?php
    }

    public function who_viewed_useThumbnail_callback()
    {
        $text = get_option('who_viewed_useThumbnail', '');
        ?>
        <input type="checkbox" id="who_viewed_useThumbnail" name="who_viewed_useThumbnail" value="1" <?php checked(get_option('who_viewed_useThumbnail', false)); ?>>
        <pre><p><b><u>Enable to display the post thumbnail in the accent.</a></u></b></div> Note that this will override any icon you select.</p></pre>
        <?php
    }

    public function who_viewed_timeZone_callback()
    {
        $text = get_option('who_viewed_timeZone', '');
        ?>
        <input type="text" maxlength ="20" id="who_viewed_timeZone" name="who_viewed_timeZone" value="<?php echo esc_attr($text); ?>" class="regular-text" />
        <pre><p><p><b><u>Continent/Country</u></b>    We keep track of <b>time zones</b> for you, making the view count more realistic. <a href = "https://www.php.net/manual/en/timezones.php">List of <b>timezones</b></a></p></pre>
        <?php
    }
    public function who_viewed_scale_callback()
    {
        $text = get_option('who_viewed_scale', '');
        ?>
        <input type="text" style ="width:60px;" maxlength ="5" id="who_viewed_scale" name="who_viewed_scale" value="<?php echo esc_attr($text); ?>" class="regular-text" />
        <pre><p><b><u>FLOAT</u></b>    Please start with <b>low values</b> (0.2 , 0.3) and work your way up to the desired view count</p></pre>
        <?php
    }

    /*
     * Alignment field callback
     */

     public function who_viewed_h_alignment_callback()
     {
         $alignment = get_option('who_viewed_h_alignment', 'left');
         ?>
         <fieldset>
             <legend class="screen-reader-text"><span>Alignment</span></legend>
             <label>
                 <input type="radio" name="who_viewed_h_alignment" value="left" <?php checked($alignment, 'left'); ?>>
                 Left
             </label><br>
             <label>
                 <input type="radio" name="who_viewed_h_alignment" value="middle" <?php checked($alignment, 'middle'); ?>>
                 Middle
             </label><br>
             <label>
                 <input type="radio" name="who_viewed_h_alignment" value="right" <?php checked($alignment, 'right'); ?>>
                 Right
             </label>
         </fieldset>
         <?php
     }

     public function who_viewed_v_alignment_callback()
     {
         $alignment = get_option('who_viewed_v_alignment', 'left');
         ?>
         <fieldset>
             <legend class="screen-reader-text"><span>Alignment</span></legend>
             <label>
                 <input type="radio" name="who_viewed_v_alignment" value="top" <?php checked($alignment, 'top'); ?>>
                 Top
             </label><br>
             <label>
                 <input type="radio" name="who_viewed_v_alignment" value="middle" <?php checked($alignment, 'middle'); ?>>
                 Middle
             </label><br>
             <label>
                 <input type="radio" name="who_viewed_v_alignment" value="bottom" <?php checked($alignment, 'bottom'); ?>>
                 Bottom
             </label>
         </fieldset>
         <?php
     }
     
     /*
      * Time interval field callback and additional functions
      */

     public function who_viewed_timeIntervals_callback()
     {

         $timeIntervals = get_option('who_viewed_timeIntervals', array());

         if (is_array($timeIntervals)) {
             $timeIntervalsText = implode("\n", $timeIntervals);
         } else {
             $timeIntervalsText = "";
         }

     
         ?>
         <fieldset>
             <legend class="screen-reader-text"><span>Time Intervals</span></legend>
             <label for="who_viewed_timeIntervals">Add Time Intervals (HH-HH, one per line), leave empty for defaults: </label>
             <textarea id="who_viewed_timeIntervals" name="who_viewed_timeIntervals" rows="5" cols="50" placeholder="e.g., 08-10&#10;13-16"><?php echo esc_textarea($timeIntervalsText); ?></textarea>
         </fieldset>
         <?php
     }

     public function sanitize_time_intervals($input)
     {
        $defaultState = false;
         // Convert the textarea input to an array
         $timeIntervals = explode("\n", $input);
         $timeIntervals = array_map('trim', $timeIntervals);
     
         // Filter out empty lines and ensure valid format
         $filteredIntervals = array_filter($timeIntervals, function($interval) {
             return preg_match('/^\d{2}-\d{2}$/', $interval);
         });
     
         // Use default value if input is empty
         if (empty($filteredIntervals)) {
            $defaultState = true;
             $filteredIntervals = array(
                 "00-02",
                 "03-07",
                 "08-12",
                 "13-16",
                 "17-18",
                 "18-19",
                 "20-21",
                 "22-23"
             );
             update_option('who_viewed_timeIntervalWeights', array(
                0.5,
                1.0,
                1.5,
                1.0,
                1.5,
                2.0,
                2.0,
                1.0
            ));

         }
     
         // Check for overlapping intervals
         $nonOverlappingIntervals = $this->remove_overlapping_intervals($filteredIntervals);
     
         if (count($filteredIntervals) !== count($nonOverlappingIntervals) && !$defaultState) {
             add_settings_error(
                 'who_viewed_group',
                 'overlapping_intervals',
                 'Overlapping intervals detected. Please make sure intervals do not overlap.',
                 'error'
             );
         }
         if($defaultState)
         {
            add_settings_error(
                'who_viewed_group',
                'timeintervals_default',
                'Time intervals have been reset to default because the field has been left empty',
                'info'
            );
         }
     
        // Handle interval weights
        //$timeIntervalWeights = isset($_POST['who_viewed_timeIntervalWeights']) ? $_POST['who_viewed_timeIntervalWeights'] : array();

        return $nonOverlappingIntervals;
     }
     
     // Function to remove overlapping intervals
     private function remove_overlapping_intervals($intervals)
     {
         $nonOverlapping = array();
     
         foreach ($intervals as $interval) {
             $range = explode('-', $interval);
             $start = intval($range[0]);
             $end = intval($range[1]);
     
             // Check for overlaps
             $isOverlapping = false;
             foreach ($nonOverlapping as $existing) {
                 $existingRange = explode('-', $existing);
                 $existingStart = intval($existingRange[0]);
                 $existingEnd = intval($existingRange[1]);
     
                 if (($start >= $existingStart && $start <= $existingEnd) || 
                     ($end >= $existingStart && $end <= $existingEnd)) {
                     $isOverlapping = true;
                     break;
                 }
             }
     
             if (!$isOverlapping) {
                 $nonOverlapping[] = $interval;
             }
         }
     
         return $nonOverlapping;
     }
    
     public function sanitize_weights($input)
     {
         // Ensure the input is an array
         if (!is_array($input)) {
             return array();
         }
     
         // Sanitize and validate each weight
         $sanitized_weights = array();
         foreach ($input as $weight) {
             // Ensure each weight is a valid float
             $sanitized_weight = floatval($weight);
             // Ensure weights are greater than 0
             if ($sanitized_weight <= 0) {
                 $sanitized_weight = 1.0; // Default weight if invalid
             }
             $sanitized_weights[] = $sanitized_weight;
         }
         return $sanitized_weights;
     }
     
     
     public function who_viewed_timeIntervalsWeights_callback()
     {
         $timeIntervals = get_option('who_viewed_timeIntervals', array());
         $timeIntervalWeights = get_option('who_viewed_timeIntervalWeights', array());
     
         if (empty($timeIntervalWeights)) {
            if(!is_array($timeIntervals))
            {
                $timeIntervals = explode(" ",$timeIntervals);    
            }
         }
     
         ?>
         <fieldset>
             <legend class="screen-reader-text-weights"><span>Weights for the time intervals:</span></legend>
             <?php
             foreach ($timeIntervals as $index => $interval) {
                 $weight = isset($timeIntervalWeights[$index]) ? esc_attr($timeIntervalWeights[$index]) : 1.0;
                 ?>
                 <label>
                    <input type="text" name="who_viewed_timeIntervalWeights[]" style = "width: 50px;" value="<?php echo $weight; ?>" >
                    <?php echo esc_html($interval); ?>
                 </label><br>
                 <?php
             }
             ?>
            <p>Each <b>float</b> represents the amplification factor in each time interval. For example, for a base value of 2-3 viewers, a weight of 2 will make it 4-6 viewers. Note that the <b>scale</b> option is also always used as a general amplifier.</p>
            <p>For realistic results, slightly increase the weights in time intervals that usually have more traffic.</p>
        </fieldset>
         <?php
     }
     

    /*
     * Get all settings
     */

    public function get_all_settings()
    {
        $settings = array(
            'who_viewed_enabled'        => get_option('who_viewed_enabled', false),
            'who_viewed_bg_color'       => get_option('who_viewed_bg_color', false),
            'who_viewed_acc_color'      => get_option('who_viewed_acc_color', false),
            'who_viewed_text'           => get_option('who_viewed_text', false),
            'who_viewed_h_alignment'    => get_option('who_viewed_h_alignment', false),
            'who_viewed_v_alignment'    => get_option('who_viewed_v_alignment', false),
            'who_viewed_timeZone'       => get_option('who_viewed_timeZone', false),
            'who_viewed_scale'          => get_option('who_viewed_scale', false),
            'who_viewed_icon'           => get_option('who_viewed_icon', false),
            'who_viewed_useThumbnail'   => get_option('who_viewed_useThumbnail', false),
            'who_viewed_post_types'     => get_option('who_viewed_post_types', array()),
            'who_viewed_hasExit'        => get_option('who_viewed_hasExit', false),
            'who_viewed_timeInterval'   => get_option('who_viewed_timeIntervals', array()),
            'who_viewed_timeWeights'    => get_option('who_viewed_timeIntervalWeights', array())
            // MORE SETTINGS TO BE ADDED
        );

        return $settings;
    }
}
/*
 *  Instantiate the class and initialize settings
 */ 
$wv_options_page = new WV_OPTIONS_PAGE();
add_action('admin_init', array($wv_options_page, 'who_viewed_settings_init'));
