
<?php

class Images
{

	public $imageUrl;
	public $imageOrder;
	


	public function __construct($result)
	{
		if(is_array($result))
		{
			$this->imageUrl=$result['image_path'];
			$this->imageOrder=$result['image_order'];

		}
		else
		{
			throw new Exception("No image data was supplied");
			
		}
	}	
}