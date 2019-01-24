<?php include("header.php");?>	
	<!-- BEGIN PAGE TITLE/BREADCRUMB -->
	<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h1 class="page-title"><?php echo lang('IMOVEIS'); ?></h1>
					
					<ul class="breadcrumb">
						<li><a href="index.php"><?php echo lang('INICIO'); ?> </a></li>
						<li><a href="imoveis.php"><?php echo lang('IMOVEIS'); ?></a></li>
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
			
				<!-- BEGIN MAIN CONTENT -->
				<div class="main col-sm-8">
				
					<div id="listing-header" class="clearfix">							
						<!--<div class="sort">
							<ul>
							  <?php if(get('ordem') == "DESC"){ ?>
								<li><a href="?ordem=ASC"><i title="Ordem Crescente" class="fa fa-chevron-up" data-toggle="tooltip" data-placement="top"></i></a></li>								
								<li class="active"><a href="?ordem=DESC"><i title="Ordem Decrescente" class="fa fa-chevron-down" data-toggle="tooltip" data-placement="top"></i></a></li>
							  <?php }else{ ?>
								<li class="active"><a href="?ordem=ASC"><i title="Ordem Crescente" class="fa fa-chevron-up" data-toggle="tooltip" data-placement="top"></i></a></li>								
								<li><a href="?ordem=DESC"><i title="Ordem Decrescente" class="fa fa-chevron-down" data-toggle="tooltip" data-placement="top"></i></a></li>								  
							  <?php } ?>									
							</ul>
						</div>-->
						
						<div class="view-mode">
							<ul>
								<li data-view="grid-style1" data-target="property-listing" class="active"><i class="fa fa-th"></i></li>
								<li data-view="list-style" data-target="property-listing"><i class="fa fa-th-list"></i></li>
							</ul>
						</div>
					</div>
					
					<!-- BEGIN PROPERTY LISTING -->
					<div id="property-listing" class="grid-style1 clearfix">
					  <?php $items = $imoveis->getImoveis(); ?>
					  <?php if($items): ?>
					  <?php $i =0; ?>		  
						<div class="row">
					  <?php foreach($items as $item): ?>							
						  <!-- Property Set -->
							<div class="item col-md-4">
								<div class="image">
									<a href="imoveis-detalhes.php?id_imovel=<?php echo $item->id;?>">
										<span class="btn btn-default"><i class="fa fa-file-o"></i> <?php echo lang('DETALHES'); ?></span>
									</a>
									<img src="<?php echo ADMINURL.$imoveis->getImovelFeaturedIMG($item->id);?>" height="200" alt="" />
								</div>
								<div class="price">
									<i class="fa fa-home"></i><?php echo $item->operacao;?>
									<?php if ($item->vervalor):?>
									  <span><?php echo moeda($item->valor);?></span>
									<?php endif;?>
								</div>
								<div class="info">
									<h3>
										<a href="imoveis-detalhes.php?id_imovel=<?php echo $item->id;?>"><?php echo $item->titulo;?></a>
										<!--<small>Upper East Side, New York</small>-->
									</h3>
									<p><?php echo cleanOut($item->descricao);?></p>
								
									<ul class="amenities">
										<li><i class="icon-garage"></i> <?php echo $item->garagem;?></li>
										<li><i class="icon-bedrooms"></i> <?php echo $item->quartos;?></li>
										<li><i class="icon-bathrooms"></i> <?php echo $item->banheiros;?></li>
									</ul>
								</div>
							</div>
							
						<?php  $i++; if ( $i == 3 ): $i =0;  ?>
						</div><!-- end of Property Set -->		  
						<div class="row">
						<?php endif;?>						
					  <?php endforeach;?>		
						</div><!-- end of Property Set -->				
					  <?php else: ?>
					  <div class="row">
						<h4><?php echo lang('MSG_ERRO_IMOVEIS'); ?></h1>
					  </div>
					  <?php endif;?>
					</div>
					<!-- END PROPERTY LISTING -->
					
					
					<!-- BEGIN PAGINATION  COUNT -->
					  <?php $array = $imoveis->getImoveisPagination(); ?>
					  <?php $PAGE = 1 + intval($array['PAGE']); ?>					  
					  <?php $ITEMS_PP = $array['ITEMS_PP']; ?>					  
					  <?php $pages = $imoveis->getImoveisCount() / $ITEMS_PP; ?>				  
					  
					  <?php if($pages > 1): ?>
						<div class="pagination">
							<ul id="previous">
								<li><a href="<?php echo $imoveis->setImoveisFilter('page', intval($PAGE)-1);?>"><i class="fa fa-chevron-left"></i></a></li>
							</ul>
							<ul>								
								<?php for($i=1; $i < $pages; $i++): ?>
								  <?php if($i == $PAGE) { ?>
									<li class="active"><a href="<?php echo $imoveis->setImoveisFilter('page', $i);?>"><?php echo $i;?></a></li>
								  <?php }else{?>
									<li><a href="<?php echo $imoveis->setImoveisFilter('page', $i);?>"><?php echo $i;?></a></li>
								<?php } endfor;?>								
							</ul>
							<ul id="next">
								<li><a href="<?php echo $imoveis->setImoveisFilter('page', $PAGE+1);?>"><i class="fa fa-chevron-right"></i></a></li>
							</ul>
						</div>
					  <?php endif;?>
					<!-- END PAGINATION -->
					
				</div>	
				<!-- END MAIN CONTENT -->
				
			<?php include("sidebar.php");?>			

			</div>
		</div>
	</div>
	<!-- END CONTENT WRAPPER -->		
<?php include("footer.php");?>