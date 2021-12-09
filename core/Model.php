<?php

namespace app\core;

/**
 * Class Model
 *
 * @package app\core
 */
abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';

    public array $errors = [];

    abstract public function rules(): array;

    /**
     * @param $data
     * @return void
     */
    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * @return bool
     */
    public function validate()
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};

            foreach ($rules as $rule) {
                $ruleName = !is_string($rule) ? $rule[0] : $rule;

                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addError($attribute, self::RULE_REQUIRED);
                }

                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($attribute, self::RULE_EMAIL);
                }

                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addError($attribute, self::RULE_MIN, ['min' => $rule['min']]);
                }

                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addError($attribute, self::RULE_MAX);
                }

                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $this->addError($attribute, self::RULE_MATCH, ['match' => $rule['match']]);
                }
            }
        }

        return empty($this->errors);
    }

    /**
     * @return string[]
     */
    public function errorMessages()
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This field must be valid email address',
            self::RULE_MIN => 'Min length of this field must be {min}',
            self::RULE_MAX => 'Max length of this field must be {max}',
            self::RULE_MATCH => 'This field must be the same as {match}',
        ];
    }

    /**
     * @param $rule
     * @return string
     */
    public function errorMessage($rule)
    {
        return $this->errorMessages()[$rule];
    }

    /**
     * @param string $attribute
     * @param string $rule
     * @param $params
     * @return void
     */
    public function addError(string $attribute, string $rule, $params = [])
    {
        $errorMessage = $this->errorMessage($rule);

        foreach ($params as $key => $value) {
            $errorMessage = str_replace("{{$key}}", $value, $errorMessage);
        }

        $this->errors[$attribute][] = $errorMessage;
    }
}