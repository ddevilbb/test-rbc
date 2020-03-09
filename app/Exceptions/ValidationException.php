<?php
namespace App\Exceptions;

use Illuminate\Contracts\Validation\Validator;
use Throwable;

class ValidationException extends \Exception
{
    public function __construct(Validator $validator, $code = 0, Throwable $previous = null)
    {
        $message = sprintf(
            'Validation errors: %s %s',
            PHP_EOL,
            implode(PHP_EOL, array_map(function($messages) {
                return implode(PHP_EOL, $messages);
            }, $validator->errors()->messages()))
        );

        parent::__construct($message, $code, $previous);
    }
}
