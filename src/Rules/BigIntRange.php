<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2022/5/30
 * Time: 16:39
 */

namespace HughCube\Laravel\Validation\Rules;

class BigIntRange extends IntRange
{
    protected $min = '-9223372036854775808';

    protected $max = '9223372036854775807';
}
