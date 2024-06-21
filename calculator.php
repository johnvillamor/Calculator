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
    $result = 0;
    $current_number = null;
    $last_operator = '+';
    $last_precedence = 0;
    $pending_operand = false; // Flag to handle unary minus

    // Process each token
    foreach ($tokens as $token) {
        if (is_numeric($token)) {
            // If token is a number, update current_number
            $current_number = floatval($token);
        } elseif (preg_match('/^sqrt\s*(\d+(\.\d+)?)$/', $token, $sqrt_match)) {
            // If token matches sqrt followed by a number, perform sqrt operation
            $current_number = sqrt(floatval($sqrt_match[1]));
        } else {
            // If token is an operator (+, -, *, /), determine precedence and associativity
            $current_operator = $token;

            // Determine precedence of current operator
            switch ($current_operator) {
                case '+':
                case '-':
                    $current_precedence = 1;
                    break;
                case '*':
                case '/':
                    $current_precedence = 2;
                    break;
                default:
                    $current_precedence = 0; // Assume no precedence for non-operator tokens
                    break;
            }

            // Handle unary minus (negative numbers)
            if ($current_operator == '-' && !$pending_operand) {
                // Check if the previous token is an operator or it's the start of the expression
                if ($last_operator == null || in_array($last_operator, ['+', '-', '*', '/'])) {
                    $current_number = -$current_number;
                    $pending_operand = true;
                    continue; // Skip further processing for this token
                }
            } else {
                $pending_operand = false;
            }

            // Evaluate the expression based on precedence and associativity
            if ($current_precedence > $last_precedence) {
                // Higher precedence operator, perform the operation immediately
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
                        break;
                }
            } else {
                // Lower or equal precedence operator, delay the operation
                $last_operator = $current_operator;
                $last_precedence = $current_precedence;
            }

            // Reset current number for next iteration
            $current_number = null;
        }
    }

    // Final evaluation of any remaining operation
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
