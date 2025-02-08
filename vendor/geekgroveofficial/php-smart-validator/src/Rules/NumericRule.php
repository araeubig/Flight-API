<?php

namespace GeekGroveOfficial\PhpSmartValidator\Rules;

class NumericRule implements ValidationRuleInterface
{
    public function validate(string $field, mixed $value, mixed $parameter = null): bool
    {
        //if ( (! is_numeric($value)) && ($value != 0)) {
        if ( !is_numeric($value) ) {
        // if ( $value != 0 ) {
            return false;
        }

        return true;
    }

    public function getErrorMessage(string $field, mixed $parameter = null): string
    {
        return "{$field} must be type numeric / decimal.";
    }
}
