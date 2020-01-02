<?php  include('inc/header.php'); ?>
<div class="container" style="position:relative; top:0; left:0;">
<div class="sub-header-programs">
    <ul>
    
        <li><a class="" data-target="#programsRegister" data-toggle="modal" href="#"><i class="fa fa-pencil"></i>&nbsp; Register</a></li>
        <li class="separator">|</li>
    <li><a href="./learning-shift-program.php">The Learning Shift Program</a></li>
    <li class="separator">|</li>
    <li><a href="./student-pathways-program.php">Student Pathways Programs</a></li>
    <li class="separator">|</li>
        <li><a class="active" href="./student-support-program.php">Student Support Programs</a></li>
        <li class="separator">|</li>
      <li><a class="" href="./professional-development-for-teachers.php">Professional Development For Teachers</a></li>  
              
        
    </ul>
</div>
	<div class="row">
		<div class="col-md-12 col-sm-12 student-support-program">
            <h1 class="page-header">Student Support Programs</h1>
            <div data-aos="fade-in" class="hero">

            </div>
            <br>
			<p data-aos="fade-in" class="para-blue">These programs support the individual needs of every learner and ensure that all students have equitable access to education.</p>
            <br>
                <ul data-aos="fade-right">
                    <li><b>Home Schooling Support</b></li>
                </ul>
                <p data-aos="fade-in" class="fty pull-left">
                The concept of learning is shifting to more flexible and personalized 
                learning approaches. 
                We recognize that each student is a unique individual with different 
                learning needs. Today, 
                many families are choosing non-traditional education options for their 
                children for a wide variety of reasons. Our Homeschooling Support program
                 provides an online platform with a complete homeschool curriculum 
                 (Kampala Smart School Application), tutor support services and <a href="./student-pathways-program.php">Student 
                 Pathways Programs</a> that students can engage in at our learning centre.
                </p>
                <img data-aos="fade-in" class="pull-right" src="./images/programs/hm-support.jpg" alt="Home Schooling Support">
			<br>
			<br>
            <div data-aos="fade-up" class="separate-login">
            <a data-target="#programsRegister" data-toggle="modal" class="btn btn-primary" href="#"><i class="fa fa-pencil"> </i> &nbsp; Register Now</a>
            </div>
            <br class="clear-both">
            <br class="clear-both">
            <br class="clear-both">
            <br class="clear-both">
                <ul data-aos="fade-right">
                    <li><b>Reading Recovery Program</b></li>
                </ul>
                <p data-aos="fade-in" class="fty pull-left">
                Reading is one of the most important skills children can learn.
                 Our Reading Recovery Program is a short-term intervention for students 
                 having difficulty with reading and writing. Content in this program is 
                 different for every child, starting from what the child knows and 
                what he/she needs to learn next. The five areas of focus in our 
                Reading Recovery Program are; phonemic awareness, phonics, building 
                vocabulary, comprehension and fluency. The end result is to have a 
                child progress from a non reader to a long chapter book reader in the 
                shortest time. 
                </p>
                <img data-aos="fade-in" class="pull-right" src="./images/programs/reading-recovery-program.jpg" alt="Home Schooling Support">
			<br>
			<br>
            <div data-aos="fade-up" class="separate-login">
            <a data-target="#programsRegister" data-toggle="modal" class="btn btn-primary" href="#"><i class="fa fa-pencil"> </i> &nbsp; Register Now</a>
            </div>
            <br class="clear-both">
            <br class="clear-both">
            <br class="clear-both">
            <br class="clear-both">
                <ul data-aos="fade-right">
                    <li><b>Catch-up Mathematics Program</b></li>
                </ul>
                <p data-aos="fade-in" class="fty pull-left">
                Basing on the individual’s assessment results, we create a 
                custom program to close educational mathematics gaps a student may have.
                 We know how important learning mathematics is to student’s education. 
                 A student works one to one with our instructors in a unique combination 
                 of mental, verbal, visual, tactile, and written activities. Our experienced 
                 teachers monitor and encourage 
                students along the way and provide graded assignments and assessments. 
                </p>
                <img data-aos="fade-in" class="pull-right" src="./images/programs/catch-up-math.jpg" alt="Home Schooling Support">
			<br>
			<br>
            <div data-aos="fade-up" class="separate-login">
            <a data-target="#programsRegister" data-toggle="modal" class="btn btn-primary" href="#"><i class="fa fa-pencil"> </i> &nbsp; Register Now</a>
            </div>
            <br class="clear-both">
            <br class="clear-both">
            <br class="clear-both">
            <br class="clear-both">
                <ul data-aos="fade-right">
                    <li><b>Examination Prep</b></li>
                </ul>
                <p data-aos="fade-in" class="fty pull-left">
                Examinations and Tests can be the most stressful events in a student’s 
                educational career. They determine the student’s grades, and subsequently affect 
                the student’s placement in the next class. In addition, examinations like UACE, 
                Cambridge and IB determine which universities a student will be accepted into, and 
                this can decide a person’s future career prospects! Our Examination Prep Program offers 
                students the opportunity to combat anxiety, recall information faster, and conquer tests
                 with confidence! Our teachers help students prepare for school tests, standardized tests,
                  and various school entrance examinations. These examination are;  mid-tem, end of term, 
                  promotional, PLE, UCE, UACE, Cambridge Examinations, SATS, IB Assessments and many more. We also carry 
                  out student’s independent academic assessments to ascertain the student’s level of achievement. 
                </p>
                <img data-aos="fade-in" class="pull-right" src="./images/programs/exam-prep.jpg" alt="Home Schooling Support">
			<br>
			<br>
            <div data-aos="fade-up" class="separate-login">
            <a data-target="#programsRegister" data-toggle="modal" class="btn btn-primary" href="#"><i class="fa fa-pencil"> </i> &nbsp; Register Now</a>
            </div>
            <br class="clear-both">
            <br class="clear-both">
            <br class="clear-both">
            <br class="clear-both">







		</div>
	</div>
</div>

<?php  include('inc/footer.php'); ?>
<script src="./js/aos.js"></script>
<script>
    $(function(){
        
        $('.programsPage').addClass('activeSubmenu');
        clAOS();
    });

    function clAOS() {
        AOS.init({
            offset: 100,
            duration: 500,
            easing: 'ease-in-sine',
            delay: 150,
            once: false,
            disable: 'mobile'
    });

};


</script>
