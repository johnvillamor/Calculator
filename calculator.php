<?php

// Function to evaluate the mathematical expression
function evaluateExpression($input) {
    // Code for defining a regular expression pattern to match number, operator, or sqrt number format
    if (!preg_match_all('/\b(?:\d+(\.\d+)?|sqrt\s*\d+(\.\d+)?)\b|[+\-*\/]/', $input, $matches)) {
        echo "Invalid input format." . PHP_EOL;
        exit(1);
    }

    // Split the input into tokens
    $tokens = $matches[0];

    // Initialize variables
    $result = 0;
    $last_operator = '+';
    $current_number = null;
    $perform_sqrt = false;

    // Process each token
    foreach ($tokens as $token) {
        if (is_numeric($token)) {
            // If token is a number, update current_number
            $current_number = floatval($token);
        } elseif (preg_match('/^sqrt\s*(\d+(\.\d+)?)$/', $token, $sqrt_match)) {
            // If token matches sqrt followed by a number, perform sqrt operation
            $current_number = sqrt(floatval($sqrt_match[1]));
        } else {
            // If token is an operator (+, -, *, /), perform operation with current operator
            switch ($token) {
                case '+':
                case '-':
                    // Perform addition or subtraction immediately for lower precedence
                    $result = performOperation($result, $last_operator, $current_number);
                    $last_operator = $token;
                    $current_number = null;
                    break;
                case '*':
                case '/':
                    // For higher precedence (multiplication and division), store the operator
                    $last_operator = $token;
                    break;
                default:
                    echo "Invalid operator" . PHP_EOL;
                    exit(1);
            }
        }
    }

    // Perform final operation with the last operator and number
    $result = performOperation($result, $last_operator, $current_number);

    return $result;
}

// Function to perform arithmetic operations
function performOperation($result, $operator, $number) {
    switch ($operator) {
        case '+':
            $result += $number;
            break;
        case '-':
            $result -= $number;
            break;
        case '*':
            $result *= $number;
            break;
        case '/':
            if ($number == 0) {
                echo "Error: Division by zero." . PHP_EOL;
                exit(1);
            }
            $result /= $number;
            break;
        default:
            break;
    }
    return $result;
}

// Read input from user
$input = trim(readline("(input) "));

// Evaluate the expression and output the result
$result = evaluateExpression($input);
echo "(output) $result" . PHP_EOL;

?>
