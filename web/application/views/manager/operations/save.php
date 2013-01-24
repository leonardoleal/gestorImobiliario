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
						<p>
							<label>
                            	<span>Imóvel:</span>
								<select name="product_id" class="styled">
									<option value="">Selecione um imóvel</option>
									<?php foreach( $products as $product ) { ?>
									<option value="<?php html::write( $product->id ); ?>" <?php html::write( html::is_selected( $fields[ 'product_id' ] == $product->id ) ); ?>><?php html::write( format::fill( $product->id ) ); ?></option>
									<?php } ?>
								</select>
							</label>
						</p>
						<p>
							<label>
                            	<span>Cliente:</span>
								<select name="customer_id" class="styled">
									<option value="">Selecione um cliente</option>
									<?php foreach( $customers as $customer ) { ?>
									<option value="<?php html::write( $customer->id ); ?>" <?php html::write( html::is_selected( $fields[ 'customer_id' ] == $customer->id ) ); ?>><?php html::write( $customer->name ); ?></option>
									<?php } ?>
								</select>
							</label>
						</p>
						<p>
							<label>
                            	<span>Corretor:</span>
								<select name="realtor_id" class="styled">
									<option value="">Selecione um corretor</option>
									<?php foreach( $realtors as $realtor ) { ?>
									<option value="<?php html::write( $realtor->id ); ?>" <?php html::write( html::is_selected( $fields[ 'realtor_id' ] == $realtor->id ) ); ?>><?php html::write( $realtor->name ); ?></option>
									<?php } ?>
								</select>
							</label>
						</p>
						<p>
							<label>
                            	<span>Tipo Transação:</span>
								<select name="transaction_type" class="styled">
									<?php foreach( $transaction_types as $key => $value ) { ?>
										<option value="<?php html::write( $key ); ?>" <?php html::write( html::is_selected( $fields[ 'transaction_type' ] == $key ) ); ?>><?php html::write( $value ); ?></option>
									<?php } ?>
								</select>
							</label>
						</p>
						<?php if ( $fields[ 'transaction_type' ] == 1 ) { ?>
						<p>
							<label>
                            	<span>Data inicial:</span>
								<input type="text" class="text date_picker" name="date_start" value="<?php html::write( format::date2br( $fields[ 'date_start' ] ) ); ?>">
							</label>
							<label>
								<span>Data final:</span>
								<input type="text" class="text date_picker" name="date_end" value="<?php html::write( format::date2br( $fields[ 'date_end' ] ) ); ?>">
							</label>
						</p>
						<?php } ?>
						<p>
							<label>
                            	<span>Valor: (R$)</span>
								<input type="text" name="value" alt="decimal" class="text big" value="<?php html::write( $fields[ 'value' ] ); ?>">
							</label>
						</p>
						<p>
							<input type="submit" class="submit" value="Salvar">
						</p>
					</form>
				</div>
				<div class="bendl"></div>
				<div class="bendr"></div>
			</div>
			<!-- .block ends -->