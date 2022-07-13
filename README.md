# Contao-Encore bridge

This is an extension for [Contao CMS](https://contao.org) which provides a wrapper for
[Webpack Encore bundle](https://github.com/symfony/webpack-encore-bundle)'s `encoreEntryLinkTags()` and
`encoreEntryScriptTags()` functions, allowing a developer to use those functions in `.html5` templates as well.

## Installation

*NOTE:* Webpack Encore Bundle requires `output_path` config to be set.
If you do not yet have Webpack Encore Bundle installed, Contao-Encore Bridge will add it to your application
automatically, so be sure to set `output_path` in your `config.yml` file before installation:

```yaml
# config/config.yml
webpack_encore:
    output_path: '%kernel.project_dir%/public/build'
```

Then install Contao-Encore Bridge:

```shell
composer require ameotoko/contao-encore-bridge
```

## Configuration

Configure your Webpack Encore as described in official docs:

- [setting up Webpack Encore](https://symfony.com/doc/current/frontend.html)
- [setting up Webpack Encore Bundle](https://github.com/symfony/webpack-encore-bundle)

## Usage

Assuming you have configured your Webpack entrypoint like this:

```js
// webpack.config.js
const Encore = require('@symfony/webpack-encore');

Encore
  .addEntry('app', './frontend/js/app.js')
;
```

you can now output all stylesheets and scripts for that entry in your `.html5` templates, e.g. in `fe_page.html5`:

```php
<!DOCTYPE html>
<html lang="<?= $this->language ?>"<?php if ($this->isRTL): ?> dir="rtl"<?php endif; ?>>
<head>
    ...
    <?= $this->encoreEntryLinkTags('app') ?>
</head>
<body>
    ...
    <?= $this->mootools ?>
    <?= $this->encoreEntryScriptTags('app') ?>
</body>
</html>
```

Or add them from any other template like so:

```php
<?php $this->extend('ce_gallery'); ?>

<?php $this->block('content'); ?>
    <?php $this->parent(); ?>

    <?php $GLOBALS['TL_CSS'][] = $this->encoreEntryLinkTags('app'); ?>
    <?php $GLOBALS['TL_BODY'][] = $this->encoreEntryScriptTags('app'); ?>
<?php $this->endblock(); ?>
```
