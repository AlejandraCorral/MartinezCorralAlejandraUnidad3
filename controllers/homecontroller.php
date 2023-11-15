<?php
class Home{
    
    public function index()
    {
        require_once 'models/home.php';
        $products = new HomeModel();
        $datos = $products->getproducts();
        $nuevos = $products->getproductsNuevos();
        $carrito = true;   
        include 'views/includes/menu-carrito.php';
        include 'views/includes/slider.php';
        include 'views/index.php';
        include 'views/includes/footer-carrito.php';
    }
}
