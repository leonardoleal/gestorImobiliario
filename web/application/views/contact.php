	<section class="contact">
	<?php echo html::ie_tag( 'section', 'contact' ); ?>
		<div class="message"><?php html::write( $this->session->flashdata( 'contact_message' ) ); ?></div>
		<form action="<?php html::write( $this->application->contact_send ); ?>" method="post">
			<?php foreach( $this->application->config->contact_form as $field ) { ?>
				<label>
					<span><?php html::write( $field->alias ); ?>:</span>
					<input type="text" name="<?php html::write( $field->title ); ?>">
				</label>
			<?php } ?>
			<label class="submit">
				<input type="submit" value="Enviar">
			</label>
		</form>
	<?php echo html::ie_tag_close(); ?>
	</section>