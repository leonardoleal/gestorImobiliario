var categories = 
{
	form:	null,


	init: function()
	{
		if( $( '#categories_form' ).exists() )
		{
			categories.form = $( '#categories_form form' );

			categories.bind();
		}
	},


	bind: function()
	{
		categories.form.delegate( 'input[name="item_title[]"]:empty', 'change', categories.add_fields );

		categories.form.delegate( 'a.remove.item', 'click', categories.remove_item );
	},


	add_fields: function()
	{
		if ( categories.form.find( 'input[name="item_title[]"]:last' ).val().trim() != '' )
		{
			categories.form.find( 'tbody' ).append(
				'<tr>' +
				'	<td><input type="text" name="item_title[]" class="text big"></td>' +
				'	<td></td>' +
				'	<td class="actions"></td>' +
				'</tr>'
			);

			categories.form.find( 'input[name="item_title[]"]:last' ).focus();
		}
	},


	remove_item: function( e )
	{
		e.preventDefault();

		$.ajax(
		{
			type: 'GET',
			url: e.currentTarget.href,
			dataType: 'json',
			success: function( data )
			{
				if( data )
				{
					$( e.currentTarget ).parents( 'tr' ).remove();
				}
				else
				{
					alert( 'Erro ao tentar excluir o item.\nAtualiza a página e tente novamente.' );
				}
			}
		});
	}
};


var customers = 
{
	form:	null,


	init: function()
	{

		if( $( '#customers_form' ).exists() )
		{
			customers.form = $( '#customers_form form' );

			location_fill.init();
			customers.validate();			
		}
		else if ( $( '#customers_list' ).exists() )
		{
			form_action.init( 'customers' );
		}
		
	},


	validate: function()
	{
		customers.form.validate(
		{
			rules:
			{
				email:	{ required: true, email: true }
			},

			messages:
			{
				email:	{ required: 'Obrigatório o preenchimento deste campo', email: 'E-mail inválido, preencha corretamente.' }
			},

			submitHandler: function( form )
			{
				form.submit();
			}
		});
	}
};


var operations =
{
	form: null,


	init: function()
	{
		if( $( '#operations_form' ).exists() )
		{
			operations.form = $( '#operations_form form' );

			operations.bind();
		}
	},


	bind: function()
	{
		operations.form.delegate( 'select[name="transaction_type"]', 'change', operations.add_fields );
	},


	add_fields: function( e )
	{
		if ( e.currentTarget.value == 1  )
		{
			$( e.currentTarget ).parents( 'p' ).after(
				'<p>' +
				'	<label>' +
		        '    	<span>Data inicial:</span>' +
				'		<input type="text" class="text date_picker" name="date_start">' +
				'	</label>' +
				'	<label>' +
				'		<span>Data final:</span>' +
				'		<input type="text" class="text date_picker" name="date_end">' +
				'	</label>' +
				'</p>'
			);
			$('input.date_picker').date_input();
		}
		else
		{
			$( '.date_picker' ).parents( 'p' ).remove();
		}
	},
};


var products = 
{
	form:	null,


	init: function()
	{
		if( $( '#products_form' ).exists() )
		{
			products.form = $( '#products_form form' );

			products.bind();
			location_fill.init();
			swfupload.init();
		}
		else if ( $( '#products_list' ).exists() )
		{
			products.bind_list();
			form_action.init( 'products' );
		}
	},


	bind: function()
	{
		
	},


	bind_list: function()
	{
		$( 'a.search_engine' ).bind( 'click', function()
		{
			return hs.htmlExpand(this, {
				width: 600,
				contentId: 'search_engine',
				wrapperClassName: 'highslide-white',
				outlineType: 'rounded-white',
				outlineWhileAnimating: true,
				objectType: 'ajax',
				preserveContent: true
			});
		});
	}
};


var realtors = 
{
	form:	null,


	init: function()
	{
		if( $( '#realtors_form' ).exists() )
		{
			realtors.form = $( '#realtors_form form' );

			location_fill.init();
			realtors.validate();	
		}
		else if( $( '#realtors_list' ).exists() )
		{
			form_action.init( 'realtors' );
		}
	},


	validate: function()
	{
		realtors.form.validate(
		{
			rules:
			{
				email:	{ required: true, email: true }
			},

			messages:
			{
				email:	{ required: 'Obrigatório o preenchimento deste campo', email: 'E-mail inválido, preencha corretamente.' }
			},

			submitHandler: function( form )
			{
				form.submit();
			}
		});
	}
};


var statistics =
{
	form:	null,


	init: function()
	{
		if( $( '#statistics_form' ).exists() )
		{
			statistics.form = $( '#statistics_form form' );

			statistics.bind();
		}
	},


	bind: function()
	{
		$( '.date_picker[name="date_start"]' ).next().find( 'span.month_name' ).bind( 'click', function()
		{
			$( this ).parents( '.nav' ).next().find('.selectable_day:eq(0)').trigger( 'click' );
		});

		$( '.date_picker[name="date_end"]' ).next().find( 'span.month_name' ).bind( 'click', function()
		{
			$( this ).parents( '.nav' ).next().find('.selectable_day:last').trigger( 'click' );
		});

		$( '.date_picker[name="date_start"]' ).next().find( 'span.year_name' ).bind( 'click', function()
		{
			$( this ).parents( '.nav' ).next().find('.selectable_day:eq(0)').trigger( 'click' );
		});

		$( '.date_picker[name="date_end"]' ).next().find( 'span.year_name' ).bind( 'click', function()
		{
			$( this ).parents( '.nav' ).next().find('.selectable_day:last').trigger( 'click' );
		});

		$( 'input[name="period"]' ).bind( 'change', function( e )
		{
			var type = e.currentTarget.value;

			switch ( type )
			{
				case 'year':
					$( 'input[name="date_start"]' ).parents( 'p' ).css( 'display', 'block' );
					$( 'input[name="date_end"]' ).parents( 'p' ).css( 'display', 'block' );
					break;

				case 'month':
					$( 'input[name="date_end"]' ).parents( 'p' ).css( 'display', 'none' );
					break;

				case 'day':
					$( 'input[name="date_end"]' ).parents( 'p' ).css( 'display', 'none' );
					break;

				default:
					$( 'input[name="date_start"]' ).parents( 'p' ).css( 'display', 'block' );
					$( 'input[name="date_end"]' ).parents( 'p' ).css( 'display', 'block' );
			}
		});
	}
};


var users =
{
	form: null,


	init: function()
	{
		if( $( '#users_form' ).exists() )
		{
			users.form = $( '#users_form form' );

			users.validate();
		}
	},


	validate: function()
	{
		users.form.validate(
		{
			rules:
			{
				email:	{ required: true, email: true }
			},

			messages:
			{
			   email:	{ required: 'Obrigatório o preenchimento deste campo', email: 'E-mail inválido, preencha corretamente.' }
			},

			submitHandler: function( form )
			{
				form.submit();
			}
		});
	}
};


var location_fill =
{
	init: function()
	{
		location_fill.bind();
	},


	bind: function()
	{
		$( 'body' ).delegate( 'select[name="state_id"]', 'change', location_fill.cities );
		$( 'body' ).delegate( 'select[name="city_id"]', 'change', location_fill.neighborhoods );
	},


	cities: function( e )
	{
		var state_id = e.currentTarget.value;


		// busca os cidades
		$.ajax(
		{
			url: config.manager.url + 'locations/get_cities',
			type: 'POST',
			data: { state_id: state_id },
			dataType: 'json',
			success: function( data )
			{
				var options = '<option value="">Selecione um estado</option>';

				if ( data.status != 'error' )
				{
					var cities	= data.data;
					options = '<option value="">Selecione uma cidade</option>';

					for ( var key in cities )
					{
						options += '<option value="' + cities[ key ][ 'id' ] + '">' + cities[ key ][ 'name' ] + '</option>';
					}
				}

				$( e.currentTarget ).parents( 'p' ).next().find( 'select' ).html( options );
				$( e.currentTarget ).parents( 'p' ).next().find( '.cmf-skinned-text' ).text( 'Selecione uma cidade' );
			}
		});
	},


	neighborhoods: function( e )
	{
		var city_id = e.currentTarget.value;


		// busca os bairros
		$.ajax(
		{
			url: config.manager.url + 'locations/get_neighborhoods',
			type: 'POST',
			data: { city_id: city_id },
			dataType: 'json',
			success: function( data )
			{
				var options = '<option value="">Selecione uma cidade</option>';

				if ( data.status != 'error' )
				{
					var neighborhoods	= data.data;
					options = '<option value="">Selecione um bairro</option>';

					for ( var key in neighborhoods )
					{
						options += '<option value="' + neighborhoods[ key ][ 'id' ] + '">' + neighborhoods[ key ][ 'name' ] + '</option>';
					}
				}

				$( e.currentTarget ).parents( 'p' ).next().find( 'select' ).html( options );
				$( e.currentTarget ).parents( 'p' ).next().find( '.cmf-skinned-text' ).text( 'Selecione um bairro' );
			}
		});
	}
};


var form_action =
{
	target_controller: null,

	init: function( target )
	{
		form_action.target_controller = target;

		form_action.bind();
	},


	bind: function()
	{
		$( 'select[name="action"]' ).bind( 'change', form_action.change_action );
	},


	change_action: function( e )
	{
		//
		// recebe valor selecionado 
		//  pega o form
		//   busca a url
		//
		var action		= null;
		var action_id	= e.currentTarget.value;
		var form		= $( e.currentTarget ).parents( 'form' );
		var url			= config.manager.url;


		switch ( action_id )
		{
			case '1':
				action = 'remove';
				break;

			case '2':
				action = 'export';
				break;

			default:
				action = '?';
				break;
		}

		form.attr( 'action', url + form_action.target_controller + '/' + action );
	}
};


var swfupload = 
{
	object:			null,
	project_id:		null,
	settings:		null,
	cancel_button:	'btn_cancel',


	init: function()
	{
		swfupload.project_id	= $( 'input[name="id"]' ).val();
		swfupload.conf();
		swfupload.bind();
		swfupload.object		= new SWFUpload( swfupload.settings );
	},


	bind: function()
	{
		$( '#' + swfupload.cancel_button ).bind( 'click', function()
		{
			swfupload.object.cancelQueue();
		});
	},


	conf: function()
	{
		swfupload.settings = {
			flash_url : config.manager.static_url + 'flash/swfupload.swf',
			upload_url: config.manager.upload_url + swfupload.project_id,
			// post_params: { 'name' : 'value' },
			file_size_limit : "100 MB",
			file_types : '*.png;*.jpg;*.png',
			file_types_description : 'Somente Imagens',
			file_upload_limit : 10000,
			file_queue_limit : 0,
			custom_settings : {
				progressTarget : 'fs_upload_progress',
				cancelButtonId : swfupload.cancel_button
			},
			debug: false,

			// Button settings
			button_image_url: config.manager.static_url + 'img/upload_rounded.gif',
			button_width: '85',
			button_height: '30',
			button_placeholder_id: 'span_button_place_holder',
			button_text: '',
			button_text_style: '.theFont {}',
			button_text_left_padding: 12,
			button_text_top_padding: 3,
			button_window_mode: 'transparent',

			// The event handler functions are defined in handlers.js
			file_queued_handler : fileQueued,
			file_queue_error_handler : fileQueueError,
			file_dialog_complete_handler : fileDialogComplete,
			upload_start_handler : uploadStart,
			upload_progress_handler : uploadProgress,
			upload_error_handler : uploadError,
			upload_success_handler : uploadSuccess,
			upload_complete_handler : uploadComplete,
			queue_complete_handler : queueComplete	// Queue plugin event
		};
	},


	//
	// função chamada no arquivo swfupload.handlers.js
	//
	refresh: function()
	{
		var product_id = $( 'input[name="id"]' ).val();

		$.ajax(
		{
			url: config.manager.url + 'products/get_new_photo/' + product_id,
			type: 'GET',
			dataType: 'json',
			success: function( data )
			{
				if ( data.status != 'error' )
				{
					$( '.imglist' ).append(	data.html );

					//
					// reativa o facebox
					//
					$('a[rel*=facebox]').facebox();
				}
			}
		});
	}
 };


var set_masks =
{
	init: function()
	{
		$('input:text').setMask();
	}
};

var resize_wrapper = 
{
	init: function()
	{
		$( '.wrapper' ).height( $( window ).height() - $( '#header' ).height() );
	}
};


var $extends = {
	init: function()
	{
		jQuery.fn.exists = function()
		{
			return jQuery( this ).length > 0;
		};

		jQuery.fn.is_section = function()
		{
			return jQuery( this ).exists();
		};
	}
};


$( document ).ready( function()
{
	$extends.init();
	resize_wrapper.init();
	categories.init();
	customers.init();
	operations.init();
	products.init();
	realtors.init();
	statistics.init();
	users.init();
	set_masks.init();
});