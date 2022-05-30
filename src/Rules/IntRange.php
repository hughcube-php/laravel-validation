<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2022/5/30
 * Time: 16:39
 */

namespace HughCube\Laravel\Validation\Rules;

use Illuminate\Contracts\Validation\Rule;
use Throwable;

class IntRange implements Rule
{
    protected $min = '-2147483648';

    protected $max = '2147483647';

    /**
     * @return static
     */
    public static function new(): IntRange
    {
        $class = static::class;
        return new $class();
    }

    /**
     * @inheritDoc
     */
    public function passes($attribute, $value): bool
    {
        if (function_exists('gmp_init') && function_exists('gmp_cmp')) {
            try {
                $min = gmp_init($this->min);
                $max = gmp_init($this->max);
                $v = gmp_init($value);
                return 0 <= gmp_cmp($v, $min) && 0 <= gmp_cmp($max, $v);
            } catch (Throwable $exception) {
                return false;
            }
        }

        if (is_numeric($value) && function_exists('bccomp')) {
            return 0 <= bccomp($value, $this->min) && 0 <= bccomp($this->max, $value);
        }

        if (is_int($value) || is_float($value)) {
            return $this->min <= $value && $value <= $this->max;
        }

        return is_numeric($value) && $this->min <= $value && $value <= $this->max;
    }

    /**
     * @inheritDoc
     */
    public function message()
    {
        $message = trans('validation.enum');

        return $message === 'validation.enum'
            ? ['The selected :attribute is invalid.']
            : $message;
    }
}
