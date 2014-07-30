<?php

/**
* Bootstrap Paginator Helper
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

App::import('Helper', 'Paginator') ;

class BootstrapPaginatorHelper extends PaginatorHelper {

    protected function _extractOption ($key, $options, $default = null) {
        if (isset($options[$key])) {
            return $options[$key] ;
        }
        return $default ;
    }
    
    /**
     * 
     * Get link to the first pagination page.
     * 
     * @param $title The link text
     * @param $options Options for link
     * @param $disabledtitle Title when link is disabled
     * @param $disabledOptions Options for link when it's disabled
     * 
    **/
    public function first ($title = '<<', $options = array(), $disabledTitle = null, $disabledOptions = array()) {
        $options = array_merge(array('tag' => 'li'), $options) ;
        $disabledOptions = array_merge(array('tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a'),
            $disabledOptions) ;
        return parent::first($title, $options, $disabledTitle, $disabledOptions) ;        
    }
    
    /**
     * 
     * Get link to the previous pagination page.
     * 
     * @param $title The link text
     * @param $options Options for link
     * @param $disabledtitle Title when link is disabled
     * @param $disabledOptions Options for link when it's disabled
     * 
    **/
    public function prev ($title = '<', $options = array(), $disabledTitle = null, $disabledOptions = array()) {
        $options = array_merge(array('tag' => 'li'), $options) ;
        $disabledOptions = array_merge(array('tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a'),
            $disabledOptions) ;
        return parent::prev($title, $options, $disabledTitle, $disabledOptions) ;        
    }
    
    /**
     * 
     * Get link to the next pagination page.
     * 
     * @param $title The link text
     * @param $options Options for link
     * @param $disabledtitle Title when link is disabled
     * @param $disabledOptions Options for link when it's disabled
     * 
    **/
    public function next ($title = '>', $options = array(), $disabledTitle = null, $disabledOptions = array()) {
        $options = array_merge(array('tag' => 'li'), $options) ;
        $disabledOptions = array_merge(array('tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a'),
            $disabledOptions) ;
        return parent::next($title, $options, $disabledTitle, $disabledOptions) ;        
    }
    
    /**
     * 
     * Get link to the last pagination page.
     * 
     * @param $title The link text
     * @param $options Options for link
     * @param $disabledtitle Title when link is disabled
     * @param $disabledOptions Options for link when it's disabled
     * 
    **/
    public function last ($title = '>>', $options = array(), $disabledTitle = null, $disabledOptions = array()) {
        $options = array_merge(array('tag' => 'li'), $options) ;
        $disabledOptions = array_merge(array('tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a'),
            $disabledOptions) ;
        return parent::last($title, $options, $disabledTitle, $disabledOptions) ;        
    }
    
        
    /**
     * 
     * Get pagination link list.
     * 
     * @param $options Options for link element
     *
     * Extra options:
     *  - size small/normal/large (default normal)
     *       
    **/
    public function numbers ($options = array()) {
    
        $default = array(
            'tag' => 'li',
            'currentTag' => 'a', 
            'separator' => '', 
            'currentClass' => 'active', 
            'disabledTag' => 'a',
            'size' => 'normal') ;
        $options = array_merge($default, $options) ;
        
        $size = $options['size'] ; unset($options['size']) ;
        
        $class = 'pagination' ;

        if (isset($options['ulClass'])) {
            $class .= ' '.$options['ulClass'] ;
            unset($options['ulClass']) ;
        }
        
        switch ($size) {
        case 'small':
            $class .= ' pagination-sm' ;
            break ;
        case 'large':
            $class .= ' pagination-lg' ;
            break ;
        }
          
        $options['before'] = '<ul class="'.$class.'">' ;
        $options['after'] = '</ul>' ;

        if (isset($options['prev'])) {
            $options['before'] .= $this->prev($options['prev']) ;
        }

        if (isset($options['next'])) {
            $options['after'] = $this->next($options['next']).$options['after'] ;
        }
                
        return parent::numbers ($options) ;
    }

}

?>
