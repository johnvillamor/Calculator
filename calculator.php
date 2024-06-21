<?php

$num1 = readline("Enter first number: ");
$num2 = readline("Enter second number: ");
$operator = readline("operator: ");

if ($operator == '+') {
    $result = $num1 + $num2;
} else if ($operator == '-') {
    $result = $num1 - $num2;
} else if ($operator == '*') {
    $result = $num1 * $num2;
} else if ($operator == '/') {
    $result = $num1 / $num2;
} else {
    echo "Invalid operator";
    exit(1);
}

echo $result;
?>
