# CakePHP AdminLTE Theme

## Installation

You can install using [composer](http://getcomposer.org).

```
composer require hecsedli/cakephp3adminlte
```

### Enable Plugin

```php
// config/bootstrap.php

Plugin::load('AdminLTE', ['bootstrap' => true, 'routes' => true]);
```

### Enable theme

```php
// src/Controller/AppController.php

public function beforeRender(Event $event)
{
    $this->viewBuilder()->theme('AdminLTE');
}
```

### Enable Form

```php
// src/View/AppView.php

public function initialize()
{
    $this->loadHelper('Form', ['className' => 'AdminLTE.Form']);
}
```

![Dashboard](docs/dashboard.png)

1. `src/Template/Plugin/AdminLTE/Element/nav-top.ctp`
2. `src/Template/Plugin/AdminLTE/Element/aside-main-sidebar.ctp`
3. `src/Template/Plugin/AdminLTE/Element/aside/user-panel.ctp`
4. `src/Template/Plugin/AdminLTE/Element/aside/form.ctp`
5. `src/Template/Plugin/AdminLTE/Element/aside/sidebar-menu.ctp`
6. `src/Template/Plugin/AdminLTE/Element/aside-control-sidebar.ctp`
7. `src/Template/Plugin/AdminLTE/Element/footer.ctp`


### Page debug

Added link to default page of CakePHP.

![Page debug](docs/page-debug.png)

## Contributing

1. Fork it
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Commit your changes (`git commit -am 'Add some feature'`)
4. Push to the branch (`git push origin my-new-feature`)
5. Create new Pull Request
