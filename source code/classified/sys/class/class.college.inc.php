<?php

class College
{

	public $id;
	public $collegeName;
	public $collegeNameSlug;



	public function __construct($result)
	{
		if(is_array($result))
		{
			$this->id=$result['ID'];
			$this->collegeName=$result['college_name'];
			$this->collegeNameSlug=$result['college_name_slug'];
		}
		else
		{
			throw new Exception("No category data was supplied");
			
		}
	}	
}