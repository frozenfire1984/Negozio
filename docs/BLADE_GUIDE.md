# Как устроены шаблоны в Negozio

Разбор по состоянию проекта на 20 октября 2026 года. Ниже сначала описан существующий код, затем — возможное разделение публичной части и кабинета. Предложения из последней части ещё не реализованы.

## 1. Где шаблон админки

Сейчас отдельной админки с собственными маршрутами и проверкой роли администратора в рассмотренных web-маршрутах нет. Есть интерфейс авторизации и личного кабинета, созданный Laravel Breeze.

Если под «админкой» ты имеешь в виду страницу Dashboard после входа, то:

- `resources/views/dashboard.blade.php` — содержимое страницы;
- `resources/views/layouts/app.blade.php` — общая HTML-оболочка;
- `resources/views/layouts/navigation.blade.php` — меню внутри этой оболочки.

`welcome.blade.php` — отдельная главная страница по адресу `/`. Она не оборачивает Dashboard и не служит его родительским шаблоном. Сейчас в ней собственные `html`, `head`, `body`, подключение ресурсов и пустой `body`.

Авторизация и права администратора — разные вещи: `auth` проверяет вход пользователя, но сам по себе не проверяет роль администратора.

## 2. Как запрос становится страницей

Упрощённая цепочка:

```text
Браузер запрашивает URL
    → public/index.php запускает Laravel
    → Laravel выбирает маршрут
    → middleware проверяют доступ
    → функция маршрута или контроллер возвращает view(...)
    → Blade собирает страницу из шаблонов и компонентов
    → браузер получает HTML и загружает CSS/JS
```

`bootstrap/app.php` подключает `routes/web.php`. В конце `routes/web.php` подключается `routes/auth.php`.

Фактические связи:

| URL | Где выбирается страница | Страница | Оболочка |
| --- | --- | --- | --- |
| `/` | Функция в `routes/web.php` | `welcome.blade.php` | Собственная HTML-структура |
| `/dashboard` | Функция в `routes/web.php` | `dashboard.blade.php` | `layouts/app.blade.php` |
| `/profile` (GET) | `ProfileController::edit()` | `profile/edit.blade.php` | `layouts/app.blade.php` |
| `/login` (GET) | `AuthenticatedSessionController::create()` | `auth/login.blade.php` | `layouts/guest.blade.php` |
| `/register` (GET) | `RegisteredUserController::create()` | `auth/register.blade.php` | `layouts/guest.blade.php` |

Метод запроса тоже важен: GET `/login` показывает форму, POST `/login` обрабатывает вход. После успешного входа контроллер отправляет пользователя на ранее запрошенный защищённый адрес либо на `/dashboard`.

Для `/dashboard` указаны middleware `auth` и `verified`. При этом текущая модель `User` не реализует `MustVerifyEmail`: одно наличие `verified` в маршруте не означает, что подтверждение почты уже обязательно для этой модели.

## 3. Что такое Blade и view

Blade — шаблонизатор Laravel. Файл `*.blade.php` содержит HTML, выражения PHP и директивы Blade. Laravel компилирует его в PHP и выполняет на сервере. Браузер получает результат, а не директивы `@if` или теги `<x-app-layout>`.

Шаблоны находятся в `resources/views`. Точки в имени view обозначают вложенные папки:

```php
return view('welcome');       // resources/views/welcome.blade.php
return view('profile.edit');  // resources/views/profile/edit.blade.php
return view('auth.login');    // resources/views/auth/login.blade.php
```

Данные можно передать вторым аргументом:

```php
return view('profile.edit', ['user' => $request->user()]);
```

В шаблоне они доступны как переменные:

```blade
<p>{{ $user->name }}</p>
```

`{{ ... }}` выводит значение с HTML-экранированием. `{!! ... !!}` выводит HTML без экранирования; для пользовательского текста используй обычные двойные скобки.

## 4. app.blade.php: общая оболочка кабинета

Страница `dashboard.blade.php` начинается так:

```blade
<x-app-layout>
    <x-slot name="header">
        <h2>Dashboard</h2>
    </x-slot>

    <div>Содержимое страницы</div>
</x-app-layout>
```

Связь имени компонента с файлом здесь проходит через PHP-класс:

```text
<x-app-layout>
    → app/View/Components/AppLayout.php
    → render() возвращает view('layouts.app')
    → resources/views/layouts/app.blade.php
```

В оболочке уже есть `html`, `head`, подключение CSS/JS, `body` и меню. Поэтому внутри `dashboard.blade.php` второй комплект этих тегов не нужен.

Два места вставки в оболочке:

```blade
{{ $header }}  {{-- Содержимое именованного слота header --}}
{{ $slot }}    {{-- Остальное содержимое между тегами x-app-layout --}}
```

Заголовок окружён `@isset($header)`: если страница его не передала, блок заголовка не выводится.

Оболочка — обычный компонент, предназначенный для целой страницы. Имя `app` выбрано разработчиками стартового набора; оно не делает файл автоматически главным для всех страниц.

## 5. guest.blade.php: оболочка авторизации

Здесь работает аналогичная цепочка:

```text
auth/login.blade.php содержит <x-guest-layout>
    → app/View/Components/GuestLayout.php
    → view('layouts.guest')
    → resources/views/layouts/guest.blade.php
```

Эта оболочка рисует фон, логотип и карточку с формой. Форма вставляется через `{{ $slot }}`.

Название `guest` не означает «вся публичная часть сайта». Это оболочка страниц авторизации. Сам файл не ограничивает доступ: доступ регулируют middleware маршрутов. Например, маршруты входа и регистрации находятся в группе `guest` в `routes/auth.php`.

`welcome.blade.php` сейчас не использует ни `guest`, ни `app`.

## 6. include, компоненты и partials

В проекте есть несколько способов повторно использовать разметку.

### Включение фрагмента через @include

```blade
@include('layouts.navigation')
```

Вставляет `resources/views/layouts/navigation.blade.php` в текущую страницу. Включаемый шаблон получает переменные родительского представления; дополнительные данные можно передать вторым аргументом.

На странице профиля таким способом подключаются формы из `profile/partials/`. Название `partials` — соглашение для папки с фрагментами, а не специальная команда Laravel.

### Небольшие компоненты

```blade
<x-primary-button>Сохранить</x-primary-button>
```

Этот компонент находится в `resources/views/components/primary-button.blade.php`. Для него отдельный PHP-класс не нужен: это анонимный Blade-компонент.

Внутри кнопки `{{ $slot }}` выводит «Сохранить», а `$attributes` принимает переданные HTML-атрибуты, например `class` или `disabled`.

В отличие от анонимной кнопки, компоненты `AppLayout` и `GuestLayout` в этом проекте имеют PHP-классы. Поэтому искать их только в `views/components` было бы ошибкой.

Компоненты кнопок, полей, меню и модальных окон сейчас сами содержат Tailwind-классы. Если использовать их на публичном сайте без Tailwind, оформление тоже понадобится заменить.

## 7. Другой способ: @extends и @yield

В Laravel также можно строить оболочки через наследование шаблонов:

```blade
{{-- В оболочке layouts/site.blade.php --}}
<main>@yield('content')</main>
```

```blade
{{-- В шаблоне страницы --}}
@extends('layouts.site')

@section('content')
    <h1>Главная</h1>
@endsection
```

Это альтернативный способ. Текущие страницы кабинета используют компоненты и слоты. Для нового публичного интерфейса можно выбрать любой подход; необязательно переписывать существующий кабинет.

## 8. Краткая шпаргалка по синтаксису

| Запись | Значение |
| --- | --- |
| `{{ $value }}` | Вывести значение с экранированием |
| `@if (...) ... @endif` | Условие |
| `@foreach ($items as $item) ... @endforeach` | Цикл |
| `@include('some.fragment')` | Вставить фрагмент |
| `<x-primary-button>...</x-primary-button>` | Вызвать компонент |
| `<x-slot name="header">...</x-slot>` | Передать именованный слот |
| `@csrf` | Добавить скрытое поле CSRF-токена в форму |
| `@method('PATCH')` | Указать Laravel метод PATCH для HTML-формы с POST |
| `route('dashboard')` | Получить URL по имени маршрута |
| `__('Dashboard')` | Получить перевод строки |
| `@vite([...])` | Подключить ресурсы через Vite |
| `{{-- комментарий --}}` | Комментарий Blade, не попадающий в HTML |

Атрибуты `x-data`, `x-show`, `x-on:click` и `@click` в меню относятся к Alpine.js. Не путай их с Blade-компонентами `<x-...>`: Alpine выполняется в браузере, Blade — на сервере.

## 9. Где сейчас подключается Tailwind

В текущем `resources/css/app.css` находятся:

```css
@tailwind base;
@tailwind components;
@tailwind utilities;
```

Этот файл подключается через `@vite` в трёх местах:

- `resources/views/welcome.blade.php`;
- `resources/views/layouts/app.blade.php`;
- `resources/views/layouts/guest.blade.php`.

Поэтому удаление Tailwind из общего файла затронет и кабинет, и формы авторизации. В предыдущем обсуждении пример с `@import 'tailwindcss'` был общим: фактически в твоём файле используются три директивы выше.

`resources/js/app.js` запускает Alpine.js, который нужен интерактивным компонентам кабинета. Vite отвечает за сборку ресурсов и сам по себе не требует Tailwind.

Огромный встроенный CSS из прежнего `welcome.blade.php` был отдельным запасным оформлением стартовой страницы. В текущем рабочем файле этого блока уже нет.

## 10. Как разделить публичный сайт и кабинет

Минимальный вариант — оставить `app.css` для существующего кабинета и авторизации, добавить `site.css` для сайта. Переименование в `admin.css` необязательно: текущая защищённая часть пока является кабинетом пользователя.

Возможная структура:

```text
resources/
  css/
    app.css                    # Tailwind: кабинет и авторизация
    site.css                   # Обычный CSS публичного сайта
  views/
    layouts/
      app.blade.php            # Существующая оболочка кабинета
      guest.blade.php          # Существующая оболочка авторизации
      site.blade.php           # Новая оболочка сайта
    welcome.blade.php          # Главная, использующая оболочку site
    dashboard.blade.php         # Кабинет, использующий app
```

Для одного публичного экрана можно пока оставить собственную HTML-структуру `welcome` и просто заменить в нём подключение CSS. Общая оболочка `site` станет полезна, когда несколько страниц будут делить шапку, подвал и ресурсы.

При добавлении нового CSS нужно зарегистрировать его в `vite.config.js`, сохранив существующие точки входа:

```js
input: [
    'resources/css/app.css',
    'resources/css/index.scss',
    'resources/js/app.js',
],
```

В публичной оболочке или в самостоятельном `welcome`:

```blade
@vite(['resources/css/site.css'])
```

Если публичной части нужен существующий Alpine, добавь туда `resources/js/app.js`. Если потребуется собственный JavaScript, можно создать `site.js` и тоже добавить его в точки входа Vite.

В `layouts/app.blade.php` и `layouts/guest.blade.php` существующее подключение остаётся:

```blade
@vite(['resources/css/app.css', 'resources/js/app.js'])
```

Так публичная страница не загружает Tailwind, даже если Vite собирает оба CSS-файла. Для работы `@vite` нужен запущенный `npm run dev` либо готовая сборка `npm run build`.

Если всё же переименовывать `app.css`, обновлять нужно `vite.config.js` и все использующие его `@vite`. В текущем `app.js` импорта CSS нет.

## 11. Где искать нужное изменение

| Что меняешь | Куда смотреть |
| --- | --- |
| Главную страницу `/` | `resources/views/welcome.blade.php` |
| Содержимое Dashboard | `resources/views/dashboard.blade.php` |
| Общую оболочку кабинета | `resources/views/layouts/app.blade.php` |
| Меню кабинета | `resources/views/layouts/navigation.blade.php` |
| Оболочку форм авторизации | `resources/views/layouts/guest.blade.php` |
| Саму форму входа | `resources/views/auth/login.blade.php` |
| Повторяющуюся кнопку или поле | `resources/views/components/` |
| Соответствие URL и обработчика | `routes/web.php`, `routes/auth.php` |
| Данные для страницы и обработку формы | `app/Http/Controllers/` |
| Связь x-app-layout с оболочкой | `app/View/Components/AppLayout.php` |
| Какие ресурсы собирает Vite | `vite.config.js` |

Создание файла Blade само по себе не создаёт URL. Например, текущий `shopping-lists/index.blade.php` — заготовка; в рассмотренных web-маршрутах пока нет маршрута, который её возвращает.

Для самостоятельного поиска связей пригодятся:

```sh
php artisan route:list --except-vendor
rg -n 'view\(' routes app/Http/Controllers
rg -n '<x-app-layout|<x-guest-layout|@include|@extends|@vite' resources/views
```

Файлы в `storage/framework/views` — скомпилированный кеш Blade. Исходные шаблоны нужно редактировать в `resources/views`.
