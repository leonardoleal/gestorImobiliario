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
                            	<span>Nome:</span>
								<input type="text" name="name" class="text big" value="<?php html::write( $fields[ 'name' ] ); ?>">
							</label>
						</p>
						<p>
							<label>
                            	<span>CPF:</span>
								<input type="text" name="cpf" class="text small" value="<?php html::write( $fields[ 'cpf' ] ); ?>" alt="cpf">
							</label>
						</p>
						<p>
							<label>
                            	<span>RG:</span>
								<input type="text" name="rg" class="text small" value="<?php html::write( $fields[ 'rg' ] ); ?>">
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
                            	<span>E-mail:</span>
								<input type="text" name="email" class="text big email" value="<?php html::write( $fields[ 'email' ] ); ?>">
							</label>
						</p>
						<p>
							<label>
                            	<span>Telefone:</span>
								<input type="text" name="phone" alt="phone" class="text big" value="<?php html::write( $fields[ 'phone' ] ); ?>">
							</label>
						</p>
						<p>
							<label>
                            	<span>Telefone (Secundário):</span>
								<input type="text" name="phone2" alt="phone" class="text big" value="<?php html::write( $fields[ 'phone2' ] ); ?>">
							</label>
						</p>
						<p>
							<label>
                            	<span>Celular:</span>
								<input type="text" name="cellphone" alt="phone" class="text big" value="<?php html::write( $fields[ 'cellphone' ] ); ?>">
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