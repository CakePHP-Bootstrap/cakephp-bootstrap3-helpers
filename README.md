CakePHP 2.x Helpers for Bootstrap 3
===================================

CakePHP Helpers to generate HTML with @Twitter Boostrap 3 style.

**Warning:** Works only with CakePHP 2.x!

<i>Looking for CakePHP 3.0 helpers? Check it out! https://github.com/Holt59/cakephp3-bootstrap3-helpers</i>

Do not hesitate to...
 - **Post a github issue** if you find a bug or want a new feature.
 - **Send me a message** if you have troubles installing or using the plugin.

Installation
============

Simply Clone the repository in your `app/Plugin/Bootstrap3` folder and add the following to your `app/Config/bootstrap.php`:

```php
CakePlugin::load('Bootstrap3') ;
```

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

The MIT License (MIT)

Copyright (c) 2013-2017, Mikaël Capelle.

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

See LICENSE.
