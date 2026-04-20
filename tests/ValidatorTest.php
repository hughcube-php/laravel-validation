<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2021/4/20
 * Time: 11:45 下午.
 */

namespace HughCube\Laravel\Validation\Tests;

use Illuminate\Support\Arr;

class ValidatorTest extends TestCase
{
    public function testValidateDefault()
    {
        $key = $this->randomString();
        $results = $this->validate([], [$key => ['default']]);
        $this->assertTrue(Arr::has($results, $key));
        $this->assertSame(null, $results[$key]);

        $key = $this->randomString();
        $results = $this->validate([], [$key => ['default:1']]);
        $this->assertTrue(Arr::has($results, $key));
        $this->assertSame('1', $results[$key]);

        $key = $this->randomString();
        $results = $this->validate([], [$key => ['default:0']]);
        $this->assertTrue(Arr::has($results, $key));
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
                [$key = $this->randomString(), $key],
                [[1], [1]],
            ] as $value
        ) {
            $key = $this->randomString();
            $results = $this->validate([$key => $value[0]], [$key => 'set_null_if_empty']);

            $this->assertTrue(Arr::has($results, $key));
            $this->assertSame($value[1], Arr::get($results, $key));
        }
    }

    public function testValidateSetNullIfEmptyString()
    {
        foreach (
            [
                [false, false],
                ['', null],
                ['    ', '    '],
                [0, 0],
                [null, null],
                [[], []],
                ['0', '0'],
                [true, true],
                [1, 1],
                [$key = $this->randomString(), $key],
                [[1], [1]],
            ] as $value
        ) {
            $key = $this->randomString();
            $results = $this->validate([$key => $value[0]], [$key => 'set_null_if_empty_string']);

            $this->assertTrue(Arr::has($results, $key));
            $this->assertSame($value[1], Arr::get($results, $key));
        }

        /** trim */
        foreach (
            [
                [false, false],
                ['', null],
                ['    ', null],
                [0, 0],
                [null, null],
                [[], []],
                ['0', '0'],
                [true, true],
                [1, 1],
                [$key = $this->randomString(), $key],
                [[1], [1]],
            ] as $value
        ) {
            $key = $this->randomString();
            $results = $this->validate([$key => $value[0]], [$key => 'set_null_if_empty_string:trim']);

            $this->assertTrue(Arr::has($results, $key));
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
                [$key = $this->randomString(), $key],
                [[1], [1]],
            ] as $value
        ) {
            $key = $this->randomString();
            $results = $this->validate([$key => $value[0]], [$key => 'set_null_if_zero']);

            $this->assertTrue(Arr::has($results, $key));
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
                [$this->randomString(), true],
                [[1], true],
            ] as $value
        ) {
            $key = $this->randomString();
            $results = $this->validate([$key => $value[0]], [$key => 'remove_if_empty']);

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
                [$this->randomString(), true],
                [[1], true],
            ] as $value
        ) {
            $key = $this->randomString();
            $results = $this->validate([$key => $value[0]], [$key => 'remove_if_null']);

            $this->assertSame($value[1], Arr::has($results, $key));
        }
    }

    public function testValidateRemoveIfEmptyString()
    {
        foreach (
            [
                [false, true],
                ['', false],
                ['     ', true],
                [0, true],
                [null, true],
                [[], true],
                ['0', true],
                [true, true],
                [1, true],
                [$this->randomString(), true],
                [[1], true],
            ] as $value
        ) {
            $key = $this->randomString();
            $results = $this->validate([$key => $value[0]], [$key => 'remove_if_empty_string']);

            $this->assertSame($value[1], Arr::has($results, $key));
        }

        /** trim */
        foreach (
            [
                [false, true],
                ['', false],
                ['     ', false],
                [0, true],
                [null, true],
                [[], true],
                ['0', true],
                [true, true],
                [1, true],
                [$this->randomString(), true],
                [[1], true],
            ] as $value
        ) {
            $key = $this->randomString();
            $results = $this->validate([$key => $value[0]], [$key => 'remove_if_empty_string:trim']);

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
                [$this->randomString(), true],
                [[1], true],
            ] as $value
        ) {
            $key = $this->randomString();
            $results = $this->validate([$key => $value[0]], [$key => 'remove_if_zero']);

            $this->assertSame($value[1], Arr::has($results, $key));
        }
    }

    public function testValidateStripSpaces()
    {
        foreach (
            [
                // 半角空格
                ['张 三', '张三'],
                [' 张三 ', '张三'],
                ['  张  三  ', '张三'],
                // 全角空格 U+3000
                ["张\u{3000}三", '张三'],
                // NBSP U+00A0
                ["张\u{00A0}三", '张三'],
                // ZWSP U+200B
                ["张\u{200B}三", '张三'],
                // BOM U+FEFF
                ["\u{FEFF}张三", '张三'],
                // 制表符/换行/回车
                ["张\t三", '张三'],
                ["张\r\n三", '张三'],
                // SOFT HYPHEN / CGJ / MVS
                ["张\u{00AD}三", '张三'],
                ["张\u{034F}三", '张三'],
                ["张\u{180E}三", '张三'],
                // HANGUL FILLER / BRAILLE BLANK (过滤绕过)
                ["ad\u{3164}min", 'admin'],
                ["ad\u{2800}min", 'admin'],
                // 保留: ZWNJ (波斯/印地语)
                ["می\u{200C}خواهم", "می\u{200C}خواهم"],
                // 保留: 变体选择符 (emoji 彩色变体)
                ["❤\u{FE0F}", "❤\u{FE0F}"],
                // 保留: BIDI 控制字符
                ["\u{200E}abc", "\u{200E}abc"],
                // 不含空白的字符串保持不变
                ['admin', 'admin'],
                ['张三', '张三'],
                // 非字符串值保持不变
                [0, 0],
                [1, 1],
                [true, true],
                [[1, 2], [1, 2]],
            ] as $value
        ) {
            $key = $this->randomString();
            $results = $this->validate([$key => $value[0]], [$key => 'strip_spaces']);

            $this->assertTrue(Arr::has($results, $key));
            $this->assertSame($value[1], Arr::get($results, $key));
        }
    }

    public function testHybridValidate()
    {
        /** Zero is passable */
        $key = $this->randomString();
        $this->assertFalse(
            $this->getValidationFactory()->make([$key => 0], [$key => ['required']])->fails()
        );

        /** The key can be returned normally */
        $key = $this->randomString();
        $results = $this->validate([$key => 0], [$key => ['required']]);
        $this->assertTrue(Arr::has($results, $key));

        /** Data cleaning */
        $key = $this->randomString();
        $this->assertTrue(
            $this->getValidationFactory()->make([$key => 0], [$key => ['remove_if_zero', 'required']])->fails()
        );

        /** The key can be removed later */
        $key = $this->randomString();
        $results = $this->validate([$key => 0], [$key => ['required', 'remove_if_zero']]);
        $this->assertFalse(Arr::has($results, $key));
    }

    public function testValidateDefaultOnWildcard()
    {
        /** default should NOT override an existing nested value. */
        $results = $this->validate(
            ['arr' => [['log' => 'hello']]],
            ['arr.*.log' => 'default:xx']
        );
        $this->assertSame('hello', Arr::get($results, 'arr.0.log'));

        /** default should fill in the missing nested value. */
        $results = $this->validate(
            ['arr' => [['log' => 'hello'], ['name' => 'x']]],
            ['arr.*.log' => 'default:xx']
        );
        $this->assertSame('hello', Arr::get($results, 'arr.0.log'));
        $this->assertSame('xx', Arr::get($results, 'arr.1.log'));
    }

    public function testStripSpacesOnWhitespaceOnlyValue()
    {
        /** 仅空白字符串在 Laravel 的 presentOrRuleIsImplicit 下被视为 not present;
         *  StripSpaces 必须是 implicit 才能触发. */
        $key = $this->randomString();
        $results = $this->validate([$key => '  '], [$key => 'strip_spaces']);
        $this->assertSame('', Arr::get($results, $key));

        /** 链式: strip_spaces 先把 '  ' 改成 '', set_null_if_empty_string 再置 null */
        $key = $this->randomString();
        $results = $this->validate(
            [$key => '  '],
            [$key => 'strip_spaces|set_null_if_empty_string']
        );
        $this->assertNull(Arr::get($results, $key));
    }

    public function testImplicitZeroAndNullRules()
    {
        /** set_null_if_zero / remove_if_null / remove_if_zero 是 implicit */
        $key = $this->randomString();
        $results = $this->validate([$key => 0], [$key => 'set_null_if_zero']);
        $this->assertNull(Arr::get($results, $key));

        $key = $this->randomString();
        $results = $this->validate([$key => null], [$key => 'remove_if_null']);
        $this->assertFalse(Arr::has($results, $key));

        $key = $this->randomString();
        $results = $this->validate([$key => 0], [$key => 'remove_if_zero']);
        $this->assertFalse(Arr::has($results, $key));
    }

    public function testSetNullIfEmptyOnWildcard()
    {
        $results = $this->validate(
            ['arr' => [['log' => ''], ['log' => 'hi'], ['log' => 0]]],
            ['arr.*.log' => 'set_null_if_empty']
        );
        $this->assertNull(Arr::get($results, 'arr.0.log'));
        $this->assertSame('hi', Arr::get($results, 'arr.1.log'));
        $this->assertNull(Arr::get($results, 'arr.2.log'));
    }
}
