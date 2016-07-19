<?php

class University
{

	public $id;
	public $universityName;


	public function __construct($result)
	{
		if(is_array($result))
		{
			$this->id=$result['ID'];
			$this->universityName=$result['university'];
			
		}
		else
		{
			throw new Exception("No category data was supplied");
			
		}
	}	
}