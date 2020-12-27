 <logout id="contact">
    	<p class="hero_header"></p>
    	<a href="userpage.php?sbmtlogout=1"><div class="button">LOG OUT</div></a>
        <?php if(isset($_GET['sbmtlogout'])){ 
					session_destroy();
					header("location: index.php") ;
				}
		?></logout>