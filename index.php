<!DOCTYPE html>
<html>
<head>
 <style>
.width-30-pct{
    width:30%;
}
 
.text-align-center{
    text-align:center;
}
 
.margin-bottom-1em{
    margin-bottom:1em;
}
</style>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
      
    <title>Read Products</title>
     
    <!-- include material design CSS -->
    <link rel="stylesheet" href="libs/css/materialize-v0.97.3/css/materialize.min.css" />
     
    <!-- include material design icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
     
</head>
<body>
    <div class="container" ng-app="myApp" ng-controller="productsCtrl">
    <div class="row">
        <div class="col s12">
            <h4>Products</h4>
            <!-- used for searching the current list -->
<input type="text" ng-model="search" class="form-control" placeholder="Search product..." />
 
<!-- table that shows product record list -->
<table class="hoverable bordered">
 
    <thead>
        <tr>
            <th class="text-align-center">ID</th>
            <th class="width-30-pct">Name</th>
            <th class="width-30-pct">Description</th>
            <th class="text-align-center">Price</th>
            <th class="text-align-center">Action</th>
        </tr>
    </thead>
 
    <tbody ng-init="getAll()">
        <tr ng-repeat="d in names | filter:search">
            <td class="text-align-center">{{ d.id }}</td>
            <td>{{ d.name }}</td>
            <td>{{ d.description }}</td>
            <td class="text-align-center">{{ d.price }}</td>
            <td>
                <a ng-click="readOne(d.id)" class="waves-effect waves-light btn margin-bottom-1em"><i class="material-icons left">edit</i>Edit</a>
                <a ng-click="deleteProduct(d.id)" class="waves-effect waves-light btn margin-bottom-1em"><i class="material-icons left">delete</i>Delete</a>
            </td>
        </tr>
    </tbody>
</table>
            <!-- modal for for creating new product -->
<div id="modal-product-form" class="modal">
    <div class="modal-content">
        <h4 id="modal-product-title">Create New Product</h4>
        <div class="row">
            <div class="input-field col s12">
                <input ng-model="name" type="text" class="validate" id="form-name" placeholder="Type name here..." />
                <label for="name">Name</label>
            </div>
 
            <div class="input-field col s12">
                <textarea ng-model="description" type="text" class="validate materialize-textarea" placeholder="Type description here..."></textarea>
                <label for="description">Description</label>
            </div>
 
 
            <div class="input-field col s12">
                <input ng-model="price" type="text" class="validate" id="form-price" placeholder="Type price here..." />
                <label for="price">Price</label>
            </div>
 
 
            <div class="input-field col s12">
                <a id="btn-create-product" class="waves-effect waves-light btn margin-bottom-1em" ng-click="createProduct()"><i class="material-icons left">add</i>Create</a>
 
                <a id="btn-update-product" class="waves-effect waves-light btn margin-bottom-1em" ng-click="updateProduct()"><i class="material-icons left">edit</i>Save Changes</a>
 
                <a class="modal-action modal-close waves-effect waves-light btn margin-bottom-1em"><i class="material-icons left">close</i>Close</a>
            </div>
        </div>
    </div>
</div><div class="fixed-action-btn" style="bottom:45px; right:24px;">
    <a class="waves-effect waves-light btn modal-trigger btn-floating btn-large red" href="#modal-product-form" ng-click="showCreateForm()"><i class="large material-icons">add</i></a
</div>
             
        </div> <!-- end col s12 -->
    </div> <!-- end row -->
</div>
 
<!-- page content and controls will be here -->
 
<!-- include jquery -->
<script type="text/javascript" src="libs/js/jquery.js"></script>
 
<!-- material design js -->
<script src="libs/css/materialize-v0.97.3/js/materialize.min.js"></script>
 
<!-- include angular js -->
<script src="libs/js/angular.min.js"></script>
 
<script>
var app = angular.module('myApp', []);
app.controller('productsCtrl', function($scope, $http) {
     // more angular JS codes will be here
     
     
     $scope.showCreateForm = function(){
    // clear form
    $scope.clearForm();
     
    // change modal title
    $('#modal-product-title').text("Create New Product");
     
    // hide update product button
    $('#btn-update-product').hide();
     
    // show create product button
    $('#btn-create-product').show();
     
}
// clear variable / form values
$scope.clearForm = function(){
    $scope.id = "";
    $scope.name = "";
    $scope.description = "";
    $scope.price = "";
}
// create new product 
$scope.createProduct = function(){
         
    // fields in key-value pairs
    $http.post('create_product.php', {
            'name' : $scope.name, 
            'description' : $scope.description, 
            'price' : $scope.price
        }
    ).success(function (data, status, headers, config) {
        console.log(data);
        // tell the user new product was created
        Materialize.toast(data, 4000);
         
        // close modal
        $('#modal-product-form').closeModal();
         
        // clear modal content
        $scope.clearForm();
         
        // refresh the list
        $scope.getAll();
    });
}

// read products
$scope.getAll = function(){
    $http.get("read_products.php").success(function(response){
        $scope.names = response.records;
    });
}
});


</script>
<script>
    
    $(document).ready(function(){
    // initialize modal
    $('.modal-trigger').leanModal();
});
   </script>
</body>
</html>