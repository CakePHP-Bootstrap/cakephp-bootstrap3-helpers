cakephp-bootstrap-helpers
=========================

CakePHP Helpers to generate HTML with @Twitter Boostrap style (version 3.0).

It's a work in progress, if you want to add any kind of bootstrap components, just do it!

If you want a component but you don't really know how to do, do not hesitate to contact me!

How to use?
===========

Just add Helper files into your View/Helpers directory and load the helpers in you controller:
```public $helpers = array('BoostrapHtml', 'BootstrapForm', 'BoostrapPaginator', 'BootstrapNavbar') ;```

I tried to keep CakePHP helpers style. You can find the documentation directly in the Helpers files.

BootstrapHtmlHelper
===================

This is the subclass of HtmlHelper, with 1 redefinition of method and 3 new methods:

<h3>getCrumbLists</h3>
Function now returns a bootstrap style breadcrumbs: http://getbootstrap.com/2.3.2/components.html#breadcrumbs
  
<h3>alert</h3>
Function which returns a bootstrap alert message: http://getbootstrap.com/2.3.2/components.html#alerts 

<h3>icon</h3> 
Function which returns a boostrap icon.

<h3>progress</h3>
Function which returns a boostrap progress bar.

BootstrapPaginatorHelper
========================

Currently this helper only redefines numbers, first, last, prev & next method of PaginatorHelper to create boostrap like pagination: http://getbootstrap.com/2.3.2/components.html#pagination

BootstrapFormHelper
===================

This helper redefines the the most importants method of the FormHelper:

1. BootstrapFormHelper::create now allows you to specify if you want a horizontal, inline or search form (see documentation)
2. BootstrapFormHelper::input now allows you to prepend or append element to your input

button, submit and end methods are redefined to add bootstrap btn style, and allow you to specify which button you want (by specifying "boostrap-size" and "boostrap-type" options).

Two new methods:

1. dropdownButton which allow you to create dropdown button (see documentation)
2. searchForm which allow you to quickly create a search form (see documentation)

A small example:
```
echo $this->BootstrapForm->create('', array()) ;
echo $this->BootstrapForm->input('text', array(
    'label' => 'Search... ',
    'type' => 'text',
    'prepend' => $this->BootstrapHtml->icon('search'),
    'append' => array(
            $this->BootstrapForm->dropdownButton(__('Action'), array(
                $this->BootstrapHtml->link('Action 1', array()),
                $this->BootstrapHtml->link('Action 2', array()),
                'divider',
                $this->BootstrapHtml->link('Action 3', array())
            ))
    ))) ;
echo $this->BootstrapForm->end() ;

/**
    Will output: 

    <form>
        <div style="display:none;">
            <input type="hidden" name="_method" value="POST">
        </div>
        <div class="control-group">
            <label for="ArticleText" class="control-label">Search... </label>
            <div class=" input-prepend input-append">
                <span class="add-on"><i class="icon-search icon-black"></i></span>
                <input name="data[Article][text]" type="text" id="ArticleText">
                <div class="btn-group">
                    <button data-toggle="dropdown" class="dropdown-toggle btn">
                        Action
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="#">Action 1</a></li>
                        <li><a href="#">Action 2</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Action 3</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </form>
    
**/

```

BootstrapNavbarHelper
=====================

A new helper to easily create navigation bar in bootstrap style (http://getbootstrap.com/2.3.2/components.html#navbar).

The helper allow you to create navigation bars with brand block, links (with automatic active class), dropdown menus (and hover menu on dropdown), and other bootstrap stuff with custom options.
All the boostrap navbars (fixed, fixed, inverse, static, responsive) are availables using options.

Copyright and license
=====================

Copyright 2013 Mikaël Capelle.

Licensed under the Apache License, Version 2.0 (the "License"); you may not use this work except in compliance with the License. You may obtain a copy of the License in the LICENSE file, or at:

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing permissions and limitations under the License.
