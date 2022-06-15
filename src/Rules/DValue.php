<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2022/6/15
 * Time: 17:24
 */

namespace HughCube\Laravel\Validation\Rules;

class DValue
{
    /**
     * The name of the rule.
     */
    protected $rule = 'default';

    /**
     * The accepted values.
     *
     * @var mixed
     */
    protected $value;

    public static function value($value): DValue
    {
        /** @phpstan-ignore-next-line */
        return new static($value);
    }

    /**
     * Create a new in rule instance.
     *
     * @param  mixed  $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Convert the rule to a validation string.
     *
     * @return string
     *
     * @see \Illuminate\Validation\ValidationRuleParser::parseParameters
     */
    public function __toString()
    {
        return $this->rule.':'.$this->value;
    }
}
