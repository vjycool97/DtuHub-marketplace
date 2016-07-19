<?php

$css_files = array('bootstrap.css','font-awesome.min.css','jquery-ui.css','style.css');

/*
* Include necessary files
*/
include_once 'sys/core/init.inc.php';
/*
* Load the calendar for January
*/
$rawData= $category->_loadPostData($id,'publish');
/* 
 * Output the header HTML
 */
include_once'assets/common/header.inc.php';

?>



 
<div class="container no-border-bottom background-white padding-top-15 rounded-corner">
<div class="row">
	<div class="col-md-3">
		<div class="row">
			<div class="col-md-12 text-left">
			
 <form role="form">

    <div class="panel panel-default margin-bottom-0 border-radius-0">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" href="#collapseOne">
           Sort by
          </a>
        </h4>
      </div>
      <div id="collapseOne" class="panel-collapse collapse in">
        <div class="panel-body">
          
         
            <div class="row">
                <div class="col-md-12">

                    <div class="btn-group btn-group-justified" data-toggle="buttons">
                      <label class="btn btn-default">
                        <input type="radio" name="options" value="price" class="options"> Price
                      </label>
                      <label class="btn btn-default active">
                        <input type="radio" name="options" value="post_date" class="options" checked> Posted on
                      </label>
                    </div>

                  
                </div>

            </div>
         

        </div>
      </div>
    </div>
    <div class="panel panel-default margin-bottom-0 border-radius-0">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" href="#collapseTwo">
              Filtered by
            </a>
          </h4>
        </div>
        <div id="collapseTwo" class="panel-collapse collapse in">
          <div class="panel-body">
            
            <div class="row">
                <div class="col-md-12 margin-bottom-20">
                 <div class="row">
                    <div class="col-md-12">
                      Type of ad:
                    </div>
                  </div>
                    <div class="btn-group btn-group-justified" data-toggle="buttons">
                    <label class="btn btn-default active">
                      <input type="radio" name="adType" value="all" class="options" checked>All
                    </label>

                    <label class="btn btn-default">
                      <input type="radio" name="adType" value="buy" class="options"> Buy
                    </label>

                    <label class="btn btn-default">
                      <input type="radio" name="adType" value="sell" class="options"> Sell
                    </label>
                    </div>

                  
                </div>

              </div>

            <div class="row">
              <div class="col-md-12">
                 <div class="row">
                    <div class="col-md-12">
                      Item Condition:
                    </div>
                  </div>
                  <div class="btn-group btn-group-justified" data-toggle="buttons">
                  <label class="btn btn-default active">
                    <input type="radio" name="itemCondition" value="all" class="options" checked> All
                  </label>
                  <label class="btn btn-default">
                    <input type="radio" name="itemCondition" value="old" class="options"> Old
                  </label>
                  <label class="btn btn-default">
                    <input type="radio" name="itemCondition" value="new" class="options"> New
                  </label>
                  </div>

                
              </div>

          </div>

       

      </div>
    </div>
  </div>
  <input type="hidden" value="<?php echo $id; ?>" name="id" />
  <input type="hidden" value="<?php echo $collegeSlug; ?>" name="college" />
   </form>
 





			</div>
		</div>
		

	</div>
	<div class="col-md-9 categoryPost">

		
		<?php

		  echo $category->createCategoryPostObject($id,$collegeSlug,'publish','post_date' ,'classified',$adType=NULL, $itemCondition=NULL, 1);

		?>
	</div>



</div>

    
</div>


<?php

/* 
 * Output the footer HTML
 */

include_once'assets/common/footer.inc.php';

?>
 
  