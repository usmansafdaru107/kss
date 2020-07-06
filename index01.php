<?php
session_start();
	if(isset($_SESSION['user']) && !empty($_SESSION['user']) && isset($_SESSION['username']) && !empty($_SESSION['username'])&& isset($_SESSION['status']) && $_SESSION['status']==true && isset($_SESSION['account']) && $_SESSION['account']=='sponsor')
	{
		header("location:account.php");
    }

	else if(isset($_SESSION['user']) && !empty($_SESSION['user']) && isset($_SESSION['username']) && !empty($_SESSION['username'])&& isset($_SESSION['status']) && $_SESSION['status']==true && isset($_SESSION['account']) && $_SESSION['account']=='student')
	{
		header("location:student.php");
    }
	else{
		
	$_SESSION=array();
	session_destroy();
		//header("location:index.php");
	}

 include("inc/header.php"); 

 ?>

<!--
	<div style="top:-5px;"  class="">
	<div class="carousel-inner" id="myCarousel">
		<div class="item active ">
			<div class='slideItem1'></div>
			<div class="carousel-caption cpt">
				<h3 class="animation animated-item-1 caption-heading">We are a child-centred digital learning platform offering lessons and
resources aligned to the Uganda Primary School Curriculum.</h3>
			</div>
		</div>

		<div class="item">
			<div class='slideItem2'></div>
		<div class="carousel-caption cpt">
				<h3 class="caption-heading">We are bringing learning alive in the classrooms. Our lessons and
resources have been developed by the teachers for the teachers.</h3>		
      </div>
		</div>
		<div class="item">
			<div class='slideItem3'></div>
		<div class="carousel-caption cpt">
			<h3 class="caption-heading">Re-imagine what is possible for your child's education.
No matter where your child is with their schoolwork – Kampala Smart
School can help.</h3>			
      </div>
		</div>
		<div class="item">
			<div class='slideItem4'></div>
		<div class="carousel-caption cpt">
			<h3 class="caption-heading">Here at Kampala Smart School, we are excited to help your child
learn. Our engaging lessons also ensure that your child will have fun
in the process.</h3>
      </div>
		</div>
		
		<div class="item">
			<div class='slideItem5'></div>
		<div class="carousel-caption cpt">
			<h3 class="caption-heading">1st runner-up of Uganda Communications Commission 2016 ACIA Award under Digital Content.  
			<b>Kampala Smart School</b> improves your school & pupil’s grades with over 3000 lessons and activities across the subjects.</h3>
      </div>
		</div>

		<div class="item">
			<div class='slideItem6'></div>
		<div class="carousel-caption cpt">
			<h3 class="caption-heading">Kampala Smart School was the winner  
			in the Uganda Registration Services Bureau, Intellectual Property 2017 Awards under the Education Category</h3>
      </div>
		</div>

	</div>


	
</div>
-->
	<div style="top:-5px;" id="myCarousel" class="carousel slide carousel-fade" data-ride="carousel">
	<ol class="carousel-indicators">
		<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
		<li data-target="#myCarousel" data-slide-to="1"></li>
		<li data-target="#myCarousel" data-slide-to="2"></li>
		<li data-target="#myCarousel" data-slide-to="3"></li>
		<li data-target="#myCarousel" data-slide-to="4"></li>
		<li data-target="#myCarousel" data-slide-to="5"></li>
		
	</ol>

	<div class="carousel-inner">
		<div class="item active ">
			<div class='slideItem1'></div>
			<div class="carousel-caption cpt">
				<br style="clear:both;">
				<br style="clear:both;">
				<h3 class="caption-heading">
					We are...
				</h3>
				<p>an innovative education platform 
					that uses smart approaches to create impactful
					 learning experiences and solutions for the young 
					 people that are growing up in the fast changing world.</p>
				<div class="cc-controls">
					<a data-toggle="modal" data-target="#accountPop" class="btn-lg-custom"href="#"><i class="fa fa-pencil"> </i> Register</a>
					&nbsp;
					&nbsp;
					&nbsp;
					<a class="tryDemo" href="#">Try our demo</a>
				</div>
			</div>
		</div>

		<div class="item">
			<div class='slideItem2'></div>
		<div class="carousel-caption cpt">
				<br style="clear:both;">
				<br style="clear:both;">
				<h3 class="caption-heading">Bringing learning alive...</h3>
				<p>in the classrooms. Our lessons and resources have been developed by 
					the teachers for the teachers.</p>	
					<div class="cc-controls">
						<a data-toggle="modal" data-target="#accountPop" class="btn-lg-custom"href="#">Get started</a>
						&nbsp;
					&nbsp;
					&nbsp;
						<a href="./pricing.php">See our pricing</a>
					</div>	
      </div>
		</div>
		<div class="item">
			<div class='slideItem3'></div>
		<div class="carousel-caption cpt">
		<br style="clear:both;">
				<br style="clear:both;">
			<h3 class="caption-heading">Re-imagine...</h3>
			<p>what is possible for your child's education.
			<br>No matter where your child is with their schoolwork – Kampala Smart
			School can help.</p>
			<div class="cc-controls">
						<a data-toggle="modal" data-target="#accountPop" class="btn-lg-custom"href="#">Sign in</a>
						&nbsp;
					&nbsp;
					&nbsp;
						<a data-toggle="modal" data-target="#accountPop" href="#">Register</a>
					</div>			
      </div>
		</div>
		<div class="item">
			<div class='slideItem4'></div>
		<div class="carousel-caption cpt">
		<br style="clear:both;">
				<br style="clear:both;">
			<h3 class="caption-heading">We are excited...</h3>
			<p>to help your child
learn. <br> Our engaging lessons also ensure that your child will have fun
in the process.</p>
<div class="cc-controls">
						<a data-toggle="modal" data-target="#downloadModal" class="btn-lg-custom"href="#">Download the app</a>
						&nbsp;
					&nbsp;
					&nbsp;
						<a data-toggle="modal" data-target="#sendMessageModal" href="#">Contact us</a>
					</div>
      </div>
		</div>
		
		<div class="item">
			<div class='slideItem5'></div>
		<div class="carousel-caption cpt">
		<br style="clear:both;">
				<br style="clear:both;">
			<h3 class="caption-heading">1st runner-up...</h3>
			<p>in the Uganda Communications Commission 2016 ACIA Award under Digital Content.  
			<b>Kampala Smart School</b> improves your school & pupil’s grades with over 
			3000 lessons and activities across the subjects.</p>
			<div class="cc-controls">
						<a data-toggle="modal" data-target="#accountPop" class="btn-lg-custom"href="#">Register today</a>
						&nbsp;
					&nbsp;
					&nbsp;
						<a href="#testimonial">Testimonials</a>
					</div>
      </div>
		</div>

		<div class="item">
			<div class='slideItem6'></div>
		<div class="carousel-caption cpt">
		<br style="clear:both;">
				<br style="clear:both;">
			<h3 class="caption-heading">Intellectual Property 2017 Awards winner</h3>
			<p>Kampala Smart School was the winner  
			in the Uganda Registration Services Bureau, Intellectual Property 
			2017 Awards under the Education Category</p>
			<div class="cc-controls">
						<a class="btn-lg-custom" target="_blank" href="https://twitter.com/kampalasmartsch"><i class="fa fa-twitter"> </i> Follows us</a>
						&nbsp;
					&nbsp;
					&nbsp;
						<a href="./about.php">Read more about us</a>
					</div>
      </div>
		</div>

	</div>
			<div>
			
			<!--
			<span class="carousel-left-btn fa fa-chevron-left" aria-hidden="true" style="background-color:#e53e30; color:#fff; line-height:50px; text-align:center; border-radius:50%; width:50px; height:50px;" ></span>
			-->
			<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev" style="z-index:995;">
			<span class="fa fa-chevron-left" aria-hidden="true" style="position:absolute; left:20%; top:45%; background-color:#e53e30; color:#fff; line-height:50px; text-align:center; border-radius:50%; width:50px; height:50px;" ></span>
			<span class="sr-only">Previous</span>
			</a>

			<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next" style="z-index:995;">
			<span class="fa fa-chevron-right" aria-hidden="true" style="position:absolute; right:20%; top:45%; background-color:#e53e30; color:#fff; line-height:50px; text-align:center; border-radius:50%; width:50px; height:50px;" ></span>
			<span class="sr-only">Next</span>
			</a>
		
			</div>	
</div>



	<div class="classListBox" id="classesInList">
	<div class="white-shadow-panel">
				<h3 class="animation animated-item-1 text-center">Explore Our Online Classes</h3>
				<p class="animation animated-item-1 text-center">Kampala Smart School is organized into classes based on Levels. Navigate to find the right class for you. </p>
			</div>
			
			
			
			<div class="blueBox doodle_bg">
			<div class="container">
				<div class="row classList">
					

				</div >
</div>
			</div >

		
	</div >

	
	<div id="testimonial" class="jumbotron feedBack">
	<div class="container">
	<h3 class="animation animated-item-1 text-center">What our amazing students say about us.</h3>
		<br>

		</div>
		<div class="container feeDInner" style="background-color:#fff;">
		
		<div class="profile">
			<img src="images/AbigailMukisa.png" class="img-responsive  img-circle">
			
			<div class="sayings">
			<p class="text-center">“Before I started using Kampala Smart School I was never sure about the answer and I would sometimes be guessing when 
			I answered the question. After using the programme … 
			Science is now my favourite subject.”  </p>
			<p class="text-center"><strong>Abigail Mukisa,</strong><br><small>Learner.</small></p>
			</div>
		</div>
				<div class="profile">
			<img src="images/EstherAtuhaise.png" class="img-responsive  img-circle">
			
			<div class="sayings">
			<p class="text-center">“I have improved over the past year in both my Mathematics and English. 
			I am finding everything so much easier. Having tutorials has made the difference! 
			Tests are no longer a problem and my homework is a breeze. Thanks Kampala Smart School” </p>
			<p class="text-center"><strong>Esther Atuhaise,</strong><br><small>Learner.</small></p>
			</div>
		</div>
		
			<div class="profile">
			<img src="images/DeshinKumar.png" class="img-responsive  img-circle">
			
			<div class="sayings">
			<p class="text-center">“My mum made me do a lesson a day. I now feel really great when I am doing my Mathematics because over the holidays I was able to revise my work and catch up” </p>
			<p class="text-center"><strong>Dishin Kumar,</strong><br><small>Learner.</small></p>
			</div>
		</div>
		<div class="profile">
			<img src="images/LouisAcon.png" class="img-responsive  img-circle">
			
			<div class="sayings">
			<p class="text-center">“My Mathematics has improved a lot and I’m now in the top group in my class. 
			Kampala Smart School has made it easy for me to study at home and it really helps me in the class at school.” </p>
			<p class="text-center"><strong>Louis Acon</strong><br><small>Learner.</small></p>
			</div>
		</div>
		
		<div class="profile">
			<img src="images/AsiimweNathan.png" class="img-responsive  img-circle">
			
			<div class="sayings">
			<p class="text-center">“Kampala Smart School  has really made a difference for me at school. 
			Before we started on the programme, I never wanted to be picked by the teacher to answer a question,
			so I would always be looking down when the teacher asked a question. Now it is different!"</p>
			<p class="text-center"><strong>Nathan Asiimwe</strong><br><small>Learner.</small></p>
			</div>
		</div>
	
		<div class="profile">
			<img src="images/ChristenNatasha.png" class="img-responsive  img-circle">
			
			<div class="sayings">
			<p class="text-center">“I am new to Kampala Smart School. My sister and I have only been on the programme for about 5 months and [now] I really do understand what the teacher is saying.”  </p>
			<p class="text-center"><strong>Christen Natasha</strong><br><small>Learner.</small></p>

			</div>
		</div>
		</div>
	</div>

	<div class="blueBox doodle_bg">
	<br>
	<div class="container">
		<h3 class='animation animated-item-1 text-center'>Get started as a Parent and register your child to learn now</h3>
		<br>
	
	<div class="accBox">
		<div class="animation animated-item-1 loginBox">
			<p class="text-center"><strong>Do you have an account with us ?</strong></p>
			<br>
			<div class='button-center'>
			<button class="btn btn-danger" data-target="#accountPop" data-toggle="modal"><strong>Get started</strong></button>
			</div>
		</div>
		<div class="animation animated-item-1 loginBox">
			<p class="text-center"><strong>Do you have any questions ?</strong></p>
			<br>
			<div class='button-center'>
			<button class="btn btn-danger" data-target="#sendMessageModal" data-toggle="modal"><strong>Contact us</strong></button>
			</div>
		</div>
	</div>
	</div>
<br>
</div >

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-92899523-1', 'auto');
  ga('send', 'pageview');



</script>
<?php  include("inc/footer.php"); ?>
<script>
  $( function(){
	var app = new initHome();
	app.slider('.feeDInner');
  })
  function initHome(){
	  this.slider = function(slidElement){
		$(slidElement).slick({
			dots: true,
			infinite: true,
			autoplay:true,
			fade: true,
			arrows: false,
			cssEase: 'linear',
			autoplaySpeed: 9000,
			adaptiveHeight:true,
			responsive:true
		});
	  }
  }
</script>
<?php  if (isset($_GET['action'])){ ?>
<script>
$( function(){
	$('#accountPop').modal('show');
});
</script>
<?php
	}
?>
