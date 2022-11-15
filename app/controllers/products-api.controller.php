<?php
require_once './app/models/products-api.model.php';
require_once './app/views/products-api.view.php';

class ProductsApiController{

    private $modelProduct;
    private $viewProduct;
    private $data;
    private $nameColumnsTables = ['id_producto', 'nombre_producto'. 'precio', 'id_categoria', 'tipo_producto'];

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
            //ORDENADO ASCENDENTE POR COLUMNA, FILTRADO Y PAGINADO
            else if (isset($_GET['sort'])&&isset($_GET['page'])&&isset($_GET['search'])&&isset($_GET['limit'])){
                $sort = $_GET['sort'];
                $page = $_GET['page'];
                $search = $_GET['search'];
                $limit = $_GET['limit'];
                $this-> getProductsFilteredPaginatedWithLimitAndOrdered($page, $search, $sort, $limit);
                die();
            }
            //USO DEL LIMIT SOLO
            else if (!isset($_GET['sort'])&&!isset($_GET['page'])&&!isset($_GET['search'])&&isset($_GET['limit'])){
                $this->viewProduct->response("El servidor no pudo interpretar la solicitud"); 
                die();
            }
            else {
                $this->getColumnsTable();
                die();
            }
        } 
        catch (Exception){
            $this->viewProduct->response("El servidor no pudo interpretar la solicitud por una sintaxis erronea", 500);
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
        $nameColumnsTables = ['id_producto', 'nombre_producto'. 'precio', 'id_categoria', 'tipo_producto'];
        if($sort != null) {
            if (in_array($sort, $nameColumnsTables)){
                $products = $this->modelProduct->getOrderedByColumn($sort);
                if($products){
                    $this->viewProduct->response($products, 200);
                }
                else{
                    $this->viewProduct->response("No existe una columna $sort", 400);
                }
            }
            else{
                $this->viewProduct->response("No existe esa columna", 404);
            }
        }
        else {
            $this->viewProduct->response("Debe completar el nombre de la columna por el que quiere ordenar", 404);
        }
    }

    //PAGINADO
    public function getProductsPaginated($page = null){
        if(is_numeric($page) && $page != null) {
            $limit = 5;
            $quantityProducts = $this->modelProduct->getQuantityProducts();
            if ($quantityProducts >= 0  && $page >= 0){
                $pages = ceil($quantityProducts/$limit);
                if ($page <= $pages){
                    $productsByPage = $this->modelProduct-> productsByPage($page, $limit);
                    $this->viewProduct->response($productsByPage, 200);
                }
                else{
                    $this->viewProduct->response("No hay más productos que mostrar", 404);
                }       
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
                $pages = ceil($quantityProducts/$limit);
                if ($page <= $pages){
                    $productsByPage = $this->modelProduct-> productsByPageWithLimit($page, $limit);
                    $this->viewProduct->response($productsByPage, 200);
                }
                else{
                    $this->viewProduct->response("No hay más productos que mostrar", 404);
                }
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
        $nameColumnsTables = ['id_producto', 'nombre_producto'. 'precio', 'id_categoria', 'tipo_producto'];
        if (is_numeric($page) && $sort != null && $page != null){
            if(in_array($sort, $nameColumnsTables)){
                $pages = ceil($quantityProducts/$limit);
                if ($page <= $pages){
                    $products = $this->modelProduct->getOrderedAndPaginated($sort, $page);
                    if ($products){
                        $this->viewProduct->response($products, 200);
                    }
                    else{
                        $this->viewProduct->response("No hay productos para mostrar", 404);
                    }
                }
                else{
                    $this->viewProduct->response("No hay más productos que mostrar", 404);
                }
            }
            else{
                $this->viewProduct->response("No existe esa columna", 404);
            }
        }
        else {
            $this->viewProduct->response("Ingresar parámetros válidos", 400);
        }
    }
    
    //PAGINADO CON LIMITE Y ORDENADO ASCENDENTE POR COLUMNA 
    public function getProductsPaginatedWithLimitAndOrdered($sort = null, $page = null, $limit = null){
        $nameColumnsTables = ['id_producto', 'nombre_producto'. 'precio', 'id_categoria', 'tipo_producto'];
        if (is_numeric($page) && $sort != null && $page != null && $limit != null){
            if (in_array($sort, $nameColumnsTables)){
                $pages = ceil($quantityProducts/$limit);
                if ($page <= $pages){
                    $products = $this->modelProduct->getOrderedAndPaginatedWithLimit($sort, $page, $limit);
                    if ($products){
                        $this->viewProduct->response($products, 200);
                    }
                    else{
                        $this->viewProduct->response("Ingresar parámetros válidos", 404);
                    }
                }
                else{
                    $this->viewProduct->response("No hay más productos que mostrar", 404);
                }
            }
            else {
                $this->viewProduct->response("No existe esa columna", 404);
            }
        }
        else if (!is_numeric($page)){
            $this->viewProduct->response("No es posible interpretar la solicitud", 400);
        }
        else {
            $this->viewProduct->response("Ingresar un parámetro", 400);
        }
    }

    //ORDENADO ASCENDENTE POR COLUMNA Y FILTRADO
    public function getProductsOrderedAndFiltered($sort = null, $search = null){
        $nameColumnsTables = ['id_producto', 'nombre_producto'. 'precio', 'id_categoria', 'tipo_producto'];
        if ($sort != null && $search != null){
            if (in_array($sort, $nameColumnsTables)){
                $products = $this->modelProduct->getOrderedAndFiltered($sort, $search);
                if ($products){
                    $this->viewProduct->response($products, 200);
                }
                else{
                    $this->viewProduct->response("No hay resultado para esa búsqueda", 404);
                }
            }
            else {
                $this->viewProduct->response("No existe esa columna", 404);
            }
        }
        else {
            $this->viewProduct->response("Ingresar parámetros válidos", 400);
        }
    }

    //PAGINADO Y FILTRADO
    public function getProductsPaginatedAndFiltered($page = null, $search = null){
        if (is_numeric($page) && $page !=null && $search != null){
            $pages = ceil($quantityProducts/$limit);
            if ($page <= $pages){
                $products = $this->modelProduct->getFilteredAndPaginated($search, $page);
                if ($products){
                    $this->viewProduct->response($products, 200);
                }
                else{
                    $this->viewProduct->response("No hay resultado para esa búsqueda", 404);
                }
            }
            else{
                $this->viewProduct->response("No hay más productos que mostrar", 404);
            }

        }
        else if (!is_numeric($page)){
            $this->viewProduct->response("No es posible interpretar la solicitud", 400);
        }
        else {
            $this->viewProduct->response("Ingresar un parámetro", 400);
        }
    }

    //PAGINADO CON LIMITE Y FILTRADO
    public function getProductsPaginatedWithLimitAndFiltered($page = null, $search = null, $limit = null){
        if (is_numeric($page) && $page !=null && $search != null && $limit != null && is_numeric($limit)){
            $pages = ceil($quantityProducts/$limit);
            if ($page <= $pages){
                $products = $this->modelProduct->getFilteredAndPaginatedWithLimit($search, $page, $limit);
                if ($products){
                    $this->viewProduct->response($products, 200);
                }
                else {
                    $this->viewProduct->response("No hay resultado para esa búsqueda", 404);
                }
            }
            else{
                $this->viewProduct->response("No hay más productos que mostrar", 404);
            }
        }
        else if (!is_numeric($page)||!is_numeric($limit)){
            $this->viewProduct->response("No es posible interpretar la solicitud", 400);
        }
        else {
            $this->viewProduct->response("Ingresar un parámetro", 400);
        }
    }

    //PRODUCTOS FILTRADOS, PAGINADOS Y ORDENADOS ASCENDENTE POR COLUMNA
    public function getProductsFilteredPaginatedAndOrdered($page = null, $search = null, $sort = null){
        $nameColumnsTables = ['id_producto', 'nombre_producto'. 'precio', 'id_categoria', 'tipo_producto'];
        if (is_numeric($page) && $page != null && $search != null && $sort !=null){
            if (in_array($sort, $$nameColumnsTables)){
                $pages = ceil($quantityProducts/$limit);
                if ($page <= $pages){
                    if (products){
                        $products = $this->modelProduct->getFilteredPaginatedAndOrdered($page, $search, $sort);
                        $this->viewProduct->response($products, 200);
                    }
                    else{
                        $this->viewProduct->response("No hay resultado para esa búsqueda", 404);
                    } 
                }
                else{
                    $this->viewProduct->response("No hay más productos que mostrar", 404);
                } 
            }    
            else {
                $this->viewProduct->response("No existe esa columna", 404);
            }
        }
        else if (!is_numeric($page)){
            $this->viewProduct->response("No es posible interpretar la solicitud", 400);
        }
        else {
            $this->viewProduct->response("Ingresar un parámetro", 400);
        }
       
    }

    //PRODUCTOS FILTRADOS, PAGINADOS CON LIMITE Y ORDENADOS ASCENDENTE POR COLUMNA
    public function getProductsFilteredPaginatedWithLimitAndOrdered($page = null, $search = null, $sort = null, $limit = null){
        $nameColumnsTables = ['id_producto', 'nombre_producto'. 'precio', 'id_categoria', 'tipo_producto'];
        if (is_numeric($page) && $page != null && $search != null && $sort !=null && $limit != null && is_numeric($limit)){
            if (in_array($sort, $$nameColumnsTables)){
                $pages = ceil($quantityProducts/$limit);
                if ($page <= $pages){
                    if (products){
                        $products = $this->modelProduct->getFilteredPaginatedWithLimitAndOrdered($page, $search, $sort, $limit);
                        $this->viewProduct->response($products, 200);
                    }
                    else {
                        $this->viewProduct->response("No hay resultado para esa búsqueda", 404);
                    }      
                }
                else {
                    $this->viewProduct->response("No hay más productos que mostrar", 404);
                } 
            }
            else {
                $this->viewProduct->response("No existe esa columna", 404);
            }
        }
        else if (!is_numeric($page)||!is_numeric($limit)){
            $this->viewProduct->response("No es posible interpretar la solicitud", 400);
        }
        else {
            $this->viewProduct->response("Ingresar un parámetro", 400);
        }
    }

    //MOSTRAR PRODUCTO 
    public function getProduct($params = null) {
        $id = $params[':ID'];
        $product = $this->modelProduct->get($id);
        if ($product){
            $this->viewProduct->response($product, 200);
        }
        else {
            $this->viewProduct->response("El producto con el id $id no existe", 404);
        }
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
            $this->viewProduct->response("El producto con el id $id no existe", 404);
    }

}
