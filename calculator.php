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
    $result = null;
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
                    // Apply previous operation if there is a pending operation and update result
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
                                if ($current_number == 0) {
                                    echo "Division by zero error" . PHP_EOL;
                                    exit(1);
                                }
                                $result /= $current_number;
                                break;
                            default:
                                break;
                        }
                    }

                    // Update last operator
                    $last_operator = $token;
                    // Reset current number
                    $current_number = null;
                    // Reset sqrt flag
                    $sqrt_flag = false;
                    break;
                case '*':
                case '/':
                    // Directly apply multiplication and division rules
                    if ($sqrt_flag) {
                        $current_number = $last_operator == '-' ? -$current_number : $current_number;
                        $result = $token == '*' ? $result * $current_number : ($result / $current_number);
                        $sqrt_flag = false;
                    } else {
                        // Evaluate pending multiplication and division before updating last operator
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
                                    echo "Division by zero error" . PHP_EOL;
                                    exit(1);
                                }
                                $result /= $current_number;
                                break;
                            default:
                                break;
                        }
                        // Update last operator
                        $last_operator = $token;
                    }
                    // Reset current number
                    $current_number = null;
                    break;
                default:
                    echo "Invalid operator" . PHP_EOL;
                    exit(1);
            }
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
                if ($current_number == 0) {
                    echo "Division by zero error" . PHP_EOL;
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
