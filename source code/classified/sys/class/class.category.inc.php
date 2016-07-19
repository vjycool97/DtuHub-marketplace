
<?php

class Category
{

	public $categoryName;
	public $categoryId;
	public $categoryCount;
	public $categoryTaxonomyId;
	public $categoryParent;


	public function __construct($result)
	{
		if(is_array($result))
		{
			$this->categoryName=$result['name'];
			$this->categoryId=$result['term_id'];
			$this->categoryCount=$result['count'];
			$this->categoryTaxonomyId=$result['term_taxonomy_id'];
			$this->categoryParent=$result['parent'];

		}
		else
		{
			throw new Exception("No category data was supplied");
			
		}
	}	
}