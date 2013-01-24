	<section class="products_details">
	<?php echo html::ie_tag( 'section', 'products_details' ); ?>
		<h2>Detalhe do Imóvel:</h2>
		<div class="photos">
		</div>
		<div class="details">
			<p>
				<label>Código:</label> <span><?php html::write( format::fill( $record->id ) ); ?></span>
			</p>
			<p>
				<label>Tipo:</label> <span><?php html::write( $record->get_type( $record->type ) . ' / ' . $record->get_transaction_type( $record->transaction_type ) ); ?></span>
			</p>
			<p>
				<label>Bairro:</label> <span><?php html::write( $record->neighborhood_name ); ?></span>
			</p>
			<p>
				<label>Cidade:</label> <span><?php html::write( $record->city_name ); ?></span>
			</p>
			<p>
				<label>Valor:</label> <span><?php html::write( format::decimalus2br( $record->value ) ); ?></span>
			</p>
		</div>
		<p><?php html::write_text_area( $record->description ); ?></p>
	<?php echo html::ie_tag_close(); ?>
	</section>