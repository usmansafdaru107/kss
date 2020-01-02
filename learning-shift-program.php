<?php  include('inc/header.php'); ?>
<div class="container" style="position:relative; top:0; left:0;">
<div class="sub-header-programs">
    <ul>
    
    <li><a class="" data-target="#programsRegister" data-toggle="modal" href="#"><i class="fa fa-pencil"></i>&nbsp; Register</a></li>
        <li class="separator">|</li>
    <li><a class="active" href="./learning-shift-program.php">The Learning Shift Program</a></li>
    <li class="separator">|</li>
    <li><a class="" href="./student-pathways-program.php">Student Pathways Programs</a></li>
    <li class="separator">|</li>
        <li><a class="" href="./student-support-program.php">Student Support Programs</a></li>
        <li class="separator">|</li>
      <li><a class="" href="./professional-development-for-teachers.php">Professional Development For Teachers</a></li>   
        
    </ul>
</div>
	<div class="row">
		<div class="col-md-12 col-sm-12 student-support-program">
            <h1 class="page-header">The Learning Shift Program</h1>
            <div data-aos="fade-in" class="hero-lsp">

            </div>
            <br>
			<p data-aos="fade-in" class="para-blue">Our goal is to transform the instruction
             practice in schools by working with educators and school administration through 
             collaboration, where students participate in Immersive Learning Projects that  
             sharpen their core competencies and skills  to help them adapt and thrive in the 
             rapidly changing world. 
</p>
            <br>
                <ul data-aos="fade-right">
                    <li><b>A sneak peek into the future</b></li>
                </ul>
                <p data-aos="fade-in" class="ftyg">
                We face a challenge, half of our country’s population is below 16 years, and 
                almost 90% of them are still in school. Two thirds of children starting school
                 today will enter professions that don’t exist yet. According to the McKinsey
                  Global Institute, approximately half of all jobs today may be lost due to 
                  advances in robotics, artificial intelligence, and machine learning that 
                  will usher in a new age of automation. Machines are expected to match or 
                  outperform human performance in a range of work activities, including ones 
                  requiring cognitive capabilities.
                </p>
                <p data-aos="fade-in" class="ftyg">
                <b>To prepare students to adapt and thrive in this uncertain future,</b> we need to help them develop new 21st century skills and competencies.  Knowledge will still be important. But competencies like Critical thinking, Problem solving, Creativity, Communication and Collaboration will be even more important. Character qualities like curiosity, initiative, grit, adaptability, leadership, and social and cultural awareness will be critical.
            </p>
            <p data-aos="fade-in" class="ftyg"><b>The Learning Shift Program</b> is contributing to this 
            massive transformation in the instruction practice in schools by putting
             teachers and students at the heart of this change through carrying out teacher 
             trainings and collaborative programs with schools. We are currently running
              Place-Based Education Program. We wish to invite schools and Mentor
               educators to participate in our innovative Place-Based Education 
               Projects (PBE) that have been designed for both national and international schools.</p>
                
			<br>
			<br>
            <div data-aos="fade-up" class="separate-login">
            <h3> To take part in this program, register as a school or as a Mentor educator.</h3>
            <a data-target="#programsRegister" data-toggle="modal" class="btn btn-primary" href="#"><i class="fa fa-institution"> </i> &nbsp; Register as a School</a>
            &nbsp;
            <a data-target="#programsRegister" data-toggle="modal" class="btn btn-success" href="#"><i class="fa fa-user-circle"> </i> &nbsp; Register as a Mentor</a>

            </div>
            <br class="clear-both">
            <br class="clear-both">
            <br class="clear-both">
            <br class="clear-both">
            <p data-aos="fade-in" class="fty pull-left">
            Place-Based Education is an immersive learning experience that places students in local heritage,
            cultures, landscapes, opportunities and experiences, and uses these as a foundation for the study of
             language arts, mathematics, social studies, science and other subjects across the curriculum.
             <br>
             <br>
             Schools that enroll for the Learning Shift Program will chose projects basing on one or 
             more of  the following themes; Civic Engagement, Environmental Education, Culture, Community
              Economic Development, Public Health and Wellbeing, and Nutrition, Agriculture and Food Systems.
               The Learning Shift Program’s team together with the participating school will design the project and identify which 
             places in the school’s community or the nearby community would create rich opportunities for students’
              learning about a given topic.
              <br>
             <br>
             Students from the participating schools will actively be involved in activities such 
             as; making balanced research, collecting data, conducting interviews, making short films 
             and documentaries, carrying out surveys and taking part in other community programs. 
             For example, under Environmental Education, students will be guided to design and implement
              a project that explores causes and solutions to an environmental issue in the community.
               Students will be required to integrate concepts from Science, Technology, Engineering 
               and Mathematics (STEM) as an interdisciplinary approach to solving a problem.  
             This will sharpen students’ core competencies and skills. Such students are the 
             citizens the world needs for tomorrow.”
                </p>
            <img data-aos="fade-in" class="pull-right" src="./images/programs/goals.png" alt="Kas Goals">
            <br class="clear-both">
            <br class="clear-both">
            <br class="clear-both">
            <br class="clear-both">
               <iframe data-aos="fade-up" width="100%" height="580" src="https://www.youtube.com/embed/MQi2UWzba3g" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            <br><p data-aos="fade-in">The Learning Shift Program takes on passionate Mentor Educators who will work with schools to implement
                 Place-based projects. <a href="#" data-target="#sendMessageModal" data-toggle="modal">Contact us for more information</a>.</p>

            



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
