<?php
//the path to the class
//require_once('classes/validations.php');
spl_autoload_register(function ($class) {
    include 'class/' . $class . '.php';
});

//instance of the class
$validator = new validation();

//validate only number from 0-9 and it will also handle spaces.
//@param1 = input
//@param2 = length
if($validator->number(2323, 4))
{
	//code
	echo "true";
}

//validate only character from a-z
//@param1 = input
//@param2 = length
if($validator->character('as', 2))
{
	//code
	echo "true";
}

//no domain check
if($validator->email('dasd@skaldkla.com'))
{
	//code
	echo "string";
}

//domain check
if($validator->email('dsad@sadsadsad.com', true))
{
	//code
	echo "Domain Valid";
}

if($validator->minLength('@?½<>', 0, 100))
{

}