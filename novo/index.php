<?php include("header.php");?>
		
	<!-- BEGIN HOME SLIDER SECTION -->	
	<div id="property-detail-wrapper" class="revslider-container style1">						
		<div class="revslider" >
			<ul>							
				<li data-transition="fade">
					<img src="images/fotos/foto1.jpg" alt=""/>
				</li>							
				<li data-transition="fade">
					<img src="images/fotos/slide1.jpg" alt=""/>
				</li>
				<li data-transition="fade">
					<img src="images/fotos/slide0.jpg" alt=""/>
				</li>				
			</ul>
		</div>
	</div>
	<!-- END HOME SLIDER SECTION -->
		
	<!-- BEGIN HOME GRID
	<div id="home-grid">
		<div id="freewall" class="free-wall">
		  <?php $items = $imoveis->getIndexGridImoveis(); ?>
		  <?php if($items): ?>
		  <?php foreach($items as $item): ?>		  
			<div class="item">
				<a class="info" href="imoveis-detalhes.php?id_imovel=<?php echo $item->id;?>">
					<span class="price">
						<i class="fa fa-home"></i><?php echo $item->operacao;?><span><?php echo moeda($item->valor);?></span>
					</span>
					<h3><?php echo $item->titulo;?></h3>
					<span class="location"><?php echo $item->cidade;?></span>
				</a>
				<img src="<?php echo ADMINURL.$imoveis->getImovelFeaturedIMG($item->id);?>" alt="" />
			</div>
		  <?php endforeach;?>					
		  <?php endif;?>
		</div>
	</div>
	  END HOME GRID -->
	
	<?php include("pesquisa_avancada.php");?>
	
	<div class="home3-hero">
		<div class="container">
			<div class="row">
				<div class="col-sm-7">
					<h2 data-animation-direction="from-left" data-animation-delay="50">Nós trabalhamos para fazer parte de conquistas importantes da sua vida.</h2>
					<p data-animation-direction="from-left" data-animation-delay="70">Por isso, oferecemos mais do que tradição e experiência no mercado imobiliário: oferecemos soluções reais que facilitam o dia-a-dia de nossos clientes. Isso se traduz em tranqüilidade e na certeza de satisfazer as expectativas de todos os clientes.</p>
					<!--<a href="agent-listing.html" class="btn btn-default-color" data-animation-direction="from-left" data-animation-delay="500">Encontre a sua casa!</a>-->
				</div>
				
				<div class="col-sm-5" data-animation-direction="from-right" data-animation-delay="80">
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3760.3723310964365!2d-42.62742178499247!3d-19.525622230904183!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xa554219179e035%3A0x937a0a416f12211!2sR.+Maria+Matos%2C+155+-+Centro%2C+Cel.+Fabriciano+-+MG%2C+35170-111!5e0!3m2!1spt-BR!2sbr!4v1531423250908" width="400" height="250" frameborder="0" style="border:0" allowfullscreen></iframe>
				</div>
			</div>
		</div>
	</div>
	
	<!-- BEGIN PROPERTIES SLIDER WRAPPER-->
	<div class="parallax dark-bg" data-stellar-background-ratio="0.5">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h1 class="section-title" data-animation-direction="from-bottom" data-animation-delay="50"><?php echo lang('ADICIONADO_RECENTEMENTE'); ?></h1>
					
					<div id="new-properties-slider" class="owl-carousel carousel-style1">
						
					  <?php $items = $imoveis->getDestaqueImoveis(); ?>
					  <?php if($items): ?>
					  <?php foreach($items as $item): ?>							
						<div class="item" data-animation-direction="from-bottom" data-animation-delay="60">
							<div class="image">
								<a href="imoveis-detalhes.php?id_imovel=<?php echo $item->id;?>" class="info">
									<h3><?php echo $item->bairro;?></h3>
									<span class="location"><?php echo $item->cidade;?></span>
								</a>
								<img src="<?php echo ADMINURL.$imoveis->getImovelFeaturedIMG($item->id);?>" alt="" height="236"/>
							</div>
							<div class="price">
								<i class="fa fa-home"></i><?php echo $item->operacao;?>
								
								<?php if ($item->vervalor):?>
								  <span><?php echo moeda($item->valor);?></span>
								<?php endif;?>
							</div>
							<ul class="amenities">
								<li><i class="icon-garage"></i> <?php echo $item->garagem;?></li>
								<li><i class="icon-bedrooms"></i> <?php echo $item->quartos;?></li>
								<li><i class="icon-bathrooms"></i> <?php echo $item->banheiros;?></li>
							</ul>
						</div>
					  <?php endforeach;?>
					  <?php endif;?>
					  
					</div>					
				</div>
			</div>
		</div>
	</div>
	<!-- END PROPERTIES SLIDER WRAPPER -->	
	
	<!-- BEGIN NEWSLETTER WRAPPER WITH COLORED BACKGROUND-->
	<div class="parallax colored-bg" style="background-image:url(images/fotos/fabriciano.jpg);" data-stellar-background-ratio="3">
		<div class="container">
			<div class="row">
				<!-- BEGIN NEWSLETTER -->
				<div id="newsletter" class="col-md-7 center">
					<h1 data-animation-direction="from-top" data-animation-delay="50">Realize o seu <strong>Sonho!</strong></h1>
					<!--<p data-animation-direction="from-top" data-animation-delay="50">com a nossa ajuda...</p>-->
					
					<div class="input-group col-md-7 center" data-animation-direction="from-bottom" data-animation-delay="50">
						<input type="text" placeholder="Seu e-mail" name="newsletter_email" id="newsletter_email" class="form-control" />
						<span class="input-group-btn">
							<button class="btn btn-default" type="button"><?php echo lang('CONTATO'); ?></button>
						</span>
					</div>
				</div>
				<!-- END NEWSLETTER -->
			</div>
		</div>
	</div>
	<!-- END NEWSLETTER WRAPPER WITH COLORED BACKGROUND-->		
<?php include("footer.php");?>		