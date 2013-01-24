			<div id="<?php html::write( $this->router->class ); ?>_form" class="block">
				<div class="block_head">
					<div class="bheadl"></div>
					<div class="bheadr"></div>
					<h2><?php html::write( $page[ 'title' ] ); ?></h2>
				</div>
				<!-- .block_head ends -->
				<div class="block_content">
					<?php $this->load->view( 'manager/layout/messages' ); ?>
					<form method="post" action="<?php html::write( $page[ 'url' ] ); ?>update/" enctype="multipart/form-data">
						<input type="hidden" name="id" value="<?php html::write( $fields[ 'id' ] ); ?>">
						<input type="hidden" name="group_id" value="<?php html::write( $group_id ); ?>">
						<p>
							<label>
                            	<span>Título:</span>
								<input type="text" name="alias" class="text big" value="<?php html::write( $fields[ 'alias' ] ); ?>">
							</label>
						</p>
						<p>
							<label>
                            	<span>Valor:</span>
								<input type="text" name="value" class="text big" value="<?php html::write( $fields[ 'value' ] ); ?>">
							</label>
						</p>
						<p>
							<label class="submit">
								<input type="submit" value="Salvar">
							</label>
						</p>
					</form>
				</div>
				<div class="bendl"></div>
				<div class="bendr"></div>
			</div>
			<!-- .block ends -->