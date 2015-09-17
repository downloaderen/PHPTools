<?php
namespace classes;

class Validations{
	function __construct()
	{
	}
	public function number($number = null, $length = null)
	{
		(bool)$status = true;
		(int)$newNumber = str_replace(' ', '', $number);

		if($newNumber == null)
		{
			$status = false;
		}
		if($length != null)
		{
			if(strlen($newNumber) == $length)
			{
				$status = true;
			}
			else
			{
				$status = false;
			}
		}

		return $status;
	}
	public function character($value = null, $length = null)
	{
		(bool)$status = true;
		if (!ctype_alpha($value))
		{
			$status = false;
		}
		elseif ($length != null)
		{
			if(strlen($value) != $length)
			{
				$status = false;
			}
		}
		return $status;
	}
	public function email($email = null, $online = false)
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			if($online){
				$domain = explode('@', $email);
				if(filter_var(gethostbyname($domain[1]), FILTER_VALIDATE_IP))
				{
				    return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return true;
			}
		}
		else
		{
			return false;
		}
	}
	public function minLength($value, $min, $max)
	{
		$countValue = strlen(utf8_decode($value));
		echo $countValue;
		if(($countValue > $min) AND ($countValue < $max))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}