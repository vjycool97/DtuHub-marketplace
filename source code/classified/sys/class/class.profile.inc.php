<?php

class Profile
{

	
	public $fullName;
	public $collegeYear;
	public $collegeId;
	public $stateId;
	public $userEmail;
	public $userMobile;
	public $userStatus;




	public function __construct($result)
	{
		if(is_array($result))
		{
			$this->id=$result['ID'];
			$this->fullName=$result['user_login'];
			$this->userEmail=$result['user_email'];
			$this->userMobile=$result['user_mobile'];
			$this->userStatus=$result['user_status'];

			
		}
		else
		{
			throw new Exception("No profile data was supplied");
			
		}
	}	
}