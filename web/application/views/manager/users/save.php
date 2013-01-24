			<div id="<?php html::write( $this->router->class ); ?>_form" class="block">
				<div class="block_head">
					<div class="bheadl"></div>
					<div class="bheadr"></div>
					<h2><?php html::write( $page[ 'title' ] ); ?></h2>
				</div>
				<!-- .block_head ends -->
				<div class="block_content">
					<?php $this->load->view( 'manager/layout/messages' ); ?>
					<form method="post" action="<?php html::write( $page[ 'url' ] ); ?>update/">
						<input type="hidden" name="id" value="<?php html::write( $fields[ 'id' ] ); ?>">
						<p>
							<label>
                            			<span>Nome:</span>
								<input type="text" name="name" class="text big" value="<?php html::write( $fields[ 'name' ] ); ?>">
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
                            			<span>Usuário:</span>
								<input type="text" name="login" class="text big" value="<?php html::write( $fields[ 'login' ] ); ?>">
							</label>
						</p>
						<p>
							<label>
                            			<span>Senha:</span>
								<input type="password" name="password" class="text big">
							</label>
						</p>
						<p>
							<label class="submit">
								<input type="submit" value="Salvar">
							</label>
						</p>
					</form>
				</div>
				<!-- .block_content ends -->
				<div class="bendl"></div>
				<div class="bendr"></div>
			</div>
			<!-- .block ends -->
