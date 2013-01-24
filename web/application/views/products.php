	<section class="products">
	<?php echo html::ie_tag( 'section', 'products' ); ?>
		<?php foreach( $records as $record ) { ?>
			<a href="<?php html::write( $this->application->products_details ); ?><?php html::write_url( $record->id ); ?>/<?php html::write_url( $record->title ); ?>/"><?php html::write( $record->title ); ?></a>
			<?php html::write( format::decimalus2br( $record->value ) ); ?>
		<?php } ?>
	<?php echo html::ie_tag_close(); ?>
	</section>