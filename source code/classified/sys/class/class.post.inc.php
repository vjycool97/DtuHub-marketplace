<?php

/** 
 * Stores post information 
 * 
 * PHP version 5
 *
 * LICENSE: This source file is subject to the MIT License, available
 * at http://www.opensource.org/licenses/mit-license.html
 *
 * @author Hari Shekhar <shekhardtu@gmail.com>
 * @copyright 2014-2016 Prepmade India 
 * @license http://www.opensource.org/licenses/mit-license.html
 */
 
class Post
{
	
	/* 
	 * The post ID
	 *
	 * @var int
	 */
	public $post_id;
	/* 
	 * The post title
	 *
	 * @var string
	 */
	public $post_title;
	
	/* 
	 * The post content excerpt
	 *
	 * @var string
	 */
	public $post_excerpt;
	/* 
	 * The post content content
	 *
	 * @var string
	 */
	public $post_content;

	/* 
	 * The post posting_author
	 *
	 * @var string
	 */
	public $post_author;

	/* 
	 * The post posting_date
	 *
	 * @var datetime
	 */
	public $post_date;

	
	
	/* 
	 * The post post status
	 *
	 * @var string
	 */
	public $post_status;

	/* 
	 * The post price
	 *
	 * @var float
	 */
	public $price;

	/* 
	 * The seller state
	 * 
	 * @var int
	 */
	public $stateName;
	
	/* 
	 * The seller college
	 * 
	 * @var int
	 */
	public $collegeName;

	

	
	

	

	
	
	/** 
	 * Accepts an array of content posts and stores it
	 * @param array $post Associative array of post data
	 * @return void
	 */
	 
	
	public function __construct($post)
	{
		if(is_array($post))
		{
			$this->post_id=$post['ID'];
			$this->post_content=$post['post_content'];
			$this->post_title =$post['post_title'];
			$this->post_excerpt=$post['post_excerpt'];
			$this->post_author=$post['post_author'];
			$this->post_date=$post['post_date'];
			$this->post_status=$post['post_status'];
			$this->price=$post['price'];
			$this->stateName=$post['state_name'];
			
			$this->collegeName=$post['college_name'];
		
		}
		else
		{
			throw new Exception("There is no category in this post");
			
		}
	}
	
	
}