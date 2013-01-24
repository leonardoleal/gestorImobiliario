			<div id="<?php html::write( $this->router->class ); ?>_form" class="block">
				<div class="block_head">
					<div class="bheadl"></div>
					<div class="bheadr"></div>
					<h2><?php html::write( $page[ 'title' ] ); ?></h2>
				</div>
				<!-- .block_head ends -->
				<div class="block_content">
					<?php $this->load->view( 'manager/layout/messages' ); ?>
					<form method="post" action="<?php html::write( $page[ 'url' ]); ?>update/">
						<input type="hidden" name="id" value="<?php html::write( $fields[ 'id' ] ); ?>">
						<p>
							<label>
                            	<span>Título:</span>
								<input type="text" name="title" class="text big" value="<?php html::write( $fields[ 'title' ] ); ?>">
							</label>
						</p>
						<p>
							<label>
                            	<span>Tipo:</span>
								<select name="type" class="styled">
								<?php foreach( $types as $key => $value ) { ?>
										<option value="<?php html::write( $key ); ?>" <?php html::write( html::is_selected( $fields[ 'type' ] == $key ) ); ?>><?php html::write( $value ); ?></option>
									<?php } ?>
								</select>
							</label>
						</p>

						<?php if ( $is_new ) { ?>
						<p>* A adição de items será habilitada após a categoria ser salva.</p>
						<?php } else { ?>
						<p><label><span>Itens:</span></label></p>
						<table class="sortable">
							<thead>
								<tr>
									<th>Título</th>
									<th class="date">Cadastro</th>
									<?php if ( count( $permitted_actions ) > 0 ) { ?>
									<td>&nbsp;</td>
						    		<?php } ?>
								</tr>
							</thead>
							<tbody>
								<?php foreach( $records as $record ) { ?>
								<tr>
									<td>
										<input type="hidden" name="item_id[]" value="<?php html::write( $record->id ); ?>">
										<input type="text" name="item_title[]" class="text big" value="<?php html::write( $record->title ); ?>">
									</td>
									<td><?php html::write( format::datetime2br( $record->created ) ); ?></td>
                                    <?php if ( count( $permitted_actions ) > 0 ) { ?>
									<td class="actions">
										<?php if ( in_array( 'remove', $permitted_actions ) ) { ?>
										<a href="<?php html::write( $page[ 'url' ] ); ?>remove_item/<?php html::write( $record->id ); ?>" title="Remover" class="remove item">Remover</a>
										<?php } ?>
									</td>
                                    <?php } ?>
								</tr>
								<?php } ?>
								<tr>
									<td><input type="text" name="item_title[]" class="text big"></td>
									<td></td>
									<td class="actions"></td>
								</tr>
							</tbody>
						</table>
						<?php } ?>

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