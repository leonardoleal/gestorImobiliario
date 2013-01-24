			<!-- wrapper begins -->
			<div id="<?php html::write( $this->router->class ); ?>" class="block small center login">
				<div class="block_head">
					<div class="bheadl"></div>
					<div class="bheadr"></div>
					<h2>Login</h2>
					<ul>
						<li><a href="<?php echo( base_url() ); ?>">voltar para o site</a></li>
					</ul>
				</div>
				<!-- .block_head ends -->
				<div class="block_content">
					<?php $this->load->view( 'manager/layout/messages' ); ?>
					<form method="post" action="<?php echo( base_url() . $this->config->item( 'manager_uri' ) ); ?>users/test/">
						<p>
							<label>
                            		<span>Usuário:</span>
								<input type="text" name="login" class="text">
							</label>
						</p>
						<p>
							<label>
                            			<span>Senha:</span>
								<input type="password" name="password" class="text">
							</label>
						</p>
						<p>
							<label class="submit">
								<input type="submit" value="Entrar">
							</label>
							<!--
							<input type="checkbox" class="checkbox" checked="checked" id="rememberme">
							<label for="rememberme">Mantenha-me conectado</label>
							-->
						</p>
					</form>
				</div>
				<!-- .block_content ends -->
				<div class="bendl"></div>
				<div class="bendr"></div>
			</div>
			<!-- .login ends -->