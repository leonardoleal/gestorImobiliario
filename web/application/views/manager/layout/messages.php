<?php

if ( is_array( $messages ) )
{
    foreach ( $messages as $type => $msgs )
	{
        foreach ( $msgs as $message )
		{
			if ( $type == 'error' )
			{
				$type = 'errormsg';
			}
		?>
					<div class="message <?php echo $type; ?>">
						<p><?php echo $message; ?></p>
					</div>
		<?
		}
	}
}