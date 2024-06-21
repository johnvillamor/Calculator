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

    // Process each token
    foreach ($tokens as $token) {
        if (is_numeric($token)) {
            // If token is a number, update current_number
            $current_number = floatval($token);
        } elseif (preg_match('/^sqrt\s*(\d+(\.\d+)?)$/', $token, $sqrt_match)) {
            // If token matches sqrt followed by a number, perform sqrt operation
            $current_number = sqrt(floatval($sqrt_match[1]));
        } else {
            // If token is an operator (+, -, *, /), perform operation according to precedence
            $current_operator = $token;

            // Determine precedence of current operator
            if ($current_operator == '*' || $current_operator == '/') {
                $current_precedence = 2;
            } else {
                $current_precedence = 1;
            }

            // Evaluate the expression if current operator has higher precedence or if it's the end of the expression
            if ($current_precedence > $last_precedence || $current_operator == null) {
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
                $last_operator = $current_operator;
                $last_precedence = $current_precedence;
                $current_number = null;
            } else {
                // Update last operator and continue to next token
                $last_operator = $current_operator;
                $last_precedence = $current_precedence;
            }
        }
    }

    // Final evaluation of the last operation
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
