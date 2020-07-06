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

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Kampala Smart School</title>
	<meta charset="UTF-8">		
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="We are an award winning innovative education platform that uses smart approaches to create impactful learning experiences and solutions for the young people that are growing up in the fast changing world.">
	<meta name="keywords" content="kampalasmartschool, elerning, kampala, uganda, africa, education, smart school, kas, kass, onteq, mugarura, emmanuel, digital learning, website, platform, primary education ">
	<meta name="author" content="Onteq, Nnyanzi Ian, Onen julius">
	<meta http-equiv="cache-control" content="no-cache">
	<meta name="google-site-verification" content="J04q1A2DBNBk2YQxZDLCA11e0TXo6LVLhja45wcuWCM" />
	
		<!-- face book seo -->
	<meta property="og:url"                content="<?php echo $_SERVER['REQUEST_URI']; ?>" />
	<meta property="og:type"               content="website" />
	<meta property="og:title"              content="Kampala Smart School" />
	<meta property="og:description"        content="We are an award winning innovative education platform that uses smart approaches to create impactful learning experiences and solutions for the young people that are growing up in the fast changing world." />
	<meta property="og:image"              content="./images/webAdd.jpg" />

	<!-- Favicon -->
	<link href="images/favicon.ico" rel="shortcut icon"/>

	<!-- Google font -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 
	<!-- Stylesheets -->
	<!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous"> -->

   
    <!-- font awesome 5 cdn -->
    <!-- <script src="https://kit.fontawesome.com/a076d05399.js"></script> -->

    <link rel="stylesheet" href="css/bootstrap.min.css"/>
	<link rel="stylesheet" href="css/font-awesome.min.css"/> 
    <link rel="stylesheet" href="css/owl.carousel.min.css"> 
    <link rel="stylesheet" href="css/aos.css">
	<link rel="stylesheet" href="css/slicknav.min.css"/>

	<!-- Main Stylesheets -->
	<link rel="stylesheet" href="css/style.css"/>
	<link rel="stylesheet" href="css/main.css">
</head>
<body>
	<!-- Page Preloder -->
	<div id="preloder">
		<div class="loader"></div> 
 	</div>

	<!-- Header section -->
	<header class="header-section clearfix">
		<a href="index.php" class="site-logo">		
			<img src="img/logo.png" class="logo" alt="website logo" width="70px" height="auto"	>
		</a>

		<div class="header-right">
			<div class="user-panel">
				<a data-target="#accountPop" data-toggle="modal" class="login acc">Login</a>
				<a data-target="#accountPop" data-toggle="modal" class="register"  >Create an account</a>
			</div> 
		</div>
		<ul class="main-menu">
			<li><a href="#online-learning">Online Learning</a></li>
			<li><a href="#homeschooling">Homeschooling</a>
				
			</li>
			<li><a href="#contact-section">Smart Tutor</a></li>
			<li><a href="#ftco-appointment">Contact</a></li>
		</ul>
	</header>
	<!-- Header section end -->


    <!-- slider -->
    <section class="home">
		<div class="slider">
			<div class="slide">
				<div class="container">
					<div class="caption">
						<h2><span>We are</span></h2>
						<h2 style="font-size: 40px;">an award winning</h2>
						<p>
							student-centred innovative learning platform that creates
							new learning models to serve children, teachers and families
							from kindergarten through high school with distinctive
							pathways in non-traditional learning environments.
						</p>
						<a data-target="#accountPop" data-toggle="modal" class="site-btn register" >Register Now</a>
						<a data-target="#accountPop" data-toggle="modal" class="site-btn" style="padding: 10px !important" >Already Member</a>
					</div>
				</div>
			</div>
			<div class="slide active">
				<div class="container">
					<div class="caption">
						<h2><span>Our students</span></h2>
						<h2 style="font-size: 40px;">achieve success</h2>
						<p>
							for their whole self through a completely personalised
							educational experience, centered on our one-to-one approach:
							one student and one teacher.
						</p>
						<a data-target="#accountPop" data-toggle="modal" class="site-btn register" >Register Now</a>
						<a data-target="#accountPop" data-toggle="modal" class="site-btn sb-c2" style="padding: 10px !important">Already Member</a>

					</div>
				</div>
			</div>
			<div class="slide">
				<div class="container">
					<div class="caption">
						<h2>
							<span style="font-size: 50px;">Traditional school</span>
						</h2>
						<h2 style="font-size: 40px;">may not suit</h2>
						<p>
							every child, and often students’ particular needs are not
							adequately met. At Kampala Smart School, we use an
							innovative education model centered on competency-based
							learning.
						</p>
						<a data-target="#accountPop" data-toggle="modal" class="site-btn register" >Register Now</a>
						<a data-target="#accountPop" data-toggle="modal" class="site-btn sb-c2" style="padding: 10px !important">Already Member</a>

					</div>
				</div>
			</div>
		</div>

		<!-- controls  -->
		<div class="controls">
			<div class="prev">
				&lt; </div> <div class="next"> &gt;
			</div>
		</div>

		<!-- indicators -->
		<div class="indicator">
		
	</section>
    <!-- slider close -->

	<!-- Intro section -->
	<section class="intro-section spad">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="">
						<h2 style="text-align:center;font-size:38px;margin-bottom:30px;">OUR MISSION</h2>
					</div>
				</div>
				
				<div class="col-lg-12" style="text-align:center">
					<p style="font-size:25px;color:#000000">To unlock the true learning potential of each student using innovative approaches.</p>
					<a href="#" class="site-btn">Try it now</a>
				</div>
			</div>
		</div>
	</section>
	<!-- Intro section end -->
	
	    <section class="ftco-section">
    	<div class="container">
    		<div class="row justify-content-center">
          <div class="col-md-12 heading-section text-center  mb-5">
          	
            <h2 class="mb-2">OUR VALUES</h2>
          </div>
        </div>
		<br><br>
        <div class="row d-flex">
          <div class="col-md-6 col-lg-4 d-flex align-self-stretch ">
            <div class="media block-6 services d-block text-center">
            	<div class="icon d-flex justify-content-center align-items-center">
				<span><i class="fa fa-lightbulb-o" aria-hidden="true"></i></span>
				</div>
              <div class="media-body py-md-4">
                <h3>Innovation</h3>
                <p>We imagine, create, devise and design.</p>
              </div>
            </div>      
          </div>
          
          <div class="col-md-6 col-lg-4 d-flex align-self-stretch">
            <div class="media block-6 services d-block text-center">
            	<div class="icon d-flex justify-content-center align-items-center">
				<span><i class="fa fa-search-plus" aria-hidden="true"></i></span>
				</div>
              <div class="media-body py-md-4">
                <h3 class="hea-3">Curiosity</h3>
                <p class="p-3">We are lifelong learners.</p>
              </div>
            </div>      
          </div>
          <div class="col-md-6 col-lg-4 d-flex align-self-stretch ">
            <div class="media block-6 services d-block text-center">
            	<div class="icon d-flex justify-content-center align-items-center">
				<span><i class="fa fa-heart-o" aria-hidden="true"></i></span>
				</div>
              <div class="media-body py-md-4">
                <h3 class="hea-31">Grit</h3>
                <p class="p-31">We don’t quit.</p>
              </div>
            </div>      
          </div>
          <div class="col-md-6 col-lg-4 d-flex align-self-stretch">
            <div class="media block-6 services d-block text-center">
            	<div class="icon d-flex justify-content-center align-items-center">
				<span><i class="fa fa-plus-square" aria-hidden="true"></i></span>
				</div>
              <div class="media-body py-md-4">
                <h3>Empathy</h3>
                <p>We seek to understand before we judge.</p>
              </div>
            </div>      
          </div>

          <div class="col-md-6 col-lg-4 d-flex align-self-stretch">
            <div class="media block-6 services d-block text-center">
            	<div class="icon d-flex justify-content-center align-items-center">
				<span><i class="fa fa-flask" aria-hidden="true"></i></span>
				</div>
              <div class="media-body py-md-4">
                <h3>Experiential</h3>
                <p>We apply knowledge in a real-world context.</p>
              </div>
            </div>      
          </div>
          <div class="col-md-6 col-lg-4 d-flex align-self-stretch">
            <div class="media block-6 services d-block text-center">
            	<div class="icon d-flex justify-content-center align-items-center">
				<span><i class="fa fa-check" aria-hidden="true"></i></span>
				</div>
              <div class="media-body py-md-4">
                <h3 class="hea-32">Accountability</h3>
                <p class="p-32">We follow through on tasks.</p>
              </div>
            </div>      
          </div>

        </div>
    	</div>
    </section>
	
	
	<div class="site-section block-13" id="testimonials-section" style="background-color: #38b6ff;">
      <div class="container">
        
        <div class="text-center mb-5">
          <div class="block-heading-1">
            <h2>Awards and Recognitions</h2>
          </div>
        </div>

        <div class="owl-carousel nonloop-block-13">
          <div>
            <div class="block-testimony-1 text-center">
                <img src="img/AWARDS_RECOGNITIONS/MTN_INNOVATION_AWARD_LOGO.png" alt="Image" >
              <blockquote class="mb-4 custom-design">
                <p>&ldquo; 2017 MTN Innovation <br> Education Category <br> ( Nominee)  &rdquo;</p>
              </blockquote>              
            </div>
          </div>

          <div>
            <div class="block-testimony-1 text-center">

                <img src="img/AWARDS_RECOGNITIONS/URSB_AWARD.png" alt="Image" >
              <blockquote class="mb-4 custom-design">
                <p>&ldquo; 2017  Intellectual Property  Awards- Uganda Registration Services Bureau  (URSB), Education Category (Winner)  &rdquo;</p>
              </blockquote>              
            </div>
          </div>

          <div>
            <div class="block-testimony-1 text-center">

                <img src="img/AWARDS_RECOGNITIONS/UCC_AWARD.png" alt="Image" >
              <blockquote class="mb-4 custom-design">
                <p>&ldquo; 2016  ACIA Awards -Uganda Communications Commission (UCC) Digital Content ( 1st Runner-up)  &rdquo;</p>
              </blockquote>              
            </div>
          </div>


        </div>

      </div>
    </div>

	<!-- Concept section -->
	<section class="concept-section spad" id="homeschooling">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="section-title">
						<h2 style="font-size: 3.5rem;color: #38b6ff;">Home <br>Schooling <br> Programme</h2>
					</div>
				</div>
				<div class="col-lg-6">
					<p>We design a customized homeschooling pathway for your child based on any of the four curricula with the aim of reigniting your child's 
					passion for learning.
</p>
					<ul style="margin-left: 2rem">
						<li>
							The English National Curriculum
						</li>
						<li>
						Cambridge Assessments International Education
						</li>
						<li>
						Pearson Edexcel Curriculum
						</li>
						<li>
						The Uganda National School Curriculum
						</li>
						<li>
						Singapore Maths
						</li>
					</ul>
<p>

					We prepare students for International Assessments such as IGCSE, SAT, IELTS, EDEXCEL, Cambridge AS & A Level
				We will develop a flexible learning schedule that allows a student to take lessons at our Learning Lab or at home and recommend clubs for 
				co-curricular programme. Our students sit for final Examinations with British Council Examination Centre as private candidates or any other 
				school that registers private candidates.</p>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-3 col-sm-6">
					<div class="concept-item">
						<img src="img/cambridge.jpg" alt="">
						
					</div>
				</div>
				<div class="col-lg-3 col-sm-6">
					<div class="concept-item">
						<img src="img/edexcel.jpg" alt="">
						
					</div>
				</div>
				<div class="col-lg-3 col-sm-6">
					<div class="concept-item">
						<img src="img/IELTS.jpg" alt="">
						
					</div>
				</div>
				<div class="col-lg-3 col-sm-6">
					<div class="concept-item">
						<img src="img/SAT.jpg" alt="">
						
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Concept section end -->

	<!-- Subscription section -->
	<section class="subscription-section spad" id="online-learning">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="sub-text">
						<h2>Online learning</h2>
						<h3>Start a free trial now</h3>
						<p style="color:#fff;font-size:18px;opacity:1;">Online learning delivers the same high-quality experience you'd expect from a traditional classroom but with a number of additional 
							benefits.Sign up/Login to our Learning Application to access digital lessons from Primary one to Primary Seven 
							aligned to the Uganda Primary School Curriculum.</p>
						<a href="index01.php#classesInList" class="site-btn" id="contact-section">Try it now</a>
					</div>
				</div>
				<div class="col-lg-6">
					<ul class="sub-list" style="background-image: url('img/STUDENT_LEARNING_ON_COMPUTER.jpg'); height:400px;">

					</ul>
				</div>
			</div>
		</div>
	</section>
	<!-- Subscription section end -->

    <div class="site-section bg-light" >
      <div class="container">
        <div class="row">
          <div class="col-12 text-center mb-5"  data-aos-delay="">
            <div class="block-heading-1">
              <h2 style="color:#38b6ff; font-size: 4rem" >Smart Tutor</h2>
			  <br><br>
			  <span> Location is no longer a limitation. No matter where you live, we can find the perfect tutor for your child.  Our Smart Tutors are 
			  qualified, friendly, vetted and mentored for highest quality. </span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6 mb-5"  data-aos-delay="100">
              <p class="text-center">
                <h2 class="text-center">BOOK A SMART TUTOR </h2>
              </p>
			  <span> 
			  An experienced tutor is just a click away. Register here to get matched to one.
			  </span>
			  <!-- <br/> -->
			  <br/> 
			  <br>
            <form action="book_tutor.php" method="POST">
              <div class="form-group row">
                <div class="col-md-6 mb-4 mb-lg-0">
                  <input name="class" required type="text" class="form-control" placeholder="Class">
                </div>
                <div class="col-md-6">
                  <input name="curri" type="text" required  class="form-control" placeholder="Curriculum">
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-12">
                  <input name="email" type="email" required class="form-control" placeholder="Email address">
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-12">
                  <input name="name" type="text" required class="form-control" placeholder="Your Name">
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-12">
                  <input name="loc" type="text" required class="form-control" placeholder="Location...">
                </div>
              </div>
			  
			  <div class="form-group row">
                <div class="col-md-12">
                  <input name="phone" type="number" required class="form-control" placeholder="Phone Number">
                </div>
              </div>
			  
              <div class="form-group row">
                <div class="col-md-6 ml-auto">
                  <input type="submit" class="btn btn-md site-btn text-white py-3 px-5 "  style="width: 262px !important;padding: 10px !important;" value="Register Now">
                </div>
              </div>
            </form>
          </div>
		  
		  
          <div class="col-lg-6 ml-auto" style="border-left:1px dotted grey;" data-aos-delay="200">
		    <p class="text-center">
                <h2 class="text-center">BECOME A SMART TUTOR</h2>
            </p>
			<span> 
			  Teach your favorite subject. Register here.
			</span>
			<br><br>
		
			
            <form action="be_tutor.php" method="post">
              <div class="form-group row">
                <div class="col-md-6 mb-4 mb-lg-0">
                  <input name="qualifi" required type="text" class="form-control" placeholder="Qualification">
                </div>
                <div class="col-md-6">
                  <input type="text" name="subject" required class="form-control" placeholder="Subject">
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-12">
                  <input type="email" class="form-control" name="email" required placeholder="Email address">
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-12">
                  <input type="text" class="form-control" placeholder="Your Name" name="name" required>
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-12">
                  <input type="text" class="form-control" placeholder="Location..." name="loc" required>
                </div>
              </div>
			  
			  <div class="form-group row">
                <div class="col-md-12">
                  <input type="number" class="form-control" placeholder="Phone Number" required name="phone">
                </div>
              </div>
			  
              <div class="form-group row">
                <div class="col-md-6 ml-auto">
                  <input type="submit" class="btn btn-block site-btn text-white py-3 px-5" style="padding: 10px !important;" value="Apply Now" id="ftco-appointment">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
	
	
	<section class="ftco-appointment ftco-section ftco-no-pt ftco-no-pb img" style="background-image: url(img/bg_2.jpg);">
		<div class="overlay"></div>
    	<div class="container">
    		<div class="row d-md-flex justify-content-end">
    			<div class="col-md-12 col-lg-6 half p-3 py-5 pl-lg-5 ">
    				<h2 class="mb-4">Send a Message &amp; Get in touch!</h2>
    				<form action="sendMail.php" method="POST" class="appointment">
    					<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<input type="text" name="fname" class="form-control" placeholder="Your Name">
								</div>
							</div>
							<div class="col-md-6">
							<div class="form-group">
								<input type="text" class="form-control" name="email" placeholder="Email">
							</div>
							</div>
							<div class="col-md-12">
							<div class="form-group">
								<input type="text" class="form-control" placeholder="phone number (optional)" name="phone">
							</div>
							</div>
						<div class="col-md-12">
							<div class="form-group">
								<textarea name="msg" cols="30" rows="7" class="form-control" placeholder="Message"></textarea>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<input type="submit" value="Send message" class="btn btn-primary py-3 px-4">
							</div>
						</div>
    					</div>
	          </form>
    			</div>
    		</div>
    	</div>
    </section>	

	<!-- Footer section -->
	<footer class="footer-section" id="footer-section">
		<div class="container">
			<div class="row">
				<div class="col-xl-6 col-lg-7 order-lg-2">
					<div class="row">
						<div class="col-sm-4">
							<div class="footer-widget">
								<h2>Address</h2>
								<ul>
									<li><a href="">Plot 5 Katego Road, Opposite Daks Toyota, Kamwokya.</a></li>
									<li><a href="">Education Lab</a></li>

								</ul>
							</div>
						</div>
						
						<div class="col-sm-4">
							<div class="footer-widget">
								<h2>Legal</h2>
								<ul>
									<li><a class="privacy-sec" href="terms_of_use.php"> Term and Condition </a></li>
									<li><a class="privacy-sec" href="privacy_policy.php"> Privacy Statement </a></li>

								</ul>
							</div>
						</div>
						
						<div class="col-sm-4">
							<div class="footer-widget">
								<h2>Contact us</h2>
								<ul>
									<li><a href="">Call or Whatsapp: 0776182222</a></li>
									<li><a href="">Email: kampalasmartschool@gmail.com</a></li>
								</ul>
							</div>
						</div>

					</div>
				</div>
				<div class="col-xl-6 col-lg-5 order-lg-1">
					<img src="img/logo.png" alt="" width="100px" height="100px"	>
					<div class="copyright text-white">
                        Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved
                        <br/>                      
                        
                        
					</div>
					<div class="social-links">						
                        <a href="https://www.facebook.com/kampalasmartsch/"><i class="fa fa-facebook-f"></i></a>
                        
						<a href="https://twitter.com/kampalasmartsch"><i class="fa fa-twitter"></i></a>
						<a href="https://www.youtube.com/channel/UCtKy_9I1zkxT5SoVrkEecTA?"><i class="fa fa-youtube"></i></a>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<!-- Footer section end -->
	


	<!-- Bootstrap => JS, Popper.js, and jQuery -->
    <script src="js/jquery-3.2.1.min.js"></script>    
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.slicknav.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/aos.js"></script>
	<script src="js/scroll.js"></script>
	<script src="js/script.js"></script>
	<script async="" src="https://drv.tw/inc/wd.js"></script>
	
	<?php require("inc/modal.php")	?>
	<?php  if (isset($_GET['action'])){ ?>
	<script>
		$( function(){
			$('#accountPop').modal('show');
		});
		</script>
		<?php
			}
	?>


</body>
</html>
