<?php 
	$id = get('id');
	if($id):
	$row = $imoveis->getImovel($id);
	$imagens_row = $imoveis->getImagens($id);
?>
<!-- CONTENT -->
<div id="content">
	<div class="container">
		<div id="main">
			<div class="row">
				<div class="span9">
					<h1 class="page-header"><?php echo $row->titulo;?></h1>
					<div class="carousel property">
						<div class="preview">
							<img src="<?php echo $imoveis->getSlide($row->id);?>" alt="">
						</div><!-- /.preview -->
						<div class="content">
							<a class="carousel-prev" href="#"><?php echo lang('ANTERIOR');?></a>
							<a class="carousel-next" href="#"><?php echo lang('PROXIMO');?></a>
							<ul>
								<?php	if($imagens_row): 
										foreach ($imagens_row as $exrow):?>	
									<li>
										<img src="<?php echo Registry::get("Core")->site_sistema."/uploads/data/".$exrow->nome;?>" alt="">
									</li>
								<?php	endforeach;
										unset($exrow);
										endif;?>
							</ul>
						</div><!-- /.content -->
					</div><!-- /.carousel -->
					<div class="property-detail">
						<table><tr><td>
							<div class="pull-left overview">
								<div class="row">
									<div class="span3">
										<h2><?php echo lang('DETALHES');?></h2>

										<table>
											<tr>
												<th><?php echo lang('PRECO');?>:</th>
												<td><?php echo ($row->vervalor) ? moeda($row->valor) : "Consulte-nos";?></td>
											</tr>
											<tr>
												<th><?php echo lang('OPERACAO');?>:</th>
												<td><?php echo $row->operacao;?></td>
											</tr>
											<tr>
												<th><?php echo lang('TIPO');?>:</th>
												<td><?php echo $row->tipo;?></td>
											</tr>
											<tr>
												<th><?php echo lang('ENDERECO');?>:</th>
												<td><?php if($row->verendereco) echo $row->endereco.", ".$row->numero." - ".$row->complemento."<br/>";echo $row->bairro." - ".$row->cidade."/".$row->uf;?></td>
											</tr>
											<tr>
												<th><?php echo lang('SUITES');?>:</th>
												<td><?php echo $row->suites;?></td>
											</tr>
											<tr>
												<th><?php echo lang('QUARTOS');?>:</th>
												<td><?php echo $row->quartos;?></td>
											</tr>
											<tr>
												<th><?php echo lang('BANHEIROS');?>:</th>
												<td><?php echo $row->banheiros;?></td>
											</tr>
											<tr>
												<th><?php echo lang('AREA');?>:</th>
												<td><?php echo $row->area;?>m<sup>2</sup></td>
											</tr>
											<tr>
												<th><?php echo lang('GARAGEM');?>:</th>
												<td><?php echo $row->garagem;?></td>
											</tr>
										</table>
									</div><!-- /.span2 -->
								</div><!-- /.row -->
							</div>
							<p><?php echo cleanOut($row->descricao);?></p>
						</td></tr><tr><td>						
							<h2><?php echo lang('CARACTERISTICASIMOVEL');?></h2>
							<div class="row">
								<ul class="span2">
									<li class="<?php echo ($row->suites) ? "checked" : "plain";?>">
										<?php echo lang('SUITES');?>
									</li>
									<li class="<?php echo ($row->garagem) ? "checked" : "plain";?>">
										<?php echo lang('GARAGEM');?>
									</li>
								</ul>
								<ul class="span2">
									<li class="<?php echo ($row->piscina) ? "checked" : "plain";?>">
										<?php echo lang('PISCINA');?>
									</li>
									<li class="<?php echo ($row->churrasqueira) ? "checked" : "plain";?>">
										<?php echo lang('CHURRASQUEIRA');?>
									</li>
								</ul>
								<ul class="span2">
									<li class="<?php echo ($row->elevador) ? "checked" : "plain";?>">
										<?php echo lang('ELEVADOR');?>
									</li>
									<li class="<?php echo ($row->portao) ? "checked" : "plain";?>">
										<?php echo lang('PORTAOELETRONICO');?>
									</li>
								</ul>
								<ul class="span2">
									<li class="<?php echo ($row->armario) ? "checked" : "plain";?>">
										<?php echo lang('ARMARIOSCOZINHA');?>
									</li>
									<li class="<?php echo ($row->guardaroupa) ? "checked" : "plain";?>">
										<?php echo lang('GUARDAROUPAS');?>
									</li>
								</ul>
							</div>
						</td></tr><tr><td>		
							<div class="row">
								<ul class="span2">
									<li class="checked">
										<?php echo lang('POSSUI');?>
									</li>
								</ul>
								<ul class="span2">
									<li class="plain">
										<?php echo lang('NAOPOSSUI');?>
									</li>
								</ul>
							</div>
						</td></tr></table>
					</div>
				</div>
				<div class="sidebar span3">
					<div class="widget properties last">
						<div class="title">
							<h2><?php echo lang('OUTROSIMOVEIS');?></h2>
						</div><!-- /.title -->
						<div class="content">
							<div class="content">
								<?php	$imoveis_row = $imoveis->getImoveis(true, 8);
										if($imoveis_row):
										foreach ($imoveis_row as $exrow):?>	
									<div class="property">
										<div class="image">
											<a href="index.php?do=detalhes&id=<?php echo $exrow->id;?>"></a>
											<img src="<?php echo $imoveis->getDestaque($exrow->id);?>" width="270" height="200" alt="">
										</div><!-- /.image -->
										<div class="wrapper">
											<div class="title">
												<h3>
													<a href="index.php?do=detalhes&id=<?php echo $exrow->id;?>"><?php echo cleanSanitize($exrow->titulo, 10);?></a>
												</h3>
											</div><!-- /.title -->
											<div class="location"><?php echo cleanSanitize($exrow->bairro." - ".$exrow->cidade, 15);?></div><!-- /.location -->
											<div class="price"><?php echo ($exrow->vervalor) ? moeda($exrow->valor) : "Consulte-nos";?></div><!-- /.price -->
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
<?php else:
	  redirecionar("index.php?do=404");
	  endif;
?>