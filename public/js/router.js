'use strict';

angular.module('Client',[
	'imageupload',
	'satellizer',
	'ui.router',
	'pusher-angular',
	'naif.base64',
	'ngRoute',
	'ngResource'])
	.config(function($stateProvider, $urlRouterProvider, $authProvider){
		// Satellizer configuration that specifies which API
        // route the JWT should be retrieved from
		$authProvider.loginUrl = '/authenticate';

		// $routeProvider
		// .when('/denuncias/view/:id',{
		// 	templateUrl: '/partials/denuncia-form.html',
		// 	controller: 'ViewDenunciaCtrl'
		// });

		$stateProvider

			.state('precioPlataforma', {
				url: '/admin/precio',
				templateUrl: '/partials/precio-plataforma.html',
				controller: 'ListTipoPagoCtrl'
			})

			.state('plataforma', {
				url: '/admin/plataforma',
				templateUrl: '/partials/platform-status.html',
				controller: 'AdminPlataformaCtrl'
			})

			.state('pagos', {
				url: '/admin/pagos',
				templateUrl: '/partials/admin-pagos.html',
				controller: 'ListPagoCtrl'
			})

			.state('rubros', {
				url: '/admin/rubros',
				templateUrl: '/partials/admin-rubros.html',
				controller: 'ListRubroCtrl'
			})

			.state('eventos',{
				url: '/admin/eventos',
				templateUrl: '/partials/evento-list.html',
				controller: 'AdminPlataformaCtrl'
			})

			.state('resenas',{
				url: '/admin/resenas',
				templateUrl: '/partials/resena-list.html',
				controller: 'AdminPlataformaCtrl'
			})

			.state('posts',{
				url: '/admin/posts',
				templateUrl: '/partials/post-list.html',
				controller: 'AdminPlataformaCtrl'
			})

			.state('verPago', {
				url: '/admin/pagos/ver/:id',
				templateUrl: '/partials/admin-pago-form.html',
				controller: 'AdminVerPagoCtrl'
			})

			// admin agregar certificado
			.state('certificadosAdd', {
				url: '/admin/certificados/new',
				templateUrl: '/partials/admin-certificado-form.html',
				controller: 'AdminCreateCertificadoCtrl'
			})

			// admin editar certificado
			.state('certificadosEdit', {
				url: '/admin/certificados/edit/:certId',
				templateUrl: '/partials/admin-certificado-form.html',
				controller: 'AdminEditCertificadoCtrl'
			})

			// admin listar certificados
			.state('certificadosAdmin', {
				url: '/admin/certificados/list',
				templateUrl: '/partials/certificado-list.html',
				controller: 'AdminListCertificadoCtrl'
			})

			// admin editar precios
			.state('editPrecio', {
				url: '/tipopago/edit/:id',
				templateUrl: '/partials/tipo-pago-form.html',
				controller: 'EditTipoPagoCtrl'
			})

			// show login selection
			.state('loginSelect', {
				url: '/login',
				type: 'auth',
				templateUrl: '/partials/login-select.html'
			})

			//show login for proveedor
			.state('loginProveedor', {
				type: 'auth',
				templateUrl: '/partials/login-form.html',
				controller: 'LoginProveedorCtrl'
			})

			//show login for proveedor
			.state('loginCliente', {
				type: 'auth',
				templateUrl: '/partials/login-form.html',
				controller: 'LoginClienteCtrl'
			})

			//show login for admin
			.state('status', {
				type: 'admin',
				templateUrl: '/partials/platform-status.html',
			})

			//show list de clientes
			.state('clientesList', {
				url: '/clientes/list',
				templateUrl: '/partials/listado-cliente.html',
				controller: 'ListClienteCtrl'
			})

			//show form for new cliente
			.state('clientesNew', {
				type: 'auth',
				url: '/clientes/new',
				templateUrl: '/partials/cliente-form.html',
				controller: 'CreateClienteCtrl'
			})

			//show form to edit cliente
			.state('clientesEdit', {
				url: '/edit/',
				templateUrl: '/partials/cliente-form.html',
				controller: 'EditClienteCtrl'
			})

			.state('cambiarPasswordCliente', {
				url: '/edit-password',
				templateUrl: '/partials/cambiar-contraseña-form.html',
				controller: 'CambiarPasswordCtrl'
			})

			//show profile from cliente
			.state('clientesProfile', {
				url: '/clientes/profile/:id',
				templateUrl: '/partials/cliente-profile.html',
				controller: 'ViewClienteCtrl'
			})

			.state('clienteDenuncias', {
				url: '/clientes/profile/:id/denuncias',
				templateUrl: '/partials/denuncia-list.html',
				controller: 'ListClienteDenunciaCtrl'
			})

			.state('clienteResenas', {
				url: '/clientes/profile/:id/resenas',
				templateUrl: '/partials/resena-list.html',
				controller: 'ListClienteResenaCtrl'
			})

		// .when('/clientes/profile/:id',{
		// 	templateUrl: '/partials/cliente-profile.html',
		// 	controller: 'ViewClienteCtrl'
		// })
		// .when('/clientes/profile/:id/eventos/new',{
		// 	templateUrl: '/partials/homepage.html',
		// 	controller: 'HomepageCtrl'
		// })

			//show form for new certificado
			.state('certificadosNew', {
				url: '/proveedores/profile/:id/certificados/new',
				templateUrl: '/partials/certificado-form.html',
				controller: 'CreateCertificadoCtrl'
			})

			.state('certificadosView', {
				url: '/certificados/view/:certId',
				templateUrl: '/partials/admin-certificado-form.html',
				controller: 'ViewCertificadoCtrl'
			})

			.state('certProvView',{
				url: '/proveedores/profile/:id/certificados/view/:certId',
				templateUrl: '/partials/certificado-form.html',
				controller: 'ViewCertificadoCtrl'
			})

			//show list of certificados
			.state('certificadosList', {
				url: '/proveedores/profile/:id/certificados',
				templateUrl: '/partials/certificado-list.html',
				controller: 'RemoveCertificadoCtrl'
			})

			//show list of proveedores
			.state('proveedoresList', {
				url: '/proveedores/list',
				templateUrl: '/partials/proveedor-list.html',
				controller: 'ListProveedorCtrl'
			})

			//show list of proveedores
			.state('proveedoresRubro', {
				url: '/rubro/:rubroName',
				templateUrl: '/partials/rubro-proveedor-list.html',
				controller: 'RubroListCtrl'
			})

			//show form for new proveedor
			.state('proveedoresNew', {
				url: '/proveedores/new',
				templateUrl: '/partials/proveedor-form.html',
				controller: 'CreateProveedorCtrl'
			})

			//show form to edit proveedor
			.state('proveedoresEdit', {
				url: '/proveedores/edit/:id',
				templateUrl: '/partials/proveedor-form.html',
				controller: 'EditProveedorCtrl'
			})

			//show form to view proveedor
			.state('proveedoresView', {
				url: '/proveedores/view/:id',
				templateUrl: '/partials/proveedor-form.html',
				controller: 'ViewProveedorCtrl'
			})

			//show profile of proveedor
			.state('proveedoresProfile', {
				url: '/proveedores/profile/:id',
				templateUrl: '/partials/proveedor-profile.html',
				controller: 'ViewProveedorCtrl'
			})

			//show calendario of proveedor
			.state('proveedoresCalendario', {
				url: '/calendario',
				templateUrl: '/partials/prov-calendar.html',
				controller: 'ProvCalendarCtrl'
			})

			//show form of suscripción
			.state('proveedoresSuscripcion', {
				url: '/suscripcion',
				templateUrl: '/partials/prov-suscripcion.html',
				controller: 'ProvSuscripcionCtrl'
			})
			
			//show list of solicitudes
			.state('solicitudes', {
				url: '/solicitudes',
				templateUrl: '/partials/solicitud-list.html',
				controller: 'SolicitudesCtrl'
			})

			.state('proveedoresPago', {
				url: '/suscripcion/info-pago',
				templateUrl: '/partials/precio-plataforma.html',
				controller: 'ProvSuscripcionCtrl'
			})

			//show list of resultados
			.state('searchResultados', {
				url: '/resultados/:dateMillis/:cantPers',
				templateUrl: '/partials/resultados.html',
				controller: 'SearchCtrl'
			})

			//show form for new cliente
			.state('rubroNew', {
				type: 'admin',
				url: '/rubros/new',
				templateUrl: '/partials/rubro-form.html',
				controller: "CreateRubroCtrl"
			})

			// //show list of resultados
			// .state('searchResultados', {
			// 	url: '/resultados/',
			// 	templateUrl: '/partials/resultados.html',
			// 	controller: 'SearchCtrl'
			// })

			//show form to view post
			.state('postsView', {
				url: '/posts/view/:postId',
				templateUrl: '/partials/post-form.html',
				controller: 'ViewPostCtrl'
			})

			.state('proveedorConversations', {
				url: '/chats',
				templateUrl: '/partials/conversation-list.html',
				controller: 'ProvConversationsCtrl'
			})

			.state('proveedorChat', {
				url: '/chats/:chatId',
				templateUrl: '/partials/chat-view.html',
				controller: 'ProveedorChatCtrl'
			})

			.state('clienteConversations', {
				url: '/chats',
				templateUrl: '/partials/conversation-list.html',
				controller: 'ClienteConversationsCtrl'
			})

			.state('clienteChat', {
				url: '/chats/:chatId',
				templateUrl: '/partials/chat-view.html',
				controller: 'ClienteChatCtrl'
			})


//////////
			//show form to denunciar a post
			.state('denunciarPost',{
				url: '/posts/denunciar/:postId',
				templateUrl: '/partials/denuncia-form.html',
				controller: 'CreateDenunciaCtrl'
			})

			//show list of denuncias
			.state('listDenuncias',{
				type: 'admin',
				url: '/denuncias/list',
				templateUrl: '/partials/denuncia-list.html',
				controller: 'ListDenunciaCtrl'
			})

			//show form to ver denuncia
			.state('verDenuncia',{
				url: '/denuncias/view/:id',
				templateUrl: '/partials/denuncia-form.html',
				controller: 'ViewDenunciaCtrl'
			})
/////////

			//show form for new reseña
			.state('resenasNew', {
				url: '/posts/view/:postId/resenas/new',
				templateUrl: '/partials/resena-form.html',
				controller: 'CreateResenaCtrl'
			})

			//show form to edit reseña
			.state('resenasEdit', {
				url: '/resenas/edit/:resId',
				templateUrl: '/partials/resena-form.html',
				controller: 'EditResenaCtrl'
			})

			.state('resenasView', {
				url: '/resenas/view/:resId',
				templateUrl: '/partials/resena-form.html',
				controller: 'ViewResenaCtrl'
			})

			//show form to edit post
			.state('postsEdit', {
				url: '/posts/edit/:id',
				templateUrl: '/partials/post-form.html',
				controller: 'EditPostCtrl'
			})

			//DELETE- DEMO PURPOSES
			.state('imageDemo', {
				url: '/demo',
				templateUrl: '/partials/demo.html',
				controller: 'DemoCtrl'
			})

			//show form to pagar
			.state('pagar', {
				url: '/pagar/:id',
				templateUrl: 'partials/pago-form.html',
				controller: 'PagoCtrl'
			})

			.state('pagarPost', {
				url: '/pagar/post/:postId',
				templateUrl: 'partials/pago-post-form.html',
				controller: 'PagoPostCtrl'
			})

			.state('pagarRubro', {
				url: '/pagar/rubro',
				templateUrl: 'partials/pago-post-form.html',
				controller: 'PagoRubroCtrl'
			})

			//????????????
			.state('exito', {
				url: '/exito',
				templateUrl: 'partials/exito.html',
				controller: 'ProvSuscExitoCtrl'
			})

			.state('exitoPost', {
				url: '/exito-post/:postId',
				templateUrl: 'partials/exito-post.html',
				controller: 'PostExitoCtrl'
			})

			.state('exitoRubro', {
				url: '/exito-rubro',
				templateUrl: 'partials/exito.html',
				controller: 'RubroExitoCtrl'
			})

			//????????????
			.state('error', {
				url: '/error',
				templateUrl: 'partials/error.html'
			})

			//show homepage
			.state('homepage', {
				url: '/',
				templateUrl: '/partials/homepage.html',
				controller: 'HomepageCtrl'
			})

			//show login for admin
			.state('loginAdmin', {
				type: 'auth',
				url:'/',
				templateUrl: '/partials/login-form.html',
				controller: 'LoginAdminCtrl'
			});

			// //show 404
			// .state('404', {
			// 	url: '/404',
			// 	templateUrl: '/partials/404.html'
			// });

		// catch all route
		// send users to the home page
		$urlRouterProvider.otherwise('/');
	})
	.run(function($transitions, $rootScope) {
		$rootScope.navbarContent = 'navbar.auth.html';
		$transitions.onStart({}, function(trans) {

			var user = JSON.parse(localStorage.getItem('user'));
			if (user) {
				//initialize rootScope
				$rootScope.navbarContent = user.navbarContent;
				$rootScope.authenticated = true;
				$rootScope.currentUser = JSON.parse(localStorage.getItem('user'));
				if (trans.to().type === 'auth') { return trans.router.stateService.target('homepage'); }
			} else if (trans.to().type != 'auth' && trans.to().name != 'homepage') {
				return trans.router.stateService.target('loginSelect');
			}

			if (trans.to().type === 'admin' && user.rol != 'admin'){
				return trans.router.stateService.target('homepage');
			}
		});
    });
// angular.module('Client',[
// 	'imageupload',
// 	'ngResource',
// 	'ngRoute'])
// 	.config(function($routeProvider){
// 		$routeProvider
// 		.when('/clientes/list',{
// 			templateUrl: '/partials/listado-cliente.html',
// 			controller: 'ListClienteCtrl'
// 		})
// 		.when('/login', {
// 		  templateUrl: '/partials/proveedor-login.html',
// 		  controller: 'AuthLoginCtrl',
// 		  controllerAs: 'authLoginCtrl'
// 		})
// 		.when('/clientes/new',{
// 			templateUrl: '/partials/cliente-form.html',
// 			controller: 'CreateClienteCtrl'
// 		})
// 		.when('/clientes/login',{
// 			templateUrl: 'partials/cliente-iniciar-sesion.html',
// 			controller: 'LoginClienteCtrl'
// 		})
// 		.when('/clientes/edit/:id',{
// 			templateUrl: '/partials/cliente-form.html',
// 			controller: 'EditClienteCtrl'
// 		})
// 		.when('/clientes/profile/:id',{
// 			templateUrl: '/partials/cliente-profile.html',
// 			controller: 'ViewClienteCtrl'
// 		})
// 		.when('/certificados/new', {
// 			templateUrl: '/partials/certificado-form.html',
// 			controller: 'CreateCertificadoCtrl'
// 		})
// 		.when('/certificados/list', {
// 			templateUrl: '/partials/certificado-list.html',
// 			controller: 'RemoveCertificadoCtrl'
// 		})
// 		.when('/proveedores/list',{
// 			templateUrl: '/partials/proveedor-list.html',
// 			controller: 'ListProveedorCtrl'
// 		})
// 		.when('/proveedores/new',{
// 			templateUrl: '/partials/proveedor-form.html',
// 			controller: 'CreateProveedorCtrl'
// 		})
// 		.when('/proveedores/edit/:id',{
// 			templateUrl: '/partials/proveedor-form.html',
// 			controller: 'EditProveedorCtrl'
// 		})
// 		.when('/proveedores/view/:id',{
// 			templateUrl: '/partials/proveedor-form.html',
// 			controller: 'ViewProveedorCtrl'
// 		})
// 		.when('/proveedores/profile/:id',{
// 			templateUrl: '/partials/proveedor-profile.html',
// 			controller: 'ViewProveedorCtrl'
// 		})
// 		.when('/proveedores/profile/:id/calendario',{
// 			templateUrl: '/partials/prov-calendar.html',
// 			controller: 'ProvCalendarCtrl'
// 		})
// 		.when('/proveedores/profile/:id/suscripcion',{
// 			templateUrl: '/partials/prov-suscripcion.html',
// 			controller: 'ProvSuscripcionCtrl'
// 		})
// 		.when('/resultados/:dateMillis/:cantPers',{
// 			templateUrl: '/partials/resultados.html',
// 			controller: 'SearchCtrl'
// 		})
// 		.when('/resultados/',{
// 			templateUrl: '/partials/resultados.html',
// 			controller: 'SearchCtrl'
// 		})
// 		.when('/posts/view/:postId',{
// 			templateUrl: '/partials/post-form.html',
// 			controller: 'ViewPostCtrl'
// 		})
// 		.when('/posts/view/:postId/resenas/new',{
// 			templateUrl: '/partials/resena-form.html',
// 			controller: 'CreateResenaCtrl'
// 		})
// 		.when('/resenas/edit/:resId',{
// 			templateUrl: '/partials/resena-form.html',
// 			controller: 'EditResenaCtrl'
// 		})
// 		.when('/posts/edit/:id',{
// 			templateUrl: '/partials/post-form.html',
// 			controller: 'EditPostCtrl'
// 		})
// 		.when('/demo',{
// 			templateUrl: '/partials/demo.html',
// 			controller: 'DemoCtrl'
// 		})
// 		.when('/pagar/:id',{
// 			templateUrl: 'partials/pago-form.html',
// 			controller: 'PagoCtrl'
// 		})
// 		.when('/exito',{
// 			templateUrl: 'partials/exito.html'
// 		})
// 		.when('/error',{
// 			templateUrl: 'partials/error.html'
// 		})
// 		.when('/',{
// 			templateUrl: '/partials/homepage.html',
// 			controller: 'HomepageCtrl'
// 		})
// 		.otherwise({
// 			redirectTo: '/'
// 		});
// 	});
