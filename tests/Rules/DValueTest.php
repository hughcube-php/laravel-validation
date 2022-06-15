<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2022/5/30
 * Time: 16:57.
 */

namespace HughCube\Laravel\Validation\Tests\Rules;

use HughCube\Laravel\Validation\Rules\DValue;
use HughCube\Laravel\Validation\Tests\TestCase;

class DValueTest extends TestCase
{
    public function testValidate()
    {
        $data = $this->validate([], ['id' => DValue::value(1)]);
        $this->assertTrue($data['id'] == 1);

        $data = $this->validate(['id' => 2], ['id' => DValue::value(1)]);
        $this->assertTrue($data['id'] == 2);
    }
}
