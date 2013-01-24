			<div id="<?php html::write( $this->router->class ); ?>_list" class="block">
				<div class="block_head">
					<div class="bheadl"></div>
					<div class="bheadr"></div>
					<h2><?php html::write( $page[ 'title' ] ); ?><small> / Filtros</small></h2>
				</div>
				<!-- .block_head ends -->
				<div class="block_content">
					<?php $this->load->view( 'manager/layout/messages' ); ?>
					<form method="post">
						<?php html::write_text_area( $filters ); ?>
						<p>
							<label class="submit">
								<input type="submit" value="Filtrar">
							</label>
							<a href="<?php html::write( $page[ 'url' ] ); ?>">
							<label class="submit">
								<input type="button" value="Limpar">
							</label></a>
						</p>
					</form>
					<!-- .tableactions ends -->
				</div>
				<!-- .block_content ends -->
				<div class="bendl"></div>
				<div class="bendr"></div>
			</div>


			<div class="block">
				<div class="block_head">
					<div class="bheadl"></div>
					<div class="bheadr"></div>
					<h2><?php html::write( $page[ 'title' ] ); ?><small> / <?php html::write( $legends->subtitle )?></small><small> | <a href="<?php html::write( $this->config->item( 'manager_uri' ) )?>statistics/export/<?php html::write( $filter_hash ); ?>">Exportar</a></h2>
				</div>
				<!-- .block_head ends -->
				<div class="block_content">
					<table>
						<thead>
							<tr> 
							<?php foreach( $legends->table_headers as $key => $title ) { ?>
								<th <?php ( $key != 0 ) ? : html::write( 'width=150' ); ?>><?php html::write( $title ); ?></th>
							<?php } ?>
							</tr>
						</thead>
						<tbody>
							<?php $date = ''; ?>
							<?php foreach( $records as $record ) { ?>
								<?php if ( $date != $record->date ) { ?>
								<?php $date = $record->date; ?>
								<tr>
									<td><strong><?php echo( html::write( $date ) ); ?></strong></td>
									<td>&nbsp;</td>
								</tr>
								<?php } ?>
							<tr>
								<td><?php html::write( $record->title ); ?></td>
								<td>
									<div class="graph">
										<strong class="bar" style="width: <?php html::write( $record->percent ) ?>;"><?php html::write( $record->percent ) ?></strong>
										<span><?php html::write( $record->number ); ?></span>
									</div>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
					<!-- .tableactions ends -->
				</div>
				<!-- .block_content ends -->
				<div class="bendl"></div>
				<div class="bendr"></div>
			</div>
			<!-- .block ends -->