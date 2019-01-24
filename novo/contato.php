<?php include("header.php");?>
	<!-- BEGIN PAGE TITLE/BREADCRUMB -->
	<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h1 class="page-title"><?php echo lang('CONTATO'); ?></h1>
					
					<ul class="breadcrumb">
						<li><a href="index.php"><?php echo lang('INICIO'); ?> </a></li>
						<li><a href="contato.php"><?php echo lang('CONTATO'); ?> </a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!-- END PAGE TITLE/BREADCRUMB -->
	
	
	<!-- BEGIN CONTENT WRAPPER -->
	<div class="content contacts">
	
		<div id="contacts_map"></div>
		
		<div class="container">
			<div class="row">
			
				<div id="contacts-overlay" class="col-sm-7">
					<i id="contacts-overlay-close" class="fa fa-minus"></i>
					
					<ul class="col-sm-6">
						<li><i class="fa fa-map-marker"></i> <?php echo lang('EMPRESA_ENDERECO'); ?></li>
						<li><i class="fa fa-envelope"></i> <a href="mailto:<?php echo lang('EMPRESA_EMAIL'); ?>"><?php echo lang('EMPRESA_EMAIL'); ?></a></li>
					</ul>
					
					<ul class="col-sm-6">
						<li><i class="fa fa-phone"></i> <?php echo lang('TELEFONE'); ?>: <?php echo lang('EMPRESA_TEL'); ?></li>
					</ul>
				</div>
				
				<!-- BEGIN MAIN CONTENT -->
				<div class="main col-sm-4 col-sm-offset-8">
					<h2 class="section-title"><?php echo lang('FALE_COM_A_GENTE'); ?></h2>
					<p class="col-sm-12 center">
					  nos envie um recado<br>
					  <strong>Queremos saber a sua opinião</strong>
					</p>
					
					<form id="contato-form" action="#">					
						<div class="col-sm-12">
							<input type="text" name="nome" id="nome" placeholder="<?php echo lang('SEU_NOME'); ?>" class="form-control required fromName" />
						
							<input type="email" name="email" id="email" placeholder="<?php echo lang('SEU_EMAIL'); ?>" class="form-control required fromEmail"  />
						
							<input type="text" name="assunto" id="assunto" placeholder="<?php echo lang('SEU_ASSUNTO'); ?>" class="form-control required subject"  />
							<textarea name="mensagem" id="mensagem" placeholder="<?php echo lang('SUA_MENSAGEM'); ?>" class="form-control required"></textarea> 
						</div>
						
						<div class="center">
							<a class="btn btn-default-color btn-lg submit_form" id="submit"><i class="fa fa-envelope"></i> <?php echo lang('ENVIAR_MSG'); ?></a>
						</div>
					</form>
				</div>	
				<!-- END MAIN CONTENT -->

			</div>
		</div>
	</div>
	<!-- END CONTENT WRAPPER -->	
<?php include("footer.php");?>	