<?php

// Function to evaluate the mathematical expression following MDAS rule
function evaluateExpression($input) {
    // Define a regular expression pattern to match number, operator, or sqrt number format
    if (!preg_match_all('/\b(?:\d+(\.\d+)?|sqrt\s*\d+(\.\d+)?)\b|[+\-*\/]/', $input, $matches)) {
        echo "Invalid input format." . PHP_EOL;
        exit(1);
    }

    // Split the input into tokens
    $tokens = $matches[0];

    // Initialize variables
    $current_result = 0;
    $current_number = null;
    $last_operator = '+';
    $temp_result = null;
    $temp_operator = null;

    // Process each token
    foreach ($tokens as $token) {
        if (is_numeric($token)) {
            $current_number = floatval($token);
            if ($temp_operator) {
                if ($temp_operator == '*') {
                    $temp_result *= $current_number;
                } elseif ($temp_operator == '/') {
                    if ($current_number == 0) {
                        echo "Division by zero error" . PHP_EOL;
                        exit(1);
                    }
                    $temp_result /= $current_number;
                }
                $current_number = $temp_result;
                $temp_result = null;
                $temp_operator = null;
            }
        } elseif (preg_match('/^sqrt\s*(\d+(\.\d+)?)$/', $token, $sqrt_match)) {
            $current_number = sqrt(floatval($sqrt_match[1]));
            if ($temp_operator) {
                if ($temp_operator == '*') {
                    $temp_result *= $current_number;
                } elseif ($temp_operator == '/') {
                    if ($current_number == 0) {
                        echo "Division by zero error" . PHP_EOL;
                        exit(1);
                    }
                    $temp_result /= $current_number;
                }
                $current_number = $temp_result;
                $temp_result = null;
                $temp_operator = null;
            }
        } elseif ($token == '*' || $token == '/') {
            if ($temp_result === null) {
                $temp_result = $current_number;
            } else {
                if ($temp_operator == '*') {
                    $temp_result *= $current_number;
                } elseif ($temp_operator == '/') {
                    if ($current_number == 0) {
                        echo "Division by zero error" . PHP_EOL;
                        exit(1);
                    }
                    $temp_result /= $current_number;
                }
            }
            $temp_operator = $token;
            $current_number = null;
        } elseif (in_array($token, ['+', '-'])) {
            if ($last_operator == '+') {
                $current_result += $current_number;
            } elseif ($last_operator == '-') {
                $current_result -= $current_number;
            }
            $last_operator = $token;
            $current_number = null;
        } else {
            echo "Invalid token: $token" . PHP_EOL;
            exit(1);
        }
    }

    if ($current_number !== null) {
        if ($last_operator == '+') {
            $current_result += $current_number;
        } elseif ($last_operator == '-') {
            $current_result -= $current_number;
        }
    }

    return $current_result;
}

// Read input from user
$input = trim(readline("(input) "));

// Evaluate the expression and output the result
$result = evaluateExpression($input);
echo "(output) $result" . PHP_EOL;

?>
