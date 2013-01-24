			<div id="<?php html::write( $this->router->class ); ?>" class="block">
				<div class="block_head">
					<div class="bheadl"></div>
					<div class="bheadr"></div>
					<h2><?php html::write( $page[ 'title' ] ); ?></h2>
				</div>
				<!-- .block_head ends -->
				<div class="block_content">
					<?php $this->load->view( 'manager/layout/messages' ); ?>
					<form method="post" action="<?php html::write( $page[ 'url' ] ); ?>search_engine/" enctype="multipart/form-data" class="search_engine">
						<p>
							<label>
								<span>Código:</span>
								<input type="text" name="id" class="text small">
							</label>
						</p>
						<p>
                            <label>
								<span>Finalidade:</span>
							<select name="transaction_type" class="big">
								<?php foreach( $transaction_types as $key => $value ) { ?>
									<option value="<?php html::write( $key ); ?>"><?php html::write( $value ); ?></option>
								<?php } ?>
							</select>
							<select name="type" class="big">
								<?php foreach( $types as $key => $value ) { ?>
									<option value="<?php html::write( $key ); ?>"><?php html::write( $value ); ?></option>
								<?php } ?>
							</select>
							</label>
						</p>


						<p>
							<label>
								<span>Estado:</span>
								<select name="state_id" class="big">
									<option value="">Selecione um estado</option>
									<?php foreach( $states as $state ) { ?>
									<option value="<?php html::write( $state->id ); ?>"><?php html::write( $state->alias ); ?></option>
									<?php } ?>
								</select>
							</label>
						</p>
						<p>
							<label>
								<span>Cidade:</span>
								<select name="city_id" class="big">
									<?php if ( empty( $fields[ 'city_id' ] ) ) { ?>
									<option value="">Selecione um estado</option>
									<?php } else { ?>
									<option value="">Selecione uma cidade</option>
									<?php foreach( $cities as $city ) { ?>
									<option value="<?php html::write( $city->id ); ?>"><?php html::write( $city->name ); ?></option>
									<?php } ?>
									<?php } ?>
								</select>
							</label>
						</p>
						<p>
							<label>
								<span>Bairro:</span>
								<select name="neighborhood_id" class="big">
									<?php if ( empty( $fields[ 'neighborhood_id' ] ) ) { ?>
									<option value="">Selecione uma cidade</option>
									<?php } else { ?>
									<option value="">Selecione um bairro</option>
									<?php foreach( $neighborhoods as $neighborhood ) { ?>
									<option value="<?php html::write( $neighborhood->id ); ?>"><?php html::write( $neighborhood->name ); ?></option>
									<?php } ?>
									<?php } ?>
								</select>
							</label>
						</p>

						<?php foreach( $categories as $key => $category ) { ?>
						<p>
							<label>
								<span><?php html::write( $category->title ); ?>:</span>
							<?php if ( $category->type ) { ?>
							</label>
								<?php foreach( $category->items as $item ) { ?>
								<label><input type="checkbox" name="item[]" value="<?php html::write( $item->id ); ?>"><?php html::write( $item->title ); ?></label>
								<?php } ?>
							<?php } else { ?>
								<select name="item[]" class="big" multiple="multiple">
									<?php foreach( $category->items as $item ) { ?>
									<option value="<?php html::write( $item->id ); ?>"><?php html::write( $item->title ); ?></option>
									<?php } ?>
								</select>
							</label>
							<?php } ?>
						</p>
						<?php } ?>

						<p>
							<label>
								<span>Valor Mínimo:</span>
								<select name="min_value" class="big">
									<option value="">Todos</option>
									<option value="100000.00">100.000,00</option>
									<option value="150000.00">150.000,00</option>
									<option value="200000.00">200.000,00</option>
									<option value="300000.00">300.000,00</option>
									<option value="400000.00">400.000,00</option>
									<option value="500000.00">500.000,00</option>
									<option value="1000000.00">1.000.000,00</option>
								</select>
							</label>
						</p>
						<p>
							<label>
								<span>Valor Máximo:</span>
								<select name="max_value" class="big">
									<option value="">Todos</option>
									<option value="100000.00">100.000,00</option>
									<option value="150000.00">150.000,00</option>
									<option value="200000.00">200.000,00</option>
									<option value="300000.00">300.000,00</option>
									<option value="400000.00">400.000,00</option>
									<option value="500000.00">500.000,00</option>
									<option value="1000000.00">1.000.000,00</option>
								</select>
							</label>
						</p>
						<p>
							<label class="submit">
								<input type="submit" value="Pesquisar">
							</label>
						</p>
					</form>
				</div>
				<div class="bendl"></div>
				<div class="bendr"></div>
			</div>
			<!-- .block ends -->