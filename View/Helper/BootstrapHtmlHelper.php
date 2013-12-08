<?php

/**
* Bootstrap Html Helper
*
*
* PHP 5
*
*  Licensed under the Apache License, Version 2.0 (the "License");
*  you may not use this file except in compliance with the License.
*  You may obtain a copy of the License at
*
*      http://www.apache.org/licenses/LICENSE-2.0
*
*
* @copyright Copyright (c) Mikaël Capelle (http://mikael-capelle.fr)
* @link http://mikael-capelle.fr
* @package app.View.Helper
* @since Apache v2
* @license http://www.apache.org/licenses/LICENSE-2.0
*/

App::import('Helper', 'Html') ;

class BootstrapHtmlHelper extends HtmlHelper {    

    private function _extractOption ($key, $options, $default = null) {
        if (isset($options[$key])) {
            return $options[$key] ;
        }
        return $default ;
    }
    
    /**
     * 
     * Check type values in $options, returning null if no option is found or if
     * option found is equal to $default or if otion is not in $avail.
     * 
    **/
    private function _extractType ($options, $key = 'type', $default = 'info', 
                                      $avail = array('info', 'success', 'warning', 'error')) {
        $type = $this->_extractOption($key, $options, $default) ;
        if ($default !== false && $type == $default) {
            return null ;
        }
        if (!in_array($type, $avail)) {
            return null ;
        }
        return $type ;
    }

    /**
     * 
     * Create a Twitter Bootstrap icon.
     * 
     * @param $icon The type of the icon (search, pencil, etc.)
     * @param $color The color of the icon (black or white)
     * 
    **/
    public function icon ($icon, $color = 'black') {
        return '<i class="icon-'.$icon.' icon-'.$color.'"></i>' ; 
    }
    
    /**
     *
     * Create a Twitter Bootstrap span label.
     * 
     * @param text The label text
     * @param options Options for span
     *
     * Extra options
     *  - type The type of the label
     *
    **/
    public function label ($text, $options = array()) {
        $type = $this->_extractType($options, 'type', $default = false,
                    array('default', 'success', 'warning', 'info', 'danger')) ;
        unset ($options['type']) ;
        $options = $this->addClass($options, 'label') ;
        $options = $this->addClass($options, 'label-'.$type) ;
        return $this->tag('span', $text, $options) ;
    }
    
    /**
     *
     * Create a Twitter Bootstrap span badge.
     * 
     * @param text The badge text
     * @param options Options for span
     *
     * Extra options
     *  - type The type of the badge
     *
    **/
    public function badge ($text, $options = array()) {
        $type = $this->_extractType($options, 'type', $default = false,
                    array('default', 'success', 'warning', 'info', 'danger')) ;
        unset ($options['type']) ;
        $options = $this->addClass($options, 'badge') ;
        $options = $this->addClass($options, 'badge-'.$type) ;
        return $this->tag('span', $text, $options) ;
    }

    /**
     * 
     * Get crumb lists in a HTML list, with bootstrap like style.
     *
     * @param $options Options for list
     * @param $startText Text to insert before list
     * 
     * Unusable options:
     * 	- Separator
    **/
    public function getCrumbList($options = array(), $startText = null) {
        $options['separator'] = '' ;
        $options = $this->addClass($options, 'breadcrumb') ;
        return parent::getCrumbList ($options, $startText) ;
    }
    
    /**
     *  
     * Create a Twitter Bootstrap style alert block, containing text.
     *  
     * @param $text The alert text
     * @param $options Options that will be passed to Html::div method
     * 
     * 
     * Available BootstrapHtml options:
     * 	- block: boolean, specify if alert should have 'alert-block' class
     * 	- type: string, type of alert (default, error, info, success)
     *     
    **/
    public function alert ($text, $options = array()) {
        $button = '<button class="close" data-dismiss="alert">&times;</button>' ;
        $type = $this->_extractType($options, 'type', 'warning', array('info', 'success', 'danger')) ;
        unset($options['type']) ;
        $block = $this->_extractOption('block', $options, false) ;
        unset($options['block']) ;
        $options = $this->addClass($options, 'alert') ;
        if ($block) {
            $options = $this->addClass($options, 'alert-block') ;
        }
        if ($type) {
            $options = $this->addClass($options, 'alert-'.$type) ;
        }
        $class = $options['class'] ;
        unset($options['class']) ;
        return $this->div($class, $button.$text, $options) ;
    }
    
    /**
     * 
     * Create a Twitter Bootstrap style progress bar.
     * 
     * @param $widths 
     * 	- The width (in %) of the bar
     * 	- An array of bar, with width and type (info, danger, success, warning) specified for each bar
     * @param $options Options that will be passed to Html::div method (only for main div)
     *  
     * Available BootstrapHtml options:
     * 	- striped: boolean, specify if progress bar should be striped
     * 	- active: boolean, specify if progress bar should be active
     *     
    **/
    public function progress ($widths, $options = array()) {
        $striped = $this->_extractOption('striped', $options, false) ;
        unset($options['striped']) ;
        $active = $this->_extractOption('active', $options, false) ;
        unset($options['active']) ;
        $bars = '' ;
        if (is_array($widths)) {
            foreach ($widths as $w) {
                $class = 'progress-bar' ;
                $type = $this->_extractType($w, 'type', 'info', array('info', 'success', 'warning', 'danger')) ;
                if ($type) {
                    $class .= ' progress-bar-'.$type ;
                }
                $bars .= $this->div($class, '', array('style' => 'width: '.$w['width'].'%;')) ;
            }
        }
        else {
            $bars = $this->div('progress-bar', '', array('style' => 'width: '.$widths.'%;')) ;
        }
        $options = $this->addClass($options, 'progress') ;
        if ($active) {
            $options = $this->addClass($options, 'active') ;
        }
        if ($striped) {
            $options = $this->addClass($options, 'progress-striped') ;
        }
        $classes = $options['class'];
        unset($options['class']) ;
        return $this->div($classes, $bars, $options) ;
    }
    
}

?>
