<?php
namespace Core\Validation;

class Validator {
    public function validate(array $data, array $rules): array {
        $errors = [];

        foreach ($rules as $field => $fieldRules) {
            $fieldRules = is_array($fieldRules) ? $fieldRules : explode('|', $fieldRules);
            $value = $data[$field] ?? null;

            foreach ($fieldRules as $rule) {
                [$ruleName, $ruleValue] = array_pad(explode(':', $rule, 2), 2, null);

                if ($ruleName === 'required' && $this->isEmpty($value)) {
                    $errors[$field][] = ucfirst($field) . ' is required.';
                    continue;
                }

                if ($this->isEmpty($value)) {
                    continue;
                }

                if ($ruleName === 'string' && !is_string($value)) {
                    $errors[$field][] = ucfirst($field) . ' must be a string.';
                }

                if ($ruleName === 'numeric' && !is_numeric($value)) {
                    $errors[$field][] = ucfirst($field) . ' must be numeric.';
                }

                if ($ruleName === 'min' && mb_strlen((string) $value) < (int) $ruleValue) {
                    $errors[$field][] = ucfirst($field) . ' must be at least ' . $ruleValue . ' characters.';
                }

                if ($ruleName === 'max' && mb_strlen((string) $value) > (int) $ruleValue) {
                    $errors[$field][] = ucfirst($field) . ' must not exceed ' . $ruleValue . ' characters.';
                }
            }
        }

        return $errors;
    }

    private function isEmpty(mixed $value): bool {
        return $value === null || $value === '' || $value === [];
    }
}