<?php

class config
{
    public static $baseUrl = 'http://photography.nationalgeographic.com/photography/photo-of-the-day/';

    public static $filters = array(

        'pics' => array(
            'content_Main div' => array(
                'regex' => '%content_mainA(.*)content_mainA%sm',
            ),
#            'blaaa' => array(
#                'regex' => '°°',
#            )
        )

    );


    /*
     *
     Idee: Eine Art Makefile machen
     Man definiert eine Menge von Regeln (Eine Regel ist zum Beispiel ein Regex
     und anschließend, in welcher Reihenfolge die anzuwenden sind.

    start => get_url  ...

    contentmainA => regex ...
    contentmainText => regex

    contentmainPic => if content.


    content => make start,contentmainA
    content.hasbigpic => make start,contentmainA
    text => make content,contentmainText
    pic => make contentcontentmainPic


    ... hm, das muss wohl noch trickier werden...

    */

    public static function pics($content)
    {
        $sxml = new SimpleXMLElement($content);
        $results = $sxml->xpath(".//*[@id='content_mainA']/div[1]/div/div[1]/div[2]/a");
        return $results;
    }
}

#
#    <div class="download_link"><a href="http://images.nationalgeographic.com/wpf/media-live/photos/000/600/custom/60072_1600x1200-wallpaper-cb1349989057.jpg">Download Wallpaper (1600 x 1200 pixels)</a></div>
#

