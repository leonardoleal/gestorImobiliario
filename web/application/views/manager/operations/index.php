﻿			<div id="<?php html::write( $this->router->class ); ?>_list" class="block">
				<div class="block_head">
					<div class="bheadl"></div>
					<div class="bheadr"></div>
					<h2><?php echo( $page[ 'title' ] ); ?></h2>
					<ul class="tabs">
						<li><a href="<?php echo( $page[ 'url' ] ); ?>search_engine_view/" class="search_engine">Busca Avançada</a></li>
						<li>Total de cadastros: <?php echo( $record_count ); ?></li>
					</ul>
					<form action="?" method="get">
						<input type="text" name="search" value="<?php echo( $search ); ?>" class="text">
					</form>
				</div>
				<!-- .block_head ends -->
				<div class="block_content">
					<?php $this->load->view( 'manager/layout/messages' ); ?>
					<form method="post" action="?">
					<input type="hidden" name="filter_hash" value="<?php html::write( $filter_hash ); ?>">
						<table class="sortable">
							<thead>
								<tr>
									<th width="10"><input type="checkbox" class="check_all"></th>
									<th class="code">Código</th>
									<th>Tipo Transação</th>
									<th class="value">Valor</th>
									<th class="date">Data</th>
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
									<td><?php echo( $record->get_transaction_type( $record->transaction_type ) ); ?></td>
									<td class="value"><?php echo( 'R$ ' . format::decimalus2br( $record->value ) ); ?></td>
									<td><?php echo( format::date2br( $record->date_start ) ); ?></td>
                                    <?php if ( count( $permitted_actions ) > 0 ) { ?>
									<td class="actions">
										<?php if ( in_array( 'save', $permitted_actions ) ) { ?>
										<a href="<?php echo( $page[ 'url' ] ); ?>save/<?php echo( $record->id ); ?>/#photos" title="Fotos" class="photo">Fotos</a>
										<a href="<?php echo( $page[ 'url' ] ); ?>save/<?php echo( $record->id ); ?>" title="Editar" class="save">Editar</a>
										<?php } ?>
										<?php if ( in_array( 'remove', $permitted_actions ) ) { ?>
										<a href="<?php echo( $page[ 'url' ] ); ?>remove/<?php echo( $record->id ); ?>" title="Remover" class="remove">Remover</a>
										<?php } ?>
									</td>
                                    <?php } ?>
								</tr>
								<?php } ?>
							</tbody>
						</table>
                        <?php if ( sizeof( $permitted_actions ) > 0 AND $record_count > 0 ) { ?>
						<div class="tableactions">
							<select name="action">
								<option value="">Ações</option>
								<?php if ( in_array( 'remove', $permitted_actions ) ) { ?>
								<option value="1">Remover</option>
								<?php } ?>
								<?php if ( in_array( 'export', $permitted_actions ) ) { ?>
								<option value="2">Exportar</option>
								<?php } ?>
							</select>
							<input type="submit" class="submit tiny" value="Aplicar">
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
