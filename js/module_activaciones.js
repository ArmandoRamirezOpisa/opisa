/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
angular.module('activaciones', []).controller('activar', function ($scope) {
    $scope.tipoValidacion = 0;
    $scope.mensajeTipoTextBox;
    $scope.itemList = [];
    $scope.blisterPackTemplates = [{id: 1, name: "Solicitud por Canje"}, {id: 2, name: "Solicitud por PO"}];
    $scope.changedValue = function (item) {
        $scope.itemList = [];
        $scope.itemList.push(item.name);
        if (item.name == "Solicitud por Canje") {
            $scope.tipoValidacion = 1;
            $scope.mensajeTipoTextBox = "Ingresa Canje";
        }
         if  (item.name == "Solicitud por PO") {
            $scope.tipoValidacion = 2;
            $scope.mensajeTipoTextBox = "Ingresa PO";
        } 
    };




});
