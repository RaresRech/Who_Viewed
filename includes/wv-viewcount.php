<?php

/*
 * Required file(s)
 */

require_once "wv-view-calculator.php";

class WV_VIEWCOUNT
{

    /*
     * Defining variables
     */

    private $postType;
    private $calculator;
    private $scale;
    private $timeZone;
    private $displayedText;
    private $accentColor;
    private $backgroundColor;
    private $faIcon;
    private $useThumbnail;
    private $hAlign;
    private $vAlign;
    private $hasExit;
    private $interval;
    private $weights;

    function __construct($params)
    {
        $this->postType = $params["postType"];
        $this->scale = $params["scale"];
        $this->timeZone = $params["timeZone"];
        $this->displayedText = $params["displayedText"];
        $this->accentColor = $params["accentColor"];
        $this->backgroundColor = $params["backgroundColor"];
        $this->faIcon = $params["faIcon"];
        $this->useThumbnail = $params["useThumbnail"];
        $this->hAlign = $params["hAlign"];
        $this->vAlign = $params["vAlign"];
        $this->hasExit = $params["hasExit"];
        if($params["interval"]!=null)
        {
            $this->interval = $params["interval"];        
        }
        $this->weights = $params["weights"];

        $this->calculator = new VIEW_GENERATOR($this->scale, $this->timeZone);

        add_filter("the_content", [$this, "display_toast"]);
    }

    /*
     * Adding the HTML to the page
     */

    public function display_toast()
    {
        if (is_singular($this->postType)) { ?>
                <div id="ttoast" style = "background-color: <?php echo $this->backgroundColor; ?>;
                    left:
                    <?php switch ($this->hAlign) {
                        case "left":
                            echo "5%";
                            break;
                        case "middle":
                            echo "40%";
                            break;
                        case "right":
                            echo "80%";
                    } ?>;
                    bottom:
                    <?php switch ($this->vAlign) {
                        case "bottom":
                            echo "5%";
                            break;
                        case "middle":
                            echo "40%";
                            break;
                        case "top":
                            echo "80%";
                    } ?>">

                    <div id="img" style = "background-color: <?php echo $this->accentColor; ?>">
                        <?php 
                        if(!$this->useThumbnail)
                        {
                            ?>
                                <i class="<?php echo $this->faIcon; ?>" id = "notificon"></i>
                            <?php
                        }
                        else
                        {
                            ?>
                                <div id = "thumbnail"><?php echo get_the_post_thumbnail(get_the_ID(),array(35,35))?></div>
                            <?php
                        }

                        ?>
                    </div>
                    <div id="desc">
                        
                        <?php echo $this->calculator->calculate(
                            get_the_ID(), $this->interval, $this->weights
                        ); ?> <?php echo $this->displayedText; ?>
                        <?php
                        if($this->hasExit)
                        {
                            ?>
                                <div class="closeButton" onclick="closeDiv()">x</div>
                            <?php
                        }
                        ?>
                    </div>
                </div>   
            <?php }
    }
}
