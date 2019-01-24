<script>
            $(function(){
			   window.onload = function(){
				   //Definir o centro do mapa [endereço + elm div]
				   initMap('Rua Maria Matos, 155, Centro, Coronel Fabriciano, MG','map');
				   //Adicionar marcadores  [endereço + descricao html)
				   addMarker('Rua Maria Matos, 155, Centro, Coronel Fabriciano, MG','<img src="assets/img/logo.png" />');
			   }
            })
        </script>
<!-- CONTENT -->
<div id="content">
	<div class="container">
		<div id="main">
            <div class="row">
                <div class="span9">
                    <h1 class="page-header"><?php echo lang('CONTATO');?></h1>
                        <div class="map" id="map" style="height: 350px; width: 100%;"></div>

					<div class="row">
						<div class="span3">
							<h3 class="address"><?php echo lang('ENDERECO');?></h3>
                                <p class="content-icon-spacing">
                                    <?php echo lang('ENDERECO_EMPRESA');?>
                                </p>
						</div>
						<div class="span3">
							<h3 class="call-us"><?php echo lang('TELEFONE');?></h3>
                                <p class="content-icon-spacing">
                                    <?php echo lang('TELEFONE_EMPRESA');?>
                                </p>
						</div>
						<div class="span3">
							<h3 class="email"><?php echo lang('EMAIL');?></h3>
							<p class="content-icon-spacing">
								<a href="mailto:<?php echo lang('EMAIL2_EMPRESA');?>"><?php echo lang('EMAIL2_EMPRESA');?></a>
							</p>
                            </div>
                        </div>
                        <h2><?php echo lang('ENVIEMENSAGEM');?></h2>
                        <form method="post" class="contact-form" action="">
                            <div class="name control-group">
                                <label class="control-label" for="inputContactName">
                                    <?php echo lang('NOME');?>
                                    <span class="form-required" title="<?php echo lang('CAMPOOBRIGATORIO');?>">*</span>
                                </label>
                                <div class="controls">
                                    <input type="text" id="inputContactName">
                                </div><!-- /.controls -->
                            </div><!-- /.control-group -->

                            <div class="email control-group">
                                <label class="control-label" for="inputContactEmail">
                                    <?php echo lang('EMAIL');?>
                                    <span class="form-required" title="<?php echo lang('CAMPOOBRIGATORIO');?>">*</span>
                                </label>
                                <div class="controls">
                                    <input type="text" id="inputContactEmail">
                                </div><!-- /.controls -->
                            </div><!-- /.control-group -->

                            <div class="control-group">
                                <label class="control-label" for="inputContactMessage">
                                    <?php echo lang('MENSAGEM');?>
                                    <span class="form-required" title="<?php echo lang('CAMPOOBRIGATORIO');?>">*</span>
                                </label>

                                <div class="controls">
                                    <textarea id="inputContactMessage"></textarea>
                                </div><!-- /.controls -->
                            </div><!-- /.control-group -->

                            <div class="form-actions">
                                <input type="submit" class="btn btn-primary arrow-right" value="<?php echo lang('ENVIAR');?>">
                            </div><!-- /.form-actions -->
                        </form>
                </div>
                <div class="sidebar span3">
                    <div class="widget properties last">
						<div class="title">
							<h2><?php echo lang('OUTROSIMOVEIS');?></h2>
						</div><!-- /.title -->
						<div class="content">
							<div class="content">
								<?php	$imoveis_row = $imoveis->getImoveis(true, 6);
										if($imoveis_row):
										foreach ($imoveis_row as $exrow):?>	
									<div class="property">
										<div class="image">
											<a href="index.php?do=detalhes&id=<?php echo $exrow->id;?>"></a>
											<img src="<?php echo $imoveis->getPrimeiraImagem($exrow->id);?>" width="270" height="200" alt="">
										</div><!-- /.image -->
										<div class="wrapper">
											<div class="title">
												<h3>
													<a href="index.php?do=detalhes&id=<?php echo $exrow->id;?>"><?php echo $exrow->titulo;?></a>
												</h3>
											</div><!-- /.title -->
											<div class="location"><?php echo $exrow->bairro." - ".$exrow->cidade."/".$exrow->uf;?></div><!-- /.location -->
											<div class="price"><?php echo moeda($exrow->valor);?></div><!-- /.price -->
										</div><!-- /.wrapper -->
									</div><!-- /.property -->
								<?php	endforeach;
										unset($exrow);
										endif;
								?>
							</div><!-- /.content -->
						</div><!-- /.content -->
					</div><!-- /.properties -->           
                </div>
            </div>
        </div>
    </div>
    </div><!-- /#content -->