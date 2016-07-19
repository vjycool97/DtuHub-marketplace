<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $page_title =strip_tags($category->pageTitle($id, $collegeSlug)); ?>
    <title><?php echo $page_title; ?></title>
    <?php if(empty($page_description)){
    $page_description="DTUhub - A standalone marketplace for students. 
    You can sell/buy/donate/exchange your old or new things. 
    We are working to make your life simpler.";
    }
    ?>
    <meta name="description" content="<?php echo $page_description; ?>" >
    <meta name="keywords" content="<?php echo $page_description; ?>">
<link href="http://fonts.googleapis.com/css?family=Headland+One%7COpen+Sans:400,300&amp;subset=latin,cyrillic" rel="stylesheet" type="text/css" /> 
    <?php foreach ( $css_files as $css ): ?>
    <link rel="stylesheet" type="text/css" media="all" href="../assets/css/<?php echo $css; ?>" />
    <link rel="stylesheet" type="text/css" media="all" href="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.1/css/bootstrapValidator.min.css" />

   <?php endforeach; ?>
   <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->    
    <?php
      include_once("analyticstracking.inc.php"); 
      ?>
</head>
<body>
<?php 
  include_once("facebooksdk.inc.php");
?>
<div class="container-fluid body-header">
  <div class="row background-white">
    <div class="col-md-3 col-xs-12 margin-top-10 text-center">
       
         
            <a href="http://www.dtuhub.com"><img src="../assets/img/logo.png" alt="DTUhub- Student to student marketplace" title="student to student marketplace" width="260" height="50" /></a>
         
        
    </div>
    <div class="col-xs-12 margin-top-15 col-md-5">
          <form method="GET" action="../search.php" role="form">           
            <div class="input-group">
              <input type="search" id="searchBox" class="form-control"
               placeholder="Search for Books, Notes, Flats and many more..." value="<?php if(!empty($_GET['search'])){echo $_GET['search'];} ?>" name="search" />
               <input type="hidden" name="action" value="search_site" />
              <span class="input-group-btn">
              <button class="btn btn-info border-radius-0" name="searchButton" type="submit"> <i class="fa fa-search"></i> Search</button>
              <?php 
                if(isset($_SESSION['user']))
                {
                  echo '<input type="hidden" name="user_id" value="'.$_SESSION["user"]["id"].'" />';

                }

              ?>

              </span>
            </div>
          </form>
    </div>
    <div class="col-xs-12 col-md-2  margin-top-20 text-center">
          <?php  echo $category->buildPostOptions(); ?>
    </div>
      
    <div class="col-xs-12 col-md-2 margin-top-15 text-right">
          <?php  echo $category->postAnAdOptions(); ?>
    </div>

      
  </div>
  
</div>


<div class="container no-border-bottom margin-top-15">
  <div class="row text-left">
    <div class="col-md-8 col-sm-12">
    
      <?php  echo $category->breadCumber($id,$collegeSlug);  ?>

    


    </div>
  </div>
</div>