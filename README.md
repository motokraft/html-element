# Работа с DOM деревом на PHP

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

## Константа "DEBUG"
Эта константа определяет построение DOM дерева. Не забудьте определить эту константу в своем приложении.

```php
define('DEBUG', true);// Учитываются уровни вложенности html-элементов
define('DEBUG', false);// Однострочный вывод без разрывов строк
```

## Пример инициализации

```php
use \Motokraft\HtmlElement\HtmlElement;

$div = new HtmlElement('div');
echo $div;// <div></div>
```

## Документация

Перейдите на страницу [**Wiki**](https://github.com/motokraft/html-element/wiki) что бы получить подробную документацию об использовании библиотеки с примерами.

## Лицензия

Эта библиотека находится под лицензией MIT License.