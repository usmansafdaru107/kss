<?php
	session_start();
	if(isset($_SESSION['user']) && !empty($_SESSION['user']) && isset($_SESSION['username']) && !empty($_SESSION['username'])&& isset($_SESSION['status']) && $_SESSION['status']==true && isset($_SESSION['account']) && $_SESSION['account']=='sponsor')
	{
		
    }
	else{
		
	$_SESSION=array();
	session_destroy();
		header("location:index.php");
	}
?>
<?php  include("inc/header.php");  ?>
<div class="box-bg" style="background-color:#f7f7f7;">
<div class="container" style="background-color:#f7f7f7;">
<div class="row" style="background-color:#f7f7f7; height:80vh;">
	<div class="col-md-3 side-bar-nav">
		
			<div class="white_bg" style="border:1px solid #ddd;">
			<div class="public-box">
				
					<img class="profile-pic img-circle sponsor_pic" src="">
					
					<br>
					<p class="text-center"><?php echo $_SESSION['username']; ?></p>
					<br>
					<a href="#" data-toggle="modal"  data-id="<?php echo $_SESSION['user']; ?>" data-target="#accountSettings" class="editAcc btn btn-sm btn-primary">Edit Account</a>
			
			</div>
			<div class="naviga">
				<ul>
					<li class="text-center"><a href="account.php" class="text-center">STUDENT</a></li>
					<li class="text-center active"><a  class="text-center" href="payment.php">PAYMENT HISTORY</a></li>
					
				</ul>
			
			</div>
		
	</div>
	</div>
	<div id="section-to-print" class="col-md-9" style="background-color:#fff; border:1px solid #ddd;">
		<div class="childTab">
			<h4 class="pull-left" style="color:#e53e30;">Payments logs</h4>
			<button href="#print" class="printPage btn btn-sm btn-primary pull-right" style="margin-right:20px;">Print</button>
			
			<table class=" pull-left ch-table table table-hover">
				<tr>
					
						<th>Date & Time</th>
						<th>Status</th>
						<th>Ref No</th>
						<th>Mobile no</th>
						<th>Action</th>
						
						
						
						
						
					
				</tr>
				<tbody class="subscriptionLogList">
					
				</tbody>
			</table>
			<div class='pull-left notPaymentsadded' style="width:100%;">
			
			</div>
			</div>
			</div>
			
		</div>
	</div>


</div>
</div>
</div>


	


	


	
	<!--  Account Settings --->
	
	<div class="modal fade" id="accountSettings" role="dialog">

		<div class="modal-dialog" style="">
		<div class="modal-content">
      <div class="modal-header">
    	<h4 class="pull-left">Edit Account Settings</h4>
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
	 <form class="editAccForm" id="editAccForm">
			
					<div class="form-group">
					<p>Account Type:<span class="accType"></span></p>
					</div>
                            <img src="" style="height:90px; width:90px;" class="pic img-circle img-responsive"/>
                            <br>
                            <!-- 
					<div class="image-change">
					<div class="form-group img-upload">
					<label class="classLogoLabel" for="classLogo">Class Logo Or Image</label>
					<input type="file" name="image" class="sponsorImageEdit" id="PimageEdit" class="form-control">
				</div>
				<div class="form-group img-avail">
				<img src="images/ggll.jpg" class="pic img-responsive"/>
				</div>
				<div class="form-group">
				<button type="button" class="removeImg btn btn-xs btn-warning"><i class="fa fa-times"> </i> Remove Image</button>
				<button type="button" class="cancelRemoveImg btn btn-xs btn-warning"><i class="fa fa-undo"> </i> Return to Previous Image</button>
						
				</div>
				</div>
                            
                            -->
					
					<div class="form-group">
						<input type="text" name="sponsor_name" class="f_name form-control" placeholder="Full Names">
					</div>
										
					
					<div class="form-group">
						<input type="text" name="country" class="country form-control" placeholder="Country">
					</div>
					
					<div class="row">
					<div class="col-md-6 form-group">
						<input type="email" name="email" class="email form-control" placeholder="Email">
					</div>
					<div class="col-md-6 form-group">
						<input type="text" name="phone" class="phone form-control" placeholder="Phone Number">
					</div>
					</div>
					<div class="row">
					<div class="col-md-12 form-group">
						<button state="deactive" class="btn btn-xs btn-danger changeP">Change Password</button>
					</div>
					<div class="changePfields alert alert-warning">
					<div class="col-md-12 form-group">
						<input type="text" name="oldpassword" class="op form-control" placeholder="Old password">
					</div>
					<div class="col-md-12 form-group">
						<input type="text" name="newPassword" class="np form-control" placeholder="New password">
					</div>
					
					<div class="col-md-12 form-group">
						<input type="text" name="newPasswordc" class="npc form-control" placeholder="Confirm New password">
					</div>
					</div>
					</div>
					
					
					<div class="form-group">
						<button class='btn btn-custom-primary'>Save changes and Exit</button>
					</div>
					
					</form>
	</form>
			
      </div>
      
    </div>
	
		</div>
	
	</div>	
	
	<!-- List student enrolled at once-->
					<!-- Subscribe Student -->
<div class="modal fade" id="listStudenSubtModal" role="dialog">
		<div class="modal-dialog" style="width:60%;">
		<div class="modal-content">
      <div class="modal-header">
        <h4 class="pull-left">Subscribe Student(s)</h4>
		
		<button type="button" class="btn btn-danger close pull-right" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
	  <h4 class="studentsNumber">Students Name(s)</h4>
	  <div class="form-group studentListE">
						
	</div>
	
	<p class="charged">Charge</p>
	<p class="datePayed">Date</p>
	<p class="NoStudent">Number of students</p>
	 <p class="StudentListRec">jdkdjfd</p>
				
			
		
			
      </div>
      
    </div>
	
		</div>
	
	</div>	
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-92899523-1', 'auto');
  ga('send', 'pageview');

</script>
<?php  include("inc/footer.php");  ?>

 <script src="js/payments.js"></script>
