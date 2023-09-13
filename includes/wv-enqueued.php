<?php

/*
 * This class handles enqueueing all scripts and styles. 
 */

class ENQUEUED_SCRIPTS
{
    function __construct()
    {
        add_action('wp_enqueue_scripts',array($this, 'enqueue_customs'));
        add_action('admin_enqueue_scripts',array($this, 'enqueue_admin'));
    }

    public function enqueue_customs() 
    {
        wp_enqueue_style('container-style', WV_PLUGIN_URI.'assets/toast/css/container-style.css');
        wp_enqueue_script('containter-behaviour', WV_PLUGIN_URI.'assets/toast/js/containter-behaviour.js');
    }
    public function enqueue_admin()
    {
        wp_register_style('wv-init-style',WV_PLUGIN_URI."assets/admin/css/wv-init-style.css",false,'1.0.0');
        wp_enqueue_style('wv-init-style');
    }
}
new ENQUEUED_SCRIPTS();
