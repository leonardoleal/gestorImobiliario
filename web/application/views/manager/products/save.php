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
						<?php if ( !$is_new ) { ?>
						<p>
							<label>
								<span>Código:</span>
								<input type="text" class="text big" value="<?php html::write( format::fill( $fields[ 'id' ], 5 ) ); ?>" disabled="disabled">
							</label>
						</p>
						<?php } ?>
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
						<p>
							<label>
                            	<span>Valor: (R$)</span>
								<input type="text" name="value" alt="decimal" class="text big" value="<?php html::write( $fields[ 'value' ] ); ?>">
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
                            	<span>Descrição:</span>
								<textarea name="description" class="big"><?php html::write( $fields[ 'description' ] ); ?></textarea>
							</label>
						</p>
						<p>
							<label>
                            	<span>CEP:</span>
								<input type="text" name="zip_code" alt="cep" class="text small" value="<?php html::write( $fields[ 'zip_code' ] ); ?>">
							</label>
						</p>
						<p>
							<label>
								<span>Estado:</span>
								<select name="state_id" class="styled">
									<option value="">Selecione um estado</option>
									<?php foreach( $states as $state ) { ?>
									<option value="<?php html::write( $state->id ); ?>" <?php html::write( html::is_selected( $state->id == $fields[ 'state_id' ] ) ); ?>><?php html::write( $state->name ); ?></option>
									<?php } ?>
								</select>
							</label>
						</p>
						<p>
							<label>
								<span>Cidade:</span>
								<select name="city_id" class="styled">
									<?php if ( empty( $fields[ 'city_id' ] ) ) { ?>
									<option value="">Selecione um estado</option>
									<?php } else { ?>
									<option value="">Selecione uma cidade</option>
									<?php foreach( $cities as $city ) { ?>
									<option value="<?php html::write( $city->id ); ?>" <?php html::write( html::is_selected( $city->id == $fields[ 'city_id' ] ) ); ?>><?php html::write( $city->name ); ?></option>
									<?php } ?>
									<?php } ?>
								</select>
							</label>
						</p>
						<p>
							<label>
								<span>Bairro:</span>
								<select name="neighborhood_id" class="styled">
									<?php if ( empty( $fields[ 'neighborhood_id' ] ) ) { ?>
									<option value="">Selecione uma cidade</option>
									<?php } else { ?>
									<option value="">Selecione um bairro</option>
									<?php foreach( $neighborhoods as $neighborhood ) { ?>
									<option value="<?php html::write( $neighborhood->id ); ?>" <?php html::write( html::is_selected( $neighborhood->id == $fields[ 'neighborhood_id' ] ) ); ?>><?php html::write( $neighborhood->name ); ?></option>
									<?php } ?>
									<?php } ?>
								</select>
							</label>
						</p>
						<p>
							<label>
                            	<span>Endereço:</span>
								<input type="text" name="address" class="text big" value="<?php html::write( $fields[ 'address' ] ); ?>">
							</label>
						</p>
						<p>
							<label>
                            	<span>Nº:</span>
								<input type="text" name="number" class="text small" value="<?php html::write( $fields[ 'number' ] ); ?>">
							</label>
						</p>
						<p>
							<label>
                            	<span>Complemento:</span>
								<input type="text" name="complement" class="text small" value="<?php html::write( $fields[ 'complement' ] ); ?>">
							</label>
						</p>
						<p>
							<label>
                            	<span>Posição:</span>
								<label>Longitude:</label>
								<input type="text" name="pos_longitude" class="text small" value="<?php html::write( $fields[ 'pos_longitude' ] ); ?>">
                            	<label>Latitude:</label>
								<input type="text" name="pos_latitude" class="text small" value="<?php html::write( $fields[ 'pos_latitude' ] ); ?>">
							</label>
						</p>

						<?php foreach( $categories as $key => $category ) { ?>
						<p>
							<label>
                            	<span><?php html::write( $category->title ); ?>:</span>
                           	</label>
                            	<?php if ( $category->type ) { ?>
                            		<?php foreach( $category->items as $item ) { ?>
									<label><input type="checkbox" name="item[]" value="<?php html::write( $item->id ); ?>" <?php html::write( html::is_checked( in_array( $item->id, $product_items ) ) ); ?>><?php html::write( $item->title ); ?></label>
									<?php } ?>
                            	<?php } else { ?>
                            	<select name="item[]" id="" class="styled">
                            		<option value="">Selecione uma opção</option>
                            		<?php foreach( $category->items as $item ) { ?>
                            		<option value="<?php html::write( $item->id ); ?>" <?php html::write( html::is_selected( in_array( $item->id, $product_items ) ) ); ?>><?php html::write( $item->title ); ?></option>
									<?php } ?>
                            	</select>
                            	<?php } ?>
						</p>
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



			<?php if ( !$is_new ) { ?>
			<a name="photos"></a>
			<div class="block">
				<div class="block_head">
					<div class="bheadl"></div>
					<div class="bheadr"></div>
					<h2>Fotos</h2>						
				</div>
				<!-- .block_head ends -->
				<div class="block_content">
					<form action="?" method="post" enctype="multipart/form-data">
						<div id="fs_upload_progress">
							<span>Dados do upload:</span>
						</div>
						<div id="divStatus">Nenhum arquivo transferido.</div>
						<div>
							<span id="span_button_place_holder"></span>
							<label class="cancel">
								<input type="reset" id="btn_cancel" value="Cancelar">
							</label>
						</div>
					</form>
				</div>
				<div class="block_content">
					<ul class="imglist">
						<?php foreach ( $product_photos as $photo ) { ?>
						<li>
							<?php echo( $photo->photo_t ); ?>
							<ul>
								<li class="view"><?php echo( $photo->photo ); ?></li>
								<li class="delete"><a href="<?php echo( $page[ 'url' ] ); ?>remove_photo/<?php echo( $fields[ 'id' ] ); ?>/<?php echo( $photo->id ); ?>">Remover</a></li>
							</ul>
						</li>
						<?php } ?>
					</ul>
				</div>
				<!-- .block_content ends -->
				<div class="bendl"></div>
				<div class="bendr"></div>
			</div>
			<?php } ?>