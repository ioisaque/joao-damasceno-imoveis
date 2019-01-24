<!DOCTYPE html>
<?php
  /**
   * Index
   *
   * @package Sistemas Folha do Comércio
   * @author Geandro Bessa
   * @copyright 2013
   */
  if (!defined("_VALID_PHP"))
      die('O acesso direto a está página não é permitido');
  
  require_once("init.php");
?>

</div><!-- /#wrapper-inner -->
<div id="footer-wrapper">
    <div id="footer-top">
        <div id="footer-top-inner" class="container">
            <div class="row">
                <div class="widget properties span3">
                    <div class="title">
                        <h2><?php echo lang('MAISRECENTES');?></h2>
                    </div><!-- /.title -->
						<div class="content">
							<div class="content">
								<?php	$imoveis_row = $imoveis->getImoveisDestaque(true, 3);
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
										endif;?>
							</div><!-- /.content -->
						</div><!-- /.content -->
					</div><!-- /.properties-small -->

                <div class="widget span3">
                    <div class="title">
                        <h2><?php echo lang('FALECONOSCO');?></h2>
                    </div><!-- /.title -->

                    <div class="content">
                        <table class="contact">
                            <tbody>
                            <tr>
                                <th class="address"><?php echo lang('ENDERECO');?>:</th>
                                <td><?php echo lang('ENDERECO_EMPRESA');?></td>
                            </tr>
                            <tr>
                                <th class="phone"><?php echo lang('TELEFONE');?>:</th>
                                <td><?php echo lang('TELEFONE_EMPRESA');?></td>
                            </tr>
                            <tr>
                                <th class="email"><?php echo lang('EMAIL');?>:</th>
                                <td><a href="mailto:<?php echo lang('EMAIL_EMPRESA');?>"><?php echo lang('EMAIL_EMPRESA');?></a></td>
                            </tr>
                            <tr>
                                <th class="gps"><?php echo lang('GPS');?>:</th>
                                <td><?php echo lang('GPS_EMPRESA');?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div><!-- /.content -->
                </div><!-- /.widget -->

                <div class="widget span3">
                    <div class="title">
                        <h2 class="block-title"><?php echo lang('TITULO_LINKS');?></h2>
                    </div><!-- /.title -->

                    <div class="content">
                        <ul class="menu nav">
                            <li class="first leaf"><a href="http://www.planalto.gov.br/ccivil_03/Leis/L8245.htm" target="_blank" ><?php echo lang('INQUILIANTO_LINKS');?></a></li>
							<li class="leaf"><a href="http://www.planalto.gov.br/ccivil_03/LEIS/L4591.htm" target="_blank" ><?php echo lang('CONDOMINIO_LINKS');?></a></li>
                            <li class="leaf"><a href="http://www.planalto.gov.br/ccivil_03/leis/2002/l10406.htm" target="_blank" ><?php echo lang('CIVIL_LINKS');?></a></li>
                            <li class="leaf"><a href="http://www.planalto.gov.br/ccivil_03/leis/L8078.htm" target="_blank" ><?php echo lang('CONSUMIDOR_LINKS');?></a></li>
                            <li class="leaf"><a href="http://www.crecimg.gov.br/" target="_blank" ><?php echo lang('CORRETORES_LINKS');?></a></li>
                            <li class="leaf"><a href="http://www.crea-mg.org.br/" target="_blank" ><?php echo lang('CREA_LINKS');?></a></li>
                            <li class="leaf"><a href="http://www.receita.fazenda.gov.br/" target="_blank" ><?php echo lang('RECEITA_LINKS');?></a></li>
                        </ul>
                    </div><!-- /.content -->
                </div><!-- /.widget -->

                <div class="widget span3">
                    <div class="title">
                        <h2 class="block-title"><?php echo lang('ENVIEMENSAGEM');?></h2>
                    </div><!-- /.title -->

                    <div class="content">
                        <form method="post">
                            <div class="control-group">
                                <label class="control-label" for="inputName">
                                    <?php echo lang('NOME');?>
                                    <span class="form-required" title="<?php echo lang('CAMPOOBRIGATORIO');?>">*</span>
                                </label>
                                <div class="controls">
                                    <input type="text" id="inputName">
                                </div><!-- /.controls -->
                            </div><!-- /.control-group -->

                            <div class="control-group">
                                <label class="control-label" for="inputEmail">
                                    <?php echo lang('EMAIL');?>
                                    <span class="form-required" title="<?php echo lang('CAMPOOBRIGATORIO');?>">*</span>
                                </label>
                                <div class="controls">
                                    <input type="text" id="inputEmail">
                                </div><!-- /.controls -->
                            </div><!-- /.control-group -->

                            <div class="control-group">
                                <label class="control-label" for="inputMessage">
                                    <?php echo lang('MENSAGEM');?>
                                    <span class="form-required" title="<?php echo lang('CAMPOOBRIGATORIO');?>">*</span>
                                </label>

                                <div class="controls">
                                    <textarea id="inputMessage"></textarea>
                                </div><!-- /.controls -->
                            </div><!-- /.control-group -->

                            <div class="form-actions">
                                <input type="submit" class="btn btn-primary arrow-right" value="<?php echo lang('ENVIAR');?>">
                            </div><!-- /.form-actions -->
                        </form>
                    </div><!-- /.content -->
                </div><!-- /.widget -->
            </div><!-- /.row -->
        </div><!-- /#footer-top-inner -->
    </div><!-- /#footer-top -->

    <div id="footer" class="footer container">
        <div id="footer-inner">
            <div class="row">
                <div class="span6 copyright">
                    <p><a href="http://www.divulgacaoonline.com.br"><img src="http://www.divulgacaoonline.com.br/footer.png" alt=""></a></p>
                </div><!-- /.copyright -->

                <div class="span6 share">
                    <div class="content">
                        <ul class="menu nav">
                            <li class="first leaf"><a href="http://www.facebook.com/" class="facebook">Facebook</a></li>
                            <li class="leaf"><a href="http://flickr.net/" class="flickr">Flickr</a></li>
                            <li class="leaf"><a href="http://plus.google.com/" class="google">Google+</a></li>
                        </ul>
                    </div><!-- /.content -->
                </div><!-- /.span6 -->
            </div><!-- /.row -->
        </div><!-- /#footer-inner -->
    </div><!-- /#footer -->
</div><!-- /#footer-wrapper -->
</div><!-- /#wrapper -->
</div><!-- /#wrapper-outer -->
</body>
</html>
