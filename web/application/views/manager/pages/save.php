			<div id="<?php html::write( $this->router->class ); ?>_form" class="block">
				<div class="block_head">
					<div class="bheadl"></div>
					<div class="bheadr"></div>
					<h2><?php html::write( $page[ 'title' ] ); ?></h2>
				</div>
				<!-- .block_head ends -->
				<div class="block_content">
					<?php $this->load->view( 'manager/layout/messages' ); ?>
					<form method="post" action="<?php html::write( $page[ 'url' ] ); ?>update/">
						<input type="hidden" name="id" value="<?php html::write( $fields[ 'id' ] ); ?>">
						<p>
							<label>
								<span>Página Superior:</span>
								<select name="parent_id" class="styled">
									<option value="">Página Principal</option>
									<?php foreach( $pages as $page ) { ?>
									<option value="<?php html::write( $page->id ); ?>" <?php html::write( html::is_selected( $page->id == $fields[ 'parent_id' ] ) ); ?>><?php html::write( $page->alias ); ?></option>
									<?php } ?>
								</select>
							</label>
						</p>
						<p>
							<label>
                            	<span>Título:</span>
								<input type="text" name="alias" class="text big" value="<?php html::write( $fields[ 'alias' ] ); ?>">
							</label>
						</p>
						<p>
							<label>
                            	<span>Conteúdo:</span>
								<textarea name="content" class="wysiwyg"><?php html::write( $fields[ 'content' ] ); ?></textarea>
							</label>
						</p>
						<p>
							<label class="submit">
								<input type="submit" value="Salvar">
							</label>
						</p>
					</form>
				</div>
				<!-- .block_content ends -->
				<div class="bendl"></div>
				<div class="bendr"></div>
			</div>
			<!-- .block ends -->
