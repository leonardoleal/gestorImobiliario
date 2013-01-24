			<div id="<?php html::write( $this->router->class ); ?>" class="block" style="width:52%;">
				<div class="block_head">
					<div class="bheadl"></div>
					<div class="bheadr"></div>
					<h2><?php html::write( $page[ 'title' ] ); ?></h2>
				</div>
				<!-- .block_head ends -->
				<div class="block_content">
					<?php $this->load->view( 'manager/layout/messages' ); ?>
					<?php if ( !$has_uploaded ) { ?>
					<form method="post" action="<?php html::write( $page[ 'url' ] ); ?>upload_image/" enctype="multipart/form-data">
						<p>
							<label>
                            	<span>Imagem:</span>
								<input type="file" name="image" class="text big" >
							</label>
						</p>
						<p>
							<label class="submit">
								<input type="submit" value="Upload">
							</label>
							<label class="cancel">
								<input type="reset" value="Cancelar">
							</label>
						</p>
					</form>
					<?php } else { ?>
					<script type="text/javascript">
						parent.window.temp.url_image = "<?php html::write( $image ); ?>";
						parent.window.temp.close = true;
					</script>
					<?php } ?>
					<script type="text/javascript">
						document.body.removeChild( document.getElementById( 'header' ) );
					</script>
				</div>
				<!-- .block_content ends -->
				<div class="bendl"></div>
				<div class="bendr"></div>
			</div>
			<!-- .block ends -->
