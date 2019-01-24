            <!-- CONTENT -->
            <div id="content">
<div class="container">
    <div>
        <div id="main">
            <div class="list-your-property-form">
    <h2 class="page-header"><?php echo lang('VENDA_AQUI');?></h2>

    <div class="content">
        <div class="row">
            <div class="span8">
                <p>
                    <?php echo lang('PREENCHAFORMULARIO');?>
                </p>
            </div><!-- /.span8 -->
        </div><!-- /.row -->

        <form method="post" action="" enctype="multipart/form-data">
            <div class="row">
                <div class="span4">
                    <h3><strong>1.</strong> <span><?php echo lang('INFPESSOAL');?></span></h3>

                    <div class="control-group">
                        <label class="control-label" for="inputPropertyFirstName">
                            <?php echo lang('PRIMEIRONOME');?>
                            <span class="form-required" title="<?php echo lang('CAMPOOBRIGATORIO');?>">*</span>
                        </label>
                        <div class="controls">
                            <input type="text" id="inputPropertyFirstName">
                        </div><!-- /.controls -->
                    </div><!-- /.control-group -->

                    <div class="control-group">
                        <label class="control-label" for="inputPropertySurname">
                            <?php echo lang('ULTIMONOME');?>
                            <span class="form-required" title="<?php echo lang('CAMPOOBRIGATORIO');?>">*</span>
                        </label>
                        <div class="controls">
                            <input type="text" id="inputPropertySurname">
                        </div><!-- /.controls -->
                    </div><!-- /.control-group -->

                    <div class="control-group">
                        <label class="control-label" for="inputPropertyEmail">
                            <?php echo lang('EMAIL');?>
                            <span class="form-required" title="<?php echo lang('CAMPOOBRIGATORIO');?>">*</span>
                        </label>
                        <div class="controls">
                            <input type="text" id="inputPropertyEmail">
                        </div><!-- /.controls -->
                    </div><!-- /.control-group -->

                    <div class="control-group">
                        <label class="control-label" for="inputPropertyPhone">
                            <?php echo lang('TELEFONE');?>
                            <span class="form-required" title="<?php echo lang('CAMPOOBRIGATORIO');?>">*</span>
                        </label>
                        <div class="controls">
                            <input type="text" id="inputPropertyPhone">
                        </div><!-- /.controls -->
                    </div><!-- /.control-group -->
                </div><!-- /.span4 -->

                <div class="span4">
                    <h3><strong>2.</strong> <span><?php echo lang('INFIMOVEL');?></span></h3>

                    <div class="control-group">
                        <label class="control-label" for="inputPropertyLocation">
                            <?php echo lang('ENDERECO');?>
                            <span class="form-required" title="<?php echo lang('CAMPOOBRIGATORIO');?>">*</span>
                        </label>
                        <div class="controls">
                            <input type="text" id="inputPropertyLocation">
                        </div><!-- /.controls -->
                    </div><!-- /.control-group -->

                    <div class="property-type control-group">
                        <label class="control-label" for="inputPropertyPropertyType">
                            <?php echo lang('TIPOIMOVEL');?>
                            <span class="form-required" title="<?php echo lang('CAMPOOBRIGATORIO');?>">*</span>
                        </label>
                        <div class="controls">
                            <select id="inputPropertyPropertyType">
							  <?php $lista = $imoveis->getTipo();?>
							  <?php if ($lista):?>
							  <?php foreach ($lista as $exrow):?>
								<option><?php echo $exrow->tipo;?></option>
							  <?php endforeach;?>
							  <?php unset($exrow);?>
							  <?php endif;?>
                            </select>
                        </div><!-- /.controls -->
                    </div><!-- /.control-group -->

                    <div class="contract-type control-group">
                        <label class="control-label" for="inputPropertyContractType">
                            <?php echo lang('TIPOOPERACAO');?>
                            <span class="form-required" title="<?php echo lang('CAMPOOBRIGATORIO');?>">*</span>
                        </label>
                        <div class="controls">
                            <select id="inputPropertyContractType">
                                <option><?php echo lang('VENDA');?></option>
                                <option><?php echo lang('ALUGUEL');?></option>
                            </select>
                        </div><!-- /.controls -->
                    </div><!-- /.control-group -->

                    <div class="bedrooms control-group">
                        <label class="control-label" for="inputPropertyBedrooms">
                            <?php echo lang('QUARTOS');?>
                            <span class="form-required" title="<?php echo lang('CAMPOOBRIGATORIO');?>">*</span>
                        </label>
                        <div class="controls">
                            <input type="text" id="inputPropertyBedrooms">
                        </div><!-- /.controls -->
                    </div><!-- /.control-group -->

                    <div class="bathrooms control-group">
                        <label class="control-label" for="inputPropertyBathrooms">
                            <?php echo lang('BANHEIROS');?>
                            <span class="form-required" title="<?php echo lang('CAMPOOBRIGATORIO');?>">*</span>
                        </label>
                        <div class="controls">
                            <input type="text" id="inputPropertyBathrooms">
                        </div><!-- /.controls -->
                    </div><!-- /.control-group -->

                    <div class="area control-group">
                        <label class="control-label" for="inputPropertyArea">
                            <?php echo lang('AREA');?>
                            <span class="form-required" title="<?php echo lang('CAMPOOBRIGATORIO');?>">*</span>
                        </label>
                        <div class="controls">
                            <input type="text" id="inputPropertyArea">
                        </div><!-- /.controls -->
                    </div><!-- /.control-group -->

                    <div class="price control-group">
                        <label class="control-label" for="inputPropertyPrice">
                            <?php echo lang('PRECO');?>
                            <span class="form-required" title="<?php echo lang('CAMPOOBRIGATORIO');?>">*</span>
                        </label>
                        <div class="controls">
                            <input type="text" id="inputPropertyPrice">
                        </div><!-- /.controls -->
                    </div><!-- /.control-group -->
                </div><!-- /.span4 -->

                <div class="span4">
                    <h3><strong>3.</strong> <span><?php echo lang('ENVIARIMAGEM');?></span></h3>

                    <div class="fileupload fileupload-new control-group" data-provides="fileupload">
                        <label class="control-label" for="inputPropertyPrice">
                            <?php echo lang('IMAGEMIMOVEL');?>
                        </label>

                        <div class="input-append">
                            <div class="uneditable-input">
                                <i class="icon-file fileupload-exists"></i>
                                <span class="fileupload-preview"></span>
                            </div>
                                                <span class="btn btn-file">
                                                    <span class="fileupload-new"><?php echo lang('BUSCARARQUIVO');?></span>
                                                    <span class="fileupload-exists"><?php echo lang('ALTERAR');?></span>
                                                    <input type="file" />
                                                </span>
                            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload"><?php echo lang('REMOVER');?></a>
                        </div><!-- /.input-append -->
                    </div><!-- .fileupload -->

                    <div class="control-group">
                        <label class="control-label" for="inputPropertyNotes">
                            <?php echo lang('INFORMACOES');?>
                            <span class="form-required" title="<?php echo lang('CAMPOOBRIGATORIO');?>">*</span>
                        </label>
                        <div class="controls">
                            <textarea id="inputPropertyNotes"></textarea>
                        </div><!-- /.controls -->
                    </div><!-- /.control-group -->
                </div><!-- /.span4 -->
            </div><!-- /.row -->
			<div class="form-actions">
                <input type="submit" class="btn btn-primary arrow-right" value="<?php echo lang('ENVIAR');?>">
            </div><!-- /.form-actions -->
        </form>
    </div><!-- /.content -->
</div><!-- /.list-your-property-form -->        </div>
    </div>
</div>

    </div><!-- /#content -->