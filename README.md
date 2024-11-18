
# TPE - Parte 3: API REST Perfumería Divain

## Introducción

Esta tercera entrega del Trabajo Práctico Especial (TPE) consiste en la creación de una API REST pública para brindar integración con otros sistemas, basada en el proyecto original de Perfumería Divain. La API permite realizar operaciones CRUD (Crear, Leer, Actualizar, Eliminar) sobre las entidades principales del proyecto: Productos, Categorías e Ingredientes. La API fue desarrollada como un repositorio nuevo, compartiendo la base de datos con el proyecto anterior.

## Objetivo

El objetivo principal es proporcionar una API RESTful que permita a otros sistemas consumir los datos de la perfumería, facilitando así la integración. Se cumple con todos los requerimientos mínimos establecidos y se implementaron algunas funcionalidades opcionales para mejorar la experiencia y alcanzar la promoción.

## Puntos de Entrada de la API (Endpoints)

A continuación, se describen los puntos de entrada disponibles en la API REST y cómo se pueden usar.

### Productos

- **GET /productos**: Lista todos los productos disponibles. Soporta ordenación opcional por `nombre_producto`, `precio`, `id_categoria` y dirección (`ASC` o `DESC`). Ejemplo:

  ```
  GET http://localhost/perfumeria-api/productos?orderBy=precio&orderDirection=DESC
  ```
- **GET /productos/{id}**: Obtiene un producto por su ID. Ejemplo:

  ```
  GET http://localhost/perfumeria-api/productos/1
  ```
- **POST /productos**: Crea un nuevo producto. Requiere autenticación con token JWT.
- **PUT /productos/{id}**: Actualiza un producto existente. Requiere autenticación.
- **DELETE /productos/{id}**: Elimina un producto por su ID. Requiere autenticación.

### Categorías

- **GET /categorias**: Lista todas las categorías disponibles. Soporta ordenación opcional por `nombre_categoria` o `id_categoria` y dirección (`ASC` o `DESC`). Ejemplo:

  ```
  GET http://localhost/perfumeria-api/categorias?orderBy=nombre_categoria&orderDirection=ASC
  ```
- **GET /categorias/{id}**: Obtiene una categoría por su ID.
- **POST /categorias**: Crea una nueva categoría. Requiere autenticación con token JWT.
- **PUT /categorias/{id}**: Actualiza una categoría existente. Requiere autenticación.
- **DELETE /categorias/{id}**: Elimina una categoría por su ID. Requiere autenticación.

### Ingredientes

- **GET /ingredientes**: Lista todos los ingredientes disponibles. Soporta ordenación opcional por `nombre_ingrediente` y dirección (`ASC` o `DESC`). Ejemplo:

  ```
  GET http://localhost/perfumeria-api/ingredientes?orderBy=nombre_ingrediente&orderDirection=DESC
  ```
- **GET /ingredientes/{id}**: Obtiene un ingrediente por su ID.
- **POST /ingredientes**: Crea un nuevo ingrediente. Requiere autenticación con token JWT.
- **PUT /ingredientes/{id}**: Actualiza un ingrediente existente. Requiere autenticación.
- **DELETE /ingredientes/{id}**: Elimina un ingrediente por su ID. Requiere autenticación.

### Autenticación

- **POST /login**: Genera un token de autenticación JWT para usar en las operaciones de **POST**, **PUT** y **DELETE**. Ejemplo:
  ```
  POST http://localhost/perfumeria-api/login
  Content-Type: application/json
  {
    "username": "usuario_de_prueba"
  }
  ```

## Manejo de Errores

La API maneja adecuadamente los siguientes códigos de error HTTP:

- **200 OK**: Solicitud exitosa.
- **201 Created**: La entidad fue creada exitosamente.
- **400 Bad Request**: La solicitud tiene un error de sintaxis o falta un dato obligatorio.
- **404 Not Found**: La entidad solicitada no se encontró.

## Ordenación y Filtrado

- Todos los endpoints de **GET** que listan colecciones soportan parámetros para **ordenar** por cualquier campo válido y elegir la **dirección** (`ASC` o `DESC`). Esto ayuda a consumir los datos de manera más específica y ordenada según las necesidades del cliente.

## Ejemplos de Peticiones

### Listar Productos Ordenados por Precio Descendente

```
GET http://localhost/perfumeria-api/productos?orderBy=precio&orderDirection=DESC
Accept: application/json
```

### Crear un Nuevo Producto (Requiere Autenticación)

```
POST http://localhost/perfumeria-api/productos
Content-Type: application/json
Authorization: Bearer <token>
{
  "nombre_producto": "Perfume X",
  "descripcion": "Fragancia fresca",
  "precio": 150.00,
  "id_categoria": 1
}
```
