cakephp-bootstrap-helpers
=========================

CakePHP Helpers to generate HTML with @Twitter Boostrap style (<strong>version 3.0</strong>).

**Warning:** Works only with CakePHP 2.x! 

<i>Looking for CakePHP 3.0 helpers? Check it out! https://github.com/Holt59/cakephp3-bootstrap3-helpers</i>

Installation
============

Simply Clone the repository in your `app/Plugin/Bootstrap3` folder.

How to use?
===========

Just load the helpers in you controller:
```php
public $helpers = array(
    'Html' => array(
        'className' => 'Bootstrap3.BootstrapHtml'
    ),
    'Form' => array(
        'className' => 'Bootstrap3.BootstrapForm'
    ),
    'Modal' => array(
        'className' => 'Bootstrap3.BootstrapModal'
    )
);
```

Documentation
=============

Current documentation available on the CakePHP 3.0 helpers repository: https://github.com/Holt59/cakephp3-bootstrap3-helpers

**Note:** If you are using an old PHP version, you must change `[]` to `array()`.

**Warning:** The `BootstrapFormHelper` configuration is not available for the CakePHP 2.x helpers.

Copyright and license
=====================

Copyright 2013 Mikaël Capelle.

Licensed under the Apache License, Version 2.0 (the "License"); you may not use this work except in compliance with the License. You may obtain a copy of the License in the LICENSE file, or at:

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing permissions and limitations under the License.
