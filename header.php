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
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Aviators - byaviators.com">

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/ico">
    <link rel="stylesheet" href="assets/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="assets/css/bootstrap-responsive.css" type="text/css">
    <link rel="stylesheet" href="assets/libraries/chosen/chosen.css" type="text/css">
    <link rel="stylesheet" href="assets/libraries/bootstrap-fileupload/bootstrap-fileupload.css" type="text/css">
    <link rel="stylesheet" href="assets/libraries/jquery-ui-1.10.2.custom/css/ui-lightness/jquery-ui-1.10.2.custom.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/realia-blue.css" type="text/css" id="color-variant-default">
    <link rel="stylesheet" href="#" type="text/css" id="color-variant">
	
	<script src="http://code.jquery.com/jquery-1.7.1.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
	<script src="assets/js/gmaps.js" type="text/javascript"></script>
	<script src="assets/js/markers.js" type="text/javascript"></script>
	
	<script type="text/javascript" src="assets/js/jquery.js"></script>
	<script type="text/javascript" src="assets/js/jquery.ezmark.js"></script>
	<script type="text/javascript" src="assets/js/jquery.currency.js"></script>
	<script type="text/javascript" src="assets/js/jquery.cookie.js"></script>
	<script type="text/javascript" src="assets/js/retina.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/carousel.js"></script>
	<script type="text/javascript" src="assets/js/gmap3.min.js"></script>
	<script type="text/javascript" src="assets/js/gmap3.infobox.min.js"></script>
	<script type="text/javascript" src="assets/libraries/jquery-ui-1.10.2.custom/js/jquery-ui-1.10.2.custom.min.js"></script>
	<script type="text/javascript" src="assets/libraries/chosen/chosen.jquery.min.js"></script>
	<script type="text/javascript" src="assets/libraries/iosslider/_src/jquery.iosslider.min.js"></script>
	<script type="text/javascript" src="assets/libraries/bootstrap-fileupload/bootstrap-fileupload.js"></script>
	<script type="text/javascript" src="assets/js/realia.js"></script>

    <title><?php echo Registry::get("Core")->empresa;?></title>
</head>
<body>
<div id="wrapper-outer" >
    <div id="wrapper">
        <div id="wrapper-inner">
            <!-- BREADCRUMB -->
            <div class="breadcrumb-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="span12">
                            <ul class="breadcrumb pull-left">
                                <li><a href="#"></a></li>
                            </ul><!-- /.breadcrumb -->

                            <div class="account pull-right">
                                <ul class="nav nav-pills">
                                    <li><a href="#"><?php echo lang('WEBMAIL');?></a></li>
                                    <li><a href="<?php echo Registry::get("Core")->site_sistema;?>"><?php echo lang('SISTEMA');?></a></li>
                                </ul>
                            </div>
                        </div><!-- /.span12 -->
                    </div><!-- /.row -->
                </div><!-- /.container -->
            </div><!-- /.breadcrumb-wrapper -->

            <!-- HEADER -->
            <div id="header-wrapper">
                <div id="header">
                    <div id="header-inner">
                        <div class="container">
                            <div class="navbar">
                                <div class="navbar-inner">
                                    <div class="row">
                                        <div class="logo-wrapper span4">
                                            <div class="logo">
                                                <a href="index.php" title="Home">
                                                    <img src="assets/img/logo.png" alt="Home">
                                                </a>
                                            </div><!-- /.logo -->
                                        </div><!-- /.logo-wrapper -->

                                        <div class="info">
                                            <div class="site-email">
                                                <a href="mailto:<?php echo lang('EMAIL2_EMPRESA');?>"><?php echo lang('EMAIL2_EMPRESA');?></a>
                                            </div><!-- /.site-email -->

                                            <div class="site-phone">
                                                <span><?php echo lang('TELEFONE_EMPRESA');?></span>
                                            </div><!-- /.site-phone -->
                                        </div><!-- /.info -->

                                        <a class="btn btn-primary btn-large list-your-property arrow-right" href="index.php?do=vendaaqui"><?php echo lang('VENDA_AQUI');?></a>
                                    </div><!-- /.row -->
                                </div><!-- /.navbar-inner -->
                            </div><!-- /.navbar -->
                        </div><!-- /.container -->
                    </div><!-- /#header-inner -->
                </div><!-- /#header -->
            </div><!-- /#header-wrapper -->

            <!-- NAVIGATION -->
            <div id="navigation">
                <div class="container">
                    <div class="navigation-wrapper">
                        <div class="navigation clearfix-normal">

                            <ul class="nav">
								<li><a href="index.php?do=home" title=""><?php echo lang('HOME_MENU');?></a></li>
								<li><a href="index.php?do=empresa" title=""><?php echo lang('EMPRESA_MENU');?></a></li>
								<li><a href="index.php?do=imoveis" title=""><?php echo lang('IMOVEIS_MENU');?></a></li>
								<li><a href="index.php?do=dicas" title=""><?php echo lang('DICAS_MENU');?></a></li>
								<li class="menuparent">
                                    <span class="menuparent nolink"><?php echo lang('SIMULADORES_MENU');?></span>
                                    <ul>
                                        <li><a href="index.php?do=caixa"><?php echo lang('CAIXA_MENU');?></a></li>
                                        <li><a href="index.php?do=bb"><?php echo lang('BB_MENU');?></a></li>
                                        <li><a href="index.php?do=itau"><?php echo lang('ITAU_MENU');?></a></li>
                                    </ul>
                                </li>
								<li><a href="index.php?do=contato" title=""><?php echo lang('CONTATO_MENU');?></a></li>
                            </ul><!-- /.nav -->

                            <form method="get" class="site-search" action="#">
                                <div class="input-append">
                                    <input title="Digite os termos da pesquisa." class="search-query span2 form-text" placeholder="Pesquise" type="text" name="">
                                    <button type="submit" class="btn"><i class="icon-search"></i></button>
                                </div><!-- /.input-append -->
                            </form><!-- /.site-search -->
                        </div><!-- /.navigation -->
                    </div><!-- /.navigation-wrapper -->
                </div><!-- /.container -->
            </div><!-- /.navigation -->
