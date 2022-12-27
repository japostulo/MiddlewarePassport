<?php
// MyVendor\formulario-contato\src\FormularioContatoServiceProvider.php
namespace Japostulo\MiddlewarePassport;

use Illuminate\Support\ServiceProvider;

class MiddlewarePassportServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
    }

    public function register()
    {
    }
}
