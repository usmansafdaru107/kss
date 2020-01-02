<?php
session_start();
	if(isset($_SESSION['user']) && !empty($_SESSION['user']) && isset($_SESSION['username']) && !empty($_SESSION['username'])&& isset($_SESSION['status']) && $_SESSION['status']==true && isset($_SESSION['account']) && $_SESSION['account']=='student')
	{
		
    }
	else{
		
	$_SESSION=array();
	session_destroy();
		header("location:index.php");
	}
?>
<?php  include("inc/header.php");  ?>
	<div class="main">
		<div class="col-md-3 col-sm-3 leftPanel full-height">
			<div class="artBg">
				<div class="title-bar-dark"><p><i class="fa fa-graduation-cap"> </i> Classes</p></div>
				<div class="classListed">
					<div class="classGroup">
						<div class="image" style="">
							<span class="">0%</span>
						</div>
						<div class="description">
							<h4></h4>
							<p>Subscription status: <span class="text-danger"></span></p>
						</div>
					</div>
				</div>
			</div>
			</div>
		<div class="col-md-9 col-sm-9 rightPanel full-height">
		<div class="title-bar-normal"><p><i class="fa fa-flask"> </i> Subjects</p></div>
		<div class="subjectsList">
		</div>
		</div>
	</div>



<!-- Modal -->
<div id="popStudy" class="modal fade" role="dialog" style="padding-right:0px !important;">
  <div class="modal-dialogs" style="width:100%; height:100vh; padding:0px; margin:0px;">

    <!-- Modal content-->
    <div class="modal-content" style="height:100vh; border-radius:0px;">
     		<!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
		<div class="main">
		<div class="col-md-3 col-sm-3 leftPanel full-height">
		<div class="artBg">
			<div class="title-bar-dark">
				<p>
					
					<button  data-dismiss="modal" class="btn btn-default btn-xs closePopUp"><span data-dismiss="modal" class="closePopUp fa fa-angle-left" style="cursor:pointer;"></span> Back to Subjects</button>
					&nbsp; &nbsp; &nbsp; &nbsp;
					<br>
					<i class="fa fa-flask"> </i>
					&nbsp; &nbsp; 
					<span id="subjectName"></span>
				</p>
			</div>
			<div class="terms">
				<span><b>Term : </b></span>
				<select class="termSelect" data-id="">
					<option  selected value="1">Term 1</option>
					<option value="2">Term 2</option>
					<option value="3">Term 3</option>
				</select>
			</div>	
		<div class="unitList">
			<div class="unitGroup">
				<div class="title-bar-light"><p><i class="fa fa-snowflake-o"> </i></p></div>
				<div class="topicList">
					<ul class="topicGroup">
						<li><i class="fa fa-tags"> </i> </li>
						<li><i class="fa fa-tags"> </i> </li>
					</ul>
				</div>	
			</div>
		</div>
		</div>
		</div>
		<div  id="section-to-print"  class="col-md-9 col-sm-9 rightPanel full-height">
		<div class="title-bar-normal">
			<p class="pull-left">
			<i class="fa fa-tags"> </i> 
			<span id="activeTopic"></span> </p> 
			<button style="margin: 10px;" class="printBtn pull-right btn btn-xs btn-default"><i class="fa fa-print"> </i> Print</button>
		</div>
		<div style="padding:15px;">
			<ul class="lessonList"></ul>
			<div class="PrintBox">
			<div style=""class="activeSlideView"></div>
</div>
			<div class="slideListGroup">
			<div class="slideCap"></div>
				<ul class="slideList"></ul>
			</div>
		</div>
		</div>
	</div>
      
    </div>

  </div>
</div>
<div class="OnMobileError">
	<h3 class="text-center text-primary">Sorry</h3>
	<p class="text-center">Kampala Smart School is not yet availabe on your mobile device.</p>
	<p class="text-center">Be sure to check on us later because our techinical team is working on it</p>
	<p class="text-center">Sorry for the inconviniences.</p>
	<p class="text-center"><a class="text-center btn btn-danger contAsStudent" href="#">Back to Home</a>
<br><br><br>
<img class="pacman" src="./images/read.gif" alt="Loading Image">
</p>
</div>

	


	

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-92899523-1', 'auto');
  ga('send', 'pageview');

</script>
<?php  include("inc/footer.php");?>
<script src="js/student.js"></script>

