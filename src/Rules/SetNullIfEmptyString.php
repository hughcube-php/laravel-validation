<?php

namespace HughCube\Laravel\Validation\Rules;

class SetNullIfEmptyString extends RuleStringable
{
    /**
     * The name of the rule.
     */
    protected $rule = 'set_null_if_empty_string';
}
