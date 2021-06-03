<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2021/6/2
 * Time: 7:32 下午.
 */

namespace HughCube\Laravel\Validation;

use Illuminate\Contracts\Translation\Translator;
use Illuminate\Support\Arr;

class Validator extends \Illuminate\Validation\Validator
{
    /**
     * @inheritDoc
     */
    public function __construct(
        Translator $translator,
        array $data,
        array $rules,
        array $messages = [],
        array $customAttributes = []
    ) {
        $this->appendImplicitRules([
            'SetNullIfEmpty', 'RemoveIfEmpty', 'RemoveIfEmptyString', 'Default', 'SetNullIfEmptyString',
            'SetNullIfZero',
        ]);

        parent::__construct($translator, $data, $rules, $messages, $customAttributes);
    }

    public function appendImplicitRules($implicitRules)
    {
        $this->implicitRules = array_values(array_merge($this->implicitRules, $implicitRules));
    }

    /**
     * If the value is not set to a default value.
     *
     * @param string $attribute
     * @param mixed  $value
     * @param array  $parameters
     *
     * @return bool
     */
    public function validateDefault($attribute, $value, $parameters)
    {
        if (!array_key_exists($attribute, $this->data)) {
            Arr::set($this->data, $attribute, Arr::get($parameters, 0));
        }

        return true;
    }

    /**
     * Set to NULL if it is a empty value.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function validateSetNullIfEmpty($attribute, $value)
    {
        if (empty($value)) {
            Arr::set($this->data, $attribute, null);
        }

        return true;
    }

    /**
     * Set to NULL if it is a "".
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function validateSetNullIfEmptyString($attribute, $value)
    {
        if ('' === $value) {
            Arr::set($this->data, $attribute, null);
        }

        return true;
    }

    /**
     * Set to NULL if it is "0" or 0.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function validateSetNullIfZero($attribute, $value)
    {
        if (0 === $value || '0' === $value) {
            Arr::set($this->data, $attribute, null);
        }

        return true;
    }

    /**
     * Delete the attribute if it is empty value.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function validateRemoveIfEmpty($attribute, $value)
    {
        if (empty($value)) {
            Arr::forget($this->data, $attribute);
        }

        return true;
    }

    /**
     * Delete the attribute if it is NULL.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function validateRemoveIfNull($attribute, $value)
    {
        if (null === $value) {
            Arr::forget($this->data, $attribute);
        }

        return true;
    }

    /**
     * Delete the attribute if it is "".
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function validateRemoveIfEmptyString($attribute, $value)
    {
        if ('' === $value) {
            Arr::forget($this->data, $attribute);
        }

        return true;
    }

    /**
     * Delete the attribute if it is "0" or 0.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function validateRemoveIfZero($attribute, $value)
    {
        if ('0' === $value || 0 === $value) {
            Arr::forget($this->data, $attribute);
        }

        return true;
    }
}
