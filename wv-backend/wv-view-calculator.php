<?php

/*
 * Version 1.0
 * 
 * This class is responsable for calculating the viewcount of any particular post
 */

 class VIEW_GENERATOR
 {
     public $scaling;
 
     function __construct($_scaling = 1, $timeZone)
     {
         $this->scaling = $_scaling;
         date_default_timezone_set($timeZone);
     }
 
     function calculate($post_id)
     {
         $weekend_amplifier = 0.5;                   // Randomly amplify weekend views between 1.0 and 2.0
         $current_time = date('H');                 // Current hour in 24-hour format
 
         $time_intervals = array(
             1 => "00-02",
             2 => "03-07",
             3 => "08-12",
             4 => "13-16",
             5 => "17-18",
             6 => "18-19",
             7 => "20-21",
             8 => "22-23"
         );
 
         $weight_factors_time = array(
             1 => 0.5,
             2 => 1.0,
             3 => 1.5,
             4 => 1.0,
             5 => 1.5,
             6 => 2.0,
             7 => 2.0,
             8 => 1.0
         );
 
         /*
          * Determine the current time interval key
          */
 
         foreach ($time_intervals as $key => $interval) {
             list($start, $end) = explode('-', $interval);
             if ($current_time >= $start && $current_time <= $end) {
                 $mapped_interval = $key;
                 break;
             }
         }
 
         /*
          * Adjusting the value based on time intervals and weight factors
          */
 
         $base_viewCount = $mapped_interval * $weight_factors_time[$mapped_interval];
 
         /*
          * Add amplifier if it's a weekend
          */
 
         if (date('N') >= 6) { // Check if it's Saturday or Sunday
             $base_viewCount *= $weekend_amplifier;
         }
 
         /*
          * Getting the unique seed of a post
          */
 
         $seed = crc32($post_id);
         $random_value = random_int(-2,2); // Generate a random value between -2 and 2
 
         /*
          * Adjusting value based off seed
          */
 
         $calculated_viewCount = $base_viewCount + $random_value;
 
         /*
          * Adjusting it to be min 0 max 10 !TO BE MADE EDITABLE
          */
 
         //$adjusted_viewCount = intval(max(min($calculated_viewCount, 10), 0) / 3);
 
         return intval(intval($calculated_viewCount) * $this->scaling);
     }
 }
 
 