# Middleware Passport

[![License](https://poser.pugx.org/yajra/laravel-oci8/license.svg)](https://packagist.org/packages/yajra/laravel-oci8)

## Requisitos
* Laravel >= 8.0
* API SSO com a implementação de dois endpoints
  * `introspect` - Endpoint que devolverá as informações do usuário,
  * `authenticate` - Endpoint que apenas retornará um booleano (Exceções são tratadas)

## Instalação Rápida

```bash
composer require japostulo/middleware-passport
```

## Configuração
Dentro do arquivo .env é necessário adicionar a `URI` do seu SSO

```bash
SSO_URL=http://localhost:8000
```

o plugin disponibiliza dois middlewares que podem ser utilizados para a introspecção do usuário ou apenas para autorizar acesso a endpoints autenticados.
É necessário registrar no arquivo `app/Http/Kernel.php`, Ex: 

```php
protected $routeMiddleware = [
        'sso.client' => \Japostulo\MiddlewarePassport\Middlewares\ClientAuthenticate::class,
        'sso.password' => \Japostulo\MiddlewarePassport\Middlewares\PasswordAuthenticate::class,
    ];
```

> Se você necessita de acesso aos dados do usuário (`Auth::user()` ou `$request->user()`) é necessário utilizar o middleware PasswordAuthenticate,
a sua classe `app\Models\User.php`, será utilizada para retornar uma instância de new User via facade

## Teste Rápido
``routes/api.php``
```php
Route::middleware('sso.client')->get('/test-authenticated', function () {
        return response()->json("I'm authenticated");
});

Route::middleware('sso.password')->get('/test-introspect', function () {
    return response()->json(Auth::user());
});
```
