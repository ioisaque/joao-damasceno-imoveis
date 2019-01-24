		<!-- BEGIN FOOTER -->
		<footer id="footer">
			<div id="footer-top" class="container">
				<div class="row">
					<div class="block col-sm-4">
						<a href="index.php"><img src="images/logo.png" alt="<?php echo lang('EMPRESA_NOME'); ?>" /></a>
						<br><br>
						<p>Nós trabalhamos para fazer parte de conquistas tão importantes na sua vida. Por isso, oferecemos mais do que tradição e experiência no mercado imobiliário: oferecemos soluções reais que facilitam o dia-a-dia de nossos clientes. Isso se traduz em tranqüilidade e na certeza de satisfazer as expectativas de todos os clientes.</p>
					</div>
					<div class="block col-sm-4">
						<h3><?php echo lang('FALE_CONOSCO'); ?></h3>
						<ul class="footer-contacts">
							<li><i class="fa fa-map-marker"></i> Rua Maria Matos, 155-B - Centro<br>Coronel Fabriciano/MG<br>CEP.: 35170-111</li>
							<li><i class="fa fa-phone"></i> <?php echo lang('EMPRESA_TEL'); ?></li>
							<li><i class="fa fa-comments"></i> <?php echo lang('EMPRESA_WHATSAPP'); ?></li>
							<li><i class="fa fa-envelope"></i> <a href="mailto:<?php echo lang('EMPRESA_EMAIL'); ?>"><?php echo lang('EMPRESA_EMAIL'); ?></a></li>
						</ul>
					</div>
					<div class="block col-sm-4">
						<h3><?php echo lang('LINKS_RAPIDOS'); ?></h3>
						<ul class="footer-links">
							<li><a href="imoveis.php"><?php echo lang('TODOS_OS_IMOVEIS'); ?></a></li>
							<li><a href="contato.php"><?php echo lang('FALE_COM_A_GENTE'); ?></a></li>
						</ul>
					</div>
				</div>
			</div>
			
			
			<!-- BEGIN COPYRIGHT -->
			<div id="copyright">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<?=file_get_contents($url.'rodape_dark.html');?>
							
							<!-- BEGIN SOCIAL NETWORKS -->
							<ul class="social-networks">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<!--<li><a href="#"><i class="fa fa-twitter"></i></a></li>-->
								<li><a href="#"><i class="fa fa-google"></i></a></li>
								<!--<li><a href="#"><i class="fa fa-pinterest"></i></a></li>-->
								<!--<li><a href="#"><i class="fa fa-youtube"></i></a></li>-->
								<!--<li><a href="#"><i class="fa fa-rss"></i></a></li>-->
							</ul>
							<!-- END SOCIAL NETWORKS -->
						
						</div>
					</div>
				</div>
			</div>
			<!-- END COPYRIGHT -->
			
		</footer>
		<!-- END FOOTER -->
	
	</div>
	<!-- END WRAPPER -->
	
	
	<!-- Libs -->
	<script src="js/common.js"></script>
	<script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/owl.carousel.min.js"></script>
	<script src="js/chosen.jquery.min.js"></script>
	
	<!-- jQuery Revolution Slider -->
    <script type="text/javascript" src="rs-plugin/js/jquery.themepunch.tools.min.js"></script>   
    <script type="text/javascript" src="rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
	
	<!-- Home Grid Plugin -->
	<script src="js/freewall.js"></script>
	
	<!-- Template Scripts -->
	<script src="js/variables.js"></script>
	<script src="js/scripts.js"></script>
	
	<!-- Notify --> 
	<script type="text/javascript" src="email/email.js"></script>
	<script type="text/javascript" src="notify/bootstrap-notify.min.js"></script>	
	
</body>
</html>