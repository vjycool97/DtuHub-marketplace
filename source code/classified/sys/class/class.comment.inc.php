<?php 
/** 
 * Stores comment information 
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
 
class Comment
{
	
	/* 
	 * The comment ID
	 *
	 * @var int
	 */
	public $commentId;
	/* 
	 * The comment title
	 *
	 * @var string
	 */
	public $sellerId;
	
	/* 
	 * The comment content excerpt
	 *
	 * @var string
	 */
	public $commentPostId;
	/* 
	 * The comment content content
	 *
	 * @var string
	 */
	public $commentAuthor;

	/* 
	 * The comment commenting_author
	 *
	 * @var string
	 */
	public $commentAuthorEmail;

	/* 
	 * The comment commenting_date
	 *
	 * @var datetime
	 */
	public $commentAuthorContact;

	
	
	/* 
	 * The comment comment status
	 *
	 * @var string
	 */
	public $commentDate;

	/* 
	 * The comment price
	 *
	 * @var float
	 */
	public $commentContent;

	/* 
	 * The seller state
	 * 
	 * @var int
	 */
	public $commentType;
	
	/* 
	 * The seller college
	 * 
	 * @var int
	 */
	public $userId;

	

	
	

	

	
	
	/** 
	 * Accepts an array of content comments and stores it
	 * @param array $comment Associative array of comment data
	 * @return void
	 */
	 
	
	public function __construct($comment)
	{
		if(is_array($comment))
		{
			$this->commentId=$comment['comment_ID'];
			$this->sellerId=$comment['seller_ID'];
			$this->commentPostId =$comment['comment_post_ID'];
			$this->commentAuthor=$comment['comment_author'];
			$this->commentAuthorEmail=$comment['comment_author_email'];
			$this->commentAuthorContact=$comment['comment_author_contact'];
			$this->commentDate=$comment['comment_date'];
			$this->commentContent=$comment['comment_content'];
			$this->commentType=$comment['comment_type'];
			
			$this->userId=$comment['user_id'];
		
		}
		else
		{
			throw new Exception("There is no comment in this wp_comment");
			
		}
	}
	
	
}