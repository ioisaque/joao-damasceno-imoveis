<!-- BEGIN HOME ADVANCED SEARCH (class="gray" for a gray background) -->
<div id="home-advanced-search" class="gray open">
	<div id="opensearch"></div>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<form method="GET" action="imoveis.php">
					<div class="form-group">
					
						<div class="form-control-large">							
						  <input type="text" class="form-control" name="inputLocalizacao" placeholder="<?php echo lang('CIDADE_OU_BAIRRO'); ?>">
						</div>
						
							<div class="form-control-large">
							  <select id="inputTipo" name="inputTipo" data-placeholder="<?php echo lang('TIPO'); ?>">
								<option value=""> </option>
								<?php $items = $imoveis->getImoveisTipos(); ?>
								<?php if ($items): ?>
								  <?php foreach($items as $ex): ?>
									<option value="<?php echo $ex->id;?>"><?php echo $ex->tipo;?></option>
								  <?php endforeach; ?>
								<?php endif; ?>
							  </select>								
							</div>							
						
						<div class="form-control-small">
							<select id="inputGaragem" name="inputGaragem" data-placeholder="<?php echo lang('GARAGEM') .'(s)'; ?>">
								<option value=""> </option>
								<option value="= 0">0</option>
								<option value="= 1">1</option>
								<option value="= 2">2</option>
								<option value="= 3">3</option>
								<option value="= 4">4</option>
								<option value="= 5">5</option>
								<option value="> 5">5+</option>
							</select>
						</div>
						
						<div class="form-control-small">
							<select id="inputQuartos" name="inputQuartos" data-placeholder="<?php echo lang('QUARTO') .'(s)'; ?>">
								<option value=""> </option>
								<option value="= 0">0</option>
								<option value="= 1">1</option>
								<option value="= 2">2</option>
								<option value="= 3">3</option>
								<option value="= 4">4</option>
								<option value="= 5">5</option>
								<option value="> 5">5+</option>
							</select>
						</div>
						
						<div class="form-control-small">
							<select id="inputBanheiros" name="inputBanheiros" data-placeholder="<?php echo lang('BANHEIRO') .'(s)'; ?>">
								<option value=""> </option>
								<option value="= 0">0</option>
								<option value="= 1">1</option>
								<option value="= 2">2</option>
								<option value="= 3">3</option>
								<option value="= 4">4</option>
								<option value="> 4">4+</option>
							</select>
						</div>							
						
						<div class="form-control-small">
							<select id="inputOperacao" name="inputOperacao" data-placeholder="<?php echo lang('DISP_PARA'); ?>">
								<option value=""> </option>
								<option value="venda"><?php echo lang('VENDA'); ?></option>
								<option value="aluguel"><?php echo lang('ALUGUEL'); ?></option>
							</select>
						</div>							
						
						<div class="form-control-small">
							<select id="inputPrecoMinimo" name="inputPrecoMinimo" data-placeholder="<?php echo lang('PRECO_MIN'); ?>">
								<option value=""> </option>
								<option value="0">$0</option>
								<option value="25000">$25000</option>
								<option value="50000">$50000</option>
								<option value="75000">$75000</option>
								<option value="100000">$100000</option>
								<option value="150000">$150000</option>
								<option value="200000">$200000</option>
								<option value="300000">$300000</option>
								<option value="500000">$500000</option>
								<option value="750000">$750000</option>
								<option value="1000000">$1000000</option>
							</select>
						</div>
						
						<div class="form-control-small">
							<select id="inputPrecoMaximo" name="inputPrecoMaximo" data-placeholder="<?php echo lang('PRECO_MAX'); ?>">
								<option value=""> </option>
								<option value="25000">$25000</option>
								<option value="50000">$50000</option>
								<option value="75000">$75000</option>
								<option value="100000">$100000</option>
								<option value="150000">$150000</option>
								<option value="200000">$200000</option>
								<option value="300000">$300000</option>
								<option value="500000">$500000</option>
								<option value="750000">$750000</option>
								<option value="1000000">$1000000</option>
								<option value="1000000plus">>$1000000</option>
							</select>
						</div>
						
						<div class="col-sm-12">							
						  <button type="submit" class="btn btn-fullcolor"><?php echo lang('PROCURAR'); ?></button>
						</div>
						
					</div>
				</form>

			</div>
		</div>
	</div>
</div>
<!-- END HOME ADVANCED SEARCH -->
