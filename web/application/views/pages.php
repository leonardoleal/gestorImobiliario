	<section class="dinamics">
	<?php echo html::ie_tag( 'section', 'dinamics' ); ?>
		<h2><?php html::write( $record->alias ); ?></h2>
		<?php html::write_text_area( $record->content ); ?>
	<?php echo html::ie_tag_close(); ?>
	</section>