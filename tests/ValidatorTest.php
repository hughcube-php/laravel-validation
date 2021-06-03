<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2021/4/20
 * Time: 11:45 下午.
 */

namespace HughCube\Laravel\Validation\Tests;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ValidatorTest extends TestCase
{
    public function testValidateDefault()
    {
        $key = Str::uuid()->toString();
        $results = $this->getValidationFactory()->make([], [$key => ['default']])->validate();
        $this->assertArrayHasKey($key, $results);
        $this->assertSame(null, $results[$key]);

        $key = Str::uuid()->toString();
        $results = $this->getValidationFactory()->make([], [$key => ['default:1']])->validate();
        $this->assertArrayHasKey($key, $results);
        $this->assertSame('1', $results[$key]);

        $key = Str::uuid()->toString();
        $results = $this->getValidationFactory()->make([], [$key => ['default:0']])->validate();
        $this->assertArrayHasKey($key, $results);
        $this->assertSame('0', $results[$key]);
    }

    public function testValidateSetNullIfEmpty()
    {
        foreach (
            [
                [false, null],
                ['', null],
                [0, null],
                [null, null],
                [[], null],
                ['0', null],
                [true, true],
                [1, 1],
                [$key = Str::uuid()->toString(), $key],
                [[1], [1]],
            ] as $value
        ) {
            $key = Str::uuid()->toString();
            $results = $this->getValidationFactory()
                ->make([$key => $value[0]], [$key => 'set_null_if_empty'])
                ->validate();

            $this->assertArrayHasKey($key, $results);
            $this->assertSame($value[1], Arr::get($results, $key));
        }
    }

    public function testValidateSetNullIfEmptyString()
    {
        foreach (
            [
                [false, false],
                ['', null],
                [0, 0],
                [null, null],
                [[], []],
                ['0', '0'],
                [true, true],
                [1, 1],
                [$key = Str::uuid()->toString(), $key],
                [[1], [1]],
            ] as $value
        ) {
            $key = Str::uuid()->toString();
            $results = $this->getValidationFactory()
                ->make([$key => $value[0]], [$key => 'set_null_if_empty_string'])
                ->validate();

            $this->assertArrayHasKey($key, $results);
            $this->assertSame($value[1], Arr::get($results, $key));
        }
    }

    public function testValidateSetNullIfZero()
    {
        foreach (
            [
                [false, false],
                ['', ''],
                [0, null],
                [null, null],
                [[], []],
                ['0', null],
                [true, true],
                [1, 1],
                [$key = Str::uuid()->toString(), $key],
                [[1], [1]],
            ] as $value
        ) {
            $key = Str::uuid()->toString();
            $results = $this->getValidationFactory()
                ->make([$key => $value[0]], [$key => 'set_null_if_zero'])
                ->validate();

            $this->assertArrayHasKey($key, $results);
            $this->assertSame($value[1], Arr::get($results, $key));
        }
    }

    public function testValidateRemoveIfEmpty()
    {
        foreach (
            [
                [false, false],
                ['', false],
                [0, false],
                [null, false],
                [[], false],
                ['0', false],
                [true, true],
                [1, true],
                [Str::uuid()->toString(), true],
                [[1], true],
            ] as $value
        ) {
            $key = Str::uuid()->toString();
            $results = $this->getValidationFactory()
                ->make([$key => $value[0]], [$key => 'remove_if_empty'])
                ->validate();

            $this->assertSame($value[1], Arr::has($results, $key));
        }
    }

    public function testValidateRemoveIfNull()
    {
        foreach (
            [
                [false, true],
                ['', true],
                [0, true],
                [null, false],
                [[], true],
                ['0', true],
                [true, true],
                [1, true],
                [Str::uuid()->toString(), true],
                [[1], true],
            ] as $value
        ) {
            $key = Str::uuid()->toString();
            $results = $this->getValidationFactory()
                ->make([$key => $value[0]], [$key => 'remove_if_null'])
                ->validate();

            $this->assertSame($value[1], Arr::has($results, $key));
        }
    }

    public function testValidateRemoveIfEmptyString()
    {
        foreach (
            [
                [false, true],
                ['', false],
                [0, true],
                [null, true],
                [[], true],
                ['0', true],
                [true, true],
                [1, true],
                [Str::uuid()->toString(), true],
                [[1], true],
            ] as $value
        ) {
            $key = Str::uuid()->toString();
            $results = $this->getValidationFactory()
                ->make([$key => $value[0]], [$key => 'remove_if_empty_string'])
                ->validate();

            $this->assertSame($value[1], Arr::has($results, $key));
        }
    }

    public function testValidateRemoveIfZero()
    {
        foreach (
            [
                [false, true],
                ['', true],
                [0, false],
                [null, true],
                [[], true],
                ['0', false],
                [true, true],
                [1, true],
                [Str::uuid()->toString(), true],
                [[1], true],
            ] as $value
        ) {
            $key = Str::uuid()->toString();
            $results = $this->getValidationFactory()
                ->make([$key => $value[0]], [$key => 'remove_if_zero'])
                ->validate();

            $this->assertSame($value[1], Arr::has($results, $key));
        }
    }
}
