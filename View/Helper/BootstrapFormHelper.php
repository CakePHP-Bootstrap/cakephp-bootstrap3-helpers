<?php

/**
* Bootstrap Form Helper
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

App::import('Helper', 'Form') ;

class BootstrapFormHelper extends FormHelper {

    public $helpers = array('Html') ;

    public $horizontal = false ;
    public $inline = false ;
    public $search = false ;

    private $colSize ;

    private $buttonTypes = array('primary', 'info', 'success', 'warning', 'danger', 'inverse', 'link') ;
    private $buttonSizes = array('sm', 'md', 'lg') ;

    private $currentInputType = null ;

    /**
     *
     * Add classes to options according to values of bootstrap-type and bootstrap-size for button.
     *
     * @param $options The initial options with bootstrap-type and/or bootstrat-size values
     *
     * @return The new options with class values (btn, and btn-* according to initial options)
     *
    **/
    protected function _addButtonClasses ($options) {
        $options = $this->addClass($options, 'btn btn-default') ;

		if (isset($options['bootstrap-type']) && in_array($options['bootstrap-type'], $this->buttonTypes)){
			$options = $this->addClass($options, 'btn-'.$options['bootstrap-type']) ;
		}

		if (isset($options['bootstrap-size']) && in_array($options['bootstrap-size'], $this->buttonSizes)){
			$options = $this->addClass($options, 'btn-'.$options['bootstrap-size']) ;
		}

        unset($options['bootstrap-size']) ;
        unset($options['bootstrap-type']) ;
        return $options ;
    }

    /**
     *
     * Try to match the specified HTML code with a button or a input with submit type.
     *
     * @param $html The HTML code to check
     *
     * @return true if the HTML code contains a button
     *
    **/
    protected function _matchButton ($html) {
        return strpos($html, '<button') !== FALSE || strpos($html, 'type="submit"') !== FALSE ;
    }

    /**
     *
     * Create a Twitter Bootstrap like form.
     *
     * New options available:
     *  - horizontal: boolean, specify if the form is horizontal
     *  - inline: boolean, specify if the form is inline
     *  - search: boolean, specify if the form is a search form
     *
     * Unusable options:
     *  - inputDefaults
     *
     * @param $model The model corresponding to the form
     * @param $options Options to customize the form
     *
     * @return The HTML tags corresponding to the openning of the form
     *
    **/
    public function create($model = null, $options = array()) {
        $this->colSize = array(
            'label' => 2,
            'input' => 6,
            'error' => 4
        ) ;
        if (isset($options['cols'])) {
            $this->colSize = $options['cols'] ;
            unset($options['cols']);
        }
        $this->horizontal = $this->_extractOption('horizontal', $options, false);
        unset($options['horizontal']);
        $this->search = $this->_extractOption('search', $options, false) ;
        unset($options['search']) ;
        $this->inline = $this->_extractOption('inline', $options, false) ;
        unset($options['inline']) ;
        if ($this->horizontal) {
            $options = $this->addClass($options, 'form-horizontal') ;
        }
        else if ($this->inline) {
            $options = $this->addClass($options, 'form-inline') ;
        }
        if ($this->search) {
            $options = $this->addClass($options, 'form-search') ;
        }
        $options['role'] = 'form' ;
        if (!isset($options['inputDefaults']) || !is_array($options['inputDefaults'])) {
            $options['inputDefaults'] = array();
        }
        $options['inputDefaults'] += array(
            'div' => array(
                'class' => 'form-group'
            )
        ) ;
        return parent::create($model, $options) ;
    }

    /**
     *
     * Return the col size class for the specified column (label, input or error).
     *
    **/
    protected function _getColClass($what, $offset = false) {
        if ($what == 'offset') {
            $what = 'label' ;
            $offset = TRUE ;
        }
        $size = $this->colSize[$what] ;
        if ($size) {
            return 'col-md-'.($offset ? 'offset-' : '').$size ;
        }
        return '' ;
    }

    /**
     *
     * Create & return a error message (Twitter Bootstrap like).
     *
     * The error is wrapped in a <span> tag, with a class
     * according to the form type (help-inline or help-block).
     *
    **/
    public function error($field, $text = null, $options = array()) {
        $this->setEntity($field);
        $optField = $this->_magicOptions(array()) ;
        $options['wrap'] = $this->_extractOption('wrap', $options, 'span') ;
        $errorClass = 'help-block' ;
        if ($this->horizontal && $optField['type'] != 'checkbox' && $optField['type'] != 'radio') {
            $errorClass .= ' '.$this->_getColClass('error') ;
        }
        $options = $this->addClass($options, $errorClass) ;
        return parent::error($field, $text, $options) ;
    }

    /**
     *
     * Create & return a label message (Twitter Boostrap like).
     *
    **/
    public function label($fieldName = null, $text = null, $options = array()) {
        if ($this->currentInputType == 'checkbox') {
            if ($text === null) {
                if (strpos($fieldName, '.') !== false) {
                    $fieldElements = explode('.', $fieldName);
                    $text = array_pop($fieldElements);
                } 
                else {
                    $text = $fieldName;
                }
                if (substr($text, -3) === '_id') {
                    $text = substr($text, 0, -3);
                }
                $text = __(Inflector::humanize(Inflector::underscore($text)));
            }
            return $text ;
        }
        if (!$this->inline) {
            $options = $this->addClass($options, 'control-label') ;
        }
        if ($this->horizontal) {
            $options = $this->addClass($options, $this->_getColClass('label')) ;
        }
        if ($this->inline) {
            $options = $this->addClass($options, 'sr-only') ;
        }
        return parent::label($fieldName, $text, $options) ;
    }

    /**
     *
     * Create & return an input block (Twitter Boostrap Like).
     *
     * New options:
     *  - prepend:
     *      -> string: Add <span class="add-on"> before the input
     *      -> array: Add elements in array before inputs
     *  - append: Same as prepend except it add elements after input
     *
    **/
    public function input($fieldName, $options = array()) {

        $prepend = $this->_extractOption('prepend', $options, null) ;
        unset ($options['prepend']) ;
        $append = $this->_extractOption('append', $options, null) ;
        unset ($options['append']) ;
        $before = $this->_extractOption('before', $options, '') ;
        $after = $this->_extractOption('after', $options, '') ;
        $between = $this->_extractOption('between', $options, '') ;
        $label = $this->_extractOption('label', $options, false) ;
        $inline = $this->_extractOption('inline', $options, false) ;
        unset ($options['inline']) ;

        $this->setEntity($fieldName);
        $options = $this->_parseOptions($options) ;
        $options['format'] = array('label', 'before', 'input', 'between', 'error', 'after') ;
        $this->currentInputType = $options['type'] ;

        $beforeClass = array() ;
        $oneLessDiv = FALSE;

        if ($options['type'] == 'checkbox' || $options['type'] == 'radio') {
            $before = '<label'.($inline ? ' class="'.$options['type'].'-inline"' : '').'>'.$before ;
            $between = $between.'</label>' ;
            $options['format'] = array('before', 'input', 'label', 'between', 'error', 'after') ;
            if ($this->horizontal) {
                $before = '<div class="'.$this->_getColClass('input')
                    .($options['type'] == 'checkbox' || !$label ? ' '.$this->_getColClass('offset') : '').'">'
                    .($inline ? '' : '<div class="'.$options['type'].'">').$before ;
                $after = $after.($inline ? '' : '</div>').'</div>' ;
            }
            else if (!$inline && ($options['type'] == 'checkbox' || !$label)) {
                $options['div'] = array(
                    'class' => $options['type']
                );
            }
            if ($options['type'] == 'radio') {
                if ($label) {
                    $before = $this->label($fieldName, $label).($this->horizontal ? '' : '<div class="radio">').$before ;
                    $after .= $this->horizontal ? '' : '</div>' ;
                }
                $options['label'] = FALSE ;
                $options['separator'] = '</label>'.($inline ? '<label'.($inline ? ' class="'.$options['type'].'-inline"' : '').'>' : '</div><div class="radio"><label>') ;
            }
        }
        else if ($this->horizontal) {
            $beforeClass[] = $this->_getColClass('input') ;
            $oneLessDiv = TRUE ;            
        }
        $beforePrepend = '' ;
        if ($prepend) {
            $beforeClass[] = 'input-group' ;
            if (is_string($prepend)) {
                $beforePrepend .= '<span class="input-group-'.($this->_matchButton($prepend) ? 'btn' : 'addon').'">'.$prepend.'</span>' ;
            }
            if (is_array($prepend)) {
                foreach ($prepend as $pre) {
                    $beforePrepend .= $pre ;
                }
            }
        }
        if ($append) {
            if (!$prepend) $beforeClass[] = 'input-group' ;
            if (is_string($append)) {
                $between = '<span class="input-group-'.($this->_matchButton($append) ? 'btn' : 'addon').'">'.$append.'</span>'.$between ;
            }
            if (is_array($append)) {
                foreach ($append as $apd) {
                    $between = '<span class="input-group-'.($this->_matchButton($apd) ? 'btn' : 'addon').'">'.$apd.'</span>'.$between ;
                }
            }
        }

        if ($oneLessDiv) {
            $between .= '</div>';
        }

        if (!empty($beforeClass)) {
            foreach($beforeClass as $bc) {
                $before .= '<div class="'.$bc.'">' ;
                if (!$oneLessDiv) {
                    $after = '</div>'.$after ;
                }
                $oneLessDiv = FALSE ;
            }
        }
        $before .= $beforePrepend ;

        $type = $options['type'];
        $error = $this->_extractOption('error', $options, null);
        if ($type !== 'hidden' 
            && $error !== false
            && $this->error($fieldName, $error)) {
            $options['div'] = $this->addClass($this->_inputDefaults['div'], 'has-error');
        }

        $options['before'] = $before ;
        $options['after'] = $after ;
        $options['between'] = $between ;

        if (!in_array($options['type'], array('checkbox', 'radio', 'file'))) {
            $options = $this->addClass($options, 'form-control') ;
        }

        return parent::input($fieldName, $options) ;
    }

    /**
     *
     * Create & return a Twitter Like button.
     *
     * New options:
     *  - bootstrap-type: Twitter bootstrap button type (primary, danger, info, etc.)
     *  - bootstrap-size: Twitter bootstrap button size (mini, small, large)
     *
    **/
    public function button($title, $options = array()) {
        $options = $this->_addButtonClasses($options) ;
        $options['type'] = FALSE ;
        return parent::button($title, $options) ;
    }

    /**
     *
     * Create & return a Twitter Like button group.
     *
     * @param $buttons The buttons in the group
     * @param $options Options for div method
     *
     * Extra options:
     *  - vertical true/false
     *
    **/
    public function buttonGroup ($buttons, $options = array()) {
        $vertical = $this->_extractOption('vertical', $options, false) ;
        unset($options['vertical']) ;
        $options = $this->addClass($options, 'btn-group') ;
        if ($vertical) {
            $options = $this->addClass($options, 'btn-group-vertical') ;
        }
        return $this->Html->tag('div', implode('', $buttons), $options) ;
    }

    /**
     *
     * Create & return a Twitter Like button toolbar.
     *
     * @param $buttons The groups in the toolbar
     * @param $options Options for div method
     *
    **/
    public function buttonToolbar ($buttonGroups, $options = array()) {
        $options = $this->addClass($options, 'btn-toolbar') ;
        return $this->Html->tag('div', implode('', $buttonGroups), $options) ;
    }

    /**
     *
     * Create & return a twitter bootstrap dropdown button.
     *
     * @param $title The text in the button
     * @param $menu HTML tags corresponding to menu options (which will be wrapped
     *       into <li> tag). To add separator, pass 'divider'.
     * @param $options Options for button
     *
    **/
    public function dropdownButton ($title, $menu = array(), $options = array()) {

        $options['type'] = false ;
        $options['data-toggle'] = 'dropdown' ;
        $options = $this->addClass($options, "dropdown-toggle") ;

        $outPut = '<div class="btn-group">' ;
        $outPut .= $this->button($title.'<span class="caret"></span>', $options) ;
        $outPut .= '<ul class="dropdown-menu">' ;
        foreach ($menu as $action) {
            if ($action === 'divider') {
                $outPut .= '<li class="divider"></li>' ;
            }
            else {
                $outPut .= '<li>'.$action.'</li>' ;
            }
        }
        $outPut .= '</ul></div>' ;
        return $outPut ;
    }

    /**
     *
     * Create & return a Twitter Like submit input.
     *
     * New options:
     *  - bootstrap-type: Twitter bootstrap button type (primary, danger, info, etc.)
     *  - bootstrap-size: Twitter bootstrap button size (mini, small, large)
     *
     * Unusable options: div
     *
    **/
    public function submit($caption = null, $options = array()) {
        $options = $this->_addButtonClasses($options) ;
        if (!isset($options['div'])) {
            $options['div'] = false ;
        }
        if (!$this->horizontal) {
            return parent::submit($caption, $options) ;
        }
        return '<div class="form-group"><div class="'.$this->_getColClass('offset').' '.$this->_getColClass('input').'">'.parent::submit($caption, $options).'</div></div>';
    }

    /**
     *
     * End a form, Twitter Bootstrap like.
     *
     * New options:
     *  - bootstrap-type: Twitter bootstrap button type (primary, danger, info, etc.)
     *  - bootstrap-size: Twitter bootstrap button size (mini, small, large)
     *
    **/
    public function end ($options = null,$secureAttributes = array()) {
        if ($options == null) {
            return parent::end($options, $secureAttributes) ;
        }
        if (is_string($options)) {
            $options = array('label' => $options) ;
        }
        if (!$this->inline) {
            if (!array_key_exists('div', $options)) {
                $options['div'] = array() ;
            }

			if (!isset($options['div']['class'])){
				$options['div']['class'] = '';
			}

            $options['div']['class'] .=  ' form-actions' ;
        }
        return parent::end($options, $secureAttributes) ;
    }

    /** SPECIAL FORM **/

    /**
     *
     * Create a basic bootstrap search form.
     *
     * @param $model The model of the form
     * @param $options The options that will be pass to the BootstrapForm::create method
     *
     * Extra options:
     *  - label: The input label (default false)
     *  - placeholder: The input placeholder (default "Search... ")
     *  - button: The search button text (default: "Search")
     *
    **/
    public function searchForm ($model = null, $options = array()) {

        $label = $this->_extractOption('label', $options, false) ;
        unset($options['label']) ;
        $placeholder = $this->_extractOption('placeholder', $options, 'Search... ') ;
        unset($options['placeholder']) ;
        $button = $this->_extractOption('button', $options, 'Search') ;
        unset($options['button']) ;

        $output = '' ;

        $output .= $this->create($model, array_merge(array('search' => true, 'inline' => (bool)$label), $options)) ;
        $output .= $this->input('search', array(
            'label' => $label,
            'placeholder' => $placeholder,
            'append' => array(
                $this->button($button, array('style' => 'vertical-align: middle'))
            )
        )) ;
        $output .= $this->end() ;

        return $output ;
    }

}

?>
