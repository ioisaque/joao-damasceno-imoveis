<?php include("header.php");?>
	<!-- BEGIN PAGE TITLE/BREADCRUMB -->
	<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h1 class="page-title"><?php echo lang('DETALHES_DO_IMOVEL'); ?></h1>
					
					<ul class="breadcrumb">
						<li><a href="index.php"><?php echo lang('INICIO'); ?> </a></li>
						<li><a href="imoveis.php"><?php echo lang('IMOVEIS'); ?></a></li>
						<li><a href="imoveis-detalhes.php"><?php echo lang('DETALHES'); ?></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!-- END PAGE TITLE/BREADCRUMB -->
	
	<!-- BEGIN CONTENT WRAPPER -->
	<div class="content">
		<div class="container">
			<div class="row">		
				<div class="main col-sm-8">	
				<?php $imovel = $imoveis->getImovelByID( get('id_imovel') ); ?>
				<?php if($imovel): ?>		
				<!-- BEGIN MAIN CONTENT -->
					<div class="row">
						<!-- BEGIN PROPERTY TITLE -->
						<h1 class="section-title" data-animation-direction="from-bottom" data-animation-delay="50"><?php echo $imovel->titulo; ?></h1>
						<!-- END PROPERTY TITLE -->
					
						<!-- BEGIN PROPERTY DESCRIPTION -->
						<p class="center" data-animation-direction="from-bottom" data-animation-delay="50">
							<?php echo cleanOut($imovel->descricao); ?>
							
							  <span>
								<?php if ($imovel->verendereco):?>
								  <?php echo $imovel->endereco .' Nº: '. $imovel->numero .' '.  $imovel->complemento; ?><br>
								<?php endif;?>
								<?php echo $imovel->bairro .' - '. $imovel->cidade; ?>
							  </span>
						</p>
						<!-- END PROPERTY DESCRIPTION -->
						
					  <?php $imagens = $imoveis->getImovelIMGs($imovel->id); ?>
					  <?php if($imagens): ?>					  
						<!-- BEGIN PROPERTY DETAIL WRAPPER -->
						<div id="property-detail-wrapper" class="revslider-container style1">
						
							<!-- BEGIN PRICE TAG -->	
							<div class="price">
								<i class="fa fa-home"></i><?php echo $imovel->operacao; ?>
								<?php if ($imovel->vervalor):?>
								  <span><?php echo moeda($imovel->valor);?></span>
								<?php endif;?>
							</div>
							<!-- END PRICE TAG -->
							
							<div id="property-gallery" class="owl-carousel property-gallery">
							  <?php foreach($imagens as $img): ?>							
								<div class="item" data-animation-direction="from-bottom" data-animation-delay="50">
									<a href="<?php echo ADMINURL."/uploads/data/".$img->nome; ?>" data-gal="prettyPhoto[gallery]" title="<?php echo $imovel->titulo; ?>"><span class="btn btn-default">+</span></a>
									<img src="<?php echo ADMINURL."/uploads/data/".$img->nome; ?>" alt="" />
								</div>	
							  <?php endforeach; ?>								
							</div>						  
						</div>					
					  <?php endif; ?>	
						<!-- END PROPERTY DETAIL SLIDERS WRAPPER -->
					</div>							 
					<div class="row">
						<div class="col-sm-2"></div>
						<!-- BEGIN PROPERTY FEATURES LIST -->
						<div class="col-sm-8">
							<h1 class="section-title"><?php echo lang('CARACTERISTICAS'); ?></h1>
							
							<?php if ($imovel->garagem > 0): ?>
							  <ul class="property-features col-sm-6">
								<li><i class="icon-garage"></i> <?php echo $imovel->garagem .' '. lang('GARAGEM') .'(s)'; ?></li>
							  </ul>					
							<?php endif; ?>
							<?php if ($imovel->piscina == 1): ?>
							  <ul class="property-features col-sm-6">
								<li><i class="icon-pool"></i> <?php echo lang('PISCINA'); ?></li>
							  </ul>					
							<?php endif; ?>
							<?php if ($imovel->suites > 0 AND $imovel->quartos > 0) { ?>
							  <ul class="property-features col-sm-6">
								<li><i class="icon-rooms"></i> <?php echo $imovel->suites .' '. lang('SUITE') .'(s) e '. $imovel->quartos .' '. lang('QUARTO') .'(s)'; ?></li>
							  </ul>
							<?php } else {  ?>
							<?php if ($imovel->suites > 0): ?>					  
							  <ul class="property-features col-sm-6">
								<li><i class="icon-rooms"></i> <?php echo $imovel->suites .' '. lang('SUITE') .'(s)'; ?></li>
							  </ul>
							<?php endif; ?>					
							<?php if ($imovel->quartos > 0): ?>					  
							  <ul class="property-features col-sm-6">
								<li><i class="icon-bedrooms"></i> <?php echo $imovel->quartos .' '. lang('QUARTO') .'(s)'; ?></li>
							  </ul>
							<?php endif; } ?>
							<?php if ($imovel->banheiros > 0): ?>					  
							  <ul class="property-features col-sm-6">
								<li><i class="icon-bathrooms"></i> <?php echo $imovel->banheiros .' '. lang('BANHEIRO') .'(s)'; ?></li>
							  </ul>
							<?php endif; ?>
							<?php if ($imovel->portao == 1): ?>					  
							  <ul class="property-features col-sm-6">
								<li><i class="icon-security"></i> <?php echo lang('PORTAO'); ?></li>
							  </ul>
							<?php endif; ?>
							<?php if ($imovel->elevador == 1): ?>					  
							  <ul class="property-features col-sm-6">
								<li><i class="icon-apartment"></i> <?php echo lang('ELEVADOR'); ?></li>
							  </ul>
							<?php endif; ?>
							<?php if ($imovel->churrasqueira == 1): ?>
							  <ul class="property-features col-sm-6">
								<li><i class="icon-land"></i> <?php echo lang('CHURRASQUEIRA'); ?></li>
							  </ul>
							<?php endif; ?>		
							<?php if ($imovel->armario == 1): ?>
							  <ul class="property-features col-sm-6">
								<li><i class="icon-area"></i> <?php echo lang('ARMARIO'); ?></li>
							  </ul>
							<?php endif; ?>
							<?php if ($imovel->guardaroupa == 1): ?>
							  <ul class="property-features col-sm-6">
								<li><i class="icon-find-agent"></i> <?php echo lang('GUARDA_ROUPA'); ?></li>
							  </ul>
							<?php endif; ?>	
						</div>
						<!-- END PROPERTY FEATURES LIST -->
						<div class="col-sm-2"></div>
					</div>
				<!-- END MAIN CONTENT -->
			  <?php endif; ?>
					<div class="row">							
						<!-- BEGIN SIMILAR PROPERTIES -->
						  <?php $items = $imoveis->getSimilarImoveis($imovel->id, $imovel->bairro); ?>
						  <?php if($items): 
								$i =0;
						  ?>					
							<h1 class="section-title"><?php echo lang('IMOVEIS_SIMILARES'); ?></h1>					
							<div id="similar-properties" class="grid-style1 clearfix">
								<div class="row">
							  <?php foreach($items as $item): ?>						
									<div class="item col-md-4">
										<div class="image">
											<a href="imoveis-detalhes.php?id_imovel=<?php echo $item->id;?>" class="info">
												<h3><?php echo $item->bairro;?></h3>
												<span class="location"><?php echo $item->cidade;?></span>
											</a>
											<img src="<?php echo ADMINURL.$imoveis->getImovelFeaturedIMG($item->id);?>" alt="" height="200"/>
										</div>
										<div class="price">
											<i class="fa fa-home"></i><?php echo $item->operacao;?>
											<span><?php echo moeda($item->valor);?></span>
										</div>
										<ul class="amenities">
											<li><i class="icon-garage"></i> <?php echo $item->garagem;?></li>
											<li><i class="icon-bedrooms"></i> <?php echo $item->quartos;?></li>
											<li><i class="icon-bathrooms"></i> <?php echo $item->banheiros;?></li>
										</ul>
									</div>
								<?php  $i++; if ( $i == 3 ): $i =0;  ?>
								</div><!-- end of Property Set -->		  
								<div class="row">
								<?php endif;?>						
							  <?php endforeach;?>		
								</div><!-- end of Property Set -->		
							</div>								
							<p class="center">
								<a href="imoveis.php?inputLocalizacao=<?php echo $imovel->bairro;?>" class="btn btn-default-color">Ver Mais</a>
							</p>
							<!-- END PROPERTIES ASSIGNED -->						
						  <?php endif;?>					
					</div>
			  
				</div>
				<?php include("sidebar.php");?>	
			</div>
		</div>
	</div>
	<!-- END CONTENT WRAPPER -->		
<?php include("footer.php");?>	