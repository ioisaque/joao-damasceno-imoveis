<script type='text/javascript'>
	$(document).ready(function() {	
	
	$('#cidades').change(function() {
	  $.ajax({
			type: 'post',
			url: 'buscabairros.php',
			data: 'cidade=' + $('#cidades').val(),
			success: function (msg) {				
				$("#bairros").html('<label class="control-label" for="bairros"><?php echo lang('BAIRRO');?></label><div class="controls"><select name="bairro" id="bairro">'+msg+'</select></div>');
			}
	  });
    });
	
});

</script>
<!-- CONTENT -->
<div id="content">
<div class="container">
	<div id="main">
        <div class="row">
            <div class="span9">
                <h1 class="page-header"><?php echo lang('RELACAOIMOVEIS');?></h1>             
				<div class="properties-rows">
					<div class="row">
						<?php	$imoveis_row = $imoveis->getImoveis(false, 5, true);
								if($imoveis_row):
								foreach ($imoveis_row as $row):?>	
									<div class="property span9">
										<div class="row">
											<div class="image span3">
												<div class="content">
													<a href="index.php?do=detalhes&id=<?php echo $row->id;?>"></a>
													<img src="<?php echo $imoveis->getDestaque($row->id);?>" width="270" height="200" alt="">
												</div><!-- /.content -->
											</div><!-- /.image -->

											<div class="body span6">
												<div class="title-price row">
													<div class="title span4">
														<h2><a href="index.php?do=detalhes&id=<?php echo $row->id;?>"><?php echo cleanSanitize($row->titulo, 15);?></a></h2>
													</div><!-- /.title -->

													<div class="price">
														<?php echo ($row->vervalor) ? moeda($row->valor) : "Consulte-nos";?>
													</div><!-- /.price -->
												</div><!-- /.title -->

												<div class="location"><?php echo cleanSanitize($row->bairro." - ".$row->cidade, 20);?></div><!-- /.location -->
												<p><?php echo cleanOut($row->descricao);?></p>
												<div class="area">
													<span class="key"><?php echo lang('AREA');?>:</span><!-- /.key -->
													<span class="value"><?php echo $row->area;?>m<sup>2</sup></span><!-- /.value -->
												</div><!-- /.area -->	
												<div class="bathrooms"><div class="content"><?php echo $row->banheiros;?></div></div><!-- /.bathrooms -->		
												<div class="bedrooms"><div class="content"><?php echo $row->quartos + $row->suites;?></div></div><!-- /.bedrooms -->									
											</div><!-- /.body -->
										</div><!-- /.property -->
									</div><!-- /.row -->
						<?php	endforeach;
								unset($row);
								endif;?>
					</div><!-- /.row -->
				</div><!-- /.properties-rows -->
                <?php echo $pager->display_pages();?><!-- /.pagination -->            
			</div>
			<div style="height:80px"></div>
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
											
											<div class="location control-group">
												<label class="control-label" for="inputBairro">
													Bairro
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
													<option value="" selected="selected">TODOS</option>
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
														<input type="checkbox" id="inputAluguel" name="inputAluguel" value="1"> Aluguel
													</label>
												</div><!-- /.controls -->
											</div><!-- /.control-group -->

											<div class="sale control-group">
												<div class="controls">
													<label class="checkbox" for="inputVenda">
														<input type="checkbox" id="inputVenda" name="inputVenda" value="1"> Venda
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
												<input type="hidden" name="do" value="imoveis">
												<input type="submit" value="Buscar" class="btn btn-primary btn-large">
											</div><!-- /.form-actions -->
										</form>
									</div><!-- /.content -->
								</div><!-- /.property-filter -->
							</div><!-- /.span3 -->
        </div>
    </div>
</div>
</div><!-- /#content -->