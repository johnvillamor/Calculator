<?php

// Function to evaluate the mathematical expression following MDAS rule
function evaluateExpression($input) {
    // Define a regular expression pattern to match numbers, operators, or sqrt number format
    if (!preg_match_all('/\b(?:\d+(\.\d+)?|sqrt\s*\d+(\.\d+)?)\b|[+\-*\/]/', $input, $matches)) {
        echo "Invalid input format." . PHP_EOL;
        exit(1);
    }

    // Split the input into tokens
    $tokens = $matches[0];

    // Initialize variables
    $current_result = 0; // To store the result of the expression
    $current_number = null; // To store the current number being processed
    $last_operator = '+'; // To store the last operator encountered, initialized to '+'
    $temp_result = null; // To store intermediate results of multiplication or division
    $temp_operator = null; // To store the last multiplication or division operator

    // Process each token
    foreach ($tokens as $token) {
        if (is_numeric($token)) {
            // If the token is a number, convert it to a float
            $current_number = floatval($token);
            // If there was a previous multiplication or division, apply it
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
                // After applying, set the current number to the temp result and reset temp variables
                $current_number = $temp_result;
                $temp_result = null;
                $temp_operator = null;
            }
        } elseif (preg_match('/^sqrt\s*(\d+(\.\d+)?)$/', $token, $sqrt_match)) {
            // If the token is a sqrt operation, calculate the square root
            $current_number = sqrt(floatval($sqrt_match[1]));
            // If there was a previous multiplication or division, apply it
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
                // After applying, set the current number to the temp result and reset temp variables
                $current_number = $temp_result;
                $temp_result = null;
                $temp_operator = null;
            }
        } elseif ($token == '*' || $token == '/') {
            // If the token is a multiplication or division operator
            if ($temp_result === null) {
                $temp_result = $current_number; // Store the current number in temp_result
            } else {
                // Apply the previous temp operator
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
            // Set the current operator to temp_operator and reset current number
            $temp_operator = $token;
            $current_number = null;
        } elseif (in_array($token, ['+', '-'])) {
            // If the token is an addition or subtraction operator
            if ($last_operator == '+') {
                $current_result += $current_number;
            } elseif ($last_operator == '-') {
                $current_result -= $current_number;
            }
            // Set the current operator to last_operator and reset current number
            $last_operator = $token;
            $current_number = null;
        } else {
            // If an invalid token is encountered, show an error message
            echo "Invalid token: $token" . PHP_EOL;
            exit(1);
        }
    }

    // Apply the last operator to the final number
    if ($current_number !== null) {
        if ($last_operator == '+') {
            $current_result += $current_number;
        } elseif ($last_operator == '-') {
            $current_result -= $current_number;
        }
    }

    return $current_result;
}

// Read input
$input = trim(readline("(input) "));

// Evaluate the expression and output the result
$result = evaluateExpression($input);
echo "(output) $result" . PHP_EOL;

?>

