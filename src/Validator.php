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
            'Default',

            'SetNullIfEmpty',
            'SetNullIfEmptyString',
            'SetNullIfZero',

            'RemoveIfEmpty',
            'RemoveIfNull',
            'RemoveIfEmptyString',
            'RemoveIfZero',

            'StripSpaces',
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
        if (!Arr::has($this->data, $attribute)) {
            $this->setAttributeValue($attribute, Arr::get($parameters, 0));
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
            $this->setAttributeValue($attribute, null);
        }

        return true;
    }

    /**
     * Set to NULL if it is a "".
     *
     * @param string $attribute
     * @param mixed  $value
     * @param array  $parameters
     *
     * @return bool
     */
    public function validateSetNullIfEmptyString($attribute, $value, $parameters)
    {
        if ('' === $value || (is_string($value) && 'trim' === Arr::get($parameters, 0) && '' === trim($value))) {
            $this->setAttributeValue($attribute, null);
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
            $this->setAttributeValue($attribute, null);
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
            $this->removeAttributeValue($attribute);
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
            $this->removeAttributeValue($attribute);
        }

        return true;
    }

    /**
     * Delete the attribute if it is "".
     *
     * @param string $attribute
     * @param mixed  $value
     * @param array  $parameters
     *
     * @return bool
     */
    public function validateRemoveIfEmptyString($attribute, $value, $parameters)
    {
        if ('' === $value || (is_string($value) && 'trim' === Arr::get($parameters, 0) && '' === trim($value))) {
            $this->removeAttributeValue($attribute);
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
            $this->removeAttributeValue($attribute);
        }

        return true;
    }

    /**
     * Strip all whitespace and invisible characters from the string value.
     *
     * 对非字符串值保持原样. 字符串值会被去除下列字符后回写:
     *   U+0009-U+000D  HT/LF/VT/FF/CR
     *   U+0020          半角空格
     *   U+0085          NEL
     *   U+00A0          NBSP
     *   U+00AD          SOFT HYPHEN
     *   U+034F          COMBINING GRAPHEME JOINER
     *   U+1680          OGHAM SPACE MARK
     *   U+180E          MONGOLIAN VOWEL SEPARATOR
     *   U+2000-U+200B   EN/EM QUAD..ZWSP (保留 ZWNJ U+200C 和 ZWJ U+200D)
     *   U+2028-U+2029   LINE/PARAGRAPH SEPARATOR
     *   U+202F          NARROW NO-BREAK SPACE
     *   U+205F          MEDIUM MATHEMATICAL SPACE
     *   U+2060          WORD JOINER
     *   U+2800          BRAILLE PATTERN BLANK
     *   U+3000          全角空格
     *   U+3164          HANGUL FILLER
     *   U+FEFF          BOM / ZWNBSP
     *
     * 保留: ZWNJ/ZWJ (印地/波斯/emoji 连字符), 双向控制字符, 阿拉伯格式字符, 变体选择符.
     *
     * 注意: 本规则只做"空白/不可见字符"剥离, 不做 Unicode 规范化.
     * 做姓名/邮箱等相等性比对前, 调用方应自行 Normalizer::normalize($s, Normalizer::FORM_C).
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function validateStripSpaces($attribute, $value)
    {
        if (is_string($value) && '' !== $value) {
            $this->setAttributeValue($attribute, static::stripSpaces($value));
        }

        return true;
    }

    /**
     * @param string $value
     *
     * @return string
     */
    protected static function stripSpaces($value)
    {
        // phpcs:ignore Generic.Files.LineLength.TooLong
        $pattern = '/[\x{0009}-\x{000D}\x{0020}\x{0085}\x{00A0}\x{00AD}\x{034F}\x{1680}\x{180E}\x{2000}-\x{200B}\x{2028}\x{2029}\x{202F}\x{205F}\x{2060}\x{2800}\x{3000}\x{3164}\x{FEFF}]+/u';

        $result = preg_replace($pattern, '', $value);

        // UTF-8 异常时 /u 正则会返回 null. 降级到字节级正则, 清理 ASCII 范围空白
        // (HT/LF/VT/FF/CR/SPACE 都是单字节, 不会出现在多字节序列中间, 按字节删除安全)
        return null === $result ? preg_replace('/[\x09-\x0D\x20]+/', '', $value) : $result;
    }

    /**
     * Set the value for the data attribute.
     *
     * @param string $name
     * @param mixed  $value
     */
    public function setAttributeValue($name, $value)
    {
        Arr::set($this->data, $name, $value);
    }

    /**
     * Delete an attribute of data.
     *
     * @param string $name
     */
    public function removeAttributeValue($name)
    {
        Arr::forget($this->data, $name);
    }
}
