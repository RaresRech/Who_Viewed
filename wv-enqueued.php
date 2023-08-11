<?php

/*
 * This class handles enqueueing all scripts and styles. 
 */

class ENQUEUED_SCRIPTS
{
    function __construct()
    {
        add_action('wp_enqueue_scripts',array($this, 'enqueue_custom_styles'));
    }

    public function enqueue_custom_styles() 
    {
        wp_enqueue_style('container-style', plugin_dir_url(__FILE__).'container-style.css');
    }
}

