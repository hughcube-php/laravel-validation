<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2022/6/20
 * Time: 18:32
 */

namespace HughCube\Laravel\Validation\Rules;

class RuleStringable
{
    /**
     * The name of the rule.
     */
    protected $rule = null;

    /**
     * The accepted values.
     *
     * @var mixed
     */
    protected $value;

    /**
     * @return static
     */
    public static function value($value, $rule = null)
    {
        /** @phpstan-ignore-next-line */
        return new static($value, $rule);
    }

    /**
     * Create a new in rule instance.
     *
     * @param  mixed  $value
     */
    public function __construct($value, $rule = null)
    {
        $this->value = $value;
        $this->rule = $rule ?? $this->rule;
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
