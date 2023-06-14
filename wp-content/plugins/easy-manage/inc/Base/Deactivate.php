<?php 
/**
*
* @package easymanage
*/

namespace Inc\Base;

class Deactivate {
    static function deactivate() {
        flush_rewrite_rules();
    }
}