<script type='text/javascript'>
	$(document).ready(function() {
	
	$('#inputCidade').change(function() {
		$('#inputBairro').val('<option value="0">Carregando...</option>');
		
		$.post("buscabairros.php", {cidade:$('#inputCidade').val()},
			function(valor){
				$("#inputBairro").innerHTML = (valor);
				})
		}
	);
});
</script>

<?php $imoveis_row = $imoveis->getImoveisDestaque();
	  $destaques_row = $imoveis->getImoveisDestaque(true, 3, true);?>
<!-- CONTENT -->
<div id="content">
<div class="container">
<div id="main">
	<?php if($imoveis_row):
			$destaques = array();
			$coluna = array();
			$todos = array();
			$cont = 0;
			foreach ($imoveis_row as $row) {
				if($cont < 6) {
					$destaques[] = $row;
				} elseif($cont < 11) {
					$coluna[] = $row;
				} else {
					$todos[] = $row;
				}
				$cont++;
			}
			unset($row);
	?>
			<div class="slider-wrapper">
				<div class="slider">
					<div class="slider-inner">
						<div class="row">
							<div class="images span9">
								<div class='iosSlider'>
									<div class='slider-content'>
										<?php foreach ($destaques_row as $row):?>
													<div class="slide">
														<img src="<?php echo $imoveis->getSlide($row->id);?>" alt="">
														<div class="slider-info">
															<div class="price">
																<h2><?php echo ($row->vervalor) ? moeda($row->valor) : "Consulte-nos";?></h2>
																<a href="index.php?do=detalhes&id=<?php echo $row->id;?>">Veja mais</a>
															</div><!-- /.price -->
															<h2><a href="index.php?do=detalhes&id=<?php echo $row->id;?>"><span style="color: #9bc9fd;"><?php echo cleanSanitize($row->titulo, 30);?></span></a></h2>
															<div class="bathrooms"><?php echo $row->banheiros;?></div><!-- /.bathrooms -->
															<div class="bedrooms"><?php echo $row->quartos + $row->suites;?></div><!-- /.bedrooms -->
														</div><!-- /.slider-info -->
													</div><!-- /.slide -->
										<?php	endforeach;
												unset($row);?>
									</div><!-- /.slider-content -->
								</div><!-- .iosSlider -->

								<ul class="navigation">
									<li class="active"><a>1</a></li>
									<li><a>2</a></li>
									<li><a>3</a></li>
								</ul><!-- /.navigation-->
							</div><!-- /.images -->
							<div class="span3">
								<div class="property-filter">
									<div class="content">
										<form method="get" action="">
											<div class="location control-group">
												<label class="control-label" for="inputCidade">
													Cidade
												</label>
												<div class="controls">	
													<select id="inputCidade" name="inputCidade">
													<?php $listacidades = $imoveis->getCidades();?>
													<?php if ($listacidades):?>
													<?php foreach ($listacidades as $exrow):?>													
														<option value="<?php echo $exrow->cidade;?>"><?php echo $exrow->cidade;?></option>
													<?php endforeach;?>
													<?php unset($exrow);?>
													<?php endif;?>
													</select>
												</div><!-- /.controls -->
											</div><!-- /.control-group -->
											
											<div class="control-group">
												<label class="control-label" for="inputBairro">
													Bairro1
												</label>
												<div class="controls">
													<select id="inputBairro" name="inputBairro">
													</select>
												</div><!-- /.controls -->
											</div><!-- /.control-group -->

											<div class="type control-group">
												<label class="control-label" for="inputTipo">
													Tipo
												</label>
												<div class="controls">
													<select id="inputTipo" name="inputTipo">
													<?php $listatipos = $imoveis->getTipo();?>
													<?php if ($listatipos):?>
													<?php foreach ($listatipos as $exrow):?>													
														<option value="<?php echo $exrow->id;?>"><?php echo $exrow->tipo;?></option>
													<?php endforeach;?>
													<?php unset($exrow);?>
													<?php endif;?>
													</select>
												</div><!-- /.controls -->
											</div><!-- /.control-group -->

											<div class="rent control-group">
												<div class="controls">
													<label class="checkbox" for="inputAluguel">
														<input type="checkbox" id="inputAluguel" value="1"> Aluguel
													</label>
												</div><!-- /.controls -->
											</div><!-- /.control-group -->

											<div class="sale control-group">
												<div class="controls">
													<label class="checkbox" for="inputVenda">
														<input type="checkbox" id="inputVenda" value="1"> Venda
													</label>
												</div><!-- /.controls -->
											</div><!-- /.control-group -->

											<div class="price-from control-group">
												<label class="control-label" for="inputPrecoMinimo">
													Preço Mínimo
												</label>
												<div class="controls">
													<input type="text" id="inputPrecoMinimo" name="inputPrecoMinimo">
												</div><!-- /.controls -->
											</div><!-- /.control-group -->

											<div class="price-to control-group">
												<label class="control-label" for="inputPrecoMaximo">
													Preço Máximo
												</label>
												<div class="controls">
													<input type="text" id="inputPrecoMaximo" name="inputPrecoMaximo">
												</div><!-- /.controls -->
											</div><!-- /.control-group -->

											<div class="price-value">
												<span class="from"></span><!-- /.from -->
												-
												<span class="to"></span><!-- /.to -->
											</div><!-- /.price-value -->

											<div class="price-slider">
											</div><!-- /.price-slider -->

											<div class="form-actions">
												<input type="submit" value="Buscar" class="btn btn-primary btn-large">
											</div><!-- /.form-actions -->
										</form>
									</div><!-- /.content -->
								</div><!-- /.property-filter -->
							</div><!-- /.span3 -->
						</div><!-- /.row -->
					</div><!-- /.slider-inner -->
				</div><!-- /.slider -->
			</div><!-- /.slider-wrapper -->
			<div class="row">
				<div class="span9">
					<h1 class="page-header"><?php echo lang('DESTAQUES');?></h1>
					<div class="properties-grid">
						<div class="row">
							<?php foreach ($destaques as $row):?>	
							<div class="property span3">
								<div class="image">
									<div class="content">
										<a href="index.php?do=detalhes&id=<?php echo $row->id;?>"></a>
										<img src="<?php echo $imoveis->getDestaque($row->id);?>" width="270" height="200" alt="">
									</div><!-- /.content -->
									<div class="price"><?php echo ($row->vervalor) ? moeda($row->valor) : "Consulte-nos";?></div><!-- /.price -->
									<?php if ($row->operacao):?>
									<div class="reduced"><?php echo $row->operacao;?> </div><!-- /.reduced -->
									<?php endif;?>
								</div><!-- /.image -->
								<div class="title">
									<h2><a href="index.php?do=detalhes&id=<?php echo $row->id;?>"><?php echo cleanSanitize($row->titulo, 15);?></a></h2>
								</div><!-- /.title -->
								<div class="location"><?php echo cleanSanitize($row->bairro." - ".$row->cidade, 20);?></div><!-- /.location -->
								<div class="area">
									<span class="key"><?php echo lang('AREA');?>:</span><!-- /.key -->
									<span class="value"><?php echo $row->area;?>m<sup>2</sup></span><!-- /.value -->
								</div><!-- /.area -->
								<div class="bedrooms"><div class="content"><?php echo $row->quartos + $row->suites;?></div></div><!-- /.bedrooms -->
								<div class="bathrooms"><div class="content"><?php echo $row->banheiros;?></div></div><!-- /.bathrooms -->
							</div><!-- /.property -->
							<?php	endforeach;
									unset($row);?>
						</div><!-- /.row -->
					</div><!-- /.properties-grid -->
				</div>
				<div class="sidebar span3">
					<div class="widget our-agents">
						<div class="title">
							<h2><?php echo lang('ATENDIMENTO');?></h2>
						</div><!-- /.title -->
						<div class="content">
							<img src="assets/img/atendimento.jpg" alt="">
						</div><!-- /.content -->
					</div><!-- /.our-agents -->
					<div class="hidden-tablet">
						<div class="widget properties last">
							<div class="content">
								<?php foreach ($coluna as $row):?>	
								<div class="property">
									<div class="image">
										<a href="index.php?do=detalhes&id=<?php echo $row->id;?>"></a>
										<img src="<?php echo $imoveis->getDestaque($row->id);?>" width="270" height="200" alt="">
									</div><!-- /.image -->
									<div class="wrapper">
										<div class="title">
											<h3>
												<a href="index.php?do=detalhes&id=<?php echo $row->id;?>"><?php echo cleanSanitize($row->titulo, 10);?></a>
											</h3>
										</div><!-- /.title -->
										<div class="location"><?php echo cleanSanitize($row->bairro." - ".$row->cidade, 15);?></div><!-- /.location -->
										<div class="price"><?php echo ($row->vervalor) ? moeda($row->valor) : "Consulte-nos";?></div><!-- /.price -->
									</div><!-- /.wrapper -->
								</div><!-- /.property -->
								<?php	endforeach;
										unset($row);?>
							</div><!-- /.content -->
						</div><!-- /.properties -->
					</div>
				</div>
			</div>
	<?php endif;?>
</div>
</div>
<div style="height:30px"></div>
	<div class="bottom-wrapper">
		<div class="bottom container">
			<div class="bottom-inner row">
				<div class="item span4">
					<div class="address decoration"></div>
					<h2><a><?php echo lang('ENCONTRESEUIMOVEL');?></a></h2>
					<p><?php echo lang('DESC_ENCONTRESEUIMOVEL');?></p>
					<a href="#" class="btn btn-primary"><?php echo lang('LEIAMAIS');?></a>
				</div><!-- /.item -->

				<div class="item span4">
					<div class="gps decoration"></div>
					<h2><a><?php echo lang('SOLICITESEUIMOVEL');?></a></h2>
					<p><?php echo lang('DESC_SOLICITESEUIMOVEL');?></p>
					<a href="#" class="btn btn-primary"><?php echo lang('LEIAMAIS');?></a>
				</div><!-- /.item -->

				<div class="item span4">
					<div class="key decoration"></div>
					<h2><a><?php echo lang('SOBREIMOVEIS');?></a></h2>
					<p><?php echo lang('DESC_SOBREIMOVEIS');?></p>
					<a href="#" class="btn btn-primary"><?php echo lang('LEIAMAIS');?></a>
				</div><!-- /.item -->
			</div><!-- /.bottom-inner -->
		</div><!-- /.bottom -->
	</div><!-- /.bottom-wrapper -->
</div><!-- /#content -->