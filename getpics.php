<?php
/**
 * Main Program to read through the stuff
 *
 * Doc: missing
 *
 * @copyright (C) Mayflower GmbH for Vaillant Group
 * @author Alex Aulbach <alex.aulbach@mayflower.de> ({ssilk})
 * @created 23.10.12
 * @version $Id$
 *
 */

if ($argc <= 2) {
    die("Need 2 params: $argv[0] CONFIGFILE MODE\n");
}

// load config
include_once $argv[1];

$mode = $argv[2];
if (!in_array($mode, array('run', 'debug'))) {
    die("Unknown mode '$mode'\n");
}

$level = 0;
if ($mode == 'debug') {
    if (empty($argv[3])) {
        $level = 1;
    } else {
        $level = $argv[3];
    }
    $debug = true;
} else {
    $debug = false;
}

// config class is now globally available

$page = new page();

$page->purify();

if ($debug and $level == 1) {
    echo "CONTENT: " . $page->content;
    exit;
}

/////////////////////////////////////////////////////////

foreach (config::$filters as $name => $filters) {
    echo "NAME: $name\n";
    $content = $page->content;
    foreach ($filters as $filtergroupname => $filtergroups) {
        echo "FILTERGROUP $filtergroupname\n";
        foreach ($filtergroups as $filtertype => $filter) {
            echo "Filtertype: $filtertype $filter\n";
            switch ($filtertype) {
                case 'regex' :
                    $matches = array();
                    if (preg_match($filter, $content, $matches)) {
                        $content = $matches[1];
                    } else {
                        $content = 'not found';
                    }
            }
        }
    }
}






if ($debug and $level == 2) {
    echo "CONTENT: " . $content;
    exit;
}



#var_export($found_pics);

class page {

    public $content;


    public function __construct($uri = null)
    {
        $this->load($uri);
    }


    public function load($uri = null)
    {
        if (empty($uri)) {
            $uri = config::$baseUrl;
        }
        $this->content = file_get_contents($uri);
    }

    public function purify()
    {
        $this->content = preg_replace('!<script[^>]*?>.*?</script[^>]*?>!s', '', $this->content);
    }


}