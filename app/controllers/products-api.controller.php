<?php
require_once './app/models/products-api.model.php';
require_once './app/views/products-api.view.php';

class ProductsApiController{

    private $modelProduct;
    private $viewProduct;
    private $data;

    public function __construct(){
        $this->modelProduct = new ProductsApiModel();
        $this->viewProduct = new ProductsApiView();
       
        $this->data = file_get_contents("php://input");
        
    } 

    private function getData() {
        return json_decode($this->data);
    }

    public function getProducts($params = null){
        try{
            //ORDENADO ASCENDENTE POR COLUMNA 
            if (isset($_GET['sort'])&&!isset($_GET['page'])&&!isset($_GET['search'])&&!isset($_GET['limit'])){
                $sort = $_GET['sort'];
                $this-> getProductsOrdered($sort);
                die();
            }
            //PAGINADO
            else if (!isset($_GET['sort'])&&isset($_GET['page'])&&!isset($_GET['search'])&&!isset($_GET['limit'])){
                $page = $_GET['page'];
                $this-> getProductsPaginated($page);
                die();
            }
            //PAGINADO CON LIMITE
            else if (!isset($_GET['sort'])&&isset($_GET['page'])&&!isset($_GET['search'])&&isset($_GET['limit'])){
                $page = $_GET['page'];
                $limit = $_GET['limit'];
                $this-> getProductsPaginatedWithLimit($page, $limit);
                die();
            }
            //FILTRADO
            else if (!isset($_GET['sort'])&&!isset($_GET['page'])&&isset($_GET['search'])&&!isset($_GET['limit'])){
                $search = $_GET['search'];
                $this-> getProductsFiltered($search);
                die();
            }
            //ORDENADO ASCENDENTE POR COLUMNA Y PAGINADO
            else if (isset($_GET['sort'])&&isset($_GET['page'])&&!isset($_GET['search'])&&!isset($_GET['limit'])){
                $sort = $_GET['sort'];
                $page = $_GET['page'];
                $this-> getProductsPaginatedAndOrdered($sort, $page);
                die();
            }
             //ORDENADO ASCENDENTE POR COLUMNA Y PAGINADO CON LIMITE
             else if (isset($_GET['sort'])&&isset($_GET['page'])&&!isset($_GET['search'])&&isset($_GET['limit'])){
                $sort = $_GET['sort'];
                $page = $_GET['page'];
                $limit = $_GET['limit'];
                $this-> getProductsPaginatedWithLimitAndOrdered($sort, $page, $limit);
                die();
            }
            //ORDENADO ASCENDENTE POR COLUMNA Y FILTRADO
            else if (isset($_GET['sort'])&&!isset($_GET['page'])&&isset($_GET['search'])&&!isset($_GET['limit'])){
                $sort = $_GET['sort'];
                $search = $_GET['search'];
                $this-> getProductsOrderedAndFiltered($sort, $search);
                die();
            }
            //PAGINADO Y FILTRADO
            else if (!isset($_GET['sort'])&&isset($_GET['page'])&&isset($_GET['search'])&&!isset($_GET['limit'])){
                $page = $_GET['page'];
                $search = $_GET['search'];
                $this-> getProductsPaginatedAndFiltered($page, $search);
                die();
            }
            //PAGINADO Y FILTRADO
            else if (!isset($_GET['sort'])&&isset($_GET['page'])&&isset($_GET['search'])&&isset($_GET['limit'])){
                $page = $_GET['page'];
                $search = $_GET['search'];
                $limit = $_GET['limit'];
                $this-> getProductsPaginatedWithLimitAndFiltered($page, $search, $limit);
                die();
            }
            //ORDENADO ASCENDENTE POR COLUMNA, FILTRADO Y PAGINADO
            else if (isset($_GET['sort'])&&isset($_GET['page'])&&isset($_GET['search'])&&!isset($_GET['limit'])){
                $sort = $_GET['sort'];
                $page = $_GET['page'];
                $search = $_GET['search'];
                
                $this-> getProductsFilteredPaginatedAndOrdered($page, $search, $sort);
                die();
            }
            //USO DEL LIMIT SOLO
            else if (!isset($_GET['sort'])&&!isset($_GET['page'])&&!isset($_GET['search'])&&isset($_GET['limit'])){
                $this->viewProduct->response("El servidor no pudo interpretar la solicitud"); 
                die();
            }
            else {
                $this->getAllProducts();
                die();
            }
        } 
        catch (Exception){
            $this->viewProduct->response("El servidor no pudo interpretar la solicitud por una sintaxis erronea", 400);
        }
    }

    //LISTADO DE TODOS LOS PRODUCTOS SIN ORDENAR, SIN PAGINAR Y SIN FILTRAR
    public function getAllProducts(){
        $products = $this->modelProduct->getAll();
        if ($products){
            $this->viewProduct->response($products, 200);
        }
        else {
            $this->viewProduct->response("El servidor no pudo interpretar la solicitud por una sintaxis erronea", 400);
        }
        
    }

    //ORDENADO ASCENDENTE POR COLUMNA 
    public function getProductsOrdered($sort = null){
        if($sort != null) {
            $products = $this->modelProduct->getOrderedByColumn($sort);
            $this->viewProduct->response($products, 200);
        }
        else {
            $this->viewProduct->response("Debe completar el nombre de la columna por el que quiere ordenar", 404);
        }
    }
    //PAGINADO
    public function getProductsPaginated($page = null){
        if(is_numeric($page) && $page != null) {
            $quantityProducts = $this->modelProduct->getQuantityProducts();
            if ($quantityProducts >= 0  && $page >= 0){
                    $productsByPage = $this->modelProduct-> productsByPage($page);
                    $this->viewProduct->response($productsByPage, 200);
            }
            else {
                $this->viewProduct->response("Ingresar un parámetro válido", 400);
            }
        }
        else {
            $this->viewProduct->response("Ingresar un parámetro válido", 404);
        } 
    }
    //PAGINADO CON LIMITE
    public function getProductsPaginatedWithLimit($page = null, $limit = null){
        if(is_numeric($page) && $page != null && is_numeric($limit) && $limit != null) {
            $quantityProducts = $this->modelProduct->getQuantityProducts();
            if ($quantityProducts >= 0  && $page >= 0 && $limit > 0){
                    $productsByPage = $this->modelProduct-> productsByPageWithLimit($page, $limit);
                    $this->viewProduct->response($productsByPage, 200);
            }
            else {
                $this->viewProduct->response("Ingresar un parámetro válido", 404);
            }
        }
        else {
            $this->viewProduct->response("Ingresar un parámetro válido", 404);
        } 
    }
    //FILTRADO
    public function getProductsFiltered($search = null){
        if($search != null) {
            $products = $this->modelProduct->getProductsFiltered($search);
            if ($products){
                $this->viewProduct->response($products, 200);
            }
            else{
                $this->viewProduct->response("No hay resultado para esa búsqueda", 404);
            }
        }
        else {
            $this->viewProduct->response("Debe ingresar un parámetro de búsqueda", 404);
        }
    }
    //PAGINADO Y ORDENADO ASCENDENTE POR COLUMNA 
    public function getProductsPaginatedAndOrdered($sort = null, $page = null){
        if (is_numeric($page) && $sort != null && $page != null){
            $products = $this->modelProduct->getOrderedAndPaginated($sort, $page);
            if ($products){
                $this->viewProduct->response($products, 200);
            }
            else{
                $this->viewProduct->response("Ingresar parametros válidos", 404);
            }
        }
        else {
            $this->viewProduct->response("No es posible interpretar la solicitud", 400);
        }
    }
    //PAGINADO CON LIMITE Y ORDENADO ASCENDENTE POR COLUMNA 
    public function getProductsPaginatedWithLimitAndOrdered($sort = null, $page = null, $limit = null){
        if (is_numeric($page) && $sort != null && $page != null && $limit != null){
            $products = $this->modelProduct->getOrderedAndPaginatedWithLimit($sort, $page, $limit);
            if ($products){
                $this->viewProduct->response($products, 200);
            }
            else{
                $this->viewProduct->response("Ingresar parametros válidos", 404);
            }
        }
        else {
            $this->viewProduct->response("No es posible interpretar la solicitud", 400);
        }
    }
    //ORDENADO ASCENDENTE POR COLUMNA Y FILTRADO
    public function getProductsOrderedAndFiltered($sort = null, $search = null){
        if ($sort != null && $search != null){
            $products = $this->modelProduct->getOrderedAndFiltered($sort, $search);
            if ($products){
                $this->viewProduct->response($products, 200);
            }
            else{
                $this->viewProduct->response("No hay resultado para esa búsqueda", 404);
            }
        }
        else {
            $this->viewProduct->response("Ingresar un parámetro", 404);
        }
    }
    //PAGINADO Y FILTRADO
    public function getProductsPaginatedAndFiltered($page = null, $search = null){
        if (is_numeric($page) && $page !=null && $search != null){
            $products = $this->modelProduct->getFilteredAndPaginated($search, $page);
            if ($products){
                $this->viewProduct->response($products, 200);
            }
            else{
                $this->viewProduct->response("No hay resultado para esa búsqueda", 404);
            }
        }
        else if (!is_numeric($page)){
            $this->viewProduct->response("No es posible interpretar la solicitud", 400);
        }
        else {
            $this->viewProduct->response("Ingresar un parámetro", 404);
        }
    }
    //PAGINADO CON LIMITE Y FILTRADO
    public function getProductsPaginatedWithLimitAndFiltered($page = null, $search = null, $limit = null){
        if (is_numeric($page) && $page !=null && $search != null && $limit != null && is_numeric($limit)){
            $products = $this->modelProduct->getFilteredAndPaginatedWithLimit($search, $page, $limit);
            if ($products){
                $this->viewProduct->response($products, 200);
            }
            //ver cuando paso a otra pagima y no hay mas productos que mostrar
            else {
                $this->viewProduct->response("No hay resultado para esa búsqueda", 404);
            }
        }
        else if (!is_numeric($page)||!is_numeric($limit)){
            $this->viewProduct->response("No es posible interpretar la solicitud", 400);
        }
        else {
            $this->viewProduct->response("Ingresar un parámetro", 404);
        }
    }
    //los tres no esta funcionando



    public function getProductsFilteredPaginatedAndOrdered($page = null, $search = null, $sort = null){
        if (is_numeric($page) && $page != null && $search != null && $sort !=null){
            if (products){
                $products = $this->modelProduct->getProductsFilteredPaginatedAndOrdered($page, $search, $sort);
                $this->viewProduct->response($products, 200);
            }
            else{
                $this->viewProduct->response("No hay resultado para esa búsqueda", 404);
            }      
        }
        else if (!is_numeric($page)){
            $this->viewProduct->response("No es posible interpretar la solicitud", 400);
        }
       
    }
    //MOSTRAR PRODUCTO 
    public function getProduct($params = null) {
        $id = $params[':ID'];
        $product = $this->modelProduct->get($id);
        if ($product)
            $this->viewProduct->response($product, 200);
        else 
            $this->viewProduct->response("El producto con el id=$id no existe", 404);
    }
    //AGREGAR PRODUCTO
    public function insertProduct($params = null) {
        $product = $this->getData();
        if (empty($product->nombre_producto)||empty($product->precio)||empty($product->id_categoria)||empty($product->imagen)) {
            $this->viewProduct->response("Complete los datos", 400);
        }
        else{
            $id = $this->modelProduct->insert($product->nombre_producto, $product->precio, $product->id_categoria , $product->imagen);
            $product = $this->modelProduct->get($id);
            $this->viewProduct->response($product, 201);
        }
    }
    //ELIMINAR PRODUCTO
    public function deleteProduct($params = null) {
        $id = $params[':ID'];

        $product = $this->modelProduct->get($id);
        if ($product) {
            $this->modelProduct->delete($id);
            $this->viewProduct->response($product, 200);
        } else 
            $this->viewProduct->response("El producto con el id=$id no existe", 404);
    }

}
