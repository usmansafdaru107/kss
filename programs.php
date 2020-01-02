<?php  include('inc/header.php'); ?>
<div class="container programs" style="position:relative; top:0; left:0;">
	<div class="row">
    <div class="col-md-3 col-sm-3 student-support-program">
        <a href="./student-innovation-challenge.php">
            <h3 class="page-header">Student Innovation Challenge 2018</h3>
            <div data-aos="fade-in" class="herosi">

            </div>
            <br>
			<p data-aos="fade-in" class="para-blue">Student Innovation Challenge is a Place and Community-Based Innovation Competition for students 
            of age groups <b>6 to 18 years</b>. This Competition provides opportunity for the students to connect 
            learning to their communities with the primary goals of increasing student engagement, boosting 
            academic outcomes, impacting communities and promoting understanding of the world around them.
            </p>
            <br/>
        </a>
		</div>    
    <div class="col-md-3 col-sm-3 student-support-program">
        <a href="./learning-shift-program.php">
            <h3 class="page-header">The Learning Shift Program</h3>
            <div data-aos="fade-in" class="hero-lsp">

            </div>
            <br>
			<p data-aos="fade-in" class="para-blue">Our goal is to transform the instruction
             practice in schools by working with educators and school administration through 
             collaboration, where students participate in Immersive Learning Projects that  
             sharpen their core competencies and skills  to help them adapt and thrive in the 
             rapidly changing world. 
            </p>
            <br/>
        </a>
		</div>
        <div class="col-md-3 col-sm-3 student-support-program">
        <a href="./student-pathways-program.php">
        <h3 class="page-header">Student Pathways Programs</h3>
            <div data-aos="fade-in" class="hero-spp">

            </div>
            <br>
			<p data-aos="fade-in" class="para-blue">These programs aim to develop students’ 21st
                 century skills that will equip them with the right competencies
                  and character qualities that are very important for them to adapt
                   and thrive in the rapidly changing world. 
            </p>
            </a>
            </div>
            <div class="col-md-3 col-sm-3 student-support-program">
            <a href="./student-support-program.php">
            <h3 class="page-header">Student Support Programs</h3>
            <div data-aos="fade-in" class="hero">

            </div>
            <br>
			<p data-aos="fade-in" class="para-blue">These programs support the individual needs of every 
            learner and ensure that all students have equitable access to education.</p>
            </a>
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
