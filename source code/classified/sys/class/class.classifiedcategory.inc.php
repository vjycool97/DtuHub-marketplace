<?php 

/**
*
* Database actions (DB access, validation, etc.)
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

class ClassifiedCategory extends DB_Connect
{

/**
 * Creates a database object and stores relevant data
 *
 * Upon instantiation, this class accepts a database object
 * that, if not null, is stored in the object's private $_db
 * property. If null, a new PDO object is created and stored
 * instead.
 *
 * Additional info is gathered and stored in this method,
 * including the month from which the calendar is to be built,
 * how many days are in said month, what day the month starts
 * on, and what day it is currently.
 *
 * @param object $dbo a database object
 * @param string $useDate the date to use to build the calendar
 * @return void
 *
 */


	public function __construct($dbo=NULL)
	{
		/**
		 * Call for parent constructor to check for
		 * a database object
		 */
		parent::__construct($dbo);

	}

	private function _loadCategoryData($parent=NULL)
	{
		$sql="SELECT wp_term_taxonomy.term_taxonomy_id,wp_term_taxonomy.term_id, wp_term_taxonomy.parent,wp_term_taxonomy.count, wp_terms.name 
		FROM wp_term_taxonomy INNER JOIN wp_terms ON wp_term_taxonomy.term_id = wp_terms.term_id 
		WHERE taxonomy='category' AND parent=$parent";

		try
		{
			$stmt=$this->db->prepare($sql);
			$stmt->execute();
			$results=$stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt->closeCursor();

		}
		catch(Exception $e)
		{
			die($e->getMessage());

		}
		return $results;

	}

	/* 
	 * 
	 */
	public function timeStamp($session_time) 
	{ 
		 
		$time_difference = time() - strtotime($session_time); 
		$seconds = $time_difference ; 
		$minutes = round($time_difference / 60 );
		$hours = round($time_difference / 3600 ); 
		$days = round($time_difference / 86400 ); 
		$weeks = round($time_difference / 604800 ); 
		$months = round($time_difference / 2419200 ); 
		$years = round($time_difference / 29030400 ); 

		if($seconds <= 60)
		{
		$time="$seconds seconds ago"; 
		}
		else if($minutes <=60)
		{
		   if($minutes==1)
		   {
		     $time="one minute ago"; 
		    }
		   else
		   {
		   $time="$minutes minutes ago"; 
		   }
		}
		else if($hours <=24)
		{
		   if($hours==1)
		   {
		   $time="one hour ago";
		   }
		  else
		  {
		  $time="$hours hours ago";
		  }
		}
		else if($days <=7)
		{
		  if($days==1)
		   {
		  $time="one day ago";
		   }
		  else
		  {
		  $time="$days days ago";
		  }


		  
		}
		else if($weeks <=4)
		{
		  if($weeks==1)
		   {
		   $time="one week ago";
		   }
		  else
		  {
		  $time="$weeks weeks ago";
		  }
		 }
		else if($months <=12)
		{
		   if($months==1)
		   {
		   $time="one month ago";
		   }
		  else
		  {
		  $time="$months months ago";
		  }
		 
		   
		}

		else
		{
		if($years==1)
		   {
		   $time="one year ago";
		   }
		  else
		  {
		  $time="$years years ago";
		  }


		}
		 
		 return $time;


	} 

	public function _loadSiteSearch($id, $post_status,$post_field, $limit)
	{
		if(isset($_GET['searchButton']) AND !empty($_GET['search']))

		{
			$string="Search results for..";
			$string.="\" ".$_GET['search']. " \"";


			$sql="SELECT *, MATCH (`post_title`) AGAINST ('$_GET[search]' IN BOOLEAN MODE)*10 AS rel1,
			 MATCH (`post_content`) AGAINST ('$_GET[search]' IN BOOLEAN MODE)*7 AS rel2,
			 MATCH (`college_name`) AGAINST ('$_GET[search]' IN BOOLEAN MODE)*5 AS rel3, 
			 MATCH (`price_type`) AGAINST ('$_GET[search]' IN BOOLEAN MODE)*3 AS rel4 
			  FROM wp_posts 
			 WHERE post_status='$post_status' AND  MATCH (post_title, post_content,college_name, price_type) AGAINST('$_GET[search]' IN BOOLEAN MODE) 
			 ORDER BY(rel1)+(rel2)+(rel3)+(rel4) DESC";

			
			try
			{
				$stmt=$this->db->prepare($sql);
				$stmt->execute();
				$result =$stmt->fetchAll();
				$stmt->closeCursor();

			}
			catch(Exception $e)
			{
				die($e->getMessage());
			}


		}
		else
			{
				return null;
			}

		return $result;
	}


	public function siteSearch($id, $post_status,$post_field, $limit)
	{ 
		$arr=$this->_loadSiteSearch($id, $post_status,$post_field, $limit);
		
		
		$html=NULL;

		
		if($arr==NULL)
		{

				$html =' <div class="row">
							<div class="col-md-12 text-center margin-top-16">
						<h4>Oops!!! There is no ads for your search term "'.$_GET["search"].'" </h4>
						</div>
						</div>';
		}
		else
		{
			$html.=' <div class="row">
							<div class="col-md-12 text-left margin-top-16">
						Search results for..."<b>'.$_GET["search"].'</b>"  with about <b>'.count($arr).' </b> results;
						</div>
						</div>';
		foreach($arr as $post)
		{ 

			$results= new Post($post);
			$imageData=$this->_loadImages($results->post_id, 'classified', $limit);

  			$link ='<div class="panel panel-head panel-default">';
			$link.='<div class="panel-heading">';
			$link.='<h1 class="panel-title"> <a href="../classified/'
			.$results->post_id.'">'.$results->post_title.'</a></h1></div>';
			$link .='<div class="panel-body padding-top-bottom-0">';

			$link .="<div class='row'>";
			$link .='<div class="col-xs-2">';
			
			foreach($imageData as $result)
			{

				$image= new Images($result);
				$link.='<img src="'.$image->imageUrl.'" class="img-responsive" alt="'.$results->post_title.'" style=" width: 130px !important;
			    height: 114px;
			    background-size: cover;
			    background-repeat: no-repeat;
			    background-position: 50% 50%;
			   ">';
			}

			$link .="</div><div class='col-xs-10'>";
			
			$link .='<div class="row">';
			$link .="<div class='col-xs-12 margin-top-16'>";
			$link .=$results->post_excerpt;
			$link .="</div>";
			$link .="</div>";

			$link .="<div class='row margin-top-16 margin-right-16 margin-bottom-0'>";
			$link .="<div class='col-xs-6 odd'>";
			$link .='<i class="fa fa-university"></i>  ';
			$link .= $results->collegeName;
			$link .="</div>";
			$link .="<div class='col-xs-3 even text-center'>";

			$link .='<i class="fa fa-clock-o"></i>  ';
			$link .= $this->timeStamp($results->post_date);
			$link .="</div>";
			$link .="<div class='col-xs-3 odd font-24 text-right'>";
			$link .="<i class='fa fa-inr'></i> ";
			$link .= $results->price."/-";
			$link .="</div>";

			$link .="</div>";
			$link .="</div>";
			
			
			
			
			$link .="</div></div></div>";

			
			$html .="\n\n\t$link";
		}

		$html .=' <div class="row">
							<div class="col-md-12 text-center margin-top-16">
						<h6>There is no more post in your selected category.</h6>
						</div>
						</div>';

	}
		

		return $html;
}

	

	

	/* It will give you the total post active in a category
	 * either it is main category or subcategory
	 *
	 * @param taxonomy_id INT
	 *
	 * @return total count of post under that category
	 */

	 public function classifiedCount($term_taxonomy_id, $college_id=NULL) 
	 {
	 	if(isset($_SESSION['guest']['collegeId']))
	 	{
	 		$college_id=$_SESSION['guest']['collegeId'];
	 	}
	 	else
	 	{
	 		$college_id=NULL;
	 	}

	 	$sql="SELECT DISTINCT count(object_id) as post_count FROM wp_term_relationships WHERE
	 	 term_taxonomy_id=:term_taxonomy_id AND relationship_status='publish' ";
	 	 

	 	 if(!empty($college_id))
	 	 {
	 	 	$sql.="AND college_id='$college_id'";
	 	 }
	 	try
	 	{
	 		$stmt=$this->db->prepare($sql);
	 		$stmt->bindParam(':term_taxonomy_id', $term_taxonomy_id,PDO::PARAM_STR);
	 		$stmt->execute();
	 		$results=$stmt->fetchAll();
	 		$stmt->closeCursor();
	 	}
	 	catch(Exception $e)
	 	{
	 		die($e->getMessage());

	 	}
	 	return $results;
	 	
	 	var_dump($results);
	 }


	public function createCategoryObject()
	{
		$html=NULL;
		$arr=$this->_loadCategoryData(0);

		
		foreach ($arr as  $value)
		{	
			
			$result=new category($value);
			$link ='<div class="col-xs-12 col-sm-6 col-md-4">';
			$link .='<ul class="category">';
			$link .="<li>";
			$link .='<a href="../category/'. $result->categoryTaxonomyId. '">' . $result->categoryName	. '</a>';
			$link .="</li>";
			$count= $this->classifiedCount($result->categoryTaxonomyId);
			$link .='<li><span class="small margin-left-5">'.$count[0][0].' Ads</span></li>';
			$html .= "$link";
				$arr1=$this->_loadCategoryData($result->categoryTaxonomyId);
				
				foreach ($arr1 as  $value1)
				{	
					
					$link1 ="<li>";
					$result1=new category($value1);
					$link1  .='<a href="../category/'
					.$result1->categoryTaxonomyId.'">'.$result1->categoryName.'</a>';
					$link1 .="</li>";
					
					$html.= "$link1";
										
				}
			
			$html .="</ul>";
			$html .="</div>";
			
			
		}
		
		
		return $html;
		
	}

	public function getCollegeNameBySlug($collegeNameSlug)
	{
		try
		{
			$stmt=$this->db->prepare("SELECT * FROM wp_college WHERE college_name_slug=:collegeSlug");
			$stmt->bindParam(":collegeSlug", $collegeNameSlug, PDO::PARAM_STR);
			$stmt->execute();
			$collegeInfo=$stmt->fetchAll();
			$stmt->closeCursor();

		}
		catch(Exception $e)
		{
			die(getMessage());
		}

		return $collegeInfo;
	}
	

	public function _loadCategoryPosts($id,$collegeNameSlug,$post_status,$postOrder,$post_field, $adType, $itemCondition, $adlimit)
	{	

		
		
		/*
		 * Check the collegeNameSlug and find its id
		 *
		 */
		if(!empty($collegeNameSlug))
		{
			
			$collegeInfo=$this->getCollegeNameBySlug($collegeNameSlug);
			$collegeNameId=(int)$collegeInfo[0]["ID"];
			
		}
		else
		{
			$collegeNameId=NULL;
		}

		
	
		/*
		 * Make sure an ID was passed
		 * Make sure the ID is an integer
		 */
		if(!empty($id))
		{
			$id = (int)(preg_replace('/[^0-9]/', '', $id));

			if(isset($_SESSION['guest']['collegeId']))
		 	{
		 		$college_id=$_SESSION['guest']['collegeId'];
		 	}
		 	else
		 	{
		 		$college_id=NULL;
		 	} 
		}
		else
		{
			
			$collegeId=$collegeNameId;
		}


		
	 	

		$sql="SELECT DISTINCT (ID) as ID, post_title, post_excerpt, post_content, post_author, post_date, term_taxonomy_id, post_status, college_name, state_name, price
		 FROM wp_posts INNER JOIN wp_term_relationships ON wp_posts.ID=wp_term_relationships.object_id AND wp_term_relationships.relationship_status='publish' ";

		
		if((!empty($adType)==true) && (!empty($itemCondition)==true))
		{
			$sql.="WHERE ad_type='$adType' AND item_condition='$itemCondition' AND ";
		}
		elseif(!empty($adType))
		{
			$sql.="WHERE ad_type='$adType' AND ";
		}
		elseif(!empty($itemCondition))
		{
			$sql.="WHERE item_condition='$itemCondition' AND ";
		}
		else
		{
			$sql.="WHERE ";
		}

		$sql.="wp_posts.post_status='$post_status' ";
		if(!empty($college_id))
		{
			$sql.="AND wp_term_relationships.college_id='$college_id' ";
		}


		if(!empty($id))
		{
			$sql.=" AND wp_term_relationships.term_taxonomy_id='$id' ";
		}
		else
		{
			$sql.=" AND wp_term_relationships.college_id='$collegeId' ";
		}

		
		
		$sql.="GROUP BY ID ";
		if(!empty($postOrder))
		{
			$sql.="ORDER BY $postOrder DESC ";
		}
		else
		{
			$sql.="ORDER BY post_date DESC ";
		}


		
		// if(!empty($adlimit))
		// {
		// 	$sql.="LIMIT $adlimit ";
		// }
		
		

		try
		{
			$stmt=$this->db->prepare($sql);
			$stmt->execute();
			$results=$stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt->closeCursor();

			// foreach($results as $row)
			// {

			// }
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
		
		return $results;

	}


	public function viewAllPost($id=NULL, $collegeNameSlug=NULL,$post_status,$postOrder,$post_field, $adType, $itemCondition, $adlimit)
	{
		
		$arr=$this->_loadCategoryPosts(($id=2), $collegeNameSlug,$post_status,$postOrder,$post_field, $adType, $itemCondition, $adlimit);
		$gethtml=NULL;
		foreach($arr as $post)
		{ 

			$results= new Post($post);
			$gethtml.='
					<li><div class="row">
							<div class="col-md-12">
							<a class="panel-title-click" href="../classified/'
							.$results->post_id.'">'.$results->post_title.'</a>
							</div>
					</div></li>';

		}
		return $gethtml;
	}

	

	public function createCategoryPostObject($id,$collegeNameSlug, $post_status,$postOrder,$post_field,$adType,$itemCondition,$limit)
	{
		$arr=$this->_loadCategoryPosts($id,$collegeNameSlug,$post_status,$postOrder,$post_field, $adType, $itemCondition, $adlimit=NULL);

		
		
		$html=NULL;
		
		if(empty($arr)){

				$html =' <div class="row">
							<div class="col-md-12 text-center margin-top-16">
						<h2>Oops!!! There is no post in your selected category.</h2>
						</div>
						</div>';
			}else
			{

		foreach($arr as $post)
		{ 

			$results= new Post($post);
			$imageData=$this->_loadImages($results->post_id, 'classified', $limit);

  			$link ='<div class="panel panel-head panel-default">';
			$link.='<div class="panel-heading">';
			$link.='<h1 class="panel-title"> <a class="panel-title-click" href="../classified/'
			.$results->post_id.'">'.$results->post_title.'</a></h1></div>';
			$link .='<div class="panel-body padding-top-bottom-0">';

			$link .="<div class='row'>";
			$link .='<div class="col-xs-2">';
			
			foreach($imageData as $result)
			{

				$image= new Images($result);
				$link.='<img src="'.$image->imageUrl.'" class="img-responsive" alt="'.$results->post_title.'" style=" width: 130px !important;
    height: 114px;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: 50% 50%;
   ">';
			}

			$link .="</div><div class='col-xs-10'>";
			
			$link .='<div class="row">';
			$link .="<div class='col-xs-12 margin-top-16'>";
			$link .=$results->post_excerpt;
			$link .="</div>";
			$link .="</div>";

			$link .="<div class='row margin-top-16 margin-right-16 margin-bottom-0'>";
			$link .="<div class='col-xs-6 odd'>";
			$link .='<i class="fa fa-university"></i>  ';
			$link .= $results->collegeName;
			$link .="</div>";
			$link .="<div class='col-xs-3 even text-center'>";

			$link .='<i class="fa fa-clock-o"></i>  ';
			$link .= $this->timeStamp($results->post_date);
			$link .="</div>";
			$link .="<div class='col-xs-3 odd font-24 text-right'>";
			$link .="<i class='fa fa-inr'></i> ";
			$link .= $results->price."/-";
			$link .="</div>";

			$link .="</div>";
			$link .="</div>";
			
			
			
			
			$link .="</div></div></div>";

			
			$html .="\n\n\t$link";
		}

		$html .=' <div class="row">
							<div class="col-md-12 text-center margin-top-16">
						<h6>There is no more post in your selected category.</h6>
						</div>
						</div>';

	}
		

		return $html ;

	}

	public function _loadPostData($id=NULL, $post_status=NULL)
	{

		/*
		 * Make sure an ID was passed
		 */
		if(empty($id))
		{
			return NULL;
		}

		/*
		* Make sure the ID is an integer
		*/
		$id = preg_replace('/[^0-9]/', '', $id);

		$sql="SELECT ID, post_title, post_excerpt, post_content, post_author, post_date, post_status, price, state_name, college_name
			FROM wp_posts WHERE ID=$id ";
			if(!empty($post_status))
			{
				$sql.="AND post_status='$post_status' ";
			}

		try
		{
			$stmt=$this->db->prepare($sql);
			$stmt->execute();
			$results=$stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt->closeCursor();

			
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
		
		return $results;
	}

	/* Get images for profile, classfied and classified listing 
	 * 
	 * @param object_id: ID of the post or ID of the user 
	 * 
	 * @return array() of images for classified or profile image or classified image
	 *
	 */

	public function _loadImages($id, $image_field, $limit)
	{

		$sql="SELECT image_path, object_id, image_order FROM wp_images ";
		
		if(!empty($id))
		{
			$sql.="WHERE object_id= $id ";
		}

		if(($id AND $image_field)==TRUE)
		{
			$sql.="AND image_field='$image_field'";
		}
		elseif(!empty($image_field))
		{
			$sql.="WHERE image_field='$image_field'";
		}

		if(!empty($limit))
		{
			$sql.="LIMIT $limit";
		}


		try
		{
			$stmt=$this->db->prepare($sql);
			$stmt->execute();
			$results=$stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt->closeCursor();
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
		return $results;
	}

	/* 
	 * This function displays the html of 
	 * individual classified post and them visible as per their visibility
	 *
	 */
	public function createPostObject($id,$postStatus,$limit)
	{
		$arr=$this->_loadPostData($id,$postStatus);
		
		
		$html=NULL;
		
		if(!isset($arr)){

				$html ="There is no result in this category.";
			}else
			{

		foreach($arr as $post)
		{ 

			$results= new Post($post);
			$imageData=$this->_loadImages($results->post_id, 'classified', $limit);

			
			
			$link ='<div class="row light-box-shadow">
						<div class="col-md-12 background-white rounded-corner">
							<div class="row">
								<div class="col-md-12">
									<h2><a href="../classified/'.$results->post_id.'">'.$results->post_title.'</a></h2>
								</div>
							</div>
							<div class="row border-top-bottom light-box-shadow">
								<div class="col-md-12">
									<div class="row classifiedFooter">
										<div class="col-md-fluid item border-right-0">
											<a><i class="fa fa-map-marker"></i> '.$results->stateName.'</a>
										</div>
										<div class="item col-md-fluid item border-right-0">
											<i class="fa fa-angle-right fa-lg"></i>
										</div>
										<div class="item col-md-fluid">
											<a href="#"><i class="fa fa-university"></i>'.$results->collegeName.'</a>
										</div>

										<div class="col-md-fluid item">
											<a><i class="fa fa-clock-o"></i> '.$this->timeStamp($results->post_date).'</a>
										</div>

										<div class="col-md-4 text-right pull-right social">
											Share <a id="ref_fb" href="http://www.facebook.com/sharer.php?s=100&amp;p[title]='.$results->post_title.'&amp;p[summary]='.$results->post_content.'&amp;p[url]=http://www.dtuhub.com/classified/'.$results->post_id.'&amp;
p[images][0]='.$imageData[0]["image_path"].'" onclick="javascript:window.open(this.href, "","menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600"); 
return false;"><i class="fa fa-facebook"></i></a><a id="ref_tw" href="http://twitter.com/home?status='.$results->post_title.'+http://www.dtuhub.com/classified/'.$results->post_id.'"  onclick="javascript:window.open(this.href, "", "menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600");return true;"><i class="fa fa-twitter"></i></a><a id="ref_gp" href="https://plus.google.com/share?url=http://www.dtuhub.com/classified/'.$results->post_id.'"
onclick="javascript:window.open(this.href, "", "menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600");return true"><i class="fa fa-google-plus"></i></a><a href="#"><i class="fa fa-envelope-o"></i></a>

										</div>
										

										
									</div>
								</div>
							</div>

							<div class="row contact-form margin-top-0">
								<div class="col-md-10 col-md-offset-1 text-center margin-top-16">
								<!-- carouser slider bootstrap [BEGIN] -->
									

									<ul id="demo1">';
									  	foreach($imageData as $result)
										{

											$image= new Images($result);
											$link.='<li><a href="#'.$image->imageOrder.'"><img src="'.$image->imageUrl.'" width="700"
											 height="360" alt="'.$results->post_title.'"></a></li>';

									
										
										}
									$link .='</ul>

									<!-- carouser slider bootstrap [END] -->
								</div>


							</div>

							<div class="row padding-15">
									<div class="col-md-12">
									<h3 class=" border-bottom">Description</h3>
										'.nl2br($results->post_content).'
				
									</div>
								</div>
						</div>';
				  					
	  					
	  					

    	
			
 			$link .='</div>';

			
			
			
			$html .="\n\n\t$link";
		}

	}
		return $html ;
		
	}

	public function displayRegisterForm()
	{

		$gethtml=NULL;

		try
		{
			$gethtml='
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-12">
							<div class="page-header">
							 	<h2> New to DTUhub? Sign up</h2>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 border-bottom">
							<form role="form" class="userRegisterForm" action="../assets/inc/process.inc.php" method="POST">

								<div class="form-group">
								    <label for="fullName">Full name</label>
								    <input type="text" class="form-control" required="required" id="fullName" name="fullName" placeholder="Enter your full name">
								</div>

						  		<div class="form-group">
							    	<label for="email">Email address</label>
							    	<input type="email" class="form-control" required="required" id="email" name="email" placeholder="Enter your email">
							  	</div>
								<div class="form-group">
								    <label for="password">Password</label>
								    <input type="password" class="form-control" required="required" id="password" name="password" placeholder="Password">
								</div>
								
								  
								
								<input type="hidden" name="token" value="'.$_SESSION['token'].'" />
								<input type="hidden" name="action" value="user_register" />
								<div class="row registerForm">
									<div class="col-md-7 text-right pull-right">
						  				<button type="submit" name="register_submit" id="formRegister" class="btn btn-default btn-block">Sign up</button>
										or <a href="./"> cancel</a>

						  			</div>
						  		</div>
				  			</form>
						</div>
					</div>
				</div>					
			</div>';
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}

	
	return $gethtml;
	}


	public function displayLoginForm(){

		$gethtml=NULL;

		$gethtml='
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-12">
					<div class="page-header">
					 	<h1> Please Log In</h1>
					</div>
				</div>
			</div>
			<div class="row">

				<div class="col-md-12 border-bottom">
					<form role="form" class="loginForm" action="../assets/inc/process.inc.php" method="post">

				  		<div class="form-group">
					    	<label for="userEmail">Email address</label>
					    	<input type="email" class="form-control" id="userEmail" required="required" name="userEmail" placeholder="Enter your email">
					  	</div>
						<div class="form-group">
						    <label for="userPassword">Password</label>
						    <input type="password" class="form-control" id="userPassword" required="required" name="userPassword" placeholder="Password">
						</div>

						<div class="row">
							<div class="col-md-5 col-xs-4">
								<div class="checkbox">
    								<label>
      									<input type="checkbox"> Remember me
    								</label>
  								</div>
							</div>
							<div class="col-md-5 col-xs-6 col-xs-offset-2 text-right">
								<div class="checkbox">
								<a href="reset.php">Forgot password</a>
								</div>
							</div>
						</div>
						
						<input type="hidden" name="token" value="'.$_SESSION['token'].'" />
						<input type="hidden" name="action" value="user_login" />
						<div class="row">
							<div class="col-md-6 col-md-offset-6">
				  				<button type="submit" name="login_submit" class="btn btn-default btn-block">Sign in</button>
				  				or <a href="./" class="cancel"> cancel</a>
				  			</div>
				  		</div>
					</form>
				</div>

			</div>
		</div>
	</div>
				';

				return $gethtml;
	}
	
	

	/* 
	 * Generates a form to edit or creates classified and events
	 *
	 * @return string the HTML markup for the editing form
	 */

	public function displayForm($emailId=NULL, $mobileNumber=NULL)
	{

		
		/*
		* Check if an ID was passed
		*/
		if (isset($_POST['post_edit']) )
		{
			$post_id = (int) $_POST['post_id'];
			
			// Force integer type to sanitize data
		}
		else
		{
			$post_id = NULL;
		}

		
		$arr=$this->_loadCategoryData(0);
		$state=$this->_loadStateData();
		
		if(!empty($post_id))
		{
			$formField=$this->_loadPostData($post_id,null);
			
			
		}else
		{
			$formField= NULL;
			$data=NULL;
		}
		/* 
		 * Build the markup
		 */ 
			
			
		
		$gethtml = '<div class="row">
				<div class="col-xs-12">
					<h2 class="page-header">Post a Free Classified Ad: 
					
					<small class="right-align">* Mandatory fields</small>
					</h2>
					
				</div>
			</div>
			<form role="form" class="form-horizontal adPostingForm" novalidate method="POST" action="../assets/inc/process.inc.php" enctype="multipart/form-data">
				
				<!-- Category of the item -->
				<div class="form-group">
					<label for="category" class="col-sm-2 control-label">Choose a category<super>*</super></label>
					<div class="col-sm-2">
						<select class="form-control category" name="category">
						<option value=" "> Select a Category </option>';

							
							foreach ($arr as  $value)
							{			
								$result=new category($value);
								
								$gethtml.= "<option value='".$result->categoryTaxonomyId."'>".$result->categoryName."</option>";
								$id=$result->categoryTaxonomyId;
								
							}

						$gethtml.='</select>
					</div>
					<div class="col-sm-3">
						<select class="form-control subCategory" name="subCategory">
								<option name=" ">Select a Subcategory </option>';
								
							
						$gethtml.='</select>
					</div>
					
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label">Ad Type<super>*</super></label>
					<div class="col-sm-6">

						<label class="radio-inline">
							<input type="radio" name="adType" id="adType1" value="sell">I want to sell
						</label>

						<label class="radio-inline">
							<input type="radio" name="adType" id="adType1" value="buy">I want to buy
						</label>

						

					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label">Item Condition<super>*</super></label>
					<div class="col-sm-6">
						<label class="radio-inline">
							<input type="radio" name="itemCondition" id="itemCondition1" value="old">It has been Used
						</label>

						<label class="radio-inline">
							<input type="radio" name="itemCondition" id="itemCondition2" value="new">It is New
						</label>

					</div>
				</div>

				<div class="form-group">
					<label for="title" class="col-sm-2 control-label">Photos </label>
					<div class="col-sm-5">
						<input type="file" name="files[]" id="input-id" accept="image/*" capture="camera" multiple/>
					</div>
				</div>

				


				<!-- title of the item -->
				<div class="form-group">
					<label for="title" class="col-sm-2 control-label">Ad title<super>*</super></label>
					<div class="col-sm-5">
					 	<input type="text" required="required" name="post_title" value="'.$formField[0]['post_title'].'" class="form-control" 
					 	id="title" placeholder="Enter a catchy title">
					</div>
				</div>

				<!-- description of the item -->
				<div class="form-group">
					<label for="description" class="col-sm-2 control-label">
					Write a good description<super>*</super> </label>
					<div class="col-sm-5">
						<textarea required="required" class="form-control" name="post_description" rows="4"
						 id="description">'.$formField[0]['post_content'].'</textarea>
					</div>
				</div>

				<!-- Price of the item -->
				<div class="form-group">
					<label class="col-sm-2 control-label">Selling Price<super>*</super></label>
					<div class="col-sm-6">
						<label class="radio-inline">
							<input type="radio" name="priceType" id="price1" value="Negotiable">Negotiable
						</label>
					
						<label class="radio-inline">
							<input type="radio" name="priceType" id="price2" value="Fixed Price">Fixed Price
						</label>
					
						<label class="radio-inline">
							<input type="radio" name="priceType" id="price3" value="Ask for price">Ask for price
						</label>

						<label class="radio-inline">
							<input type="radio" name="priceType" id="price3" value="Donate/free">Donate / Free
						</label>

					</div>
				</div>

				<!-- PriceTextBox of the item -->
				<div class="form-group">
					<label for="priceTextBox" class="col-sm-2 control-label"></label>
					<div class="col-sm-5">
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-inr"></i>
							</div>
							<input type="text" name="post_price" value="'.$formField[0]['price'].'" class="form-control"
							 id="priceTextBox" placeholder="Amount in rupee" />
						</div>
						
					</div>
				</div>
				
				<!-- User Details section begins -->
				<h2 class="page-header">Seller Information:<super>*</super> </h2>

				<!-- User email of the item -->
				<div class="form-group">
					<label for="sellerEmail" class="col-sm-2 control-label">Your Email id<super>*</super> </label>
					<div class="col-sm-5">
						<input type="text" required="required" name="sellerEmail" class="form-control" value="'.$emailId.'"
						 id="sellerEmail" placeholder="user@dtuhub.com">
					</div>
				</div>

				<div class="form-group">
					<label for="sellerName" class="col-sm-2 control-label">Your Name<super>*</super> </label>
					<div class="col-sm-5">
						<input type="text" required="required" name="sellerName" class="form-control" id="sellerName">
					</div>
				</div>
				
				<div class="form-group">
					<label for="sellerNumber" class="col-sm-2 control-label">Contact Number<super>*</super></label>
					<div class="col-sm-5">
						<input type="text" required="required" name="sellerNumber" class="form-control" id="sellerNumber" value="'.$mobileNumber.'"
						 placeholder="88-8888-8888">
					</div>
				</div>

				<!-- Category of the item -->
				<div class="form-group">
					<label for="sellerState" class="col-sm-2 control-label">State<super>*</super></label>
					<div class="col-sm-3">
						<select class="form-control sellerState" id="sellerState" name="sellerState">
						<option value=" "> Select a state</option>';
							
							foreach ($state as  $value)
							{			
								$result=new state($value);
								
								$gethtml.= "<option value='".$result->stateName."'>".$result->stateName."</option>";
													
							}

						$gethtml .='</select>
					</div>
				</div>
				<div class="form-group">
					<label for="sellerUniversity" class="col-sm-2 control-label">University<super>*</super></label>
					<div class="col-sm-3">
						<select class="form-control sellerUniversity" name="sellerUniversity" id="sellerUniversity">
								<option value="0">Select a university</option>

								</select>
					</div>
				</div>
				<div class="form-group">
					<label for="sellerCollege" class="col-sm-2 control-label">Institute<super>*</super></label>
					<div class="col-sm-3">
						<select class="form-control sellerCollege" name="sellerCollege" id="sellerCollege">
								<option value="0">Select an Institute</option>
								
							
						</select>
					</div>
				</div>
				<input type="hidden" name="token" value="'.$_SESSION['token'].'" />
				<input type="hidden" name="ip" value="'.$_SERVER['REMOTE_ADDR'].'" />
				<input type="hidden" name="action" value="post_edit" />
				<input type="hidden" name="post_id" value="'.$post_id.'" />
				<div class="form-group">
					<label class="col-sm-2"></label>
					<div class="col-sm-3">
						<button type="submit" class="btn btn-warning btn-block">Post it</button>
					</div>
				</div>
			</form>';
			return $gethtml;
	}

	/**
	 * Validates the form and saves/edits the event
	 * 
	 * @return mixed TRUE on success, an error message on failure
	 */

	public function processForm($user_id=NULL)
	{
		/*
		 * Exit if the action isn't set properly
		 */

		if( $_POST['action']!='post_edit')
		{
			return " You have reached here using unspecified way.
			 Kindly refill the form and process again.";
		}

		/*
		 * Escape data from the form
		 */

		$categoryId=htmlentities($_POST['category'], ENT_QUOTES);
		$subCategoryId=htmlentities($_POST['subCategory'], ENT_QUOTES);
		$post_title=htmlentities($_POST['post_title'],ENT_QUOTES);
		$post_content=htmlentities($_POST['post_description'], ENT_QUOTES);
		$postExcerpt=mb_substr($post_content, 0, 120) . " [...]";
		$price=htmlentities($_POST['post_price'],ENT_QUOTES);
		$priceType=htmlentities($_POST['priceType'], ENT_QUOTES);
		$adType=htmlentities($_POST['adType'], ENT_QUOTES);
		$itemCondition=htmlentities($_POST['itemCondition'], ENT_QUOTES);
		$post_date=date("Y-m-d H:i:s");
		$post_date_gmt=date("Y-m-d H:i:s");
		$post_modified=date("Y-m-d H:i:s");
		$post_modified_gmt=date("Y-m-d H:i:s");
		$post_status="pending";
		$post_type="classified";
		$ip=htmlentities($_POST['ip'], ENT_QUOTES);

		/*
		 * User Details 
		 */
		$sellerName=htmlentities($_POST['sellerName'], ENT_QUOTES);
		$sellerEmail=htmlentities($_POST['sellerEmail'], ENT_QUOTES);
		$sellerNumber=htmlentities($_POST['sellerNumber'], ENT_QUOTES);
		$sellerState=htmlentities($_POST['sellerState'], ENT_QUOTES);
		$sellerUniversity=htmlentities($_POST['sellerUniversity'], ENT_QUOTES);
		$sellerCollege=htmlentities($_POST['sellerCollege'], ENT_QUOTES);
		$sellerStatus=TRUE;



		

		/* 
		 * Execute the create of edit query after binding the data
		 */
		
		try
		{	
			$stmt4=$this->db->prepare("SELECT ID, user_status FROM wp_users WHERE user_email=:userEmail LIMIT 1");
			$stmt4->bindParam(':userEmail',$sellerEmail, PDO::PARAM_STR);
			
			$stmt4->execute();
			$ref2=$stmt4->fetchAll();
			$user2=array_shift($ref2);
			$stmt4->closeCursor();

			

			
			if(isset($user2))
			{

				$userData= $this->db->prepare("UPDATE wp_users 
					SET user_login= :sellerName, 
					user_mobile=:sellerNumber,
					user_updated=:post_date,
					user_status=:sellerStatus,
					post_count= post_count+1
					WHERE user_email=:sellerEmail");
				$userData->bindParam(":sellerName", $sellerName, PDO::PARAM_STR);
				$userData->bindParam(":sellerNumber", $sellerNumber, PDO::PARAM_INT);
				$userData->bindParam(":post_date", $post_date, PDO::PARAM_STR);
				$userData->bindParam(":sellerStatus", $user2['user_status'], PDO::PARAM_STR);
				$userData->bindParam(":sellerEmail", $sellerEmail, PDO::PARAM_STR);
				$userData->execute();
				$userData->closeCursor();
				$postAuthorId= $user2['ID'];
			}
			else
			{

				/* Command to insert seller information in wp_users table and get and insertId */
				$userDetails= $this->db->prepare("INSERT INTO wp_users 
			(user_login, user_email, user_mobile, user_registered, user_status)
			VALUES(:sellerName, :sellerEmail, :sellerNumber, :post_date, :sellerStatus)");
				$userDetails->bindParam(":sellerName", $sellerName, PDO::PARAM_STR);
				$userDetails->bindParam(":sellerEmail", $sellerEmail, PDO::PARAM_STR);
				$userDetails->bindParam(":sellerNumber", $sellerNumber, PDO::PARAM_STR);
				$userDetails->bindParam(":post_date", $post_date, PDO::PARAM_STR);
				$userDetails->bindParam(":sellerStatus", $sellerStatus, PDO::PARAM_STR);
				$userDetails->execute();
				$userDetails->closeCursor();

				$postAuthorId= $this->db->lastInsertId('ID');
				
				
		
			}

		

			/*
			 * Check if an id is SET and open an update form else ( if post id is not set) insert the information in wp_posts
			 *
			 * Update the post details if a user 
			 * Edit a exising post and send a request to publish it, either it is publish or not. 
			 */
			if (empty($_POST['post_id']))
			{

				$stmt= $this->db->prepare("INSERT INTO wp_posts 
				(post_author, post_title, post_content, post_excerpt, price, price_type, ad_type, item_condition, post_date, post_date_gmt,
				 post_status, post_modified, post_type, state_name, university_id, college_name, post_modified_gmt)
				VALUES(:postAuthorId, :post_title, :post_content, :postExcerpt,
				 :price, :priceType,:adType, :itemCondition, :post_date, :post_date_gmt, :post_status, :post_modified, :post_type, :stateId,
				  :universityId, :collegeId, :post_modified_gmt)");
				$stmt->bindParam(":post_title", $post_title, PDO::PARAM_STR);
				$stmt->bindParam(":post_content", $post_content, PDO::PARAM_STR);
				$stmt->bindParam(":postExcerpt", $postExcerpt, PDO::PARAM_STR);
				$stmt->bindParam(":price", $price, PDO::PARAM_STR);
				$stmt->bindParam(":priceType", $priceType, PDO::PARAM_STR);
				$stmt->bindParam(":adType", $adType, PDO::PARAM_STR);
				$stmt->bindParam(":itemCondition", $itemCondition, PDO::PARAM_STR);
				
				$stmt->bindParam(":post_date", $post_date, PDO::PARAM_STR);
				$stmt->bindParam(":post_date_gmt", $post_date_gmt, PDO::PARAM_STR);
				$stmt->bindParam(":post_status", $post_status, PDO::PARAM_STR);
				$stmt->bindParam(":post_modified", $post_modified, PDO::PARAM_STR);
				
				$stmt->bindParam(":post_type", $post_type, PDO::PARAM_STR);
				
				$stmt->bindParam(":post_modified_gmt", $post_modified_gmt, PDO::PARAM_STR);			
				$stmt->bindParam(":stateId", $sellerState, PDO::PARAM_STR);
				$stmt->bindParam(":universityId", $sellerUniversity, PDO::PARAM_STR);
				$stmt->bindParam(":collegeId", $sellerCollege, PDO::PARAM_STR);
				$stmt->bindParam(":postAuthorId", $postAuthorId, PDO::PARAM_STR);
				$stmt->execute();
				$stmt->closeCursor();

				$postId= $this->db->lastInsertId('ID');
		
				$getCollegeId=$this->db->prepare("SELECT ID, college_name FROM wp_college WHERE college_name_slug=:collegeId");
				$getCollegeId->bindParam(":collegeId", $sellerCollege, PDO::PARAM_STR);
				$getCollegeId->execute();
				$college=$getCollegeId->fetchAll();
				$getCollegeId->closeCursor();

				$categoryRelationship= $this->db->prepare("INSERT INTO wp_term_relationships
					(object_id, term_taxonomy_id, college_id, relationship_status) VALUES(:postId, :categoryId, :collegeID, :relationshipStatus)");
				$categoryRelationship->bindParam(":postId", $postId, PDO::PARAM_STR);
				$categoryRelationship->bindParam(":categoryId", $categoryId, PDO::PARAM_STR);
				$categoryRelationship->bindParam(":collegeID", $college[0]['ID'], PDO::PARAM_STR);
				$categoryRelationship->bindParam(":relationshipStatus", $post_status, PDO::PARAM_STR);
				$categoryRelationship->execute();
				$categoryRelationship->closeCursor();

				
				

				$subCategoryRelationship= $this->db->prepare("INSERT INTO wp_term_relationships
					(object_id, term_taxonomy_id, college_id, relationship_status) VALUES(:postId, :subCategoryId, :collegeID, :relationshipStatus)");
				$subCategoryRelationship->bindParam(":postId", $postId, PDO::PARAM_STR);
				$subCategoryRelationship->bindParam(":subCategoryId", $subCategoryId, PDO::PARAM_STR);
				$subCategoryRelationship->bindParam(":collegeID", $college[0]['ID'], PDO::PARAM_STR);
				$subCategoryRelationship->bindParam(":relationshipStatus", $post_status, PDO::PARAM_STR);
				$subCategoryRelationship->execute();
				$subCategoryRelationship->closeCursor();
				

				/* Images upload and database updation 
				 * 
				 */

				if(isset($_FILES['files']))
				{
				    $errors= array();
					foreach($_FILES['files']['tmp_name'] as $key => $tmp_name )
					{
							
							$RandomNum = rand(0, 100);

							 $ImageName = str_replace(' ','_',strtolower($_FILES['files']['name'][$key]));
							 $ImageType = $_FILES['files']['type'][$key]; //"image/png", image/jpeg etc.

							 $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
							 $ImageExt = str_replace('.','',$ImageExt);

							 $ImageName = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);

							 //Create new image name (with random number added).
							 $file_name = $ImageName.'_'.$RandomNum.'.'.$ImageExt;


							$file_size =$_FILES['files']['size'][$key];
							$file_tmp =$_FILES['files']['tmp_name'][$key];
							$file_type=$_FILES['files']['type'][$key];
							$file_error=$_FILES['files']['error'][$key];
							$file_field="classified";
							$base_path="http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);

							
                            $file_path=$base_path.'/'.'upload/'.$file_name;

							$post_date=date("Y-m-d H:i:s");
					        if($file_size > 4194304){
								$errors[]='File size must be less than 2 MB';
					        }		
					        
					        $desired_dir='../../assets/inc/upload';


					        if(empty($errors)==true)
					        {
					            if(is_dir($desired_dir)==false)
					            {
					                mkdir("$desired_dir", 0700);		// Create directory if it does not exist
					            }
					            if(is_dir("$desired_dir/".$file_name)==false)
					            {
					                move_uploaded_file($file_tmp,"$desired_dir/".$file_name);
					            }
					            else
					            {									// rename the file if another one exist
					                $new_dir="$desired_dir/".$file_name.time();
					                 rename($file_tmp,$new_dir) ;				
					            }
					            # Make sure that the query is not executed unless the $errors array is empty.
								/* Command to insert seller information in wp_users table and get and insertId */
								$userDetails= $this->db->prepare("INSERT INTO wp_images (`image_name`,`image_alt`,`image_path`,`image_order`,
					        	`image_type`, `image_size`, `error_code`,`image_field`, `object_id`, `image_added`, `image_modified`)
					        	 VALUES(:file_name,:file_alt,:file_path, :key, :file_type, :file_size, :file_error,:file_field, :postId, 
					        	 	:post_date, :date_modify)");
									$userDetails->bindParam(":file_name", $file_name, PDO::PARAM_STR);
									$userDetails->bindParam(":file_alt", $file_name, PDO::PARAM_STR);
									$userDetails->bindParam(":file_path", $file_path, PDO::PARAM_STR);
									$userDetails->bindParam(":file_type", $file_type, PDO::PARAM_STR);
									$userDetails->bindParam(":key", $key, PDO::PARAM_INT);
									$userDetails->bindParam(":postId", $postId, PDO::PARAM_STR);
									$userDetails->bindParam(":file_type", $file_type, PDO::PARAM_STR);
									$userDetails->bindParam(":file_size", $file_size, PDO::PARAM_STR);
									$userDetails->bindParam(":file_error", $file_error, PDO::PARAM_STR);
									$userDetails->bindParam(":file_field", $file_field, PDO::PARAM_STR);
									$userDetails->bindParam(":post_date", $post_date, PDO::PARAM_STR);
									$userDetails->bindParam(":date_modify", $post_date, PDO::PARAM_STR);
									$userDetails->execute();
									$userDetails->closeCursor();


			        		}
					        else
					        {
					            print_r($errors);
					        }
					        if(empty($error))
					        {        		
			        		$error=FALSE;
			    			}
	    			}
    			}
                
                
                $mail = new PHPMailer();

        		$mail->IsSMTP();
                $mail->SMTPDebug = 1;
				$mail->SMTPAuth = false;
                //$mail->SMTPSecure = 'ssl';
                $mail->Port = 25;
              	$mail->Host = 'relay-hosting.secureserver.net'; // "ssl://smtp.gmail.com" didn't worked
				
				
				// or try these settings (worked on XAMPP and WAMP):
				//$mail->Port = 587;
				//$mail->SMTPSecure = 'tls';
                
                $mail->Username = "admin@dtuhub.com";
				//$mail->Password = "Hari@134";


				$mail->IsHTML(true); // if you are going to send HTML formatted emails
				$mail->SingleTo = true; // if you want to send a same email to multiple users. multiple emails will be sent one-by-one.

				$mail->From = "admin@dtuhub.com";
				$mail->FromName = "admin";
				$mail->AddReplyTo("dtuhub@gmail.com","Admin");

				$mail->addAddress($sellerEmail,$sellerName);

               
				$mail->addBCC("shekhardtu@gmail.com","Someone posted an ad");
				
    
				$mail->Subject = "Congratulation! Your ad has been successfully submitted for review - DTUhub";
				$mail->Body= $this->emailBody($salutation='Hi '.$sellerName, $subject='Thank you for using DTUhub',  $title=NULL, 
                $welcomeBar='Your ad has been successfully submitted. It will be displayed on DTUhub within 4 to 8 hours. ',
				$comment=NULL, $mailContent='Our team will review your ad and send you an email notification as soon as it will be activated. 
                  Till than you can make it better or post more and more ads.',
	 $senderEmail=NULL, $senderNumber=NULL,$helpbar='We are here to help you! Contact us anytime.',$receipientEmail=$sellerEmail);
              
				if(!$mail->Send())
				   {
                       $mail->ErrorInfo;
			 
				   }
                   else
                   {
                
                        $_SESSION['guest']['edit']=time();
                        $_SESSION['guest']['url']='http://www.dtuhub.com/posting_preview.php?id='.$postId;
            			return true;
                 
                   }

				
			}
			else
			{

				/*
				* Cast the event ID as an integer for security
				*/
				$postId = (int) $_POST['post_id'];
				$stmt= $this->db->prepare("UPDATE wp_posts
				SET
				post_title=:post_title,
				post_content=:post_content,
				post_excerpt=:postExcerpt,
				post_modified=:post_modified,
				price=:price,
				post_type=:post_type,
				ad_type=:adType,
				item_condition=:itemCondition,
				post_status=:post_status,
				state_name=:sellerState,
				university_id=:sellerUniversity,
				college_name=:sellerCollege
				WHERE ID='$postId'");
				$stmt->bindParam(":post_title", $post_title, PDO::PARAM_STR);
				$stmt->bindParam(":post_content", $post_content, PDO::PARAM_STR);
				$stmt->bindParam(":postExcerpt", $postExcerpt, PDO::PARAM_STR);
				$stmt->bindParam(":post_modified", $post_modified, PDO::PARAM_STR);
				$stmt->bindParam(":price", $price, PDO::PARAM_STR);
				$stmt->bindParam(":post_type", $post_type, PDO::PARAM_STR);
				$stmt->bindParam(":adType", $adType, PDO::PARAM_STR);
				$stmt->bindParam(":itemCondition", $itemCondition, PDO::PARAM_STR);
				$stmt->bindParam(":post_status", $post_status, PDO::PARAM_STR);
				$stmt->bindParam(":sellerState", $sellerState, PDO::PARAM_STR);
				$stmt->bindParam(":sellerUniversity", $sellerUniversity, PDO::PARAM_STR);
				$stmt->bindParam(":sellerCollege", $sellerCollege, PDO::PARAM_STR);
				$stmt->execute();
				$stmt->closeCursor();
			
				$_SESSION['guest']['edit']=time();
				$_SESSION['guest']['url']='http://www.dtuhub.com/posting_preview.php?id='.$postId;
    			
				return true;
				
				
			}
		}
		catch( Exception $e)
		{
			return $e->getMessage();
		}

	}

	/**
	 * Confirm that a post or classified should be deleted and does so. 
	 * 
	 * upon clicking the button to delete a post or clasified, this 
	 * generate a confirmatin box. If  the user confirms, this delete the 
	 * post or classified from the database and sends the user backout to the main profile view.
	 * If the user select not delete the post or classified they are send to the main
	 * profile view without deleting anything. 
	 * @param int $id the post ID
	 * @return mixed the form if confirming, void or error if deleting. 
	 *
	 */

	public function confirmDelete()
	{
		/* 
		 * Make sure an ID was passed
		 */
		if(isset($_POST['post_id']))
		{
			
		
		
			/*
			 * Make sure the ID is integer
			 */
			$id=preg_replace('/[^0-9]/','',$_POST['post_id']);

			/* 
			 * If the confirmation form was submitted and the
			 * form has the valid token, check the form submission
			 */
			
			

			if(isset($_POST['delete']) or isset($_POST['return']) && $_POST['token'] == $_SESSION['token'])
			{
				/*
				 * If the deletion is confirm, remove the event 
				 * from the database
				 */

				if(isset($_POST['delete']))
				{
					
					try
					{
						$stmt=$this->db->prepare("UPDATE wp_posts SET post_status='removed'
							WHERE ID=:id LIMIT 1");
						$stmt->bindParam(":id",$id, PDO::PARAM_INT);
						$stmt->execute();
						$stmt->closeCursor();

						$selectTermId=$this->db->prepare("SELECT term_taxonomy_id FROM wp_term_relationships
							WHERE object_id=:id LIMIT 2");
						$selectTermId->bindParam(":id", $id, PDO::PARAM_INT);
						$selectTermId->execute();
						$termId=$selectTermId->fetchAll();
						$selectTermId->closeCursor();


		             /* 
		             * Update Category count code
					 */
						foreach ($termId as $value)
						{
							# code...
							
								$updateCategoryCount=$this->db->prepare("UPDATE wp_term_taxonomy
									SET 
									count= count-1
									WHERE term_taxonomy_id=".$value[0]);
								
								
								$updateCategoryCount->execute();
								$updateCategoryCount->closeCursor();
						}




						$deleteCategoryRelationship=$this->db->prepare("DELETE FROM wp_term_relationships
							WHERE object_id=:id LIMIT 2");
						$deleteCategoryRelationship->bindParam(":id", $id, PDO::PARAM_INT);
						$deleteCategoryRelationship->execute();
						$deleteCategoryRelationship->closeCursor();
                        
						header('Location:profile.php');
						return true;
					}
					catch(Exception $e)
					{
						return $e->getMessage();
					}


				}

				/* 
				 * If the confirmation form has not been submitted, display it
				 *
				 */
				elseif(isset($_POST['return']))
				{
					header("Location: profile.php");
					return;

				}
			}

			$post= $this->_loadPostData($id, $_POST['post_status']);

			/* 
			 * If no object is returned, return to profile view
			 */
			

			$html='
			<form action="../delete.php" method="POST">
				<div class="row margin-bottom-10 padding-15">
					<div class="col-md-6 col-md-offset-3 border rounded-corner padding-15  background-white">
						<h4 class="border-bottom">
						<span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete '.$post[0]['post_title'].' ?
						</h4>
						<p class="padding-top-15"> There is <strong> no undo </strong> if you continue. </p>
						<div class="row">
							<div class="col-md-4">
								<button type="submit" name="delete"  class="btn btn-danger btn-block"><span class="glyphicon glyphicon-trash"></span> 
								 Yes, Delete it</button>
							</div>
							<div class="col-md-4 col-md-offset-4">
								<button type="submit" name="return" class="btn btn-default btn-block"><span 
								class="glyphicon glyphicon-exclamation-sign"></span>  Nope! Just Kidding! </button>
							</div>
								<input type="hidden" name="post_id" value="'.$post[0]['ID'].'"/>
								<input type="hidden" name="token" value="'.$_SESSION["token"].'" />
							</div>
						</div>
					</div>
				</div>
			</form>';

		}
		elseif(isset($_POST['comment_id']))
		{
			/*
			 * Make sure the ID is integer
			 */
			$id=preg_replace('/[^0-9]/','',$_POST['comment_id']);

			/* 
			 * If the confirmation form was submitted and the
			 * form has the valid token, check the form submission
			 */
			
			

			if(isset($_POST['delete']) or isset($_POST['return']) && $_POST['token'] == $_SESSION['token'])
			{
				/*
				 * If the deletion is confirm, remove the event 
				 * from the database
				 */

				if(isset($_POST['delete']))
				{
					
					try
					{
						$stmt=$this->db->prepare("DELETE FROM wp_comments
							WHERE comment_ID=:id LIMIT 1");
						$stmt->bindParam(":id",$id, PDO::PARAM_INT);
						$stmt->execute();
						$stmt->closeCursor();


						
						header("Location: profile.php");
						return;
					}
					catch(Exception $e)
					{
						return $e->getMessage();
					}


				}

				/* 
				 * If the confirmation form has not been submitted, display it
				 *
				 */
				elseif(isset($_POST['return']))
				{
					header("Location: profile.php");
					return;

				}
			}
			$data = new Admin;
			$arr = $data->_getSellerMessages();

			

			/* 
			 * If no object is returned, return to profile view
			 */
			

			$html='
			<form action="delete.php" method="POST">
				<div class="row margin-bottom-10 padding-15">
					<div class="col-md-6 col-md-offset-3 border rounded-corner padding-15  background-white">
						<h4 class="border-bottom">
						<span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete " '.$arr[0]['comment_content'].' "?
						</h4>
						<p class="padding-top-15"> There is <strong> no undo </strong> if you continue. </p>
						<div class="row">
							<div class="col-md-4">
								<button type="submit" name="delete"  class="btn btn-danger btn-block"><span 
								class="glyphicon glyphicon-trash"></span>  Yes, Delete it</button>
							</div>
							<div class="col-md-4 col-md-offset-4">
								<button type="submit" name="return" class="btn btn-default btn-block"><span class="glyphicon
								 glyphicon-exclamation-sign"></span>  Nope! Just Kidding! </button>
							</div>
								<input type="hidden" name="comment_id" value="'.$arr[0]['comment_ID'].'"/>
								<input type="hidden" name="token" value="'.$_SESSION["token"].'" />
							</div>
						</div>
					</div>
				</div>
			</form>';

		}
		else
		{	
			header("Location:index.php");
			return NULL;
		}
			
		

		return $html;
		}
	

	/**
	 * Generates markup to display administrative links
	 * 
	 * @return string markup to display the administrative links
	 */
	private function _postAnAdOptions()
	{
		/* 
		 * Display admin controls
		 */

		return <<<ADMIN_OPTIONS
		<a href="../posting.php" class="btn-blue btn-3a btn-block postAnAd" role="button">
            <i class="fa fa-plus"></i> Post an Ad
        </a>
        	
ADMIN_OPTIONS;
        	}    


	public function postAnAdOptions()
	{
		$adlink=$this->_postAnAdOptions();
		return $adlink;
	}
  
    /**
	 * Generates markup to display administrative links
	 * 
	 * @return string markup to display the administrative links
	 */
	private function _postGeneralOptions()
	{

		/* 
		 * Display admin controls
		 */

		/* 
		 * If the user is logged in, display admin controls 
		 */

		if( isset($_SESSION['user']))
		{
			return <<<ADMIN_OPTIONS
		
		<a href="../profile.php"> Account </a> |

        <form action="../assets/inc/process.inc.php" method="post" style="border:0; background-color:#fff; padding:0; display:inline;" >
        
	        	 <input type="submit" value="Log Out" style="border:0; background-color:#fff; padding:0; display:inline;" />
	        	 <input type="hidden" name="token" value="$_SESSION[token]" />
	        	 <input type="hidden" name="action" value="user_logout" />
	       
       </form>
ADMIN_OPTIONS;
	}
    else
    {
    	return <<<ADMIN_OPTIONS
    		
        	<a href="../register.php" class="register"> Register </a> | <a class="login" href="../login.php">
        	Log in
        	</a>
ADMIN_OPTIONS;
        	}

    }   


	public function buildPostOptions()
	{
		/*
		 * If logged in, display the posting options
		 */
		$post= $this->_postGeneralOptions();

		return $post;
	}


public function _loadStateData($parent=NULL)
	{
		$sql="SELECT ID, state_name FROM wp_state";

		try
		{
			$stmt=$this->db->prepare($sql);
			$stmt->execute();
			$results=$stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt->closeCursor();

		}
		catch(Exception $e)
		{
			die($e->getMessage());

		}
		return $results;

	}

	public function _loadUniversityData($stateName=NULL)
	{
		$sql="SELECT ID, university FROM wp_university WHERE state_name= '$stateName'";

		try
		{
			$stmt=$this->db->prepare($sql);
			$stmt->execute();
			$results=$stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt->closeCursor();

		}
		catch(Exception $e)
		{
			die($e->getMessage());

		}
		return $results;

	}

	public function getSubCategory($id)
	{
			$arr=$this->_loadCategoryData($id);
			$gethtml=NULL;
			foreach ($arr as  $value)
								{			
									$result=new category($value);
									
									$gethtml.= "<option value='".$result->categoryTaxonomyId."'>".$result->categoryName."</option>";
									
									
								}
			return $gethtml;

	}


	public function getUniversity($stateName)
	{
			$arr=$this->_loadUniversityData($stateName);
			$gethtml=NULL;
			foreach ($arr as  $value)
								{			
									$result= new University($value);
									$gethtml.= "<option value='".$result->id."'>".$result->universityName."</option>";
											
								}
			return $gethtml;

	}

	private function _loadCollegeData($universityName=NULL)
	{
		
		
		$sql="SELECT ID, college_name, college_name_slug FROM wp_college WHERE university_id= '$universityName'";

		try
		{
			$stmt=$this->db->prepare($sql);
			$stmt->execute();
			$results=$stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt->closeCursor();

		}
		catch(Exception $e)
		{
			die($e->getMessage());

		}
		return $results;

	}

	public function getCollege($universityName)
	{
			$arr=$this->_loadCollegeData($universityName);
			$gethtml=NULL;
			foreach ($arr as  $value)
								{			
									$result= new College($value);
									$gethtml.= "<option value='".$result->collegeNameSlug."'>".$result->collegeName."</option>";
									
									
								}
			return $gethtml;

	}

	

	public function getPrice($id)
	{
		$sql= "SELECT price, post_author, price_type FROM wp_posts WHERE ID=$id LIMIT 1";

		try
		{
			$stmt= $this->db->prepare($sql);
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt->closeCursor();
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}

		return $result;
	}


	public function displayMessageForm($id)
	{	
		
		$post_id=$id;

		$author_id=$this->getSellerId($post_id);

		$gethtml='<div class="col-md-12">
					<div class="contact-form rounded-corner">
						<div class="row">
							<div class="col-md-12">
								<h2 class="padding-0 margin-bottom-10">Contact Publisher</h2>
							</div>
						</div>
						<form role="form" class="form-horizontal messageToSeller" method="post" action="assets/inc/process.inc.php"> 
							<div class="form-group">
						        <input type="buyerEmail" class="form-control" name="buyerEmail" placeholder="Enter your email id" >
						  	</div>
						  	<div class="form-group">
						       	<input class="form-control" type="text" name="buyerNumber" placeholder="Enter your contact number" maxlength="10">
						    </div>
						    <div class="form-group">
						   	    <textarea class="form-control" name="buyerMessage" rows="3"></textarea>
						   	</div>
						   	<input type="hidden" name="token" value="'.$_SESSION['token'].'" />
							<input type="hidden" name="buyerIp" value="'.$_SERVER['REMOTE_ADDR'].'" />
							<input type="hidden" name="buyerName" value="anonymous" />
							<input type="hidden" name="action" value="message_to_seller" />
							<input type="hidden" name="postId" value="'.$post_id.'"/>
							<input type="hidden" name="sellerId" value="'.$author_id[0]['post_author'].'"/>

						    <div class="form-group">
						       	<button type="submit" class="btn btn-info btn-lg btn-block">Contact</button>
						    </div>
						</form>

					</div>
					
				</div>';


				return $gethtml;
	}
	


	public function emailBody($salutation=NULL, $subject=NULL,  $title=NULL, $welcomeBar=NULL, $comment=NULL, $mailContent=NULL,
    $senderNumber=NULL, $senderEmail=NULL, $helpbar=NULL, $receipientEmail=NULL)
	{
		$gethtml='<html>
	<head>
	    </head>
	    <body>
	<div style="text-align:left;font-family:Arial,serif;background-color:#dfdfdf">

    	<table style="width:100%">

        	<tbody><tr><td align="center" style="background-color:#dfdfdf"><table align="center"
        	 style="font-family:Arial,serif;margin:0 auto;width:660px" cellspacing="0" cellpadding="0">

			<tbody><tr><td></td><td height="30"></td><td></td><td></td><td></td>

        	</tr><tr>

                <td width="30" style="width:30px" >&nbsp;</td>

                <td width="540" style="font-family:Arial,serif;width:540px;background:#F5F5F5;padding:15px 22px 5px;border-bottom:thin solid #dadada">

                	<a href="http://www.dtuhub.com" target="_blank"><img src="http://dtuhub.com/assets/img/logo.png" alt="DTUhub" width="260" height="50">

                </a></td>

				<td width="30" style="width:30px">&nbsp;</td>

            </tr>

            <tr>

            	<td style="background:#fff;padding:31px 0 41px">&nbsp;</td>

                <td style="color:#38393c;background:#fff;padding:51px 0 42px">

                	<h1 style="font-family:Arial,serif;font-weight:bold;font-size:25px">'.$salutation.', </h1>

			<p style="font-family:Arial,serif;font-size:16px;line-height:30px">'.$subject;
            if(!empty($title))
            {
            	$gethtml.='<br /> <b>'.$title.'</b><br/ >';
            }elseif(!empty($welcomeBar))
            {
            	$gethtml.='<p style="font-size:12px; width:400px;padding:5px;line-height:16px; 
            	   border:1px thin #cdcdcc; background-color:#22B2CE; color:#fff">'.$welcomeBar.' </p>';
            }

            if(!empty($comment)){
            	   $gethtml.='<p style="font-size:12px; width:400px;padding:5px;line-height:16px; 
            	   border:1px thin #cdcdcc; background-color:#22B2CE; color:#fff">'.$comment.' </p>';
            	}

            $gethtml.=$mailContent.'<br /> <br />';

            if(!empty($senderEmail))
            {
	            $gethtml.='<span style="border:1px dashed #999; padding:10px 10px;;" >Email:  <i><b> '.$senderEmail.'</b> </i> | Contact Number:
	             <i>+91 '.$senderNumber.' </i> </span> ';
	        }elseif(!empty($helpbar))
	        {
	        	$gethtml.='<span style="padding:10px 10px;;" >'.$helpbar.' </span>';
	        }

	        $gethtml.=' </p>
                </td>

                <td style="background:#fff;padding:51px 0 42px">&nbsp;</td>

            </tr>

            <tr>

                <td>&nbsp;</td>

                <td style="background:#F5F5F5;padding:14px 20px 22px;border-top:thin solid #dadada">

                	<p style="line-height:16px;margin:0;margin-bottom:-10px;font-size:14px;color:#35363a">Sincerely, <br><span class="il">
                	The DTUhub</span> Team</p>
                    <p style="line-height:10px;margin-top:20px; padding-top:10px;margin-bottom:-10px;font-size:10px;color:#35363a;
                    border-top:1px solid #999;margin-bottom: -10px;">
                    NOTE: This mail was sent to '.$receipientEmail.'. If you are not the right person for this mail, you can ignore it. </p>


                </td>

                <td>&nbsp;</td>

            </tr>

			<tr><td></td><td height="40"></td><td></td><td></td><td></td>

        </tr></tbody></table>

        	</td>

        	</tr>

        </tbody></table>



</div>

</body>
</html>

		';
		return $gethtml;
	}

	public function processMessageToSeller()
	{
		if( $_POST['action']!='message_to_seller')
		{
			return " You have reached here using unspecified way.
			 Kindly refill the form and process again.";
		}

		$buyerName=htmlentities($_POST['buyerName'], ENT_QUOTES);
		$buyerEmail=htmlentities($_POST['buyerEmail'], ENT_QUOTES);
		$buyerNumber=htmlentities($_POST['buyerNumber'], ENT_QUOTES);
		$buyerMessage=htmlentities($_POST['buyerMessage'], ENT_QUOTES);
		$buyerIp=htmlentities($_POST['buyerIp'], ENT_QUOTES);
		$sellerId=htmlentities($_POST['sellerId'], ENT_QUOTES);
		$postId=htmlentities($_POST['postId'], ENT_QUOTES);
		$commentDate= date("Y-m-d H:i:s");
		$commentDateGmt= date("Y-m-d H:i:s");
		$commentApproved= 1;
		$commentType="message";
		$commentParent="0";
		if(isset($_SESSION['user']))
		{
			$userId=$_SESSION['user']['id'];
		}
		else
		{
			$userId=0;
		}
		$commentAuthorURL= "http://";

		$seller=$this->getSellerInfo($sellerId);
		$sellerEmail=$seller[0]['user_email'];
		$sellerName=$seller[0]['user_login'];
		$sellerNumber=$seller[0]['user_mobile'];

		$sql="INSERT INTO wp_comments (comment_post_ID, comment_author, seller_ID, comment_author_email, comment_author_contact, comment_author_url,
			comment_author_IP, comment_date, comment_date_gmt, comment_content, comment_approved, comment_type, comment_parent, user_id) 
			VALUES (:postId, :buyerName, :sellerId, :buyerEmail, :buyerNumber, :commentAuthorURL, :buyerIp, :commentDate, :commentDateGmt, :buyerMessage, 
				:commentApproved, :commentType, :commentParent, :userId)";

		try
		{
			$stmt=$this->db->prepare($sql);
			$stmt->bindParam(":postId", $postId, PDO::PARAM_STR);
			$stmt->bindParam(":buyerName", $buyerName, PDO::PARAM_STR);
			$stmt->bindParam(":sellerId", $sellerId, PDO::PARAM_STR);
			$stmt->bindParam(":buyerEmail", $buyerEmail, PDO::PARAM_STR);
			$stmt->bindParam(":buyerNumber", $buyerNumber, PDO::PARAM_STR);
			$stmt->bindParam(":commentAuthorURL", $commentAuthorURL, PDO::PARAM_STR);			
			$stmt->bindParam(":buyerIp", $buyerIp, PDO::PARAM_STR);
			$stmt->bindParam(":commentDate", $commentDate, PDO::PARAM_STR);
			$stmt->bindParam(":commentDateGmt", $commentDateGmt, PDO::PARAM_STR);
			$stmt->bindParam(":buyerMessage", $buyerMessage, PDO::PARAM_STR);
			$stmt->bindParam(":commentApproved", $commentApproved, PDO::PARAM_STR);
			$stmt->bindParam(":commentType", $commentType, PDO::PARAM_STR);
			$stmt->bindParam(":commentParent", $commentParent, PDO::PARAM_STR);
			$stmt->bindParam(":userId", $userId, PDO::PARAM_STR);
			$stmt->execute();
			$stmt->closeCursor();


			// This mail will go to seller

			$sellerMail = new PHPMailer();
				$sellerMail->IsSMTP();
				$sellerMail->Mailer = 'smtp';
				$sellerMail->SMTPAuth = false;
				$sellerMail->Host = 'relay-hosting.secureserver.net'; // "ssl://smtp.gmail.com" didn't worked
				$sellerMail->Port = 25;
				// $sellerMail->SMTPSecure = 'ssl';
				// or try these settings (worked on XAMPP and WAMP):
				// $mail->Port = 587;
				// $mail->SMTPSecure = 'tls';


				// $sellerMail->Username = "shekhardtu@gmail.com";
				// $sellerMail->Password = "Hari--@134";

				$sellerMail->IsHTML(true); // if you are going to send HTML formatted emails
				$sellerMail->SingleTo = true; // if you want to send a same email to multiple users. multiple emails will be sent one-by-one.

				$sellerMail->From = "admin@dtuhub.com";
				$sellerMail->FromName = "The DTUhub Team";
				$sellerMail->AddReplyTo($buyerEmail,"DTUhub user");
				$sellerMail->addAddress($sellerEmail,'$sellerName');
				$sellerMail->addBCC("dtuhub@gmail.com","Message to seller");
				

				$sellerMail->Subject = "DTUhub | You have received an message";
				$sellerMail->Body = $this->emailBody($salutation='Dear '.$sellerName, $subject='You have received a message for your ad:', 
				 $title='Nothing Right Now', 
				$buyerMessage, $mailContent='You can hit the reply or contact using ',
				 $buyerEmail, $buyerNumber,$sellerEmail);
			
				
				$buyerMail = new PHPMailer();
				$buyerMail->IsSMTP();
				$buyerMail->Mailer = 'smtp';
				$buyerMail->SMTPAuth = false;
				$buyerMail->Host = 'relay-hosting.secureserver.net'; // "ssl://smtp.gmail.com" didn't worked
				$buyerMail->Port = 25;
				// $buyerMail->SMTPSecure = 'ssl';
				// or try these settings (worked on XAMPP and WAMP):
				// $mail->Port = 587;
				// $mail->SMTPSecure = 'tls';


				// $buyerMail->Username = "shekhardtu@gmail.com";
				// $buyerMail->Password = "Hari--@134";

				$buyerMail->IsHTML(true); // if you are going to send HTML formatted emails
				$buyerMail->SingleTo = true; // if you want to send a same email to multiple users. multiple emails will be sent one-by-one.

				$buyerMail->From = "admin@dtuhub.com";
				$buyerMail->FromName = "Hari Shekhar";

				$buyerMail->addAddress($buyerEmail,"Shekhar");


				$buyerMail->addBCC("dtuhub@gmail.com","message to buyer");
				

				$buyerMail->Subject = "DTUhub | Your message has been delivered";
				$buyerMail->Body = $this->emailBody('Hi Sparky',' Thank you for using DTUhub.',' TITLE: Buyer mail',$buyerMessage,
					 'We are just confirming that your query has been delivered.
				 Meanwhile if you want, you can also contact to ad publisher using these details' 
				  , $sellerEmail, $sellerNumber, $buyerEmail);	
				



		


		if(!$sellerMail->Send() || !$buyerMail->Send())
		{
			
				$msg=$sellerMail->ErrorInfo . $buyerMail->ErrorInfo;
				
		}
		else
							    
		return TRUE;
				
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}

	}

	public function getSellerId($id){

		$sql="SELECT post_author FROM wp_posts WHERE ID=$id";

		try
		{
			$stmt=$this->db->prepare($sql);
			$stmt->execute();
			$result=$stmt->fetchAll();
			$stmt->closeCursor();

		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
		return $result;
	}
	
	public function getSellerInfo($author_id)
	{
		$sql= "SELECT user_login, user_mobile, user_email FROM wp_users WHERE ID='$author_id'";
			try
		{
			$stmt=$this->db->prepare($sql);
			$stmt->execute();
			$result=$stmt->fetchAll();

			$stmt->closeCursor();

		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
		return $result;

	}
	
	
	public function setCollegeName()
	{
		
		if($_POST['action']=="setCollegeName")
		{

		
			$college_name=$_POST['collegeName'];
			
			$sql="SELECT * FROM wp_college WHERE college_name='$college_name'";

			try
			{
				$stmt=$this->db->prepare($sql);
				$stmt->execute();
				$ref=$stmt->fetchAll();
				$user=array_shift($ref);

				$stmt->closeCursor();

				if(isset($user))
				{
					$_SESSION['guest'] = array(
					'collegeId' => $user['ID'],
					'collegeName' => $user['college_name'],
					'universityId' => $user['university_id'],
					'universityName' => $user['univers'],
					'stateId' =>$user['state_id'],
					);
				
				}
			}
			catch(Exception $e)
			{
				die($e->getMessage());
			}
		}
		else
		{
			unset($_SESSION['guest']);
		}



		return true;

	}


	public function breadCumber($id=NULL,$collegeNameSlug)
	{
		$siteMap="<p>";
		$currentPage=basename($_SERVER["SCRIPT_FILENAME"]);
		$termId=NULL;
		$childParent=NULL;
		if($currentPage=='category.php')
		{
			$siteMap.='<a href="../index.php"><span class="glyphicon glyphicon-home"></span> Home </a> <i class="fa fa-angle-right fa-lg"></i> ';

			if(!empty($id))
			{
	            if(isset($_SESSION['guest']['collegeName']))
	                    {
	                        $siteMap.=$_SESSION['guest']['collegeName'] . ' <i class="fa fa-angle-right fa-lg"></i> ';
	                    }

				$sql="SELECT *
						FROM wp_term_taxonomy
						LEFT JOIN wp_terms ON wp_term_taxonomy.term_id = wp_terms.term_id
						WHERE wp_term_taxonomy.term_taxonomy_id=:taxonomyId";
				try
				{
					$getTermName=$this->db->prepare($sql);
					$getTermName->bindParam(":taxonomyId", $id, PDO::PARAM_STR);
					$getTermName->execute();
					$termId=$getTermName->fetchAll();
					$getTermName->closeCursor();

					
					if($termId[0]['parent']==0)
					{
	                    
						$siteMap.= $termId[0]['name'];
					}else
					{
						$getTermId=$this->db->prepare("SELECT * FROM wp_term_taxonomy
						LEFT JOIN wp_terms ON wp_term_taxonomy.term_id = wp_terms.term_id
						WHERE wp_term_taxonomy.term_taxonomy_id=:taxonomyId");
						$getTermId->bindParam(":taxonomyId", $termId[0]['parent'], PDO::PARAM_STR);
						$getTermId->execute();
						$childParent=$getTermId->fetchAll();
						$getTermId->closeCursor();
	                    
	                   
						$siteMap.='<a href=../category/'.$childParent[0]['term_taxonomy_id'].'>'.$childParent[0]['name'] .' </a> <i class="fa fa-angle-right fa-lg"></i> ';
					
	                    $siteMap.=$termId[0]['name'] ;


					}
					
					

				}
				catch(Exception $e)
				{
					die(getMessage());
				}
			}
			else
			{	$collegeInfo=$this->getCollegeNameBySlug($collegeNameSlug);
				$siteMap.= $collegeInfo[0]['college_name'];
			}
		}
		elseif($currentPage=='classified.php')
		{
			$siteMap.='<a href="../index.php"><span class="glyphicon glyphicon-home"></span> Home </a> <i class="fa fa-angle-right fa-lg"></i>';
            
            if(isset($_SESSION['guest']['collegeName']))
            {
                $siteMap.=$_SESSION['guest']['collegeName'] . ' <i class="fa fa-angle-right fa-lg"></i> ';
            }

			$sql="SELECT wp_term_relationships.term_taxonomy_id, wp_posts.post_title
					FROM wp_term_relationships
					LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
					WHERE wp_term_relationships.object_id=:objectId";
				try
				{
					$getTaxonomyId=$this->db->prepare($sql);
					$getTaxonomyId->bindParam(":objectId", $id, PDO::PARAM_STR);
					$getTaxonomyId->execute();
					$termTaxonomyID=$getTaxonomyId->fetchAll();
					$getTaxonomyId->closeCursor();

					$postTitle=$termTaxonomyID[0]['post_title'];

						
							$getTermName=$this->db->prepare("SELECT * FROM wp_term_taxonomy
							LEFT JOIN wp_terms ON wp_term_taxonomy.term_id = wp_terms.term_id
							WHERE wp_term_taxonomy.term_taxonomy_id=:taxonomyId");
							$getTermName->bindParam(":taxonomyId", $termTaxonomyID[0]['term_taxonomy_id'], PDO::PARAM_STR);
							$getTermName->execute();
							$termName=$getTermName->fetchAll();
							$getTermName->closeCursor();
                            
							if($termName[0]['parent']==0)
							{
							    

								$category='<a href=../category/'.$termName[0]['term_taxonomy_id'].'>'.$termName[0]['name'] .' </a> <i class="fa fa-angle-right fa-lg"></i> ';
							}
							else
							{
								$subcategory='<a href=../category/'.$termName[0]['term_taxonomy_id'].'>'.$termName[0]['name'] .' </a> <i class="fa fa-angle-right fa-lg"></i> ';
							}

							$getSubTermName=$this->db->prepare("SELECT * FROM wp_term_taxonomy
							LEFT JOIN wp_terms ON wp_term_taxonomy.term_id = wp_terms.term_id
							WHERE wp_term_taxonomy.term_taxonomy_id=:taxonomyIdd");
							$getSubTermName->bindParam(":taxonomyIdd", $termTaxonomyID[1]['term_taxonomy_id'], PDO::PARAM_STR);
							$getSubTermName->execute();
							$subTermName=$getSubTermName->fetchAll();
							$getSubTermName->closeCursor();

                            
							if($subTermName[0]['parent']==0)
							{
								$category='<a href=../category/'.$subTermName[0]['term_taxonomy_id'].'>'.$subTermName[0]['name'].' </a> <i class="fa fa-angle-right fa-lg"></i> ';
							}
							else
							{
								$subcategory='<a href=../category/'.$subTermName[0]['term_taxonomy_id'].'>'.$subTermName[0]['name'].' </a> <i class="fa fa-angle-right fa-lg"></i> ';
							}

							
							$siteMap.=$category . $subcategory. $postTitle;			
				

			}
			catch(Exception $e)
			{
				die(getMessage());
			}
		}
		$siteMap.="</p>";
		return $siteMap;

	}

	public function pageTitle($id=NULL, $collegeNameSlug)
	{
		$siteMap=null;
		$currentPage=basename($_SERVER["SCRIPT_FILENAME"]);
		$termId=NULL;
		$childParent=NULL;
        
		if($currentPage=='category.php')
		{
			
			if(!empty($id))
			{
					if(isset($_SESSION['guest']['collegeName']))
		                    {
		                        $siteMap.="Buy or Sell within  ". $_SESSION['guest']['collegeName'] . ' || ';
		                    }
		        
					

					$sql="SELECT *
							FROM wp_term_taxonomy
							LEFT JOIN wp_terms ON wp_term_taxonomy.term_id = wp_terms.term_id
							WHERE wp_term_taxonomy.term_taxonomy_id=:taxonomyId";
					try
					{
						$getTermName=$this->db->prepare($sql);
						$getTermName->bindParam(":taxonomyId", $id, PDO::PARAM_STR);
						$getTermName->execute();
						$termId=$getTermName->fetchAll();
						$getTermName->closeCursor();

						
						if($termId[0]['parent']==0)
						{
							$siteMap.=$termId[0]['name']. " || DTUhub - Student to Student Marketplace";
						}else
						{
							$getTermId=$this->db->prepare("SELECT * FROM wp_term_taxonomy
							LEFT JOIN wp_terms ON wp_term_taxonomy.term_id = wp_terms.term_id
							WHERE wp_term_taxonomy.term_taxonomy_id=:taxonomyId");
							$getTermId->bindParam(":taxonomyId", $termId[0]['parent'], PDO::PARAM_STR);
							$getTermId->execute();
							$childParent=$getTermId->fetchAll();
							$getTermId->closeCursor();

							$siteMap.=$childParent[0]['name']. " || ";
							
							$siteMap.=$termId[0]['name']. " || DTUhub - Student to Student Marketplace"; 


						}
						
						

					}
					catch(Exception $e)
					{
						die(getMessage());
					}
			}
			else
			{	
				$collegeInfo=$this->getCollegeNameBySlug($collegeNameSlug);
				$siteMap.="Buy or Sell within  ".$collegeInfo[0]['college_name'];
			}
		}
		elseif($currentPage=='classified.php')
		{
			

			$sql="SELECT wp_term_relationships.term_taxonomy_id, wp_posts.post_title
					FROM wp_term_relationships
					LEFT JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.ID
					WHERE wp_term_relationships.object_id=:objectId";
				try
				{
					$getTaxonomyId=$this->db->prepare($sql);
					$getTaxonomyId->bindParam(":objectId", $id, PDO::PARAM_STR);
					$getTaxonomyId->execute();
					$termTaxonomyID=$getTaxonomyId->fetchAll();
					$getTaxonomyId->closeCursor();

					$postTitle=$termTaxonomyID[0]['post_title'];

						
							$getTermName=$this->db->prepare("SELECT * FROM wp_term_taxonomy
							LEFT JOIN wp_terms ON wp_term_taxonomy.term_id = wp_terms.term_id
							WHERE wp_term_taxonomy.term_taxonomy_id=:taxonomyId");
							$getTermName->bindParam(":taxonomyId", $termTaxonomyID[0]['term_taxonomy_id'], PDO::PARAM_STR);
							$getTermName->execute();
							$termName=$getTermName->fetchAll();
							$getTermName->closeCursor();

							if($termName[0]['parent']==0)
							{
									

								$category=$termName[0]['name'] ." || ";
							}
							else
							{
								$subcategory=$termName[0]['name'] . " || ";
							}

							$getSubTermName=$this->db->prepare("SELECT * FROM wp_term_taxonomy
							LEFT JOIN wp_terms ON wp_term_taxonomy.term_id = wp_terms.term_id
							WHERE wp_term_taxonomy.term_taxonomy_id=:taxonomyIdd");
							$getSubTermName->bindParam(":taxonomyIdd", $termTaxonomyID[1]['term_taxonomy_id'], PDO::PARAM_STR);
							$getSubTermName->execute();
							$subTermName=$getSubTermName->fetchAll();
							$getSubTermName->closeCursor();


							if($subTermName[0]['parent']==0)
							{
								$category=$subTermName[0]['name']. " || ";
							}
							else
							{
								$subcategory=$subTermName[0]['name']. " || ";
							}

							$titlePostFix=" || DTUhub- Student to Student Marketplace";
							$siteMap.=$subcategory . $postTitle . $titlePostFix;			
				

			}
			catch(Exception $e)
			{
				die(getMessage());
			}
		}
		else
		{
			$siteMap.=" DTUhub- Student to Student Marketplace";
		}
		
		return $siteMap;

	}


	public  function addInstitutionDisplayForm()
	{
		$gethtml=NULL;
		
		$state=$this->_loadStateData();
		$gethtml.='<div class="row border-bottom margin-bottom-10">
						<div class="col-md-12">
							<h3> Add Institution</h3>
							
						</div>
					</div>

				<div class="row">
					<div class="col-md-12">
						<form role="form" class="form-horizontal addInstitution" novalidate method="POST" action="../assets/inc/process.inc.php" enctype="multipart/form-data">
						
								<!-- Category of the item -->
							<div class="form-group">
								<label for="sellerState">State<super>*</super></label>
								
									<select class="form-control input-sm sellerState" id="sellerState" name="sellerState">
									<option value=" "> Select a state</option>';
										
										foreach ($state as  $value)
										{			
											$result=new state($value);
											
											$gethtml.= "<option value='".$result->stateName."'>".$result->stateName."</option>";
																
										}

									$gethtml .='</select>
								
							</div>
								<div class="form-group">
									<label for="sellerUniversity">University<super>*</super></label>
									
										<select class="form-control input-sm sellerUniversity" name="sellerUniversity" id="sellerUniversity">
												<option value="0">Select a university</option>

										</select>
									
								</div>
									<!-- title of the item -->
									<div class="form-group">
										<label for="institution" >Institution Name<super>*</super></label>
										
										 	<input type="text" required="required" name="institution" class="form-control input-sm" 
										 	id="institution" placeholder="Enter institution name">
										
									</div>
								<input type="hidden" name="token" value="'.$_SESSION['token'].'" />
								<input type="hidden" name="ip" value="'.$_SERVER['REMOTE_ADDR'].'" />
								<input type="hidden" name="action" value="add_institution" />
								<div class="form-group">
									<label class="col-sm-2"></label>
									<div class="col-sm-10">
										<button type="submit" class="btn btn-warning btn-block">Submit</button>
									</div>
								</div>
							</form>
						

					</div>
				</div>';


				return $gethtml;
	}

	public function processInstitution()
	{
		$universityId=$_POST['sellerUniversity'];
		$collegeName=$_POST['institution'];
		$collegeNameSlug=strtolower(preg_replace("/ /","-",$_POST['institution']));

		$sql="INSERT wp_college(college_name, college_name_slug, university_id) VALUES(:collegeName, :collegeNameSlug, :universityId)";

		try
		{
			$stmt=$this->db->prepare($sql);
			$stmt->bindParam(":collegeName", $collegeName, PDO::PARAM_STR);
			$stmt->bindParam(":collegeNameSlug", $collegeNameSlug, PDO::PARAM_STR);
			$stmt->bindParam(":universityId", $universityId, PDO::PARAM_STR);
			$stmt->execute();
			$stmt->closeCursor();


		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}

		return true;
	}

	public function curPageURL() {
			 $pageURL = 'http';
			 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
			 $pageURL .= "://";
			 if ($_SERVER["SERVER_PORT"] != "80") {
			  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
			 } else {
			  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
			 }
			 return $pageURL;
			}


	public function processFeedback()
	{


		if( $_POST['action']!='sendFeedback')
		{
			return " You have reached here using unspecified way.
			 Kindly refill the form and process again.";
		}

		$buyerName=htmlentities($_POST['buyerName'], ENT_QUOTES);
		$buyerEmail=htmlentities($_POST['buyerEmail'], ENT_QUOTES);
		$buyerNumber=htmlentities($_POST['buyerNumber'], ENT_QUOTES);
		$buyerMessage=htmlentities($_POST['feedbackMessage'], ENT_QUOTES);
		$buyerIp=htmlentities($_POST['buyerIp'], ENT_QUOTES);
		$sellerId=htmlentities($_POST['sellerId'], ENT_QUOTES);
		$postId=htmlentities($_POST['postId'], ENT_QUOTES);
		$commentDate= date("Y-m-d H:i:s");
		$commentDateGmt= date("Y-m-d H:i:s");
		$commentApproved= 1;
		$commentType="feedback";
		$commentParent="0";
		if(isset($_SESSION['user']))
		{
			$userId=$_SESSION['user']['id'];
		}
		else
		{
			$userId=0;
		}
		$commentAuthorURL= $this->curPageURL();

		$seller=$this->getSellerInfo($sellerId);
		$sellerEmail=$seller[0]['user_email'];
		$sellerName=$seller[0]['user_login'];
		$sellerNumber=$seller[0]['user_mobile'];

		$sql="INSERT INTO wp_comments (comment_post_ID, comment_author, seller_ID, comment_author_email, comment_author_contact, comment_author_url,
			comment_author_IP, comment_date, comment_date_gmt, comment_content, comment_approved, comment_type, comment_parent, user_id) 
			VALUES (:postId, :buyerName, :sellerId, :buyerEmail, :buyerNumber, :commentAuthorURL, :buyerIp, :commentDate, :commentDateGmt, :buyerMessage, 
				:commentApproved, :commentType, :commentParent, :userId)";

		try
		{
			$stmt=$this->db->prepare($sql);
			$stmt->bindParam(":postId", $postId, PDO::PARAM_STR);
			$stmt->bindParam(":buyerName", $buyerName, PDO::PARAM_STR);
			$stmt->bindParam(":sellerId", $sellerId, PDO::PARAM_STR);
			$stmt->bindParam(":buyerEmail", $buyerEmail, PDO::PARAM_STR);
			$stmt->bindParam(":buyerNumber", $buyerNumber, PDO::PARAM_STR);
			$stmt->bindParam(":commentAuthorURL", $commentAuthorURL, PDO::PARAM_STR);			
			$stmt->bindParam(":buyerIp", $buyerIp, PDO::PARAM_STR);
			$stmt->bindParam(":commentDate", $commentDate, PDO::PARAM_STR);
			$stmt->bindParam(":commentDateGmt", $commentDateGmt, PDO::PARAM_STR);
			$stmt->bindParam(":buyerMessage", $buyerMessage, PDO::PARAM_STR);
			$stmt->bindParam(":commentApproved", $commentApproved, PDO::PARAM_STR);
			$stmt->bindParam(":commentType", $commentType, PDO::PARAM_STR);
			$stmt->bindParam(":commentParent", $commentParent, PDO::PARAM_STR);
			$stmt->bindParam(":userId", $userId, PDO::PARAM_STR);
			$stmt->execute();
			$stmt->closeCursor();


			// This mail will go to seller

		// 	$sellerMail = new PHPMailer();
		// 		$sellerMail->IsSMTP();
		// 		$sellerMail->Mailer = 'smtp';
		// 		$sellerMail->SMTPAuth = false;
		// 		$sellerMail->Host = 'relay-hosting.secureserver.net'; // "ssl://smtp.gmail.com" didn't worked
		// 		$sellerMail->Port = 25;
		// 		// $sellerMail->SMTPSecure = 'ssl';
		// 		// or try these settings (worked on XAMPP and WAMP):
		// 		// $mail->Port = 587;
		// 		// $mail->SMTPSecure = 'tls';


		// 		// $sellerMail->Username = "shekhardtu@gmail.com";
		// 		// $sellerMail->Password = "Hari--@134";

		// 		$sellerMail->IsHTML(true); // if you are going to send HTML formatted emails
		// 		$sellerMail->SingleTo = true; // if you want to send a same email to multiple users. multiple emails will be sent one-by-one.

		// 		$sellerMail->From = "admin@dtuhub.com";
		// 		$sellerMail->FromName = "The DTUhub Team";
		// 		$sellerMail->AddReplyTo($buyerEmail,"DTUhub user");
		// 		$sellerMail->addAddress($sellerEmail,'$sellerName');
		// 		$sellerMail->addBCC("dtuhub@gmail.com","Message to seller");
				

		// 		$sellerMail->Subject = "DTUhub | You have received an message";
		// 		$sellerMail->Body = $this->emailBody($salutation='Dear '.$sellerName, $subject='You have received a message for your ad:', 
		// 		 $title='Nothing Right Now', 
		// 		$buyerMessage, $mailContent='You can hit the reply or contact using ',
		// 		 $buyerEmail, $buyerNumber,$sellerEmail);
			
				
		// 		$buyerMail = new PHPMailer();
		// 		$buyerMail->IsSMTP();
		// 		$buyerMail->Mailer = 'smtp';
		// 		$buyerMail->SMTPAuth = false;
		// 		$buyerMail->Host = 'relay-hosting.secureserver.net'; // "ssl://smtp.gmail.com" didn't worked
		// 		$buyerMail->Port = 25;
		// 		// $buyerMail->SMTPSecure = 'ssl';
		// 		// or try these settings (worked on XAMPP and WAMP):
		// 		// $mail->Port = 587;
		// 		// $mail->SMTPSecure = 'tls';


		// 		// $buyerMail->Username = "shekhardtu@gmail.com";
		// 		// $buyerMail->Password = "Hari--@134";

		// 		$buyerMail->IsHTML(true); // if you are going to send HTML formatted emails
		// 		$buyerMail->SingleTo = true; // if you want to send a same email to multiple users. multiple emails will be sent one-by-one.

		// 		$buyerMail->From = "admin@dtuhub.com";
		// 		$buyerMail->FromName = "Hari Shekhar";

		// 		$buyerMail->addAddress($buyerEmail,"Shekhar");


		// 		$buyerMail->addBCC("dtuhub@gmail.com","message to buyer");
				

		// 		$buyerMail->Subject = "DTUhub | Your message has been delivered";
		// 		$buyerMail->Body = $this->emailBody('Hi Sparky',' Thank you for using DTUhub.',' TITLE: Buyer mail',$buyerMessage,
		// 			 'We are just confirming that your query has been delivered.
		// 		 Meanwhile if you want, you can also contact to ad publisher using these details' 
		// 		  , $sellerEmail, $sellerNumber, $buyerEmail);	
				



		


		// if(!$sellerMail->Send() || !$buyerMail->Send())
		// {
			
		// 		$msg=$sellerMail->ErrorInfo . $buyerMail->ErrorInfo;
				
		// }
		// else
							    
		return TRUE;
				
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}

	}

}