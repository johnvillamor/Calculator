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
    $sqrt_flag = false;

    // Process each token
    foreach ($tokens as $token) {
        if (is_numeric($token)) {
            // If token is a number, update current_number
            $current_number = floatval($token);
        } elseif (preg_match('/^sqrt\s*(\d+(\.\d+)?)$/', $token, $sqrt_match)) {
            // If token matches sqrt followed by a number, perform sqrt operation
            $current_number = sqrt(floatval($sqrt_match[1]));
            $sqrt_flag = true; // Set flag for sqrt operation
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
                case '/':
                    // Handle multiplication and division with sqrt precedence
                    if ($sqrt_flag) {
                        $current_number = $last_operator == '-' ? -$current_number : $current_number;
                        $result = $token == '*' ? $result * $current_number : $result / $current_number;
                        $sqrt_flag = false;
                    } else {
                        // No sqrt precedence, apply MDAS directly
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
                                $result /= $current_number;
                                break;
                            default:
                                break;
                        }
                        // Update last operator
                        $last_operator = $token;
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
    if ($current_number !== null) {
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
