<?php

// Code to read and write the entire input as a single string
$input = trim(readline("(input) "));

// Define a regular expression pattern to match number, operator, number format or sqrt number format
if (!preg_match('/^\s*(\d+(\.\d+)?)\s*([+\-*\/]|sqrt)\s*(\d+(\.\d+)?)?\s*$/', $input, $matches)) {
    echo "Invalid input format. Please use the format: number operator number or sqrt number" . PHP_EOL;
    exit(1);
}

// Extract components from matches
$num1 = floatval($matches[1]);
$operator = $matches[3];
$num2 = isset($matches[4]) ? floatval($matches[4]) : null;

// Initialize result variable
$result = null;

// Perform calculations based on the operator
switch ($operator) {
    case '+':
        $result = $num1 + $num2;
        break;
    case '-':
        $result = $num1 - $num2;
        break;
    case '*':
        $result = $num1 * $num2;
        break;
    case '/':
        if ($num2 == 0) {
            echo "Error: Division by zero." . PHP_EOL;
            exit(1);
        }
        $result = $num1 / $num2;
        break;
    case 'sqrt':
        if ($num1 < 0) {
            echo "Error: Cannot calculate square root of a negative number." . PHP_EOL;
            exit(1);
        }
        $result = sqrt($num1);
        break;
    default:
        echo "Invalid operator" . PHP_EOL;
        exit(1);
}

// Output the result
if ($operator == 'sqrt') {
    echo "(output) $result" . PHP_EOL;
} else {
    echo "(output) $result" . PHP_EOL;
}

?>
