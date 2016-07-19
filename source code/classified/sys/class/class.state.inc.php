<?php

class State
{

	public $id;
	public $sateName;



	public function __construct($result)
	{
		if(is_array($result))
		{
			$this->id=$result['ID'];
			$this->stateName=$result['state_name'];
		}
		else
		{
			throw new Exception("No category data was supplied");
			
		}
	}	
}