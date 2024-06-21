<?php

// Function to evaluate the mathematical expression
function evaluateExpression($input) {
    // Define a regular expression pattern to match number, operator, or sqrt number format
    if (!preg_match_all('/\b(?:\d+(\.\d+)?|sqrt\s*\d+(\.\d+)?)\b|[+\-*\/]/', $input, $matches)) {
        echo "Invalid input format." . PHP_EOL;
        exit(1);
    }

    // Split the input into tokens
    $tokens = $matches[0];

    // Initialize variables
    $result = null;
    $current_number = null;
    $last_operator = '+';

    // Process each token
    foreach ($tokens as $token) {
        if (is_numeric($token)) {
            // If token is a number, update current_number
            $current_number = floatval($token);
        } elseif (preg_match('/^sqrt\s*(\d+(\.\d+)?)$/', $token, $sqrt_match)) {
            // If token matches sqrt followed by a number, perform sqrt operation
            $current_number = sqrt(floatval($sqrt_match[1]));
        } else {
            // If token is an operator (+, -, *, /), perform operation according to MDAS rule
            switch ($token) {
                case '+':
                case '-':
                    // Evaluate previous operation and update result
                    if ($last_operator == '+') {
                        $result += $current_number;
                    } elseif ($last_operator == '-') {
                        $result -= $current_number;
                    }
                    // Update last operator
                    $last_operator = $token;
                    break;
                case '*':
                    // Update result immediately with multiplication
                    if ($result === null) {
                        $result = $current_number;
                    } elseif ($last_operator == '+') {
                        $result += $current_number;
                    } elseif ($last_operator == '-') {
                        $result -= $current_number;
                    } else {
                        $result *= $current_number;
                    }
                    break;
                case '/':
                    // Handle division by zero
                    if ($current_number == 0) {
                        echo "Error: Division by zero." . PHP_EOL;
                        exit(1);
                    }
                    // Update result immediately with division
                    if ($result === null) {
                        $result = $current_number;
                    } elseif ($last_operator == '+') {
                        $result += $current_number;
                    } elseif ($last_operator == '-') {
                        $result -= $current_number;
                    } else {
                        $result /= $current_number;
                    }
                    break;
                default:
                    echo "Invalid operator" . PHP_EOL;
                    exit(1);
            }

            // Reset current number for next iteration
            $current_number = null;
        }
    }

    // Final evaluation of any remaining operation
    if ($result === null) {
        $result = $current_number;
    } else {
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
                // Handle division by zero
                if ($current_number == 0) {
                    echo "Error: Division by zero." . PHP_EOL;
                    exit(1);
                }
                $result /= $current_number;
                break;
            default:
                break;
        }
    }

    return $result;
}

// Read input from user
$input = trim(readline("(input) "));

// Evaluate the expression and output the result
$result = evaluateExpression($input);
echo "(output) $result" . PHP_EOL;

?>
