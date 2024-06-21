<?php

//Variable declarations
$num1 = readline("Enter first number: ");
$operator = readline("Choose an operator (+, -, *, /, sqrt): ");

//Condition if you choose the sqrt operator
if ($operator == 'sqrt') {
    $result = sqrt($num1);
} else {
    $num2 = readline("Enter second number: ");
    
//Conditions for +, -, *, / operators
    if ($operator == '+') {
        $result = $num1 + $num2;
    } else if ($operator == '-') {
        $result = $num1 - $num2;
    } else if ($operator == '*') {
        $result = $num1 * $num2;
    } else if ($operator == '/') {

 //Condition if the number is divided by zero       
        if ($num2 == 0) {
            echo "Error: Division by zero.";
            exit(1);
        }
        $result = $num1 / $num2;

 //Condition if the operators entered invalid           
    } else {
        echo "Invalid operator";
        exit(1);
    }
}

echo $result;
?>
