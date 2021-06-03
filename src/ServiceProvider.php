<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2021/4/18
 * Time: 10:32 下午.
 */

namespace HughCube\Laravel\Validation;

use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->getValidationFactory()->resolver(function ($translator, $data, $rules, $messages, $customAttributes) {
            return new Validator($translator, $data, $rules, $messages, $customAttributes);
        });
    }

    /**
     * Get a validation factory instance.
     *
     * @return \Illuminate\Contracts\Validation\Factory
     */
    protected function getValidationFactory()
    {
        return app(Factory::class);
    }
}
