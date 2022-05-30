'use strict';

angular.module('Client')

    .controller('CreateCertificadoCtrl', function($scope, $stateParams,
                                                  ProveedorResource, CertificadoResource,
                                                  CertificadoProveedorResource, $state, $filter){
        $scope.title = "Agregar Certificado";
        $scope.button = "Agregar";
        $scope.action = 'clienteNewCertificado';
        $scope.certificado = {};
        // console.log("state: " + $stateParams.id);
        $scope.proveedor = ProveedorResource.get({ id: $stateParams.id });
        // console.log("prov_rubroID: " + $scope.proveedor.rubro_id);
        $scope.proveedor.$promise.then(function(data){

          $scope.certificados = CertificadoResource.query({action: 'rubro', rubroId: $scope.proveedor.rubro_id});
        })
        
        $scope.saveCertificado = function() {
          $scope.certificado.proveedor_id = $scope.proveedor.id;
          $scope.certificado.certificado_id = $scope.certificado.tipo.id;
          $scope.certificado.fecha = $filter('date')($scope.certificado.fecha,"yyyy-MM-dd");
          $scope.certificado = CertificadoProveedorResource.save($scope.certificado);
          $scope.certificado.$promise.then(function(data){
            $scope.data = angular.copy(data);
            $scope.data.fecha = new Date($filter('date')($scope.data.fecha,"yyyy-MM-dd HH:mm:ss Z"));
            $scope.certificado = $scope.data;
            alert("Certificado agregado correctamente");
            $state.go('certificadosList', {id: $stateParams.id});
          }, function(error){
            alert('Error: ' + error);
            return;
          });
        };
    })

    .controller('AdminListCertificadoCtrl', function($scope, $stateParams,$state, ProveedorResource, 
                                                    CertificadoResource){
      $scope.certificados = CertificadoResource.query();

      $scope.viewAdminCertificado = function(id){
        $state.go('certificadosView', {certId: id});
      };
      $scope.editAdminCertificado = function(id){
        $state.go('certificadosEdit', {certId: id});
      };

      $scope.removeCertificado = function(certificado){
        // var rta = confirm("¿Desea borrar este certificado?");
          if(confirm("¿Desea borrar este certificado?")){
            CertificadoResource.delete({id: certificado.id});
            var index = $scope.certificados.indexOf(certificado);
            $scope.certificados.splice(index, 1);
          }
      }
    })

    .controller('AdminCreateCertificadoCtrl', function($scope,$http, $stateParams, RubroResource, 
                                                        CertificadoResource, $state){
      $scope.title = "Crear Certificado";
      $scope.button = "Crear";
      $scope.action = 'adminNewCertificado';
      var rubros = [];
      $scope.rubros = RubroResource.query({ action: 'posts'});
      document.getElementById("cert_obligatorio").checked = true;

      $scope.agregarRubro = function(rubroId){
        rubros.push(rubroId);
      }

      $scope.certificado = {};
      $scope.saveCertificado = function() {
        $scope.rbrs.forEach(function(rubro) {
          rubros.push(rubro.id);
        });
        // $scope.certificado.rubro_id = $scope.certificado.rubro.id;
        // $scope.certificado = CertificadoResource.save($scope.certificado,{rubros: rubros});
        $scope.certificado = $http({
          				headers: {
          					'Content-Type': 'application/json'
          				},
          				url: 'certificado/add',
          				method: "POST",
          				data: {
                    rubros: rubros,
                    titulo: $scope.certificado.titulo,
                    obligatorio: $scope.certificado.obligatorio,
                    descripcion: $scope.certificado.descripcion
          				}
                }).then(function(){
                  alert("Certificado creado correctamente");
                  $state.go('certificadosAdmin');
                },function(error){
                  alert("Error: " + error);
                  return;
                });
        // $scope.certificado.$promise.then(function(data){
        //   alert("Certificado creado correctamente");
        //   $state.go('homepage');
        // },function(error){
        //   alert("Error: " + error);
        //   return;
        // })
      };
    })

    .controller('AdminEditCertificadoCtrl', function($scope, $rootScope, $stateParams, CertificadoProveedorResource,
      CertificadoResource, RubroResource, $state, $http){
        $scope.action = 'edit';
        $scope.button = "Guardar";
        $scope.rubros = RubroResource.query({ action: 'posts'});
        if($rootScope.currentUser.rol == 'admin'){
          $scope.certificado = CertificadoResource.get({id: $stateParams.certId});
          // $scope.saveCertificado = function(){
          //   $scope.certificado = CertificadoResource.update($scope.certificado);
            $scope.certificado.$promise.then(function(data){
              $scope.title = "Certificado # " + $scope.certificado.id;
          //     $scope.certificado = data;
          //     alert("Certificado actualizado");
          //     $state.go('certificadosAdmin');
            });
          // }
          var rubros= [];
          $scope.saveCertificado = function() {
            $scope.rbrs.forEach(function(rubro) {
              rubros.push(rubro.id);
            });
            // $scope.certificado.rubro_id = $scope.certificado.rubro.id;
            // $scope.certificado = CertificadoResource.save($scope.certificado,{rubros: rubros});
            $scope.certificado = $http({
                      headers: {
                        'Content-Type': 'application/json'
                      },
                      url: 'certificado/add',
                      method: "PUT",
                      data: {
                        id: $scope.certificado.id,
                        rubros: rubros,
                        titulo: $scope.certificado.titulo,
                        obligatorio: $scope.certificado.obligatorio,
                        descripcion: $scope.certificado.descripcion
                      }
                    }).then(function(){
                      alert("Certificado actualizado");
                      $state.go('certificadosAdmin');
                    },function(error){
                      alert("Error: " + error);
                      return;
                    });
          };
          $scope.cancelar = function(){
            $state.go('certificadosAdmin');
          }
        }
    })

    .controller('ViewCertificadoCtrl', function($scope, $rootScope, $stateParams, CertificadoProveedorResource,
                                                CertificadoResource, RubroResource, $state, $filter){
      $scope.action = 'view';
      if($rootScope.currentUser.rol == 'admin'){
        console.log("admin");
        $scope.certificado = CertificadoResource.get({id: $stateParams.certId});  
        $scope.certificado.$promise.then(function(data){
          $scope.title = "Certificado # " + $scope.certificado.id;
          $scope.rubros = $scope.certificado.rubros;
          // var rubro = RubroResource.get({id: $scope.certificado.rubro_id});
          // rubro.$promise.then(function(data){
          //   $scope.certificado.rubro = data.nombre;
          // });
        });
      }
      if($rootScope.currentUser.rol == 'proveedor'){
        $scope.certificado = CertificadoProveedorResource.get({id: $stateParams.certId});
        $scope.certificado.$promise.then(function(data){
          $scope.title = "Certificado # " + $scope.certificado.id;
          $scope.cert = CertificadoResource.get({id: $scope.certificado.certificado_id});
          $scope.cert.$promise.then(function(data){
            $scope.certificado.descripcion = $scope.cert.titulo;
          })
          // $scope.certificado.fecha = $filter('date')($scope.certificado.fecha,"yyyy-MM-dd");
          // $scope.data = angular.copy(data);
          // $scope.data.fecha = new Date($filter('date')($scope.data.fecha,"yyyy-MM-dd HH:mm:ss Z"));
        });
      }
    })

    .controller('RemoveCertificadoCtrl', function($scope, $stateParams,$state,
                                                  ProveedorResource, CertificadoProveedorResource){
        $scope.proveedor = ProveedorResource.get({ id: $stateParams.id });
        // $scope.certificados = CertificadoResource.query();
        // console.log("proveedor remove: " + $scope.proveedor.id);
        $scope.proveedor.$promise.then(function(data){
          $scope.certificados = $scope.proveedor.certificados;
        },function(error){
          console.log(error);
          return;
        });

        $scope.removeCertificado = function(certificado) {
          var rta = confirm("¿Desea borrar este certificado?");
          if(rta == true){
          CertificadoProveedorResource.delete({id: certificado.id});
			    // Materialize.toast('Certificado Eliminado.', 5000, 'green accent-4');
          var index = $scope.proveedor.certificados.indexOf(certificado);
          $scope.proveedor.certificados.splice(index, 1);
        }
        };

        $scope.viewCertificado = function(certid){
          $scope.certificado = CertificadoProveedorResource.get({ id: certid });
          $scope.certificado.$promise.then(function(data){
            $state.go('certProvView', {certId: $scope.certificado.id, id: $scope.certificado.proveedor_id});
          });
        };
    });
