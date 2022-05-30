<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2022/5/30
 * Time: 16:57
 */

namespace HughCube\Laravel\Validation\Tests\Rules;

use HughCube\Laravel\Validation\Rules\BigIntRange;
use HughCube\Laravel\Validation\Tests\TestCase;
use Throwable;

class BigIntRangeTest extends TestCase
{
    public function testValidate()
    {
        $exception = null;
        try {
            $this->validate(['id' => '-9223372036854775808'], ['id' => BigIntRange::new()]);
        } catch (Throwable $exception) {
        }
        $this->assertNull($exception);

        $exception = null;
        try {
            $this->validate(['id' => '9223372036854775807'], ['id' => new BigIntRange()]);
        } catch (Throwable $exception) {
        }
        $this->assertNull($exception);

        $exception = null;
        try {
            $this->validate(['id' => '1'], ['id' => new BigIntRange()]);
        } catch (Throwable $exception) {
        }
        $this->assertNull($exception);

        $exception = null;
        try {
            $this->validate(['id' => '18446744073709551615'], ['id' => new BigIntRange()]);
        } catch (Throwable $exception) {
        }
        $this->assertNotNull($exception);
    }
}
