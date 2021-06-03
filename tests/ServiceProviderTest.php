<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2021/4/20
 * Time: 11:45 下午.
 */

namespace HughCube\Laravel\Validation\Tests;

use HughCube\Laravel\Validation\Validator;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;

class ServiceProviderTest extends TestCase
{
    public function testIsResolverValidator()
    {
        $validator = $this->getValidationFactory()->make([], []);

        $this->assertInstanceOf(ValidatorContract::class, $validator);
        $this->assertInstanceOf(Validator::class, $validator);
    }
}
