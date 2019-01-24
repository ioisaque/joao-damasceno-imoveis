<?php include("header.php");?>
	<div class="container">
		<div class="row">
			<div class="col-sm-12" style="font-weight: bold;">	
			
				<!-- BEGIN PROPERTY LISTING -->
				<div id="property-listing" class="grid-style1 clearfix">									  
				  <?php echo $_GET['page']; ?>
				  
				  <?php $data = array('page' => '2'); ?>
				  <?php http_build_query($data); ?>
				  
				  <?php echo $_GET['page']; ?>
				</div>
				<!-- END PROPERTY LISTING -->
					
			</div>
		</div>
	</div>
<?php include("footer.php");?>