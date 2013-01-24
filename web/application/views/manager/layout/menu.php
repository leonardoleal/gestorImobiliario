		<ul id="nav">
			<li><a href="javascript:void(0);" class="products">Imóveis</a>
				<ul>
					<li><a href="<?php echo base_url() . $this->config->item( 'manager_uri' ) . 'products/'; ?>">Gerenciar</a></li>
					<li><a href="<?php echo base_url() . $this->config->item( 'manager_uri' ) . 'products/outdated/'; ?>">Desatualizados</a></li>
					<li><a href="<?php echo base_url() . $this->config->item( 'manager_uri' ) . 'products/save/'; ?>">Cadastrar</a></li>
					<li class="separator"><a href="javascript:void(0);">Operações</a>
						<ul>
							<li><a href="<?php echo base_url() . $this->config->item( 'manager_uri' ) . 'operations/'; ?>">Gerenciar</a></li>
							<li><a href="<?php echo base_url() . $this->config->item( 'manager_uri' ) . 'operations/save/'; ?>">Cadastrar</a></li>
						</ul>
					</li>
					<li class="separator"><a href="javascript:void(0);">Categorias</a>
						<ul>
							<li><a href="<?php echo base_url() . $this->config->item( 'manager_uri' ) . 'categories/'; ?>">Gerenciar</a></li>
							<li><a href="<?php echo base_url() . $this->config->item( 'manager_uri' ) . 'categories/save/'; ?>">Cadastrar</a></li>
						</ul>
					</li>
				</ul>
			</li>
			<li><a href="javascript:void(0);" class="customers">Clientes</a>
				<ul>
					<li><a href="<?php echo base_url() . $this->config->item( 'manager_uri' ) . 'customers/'; ?>">Gerenciar</a></li>
					<li><a href="<?php echo base_url() . $this->config->item( 'manager_uri' ) . 'customers/save/'; ?>">Cadastrar</a></li>
				</ul>
			</li>
			<li><a href="javascript:void(0);" class="realtors">Corretores</a>
				<ul>
					<li><a href="<?php echo base_url() . $this->config->item( 'manager_uri' ) . 'realtors/'; ?>">Gerenciar</a></li>
					<li><a href="<?php echo base_url() . $this->config->item( 'manager_uri' ) . 'realtors/save/'; ?>">Cadastrar</a></li>
				</ul>
			</li>
			<?php if ( site::is_admin() ) { ?>
			<li><a href="javascript:void(0);" class="statistics">Estatísticas</a>
				<ul>
					<li><a href="<?php echo base_url() . $this->config->item( 'manager_uri' ) . 'statistics/access_log/per_page/'; ?>">Acessos x Página</a></li>
					<li><a href="<?php echo base_url() . $this->config->item( 'manager_uri' ) . 'statistics/access_log/per_product/'; ?>">Acessos x Imóvel</a></li>
					<li><a href="<?php echo base_url() . $this->config->item( 'manager_uri' ) . 'statistics/operation/per_sale/'; ?>">Operações - Venda</a></li>
					<li><a href="<?php echo base_url() . $this->config->item( 'manager_uri' ) . 'statistics/operation/per_rent/'; ?>">Operações - Aluguel</a></li>
				</ul>
			</li>
			<li><a href="javascript:void(0);" class="tools">Ferramentas</a>
				<ul>
					<li class="separator"><a href="javascript:void(0);">Arquivos</a>
						<ul>
							<li><a href="<?php echo base_url() . $this->config->item( 'manager_uri' ) . 'files/'; ?>">Gerenciar</a></li>
							<li><a href="<?php echo base_url() . $this->config->item( 'manager_uri' ) . 'files/save/'; ?>">Cadastrar</a></li>
						</ul>
					</li>
					<li><a href="<?php echo base_url() . $this->config->item( 'manager_uri' ) . 'tools/'; ?>">Assinantes de Newsletter</a></li>
					<li><a href="<?php echo base_url() . $this->config->item( 'manager_uri' ) . 'tools/'; ?>">Webmail</a></li>
					<li><a href="<?php echo base_url() . $this->config->item( 'manager_uri' ) . 'tools/'; ?>">Atendimento On-line</a></li>
					<li><a href="<?php echo base_url() . $this->config->item( 'manager_uri' ) . 'tools/'; ?>">Help Desk</a></li>
				</ul>
			</li>
			<li><a href="javascript:void(0);" class="configurations">Configurações</a>
				<ul>
					<li><a href="<?php echo base_url() . $this->config->item( 'manager_uri' ) . 'configurations/'; ?>">Gerais</a></li>
					<li class="separator"><a href="javascript:void(0);">Páginas Personalizadas</a>
						<ul>
							<li><a href="<?php echo base_url() . $this->config->item( 'manager_uri' ) . 'pages/'; ?>">Gerenciar</a></li>
							<li><a href="<?php echo base_url() . $this->config->item( 'manager_uri' ) . 'pages/save/'; ?>">Cadastrar</a></li>
						</ul>
					</li>
					<li class="separator"><a href="javascript:void(0);">Usuários Administrativos</a>
						<ul>
							<li><a href="<?php echo base_url() . $this->config->item( 'manager_uri' ) . 'users/'; ?>">Gerenciar</a></li>
							<li><a href="<?php echo base_url() . $this->config->item( 'manager_uri' ) . 'users/save/'; ?>">Cadastrar</a></li>
						</ul>
					</li>
					<li><a href="<?php echo base_url() . $this->config->item( 'manager_uri' ); ?>">Plano COMBO</a></li>
				</ul>
			</li>
			<?php } ?>
		</ul>
