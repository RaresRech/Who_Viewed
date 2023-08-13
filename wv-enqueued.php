<?php

/*
 * This class handles enqueueing all scripts and styles. 
 */

class ENQUEUED_SCRIPTS
{
    function __construct()
    {
        add_action('wp_enqueue_scripts',array($this, 'enqueue_customs'));

    }

    public function enqueue_customs() 
    {
        wp_enqueue_style('container-style', plugin_dir_url(__FILE__).'container-style.css');
        wp_enqueue_script('containter-behaviour', plugin_dir_url(__FILE__).'containter-behaviour.js');
    }
}

