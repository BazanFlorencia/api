Formas de interactuar con la API

Se coloca entre llaves lo que se debe reemplazar por un valor determinado (las llaves son sólo para separar esos términos, deben quitarse).

Aplicaciones del GET

    Obtener todos los productos de la base de datos -> http://localhost/web2/tpe-Parte2/api/products

    Obtener un producto de la base de datos dado un id -> http://localhost/web2/tpe-Parte2/api/products/{id}

    Obtener los productos de la base de datos ordenados por columna de manera ascendente (se utilizó el ordenamiento ascendente que se establece por defecto)-> http://localhost/web2/tpe-Parte2/api/products?sort={nombre de columna}

    Obtener los productos filtrados por un parámetro determinado -> http://localhost/web2/tpe-Parte2/api/products?search={parámetro}

    Obtener los productos paginados estableciendo una cantidad determinada de productos por vista por defecto -> http://localhost/web2/tpe-Parte2/api/products?page={número de página}

    Obtener los productos paginados pudiendo establecer el límite de cuántos productos ver por página (limit) -> http://localhost/web2/tpe-Parte2/api/products?page={número de página}&limit={cantidad de productos por página}

    Obtener los productos filtrados y paginados -> http://localhost/web2/tpe-Parte2/api/products?page={número de página}&search={parámetro de búsqueda}

    Obtener los productos filtrados y paginados con el limite -> http://localhost/web2/tpe-Parte2/api/products?page={número de página}&limit={cantidad de productos por página}&search={parámetro de búsqueda}

    Obtener los productos filtrados ordenados por defecto ascendentes -> http://localhost/web2/tpe-Parte2/api/products?sort={nombre de columna}&search={parámetro de búsqueda}

    Obtener los productos ordenados por defecto ascendentes y paginados -> http://localhost/web2/tpe-Parte2/api/products?page={número de página}&sort={nombre de columna}

    Obtener los productos ordenados por defecto ascendentes y paginados con el limite -> http://localhost/web2/tpe-Parte2/api/products?page={número de página}&sort={nombre de columna}&limit={cantidad de productos por página}

Aplicaciones del POST

    Agregar productos a la base de datos -> http://localhost/web2/tpe-Parte2/api/products

Aplicaciones del DELETE

    Eliminar un producto de la base de datos dado un id -> http://localhost/web2/tpe-Parte2/api/products/{id}

