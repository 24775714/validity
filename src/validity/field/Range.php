<?php

namespace validity\field;

use validity\Field;
use validity\Language;
use validity\Report;

trait Range
{
    private static $languageKeyMap = [
        Field::INT => [Language::NUMBER_MIN, Language::NUMBER_MAX],
        Field::FLOAT => [Language::NUMBER_MIN, Language::NUMBER_MAX],
        Field::DATE => [Language::DATE_MIN, Language::DATE_MAX],
        Field::DATETIME => [Language::DATE_MIN, Language::DATE_MAX],
    ];

    /**
     * @param mixed $min
     * @param string $message
     * @return $this
     */
    public function setMin($min, $message = null): Field
    {
        /** @var Field $this */
        return $this->addRule(
            function() use ($min) {
                if ($this->compareWith($min) < 0) {
                    return false;
                } else {
                    return true;
                }
            },
            $message,
            self::$languageKeyMap[$this->getType()][0],
            ["min" => $min]
        );
    }

    /**
     * @param mixed $max
     * @param string $message
     * @return $this
     */
    public function setMax($max, $message = null): Field
    {
        return $this->addRule(
            function() use ($max) {
                if ($this->compareWith($max) > 0) {
                    return false;
                } else {
                    return true;
                }
            },
            $message,
            self::$languageKeyMap[$this->getType()][1],
            ["max" => $max]
        );
    }

    abstract protected function compareWith($value): int;
}