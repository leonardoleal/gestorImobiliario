			<div id="<?php html::write( $this->router->class ); ?>_list" class="block">
				<div class="block_head">
					<div class="bheadl"></div>
					<div class="bheadr"></div>
					<h2><?php html::write( $page[ 'title' ] ); ?></h2>
					<ul class="tabs">
						<li>Total de cadastros: <?php html::write( $record_count ); ?></li>
					</ul>
					<form action="?" method="get">
						<input type="text" name="search" value="<?php html::write( $search ); ?>" class="text">
					</form>
				</div>
				<!-- .block_head ends -->
				<div class="block_content">
					<?php $this->load->view( 'manager/layout/messages' ); ?>
					<form method="post" action="<?php html::write( $page[ 'url' ] ); ?>remove/">
						<table>
							<thead>
								<tr>
									<th>Título</th>
									<th>Valor</th>
                                    <?php if ( count( $permitted_actions ) > 0 ) { ?>
									<td>&nbsp;</td>
                                    <?php } ?>
								</tr>
							</thead>
							<tbody>
								<?php $group = ''; ?>
								<?php foreach( $records as $record ) { ?>
									<?php if ( $group != $record->configuration_group->id ) { ?>
									<?php $group = $record->configuration_group->id; ?>
									<tr>
										<td><strong><?php echo( html::write( $record->configuration_group->alias ) ); ?></strong></td>
										<td>&nbsp;</td>
										<td class="actions">
											<?php if ( in_array( 'save', $permitted_actions )
														AND $record->configuration_group->editable ) { ?>
											<a href="<?php html::write( $page[ 'url' ] ); ?>save_new/<?php html::write( $record->configuration_group->id ); ?>" title="Adicionar" class="activate">Adicionar</a>
											<?php } ?>
										</td>
									</tr>
									<?php } ?>
								<tr>
									<td><?php html::write( $record->alias ); ?></td>
									<td><?php html::write( $record->value ); ?></td>
                                    <?php if ( count( $permitted_actions ) > 0 ) { ?>
									<td class="actions">
										<?php if ( in_array( 'save', $permitted_actions )
													AND $record->system != 2 ) { ?>
										<a href="<?php html::write( $page[ 'url' ] ); ?>save/<?php html::write( $record->id ); ?>" title="Editar" class="save">Editar</a>
										<?php } ?>
										<?php if ( in_array( 'remove', $permitted_actions )
													AND !$record->system ) { ?>
										<a href="<?php echo( $page[ 'url' ] ); ?>remove/<?php echo( $record->id ); ?>" title="Remover" class="remove">Remover</a>
										<?php } ?>
									</td>
                                    <?php } ?>
								</tr>
								<?php } ?>
							</tbody>
						</table>
						<!-- .tableactions ends -->
					</form>
				</div>
				<!-- .block_content ends -->
				<div class="bendl"></div>
				<div class="bendr"></div>
			</div>
			<!-- .block ends -->
