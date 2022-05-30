<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2021/4/20
 * Time: 11:36 下午.
 */

namespace HughCube\Laravel\Validation\Tests;

use HughCube\Laravel\Validation\ServiceProvider;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
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

    protected function randomString()
    {
        return md5(random_bytes(100));
    }

    /**
     * @param $data
     * @param $rules
     * @return array
     * @throws ValidationException
     */
    protected function validate($data, $rules)
    {
        /** @var Validator $validator */
        $validator = $this->getValidationFactory()->make($data, $rules);

        if(method_exists($validator, 'valid')){
            $validator->validate();
            return $validator->valid();
        }

        return $validator->validate();
    }
}
