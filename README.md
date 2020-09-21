![modules](https://user-images.githubusercontent.com/7975568/93625345-147ec980-f9e2-11ea-8cbd-3cd640829ddc.png)

## What's a Module?

A module is a regular page, differentiated from other pages by being inside a modules container.
This approach makes it possible to use pages as modules without sacrificing regular subpages.

```
📄 Page
  📄 Subpage A
  📄 Subpage B
  🗂 Modules
    📄 Module A
    📄 Module B
```

Module blueprints and templates live in a separate `site/modules` folder. This way you can easily reuse modules across projects and share them with other people.

## Instructions

Add a `modules` section to any page blueprint and a modules container will be automatically created.
 
You can create modules by putting them in a `site/modules` folder. For example you can add a `site/modules/text` folder with the template `text.php` and the blueprint `text.yml`.

In the parent page template you can then use `<?php $page->renderModules() ?>` to render the modules.

### Parent Page

#### `site/blueprints/pages/default.yml`

```yml
title: Default Page
sections:
  modules: true
```

#### `site/templates/default.php`

```php
<?php $page->renderModules() ?>
```

### Example Module

#### `site/modules/text/text.yml`

```yml
title: Text Module
fields:
  textarea: true
```

#### `site/modules/text/text.php`

```php
<h1><?= $module->title() ?></h1>
<?= $module->text()->kt() ?>
```

You can access the module page object with `$module` and the parent page object with `$page`.

I created a simple [example installation](https://github.com/medienbaecker/kirby-modules/tree/example) with three different modules.

## Options

### Default Module Blueprint

By default, the `text` module will be the first/default option in the "Add page" modal.
You can overwrite it in your `site/config/config.php`:

```php
return [
  'medienbaecker.modules.default' => 'gallery'
];
```

### Autopublish Modules

You can turn on automatic publishing for modules in your `site/config/config.php`:

```php
return [
  'medienbaecker.modules.autopublish' => true
];
```

### Custom Module Model

This plugin creates a `ModulePage` model, overwriting certain methods.
You can extend this model with your own model:

```php
// site/config/config.php

return [
  'medienbaecker.modules.model' => 'CustomModulePage'
];
```

```php
// site/models/module.php

class CustomModulePage extends ModulePage {
  // methods...
}
```