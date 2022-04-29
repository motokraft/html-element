# Удобная работа с HTML элементами

![Package version](https://img.shields.io/github/v/release/motokraft/html-element)
![Total Downloads](https://img.shields.io/packagist/dt/motokraft/html-element)
![PHP Version](https://img.shields.io/packagist/php-v/motokraft/html-element)
![Repository Size](https://img.shields.io/github/repo-size/motokraft/html-element)
![License](https://img.shields.io/packagist/l/motokraft/html-element)

## Установка

Библиотека устанавливается с помощью пакетного менеджера [**Composer**](https://getcomposer.org/)

Добавьте библиотеку в файл `composer.json` вашего проекта:

```json
{
    "require": {
        "motokraft/html-element": "^1.0"
    }
}
```

или выполните команду в терминале

```
$ php composer require motokraft/html-element
```

Включите автозагрузчик Composer в код проекта:

```php
require __DIR__ . '/vendor/autoload.php';
```

## Примеры инициализации

```php
use \Motokraft\HtmlElement\HtmlElement;
$div = new HtmlElement('div');
```

## Лицензия

Эта библиотека находится под лицензией MIT License.