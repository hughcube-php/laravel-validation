<?php

namespace HughCube\Laravel\Validation\Tests\Rules;

use HughCube\Laravel\Validation\Rules\RemoveIfEmpty;
use HughCube\Laravel\Validation\Rules\RemoveIfEmptyString;
use HughCube\Laravel\Validation\Rules\RemoveIfNull;
use HughCube\Laravel\Validation\Rules\RemoveIfZero;
use HughCube\Laravel\Validation\Rules\SetNullIfEmpty;
use HughCube\Laravel\Validation\Rules\SetNullIfEmptyString;
use HughCube\Laravel\Validation\Rules\SetNullIfZero;
use HughCube\Laravel\Validation\Rules\StripSpaces;
use HughCube\Laravel\Validation\Tests\TestCase;
use Illuminate\Support\Arr;

class ShortcutsTest extends TestCase
{
    public function testToStringWithoutValue()
    {
        $this->assertSame('set_null_if_empty', strval(SetNullIfEmpty::value()));
        $this->assertSame('set_null_if_empty_string', strval(SetNullIfEmptyString::value()));
        $this->assertSame('set_null_if_zero', strval(SetNullIfZero::value()));
        $this->assertSame('remove_if_empty', strval(RemoveIfEmpty::value()));
        $this->assertSame('remove_if_null', strval(RemoveIfNull::value()));
        $this->assertSame('remove_if_empty_string', strval(RemoveIfEmptyString::value()));
        $this->assertSame('remove_if_zero', strval(RemoveIfZero::value()));
        $this->assertSame('strip_spaces', strval(StripSpaces::value()));
    }

    public function testToStringWithValue()
    {
        $this->assertSame('set_null_if_empty_string:trim', strval(SetNullIfEmptyString::value('trim')));
        $this->assertSame('remove_if_empty_string:trim', strval(RemoveIfEmptyString::value('trim')));
    }

    public function testValidateWithShortcuts()
    {
        $key = $this->randomString();
        $results = $this->validate([$key => ''], [$key => SetNullIfEmpty::value()]);
        $this->assertNull(Arr::get($results, $key));

        $key = $this->randomString();
        $results = $this->validate([$key => '   '], [$key => SetNullIfEmptyString::value('trim')]);
        $this->assertNull(Arr::get($results, $key));

        $key = $this->randomString();
        $results = $this->validate([$key => 0], [$key => SetNullIfZero::value()]);
        $this->assertNull(Arr::get($results, $key));

        $key = $this->randomString();
        $results = $this->validate([$key => ''], [$key => RemoveIfEmpty::value()]);
        $this->assertFalse(Arr::has($results, $key));

        $key = $this->randomString();
        $results = $this->validate([$key => null], [$key => RemoveIfNull::value()]);
        $this->assertFalse(Arr::has($results, $key));

        $key = $this->randomString();
        $results = $this->validate([$key => '   '], [$key => RemoveIfEmptyString::value('trim')]);
        $this->assertFalse(Arr::has($results, $key));

        $key = $this->randomString();
        $results = $this->validate([$key => 0], [$key => RemoveIfZero::value()]);
        $this->assertFalse(Arr::has($results, $key));

        $key = $this->randomString();
        $results = $this->validate([$key => '  hello  world  '], [$key => StripSpaces::value()]);
        $this->assertSame('helloworld', Arr::get($results, $key));
    }
}
