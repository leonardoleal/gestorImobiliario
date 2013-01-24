			<div id="<?php html::write( $this->router->class ); ?>_list" class="block">
				<div class="block_head">
					<div class="bheadl"></div>
					<div class="bheadr"></div>
					<h2><?php echo( $page[ 'title' ] ); ?></h2>
					<ul class="tabs">
						<li>Total de cadastros: <?php echo( $record_count ); ?></li>
					</ul>
					<form action="?" method="get">
						<input type="text" name="search" value="<?php echo( $search ); ?>" class="text">
					</form>
				</div>
				<!-- .block_head ends -->
				<div class="block_content">
					<?php $this->load->view( 'manager/layout/messages' ); ?>
					<form method="post" action="<?php echo( $page[ 'url' ] ); ?>remove/">
						<table>
							<thead>
								<tr>
									<th width="10"><input type="checkbox" class="check_all"></th>
									<th class="code">Código</th>
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
									<td><input type="checkbox" name="id[]" value="<?php echo( $record->id ); ?>"></td>
									<td><?php echo( format::fill( $record->id ) ); ?></td>
									<td><?php echo( $record->alias ); ?></td>
									<td><?php echo( format::datetime2date( $record->created ) ); ?></td>
                                    <?php if ( count( $permitted_actions ) > 0 ) { ?>
									<td class="actions">
										<?php if ( in_array( 'save', $permitted_actions ) ) { ?>
										<a href="<?php echo( $page[ 'url' ] ); ?>save/<?php echo( $record->id ); ?>" title="Editar" class="save">Editar</a>
										<?php } ?>
										<?php if ( in_array( 'remove', $permitted_actions ) ) { ?>
										<a href="<?php echo( $page[ 'url' ] ); ?>remove/<?php echo( $record->id ); ?>" title="Remover" class="remove">Remover</a>
										<?php } ?>
									</td>
                                    <?php } ?>
								</tr>
									<?php foreach( $record->children as $children ) { ?>
									<!-- .children_pages -->
									<tr class="children_pages">
										<td><input type="checkbox" name="id[]" value="<?php echo( $children->id ); ?>"></td>
										<td><?php echo( format::fill( $children->id ) ); ?></td>
										<td><?php echo( $children->alias ); ?></td>
										<td><?php echo( format::datetime2date( $children->created ) ); ?></td>
	                                    <?php if ( count( $permitted_actions ) > 0 ) { ?>
										<td class="actions">
											<?php if ( in_array( 'save', $permitted_actions ) ) { ?>
											<a href="<?php echo( $page[ 'url' ] ); ?>save/<?php echo( $children->id ); ?>" title="Editar" class="save">Editar</a>
											<?php } ?>
											<?php if ( in_array( 'remove', $permitted_actions ) ) { ?>
											<a href="<?php echo( $page[ 'url' ] ); ?>remove/<?php echo( $children->id ); ?>" title="Remover" class="remove">Remover</a>
											<?php } ?>
										</td>
	                                    <?php } ?>
									</tr>
									<!-- .children_pages ends -->
									<?php } ?>
								<?php } ?>
							</tbody>
						</table>
                        <?php if ( in_array( 'remove', $permitted_actions ) ) { ?>
						<div class="tableactions">
							<select name="remove">
								<option>Ações</option>
								<option value="1">Remover</option>
							</select>
							<label class="submit">
								<input type="submit" value="Aplicar">
							</label>
						</div>
                        <?php } ?>
						<!-- .tableactions ends -->
                        <div class="pagination right"><?php echo( $this->pagination->create_links() ); ?></div>
						<!-- .pagination ends -->
					</form>
				</div>
				<!-- .block_content ends -->
				<div class="bendl"></div>
				<div class="bendr"></div>
			</div>
			<!-- .block ends -->
