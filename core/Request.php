<?php

namespace App\Core;

/**
 * handle request made by client
 */
class Request
{
    protected $allowedRules = [
        'required',
        'min',
        'max',
        'email',
    ];

    public $errorBag = [];

    public function __construct(public Session $session)
    {
    }

    public function getPath(): string
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';

        // get path without query string
        $position = strpos($_SERVER['REQUEST_URI'], '?');

        if (!$position) {
            return $path;
        }

        return substr($_SERVER['REQUEST_URI'], 0, $position);
    }

    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function validate(array $rules): array|false
    {
        $validated = [];
        // todo handle wrong form fields and rules
        foreach ($rules as $formField => $userRules) {

            if (is_string($userRules)) {
                if (str_contains($userRules, '|')) {
                    $userRules = explode('|', $userRules);
                }
            }

            $hasError = false; // Initialize flag variable

            foreach ($userRules as $rule) {

                if (str_contains($rule, ':')) {
                    [$ruleName, $ruleValue] = explode(':', $rule);
                } else {
                    $ruleName = $rule;
                }

                if (!in_array($ruleName, $this->allowedRules)) {
                    echo "Rule {$ruleName} not allowed";
                    continue;
                }

                if (isset($this->getBody()[$formField])) {
                    $inputValue = $this->getBody()[$formField];
                } else {
                    $this->errorBag[$formField][] = "{{$formField}} not submitted";
                    $hasError = true;
                    break;
                }

                if ($ruleName == 'required') {
                    if (strlen($inputValue) <= 0) {
                        $this->errorBag[$formField][] = "{{$formField}} field cannot be empty";
                        $hasError = true;
                        break;
                    }
                }

                if ($ruleName == 'min') {
                    if (strlen($inputValue) < trim($ruleValue)) {
                        $this->errorBag[$formField][] = "{{$formField}} should have minimum " . trim($ruleValue) . " length";
                        $hasError = true;
                        break;
                    }
                }

                if ($ruleName == 'max') {
                    if (strlen($inputValue) > trim($ruleValue)) {
                        $this->errorBag[$formField][] = "{{$formField}} should have maximum " . trim($ruleValue) . " length";
                        $hasError = true;
                        break;
                    }
                }

                if ($ruleName == 'email') {
                    if (!preg_match("/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/", $inputValue)) {
                        $this->errorBag[$formField][] = "{{$formField}} is not valid email";
                        $hasError = true;
                        break;
                    }
                }
                $validated[$formField] = $this->getBody()[$formField];
            }
        }

        if (!$hasError) {
            return $validated;
        } else {
            $this->session->setFlash(Session::VALIDATION_ERRORS, $this->errorBag);
            return false;
        }
    }

    public function getBody()
    {
        $body = [];

        if ($this->getMethod() == 'get') {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->getMethod() == 'post') {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
    }
}
