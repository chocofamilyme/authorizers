# Библиотека для авторизации через сервис rbac

1. Авторизация по терминалу
```php
$rbac = new \Chocofamilyme\Authorizers\Rbac('host');

$rbac->authorizeByTerminal(123, 'permission', 123);
```

2. Авторизация по команде
```php
$rbac = new \Chocofamilyme\Authorizers\Rbac('host');

$rbac->authorizeByTeam(123, 'permission', 'team_name');
```

Метод выбрасывает ошибку ForbiddenException если доступ запрещен, ничего не возврашает если доступ разрешен.