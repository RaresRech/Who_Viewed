<?php

/*
 * This class handles enqueueing all scripts and styles. 
 */

class ENQUEUED_SCRIPTS
{
    function __construct()
    {
        add_action('wp_enqueue_scripts',array($this, 'enqueue_customs'));
        add_action('wp_head', array($this, 'enqueue_head'));
    }

    public function enqueue_customs() 
    {
        wp_enqueue_style('container-style', WV_PLUGIN_URI.'wv-container/container-style.css');
        wp_enqueue_script('containter-behaviour', WV_PLUGIN_URI.'wv-container/containter-behaviour.js');
    }
    public function enqueue_head()
    {
        echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"></link>';
    }

}
new ENQUEUED_SCRIPTS();
