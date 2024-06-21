<?php

// The function to evaluate the mathematical expression
function evaluateExpression($input) {
    // Code to determine a regular expression pattern to match number, operator, or sqrt number format
    if (!preg_match_all('/\b(?:\d+(\.\d+)?|sqrt\s*\d+(\.\d+)?)\b|[+\-*\/]/', $input, $matches)) {
        echo "Invalid input format." . PHP_EOL;
        exit(1);
    }

    // Code to split the input into tokens
    $tokens = $matches[0];

    // Code to initialize variables
    $result = 0;
    $last_operator = '+';
    $current_number = null;
    $perform_sqrt = false;

    // Code to process each token
    foreach ($tokens as $token) {
        if (is_numeric($token)) {
            // Code to check if the token is a number, the variable current_number will be updated
            $current_number = floatval($token);
        } elseif (preg_match('/^sqrt\s*(\d+(\.\d+)?)$/', $token, $sqrt_match)) {
            // Code to check if the token matches sqrt followed by a number, perform sqrt operation
            $current_number = sqrt(floatval($sqrt_match[1]));
        } else {
            // If token is an operator (+, -, *, /), perform operation with current operator
            switch ($last_operator) {
                case '+':
                    $result += $current_number;
                    break;
                case '-':
                    $result -= $current_number;
                    break;
                case '*':
                    $result *= $current_number;
                    break;
                case '/':
                    if ($current_number == 0) {
                        echo "Error: Division by zero." . PHP_EOL;
                        exit(1);
                    }
                    $result /= $current_number;
                    break;
                default:
                    echo "Invalid operator" . PHP_EOL;
                    exit(1);
            }

            // Update last operator and reset current number
            $last_operator = $token;
            $current_number = null;
        }
    }

    // Code to perform the final operation with the last operator and number
    switch ($last_operator) {
        case '+':
            $result += $current_number;
            break;
        case '-':
            $result -= $current_number;
            break;
        case '*':
            $result *= $current_number;
            break;
        case '/':
            if ($current_number == 0) {
                echo "Error: Division by zero." . PHP_EOL;
                exit(1);
            }
            $result /= $current_number;
            break;
        default:
            echo "Invalid operator" . PHP_EOL;
            exit(1);
    }

    return $result;
}

// Code to write and read the input in a single line
$input = trim(readline("(input) "));

// Code to evaluate the expression and output the result
$result = evaluateExpression($input);
echo "(output) $result" . PHP_EOL;

?>
