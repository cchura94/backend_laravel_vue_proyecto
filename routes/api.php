<?php

use App\Http\Controllers\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\ProductoController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get("/pedido/{id}/pdf/list", [PedidoController::class, "funReportePDF"]);
Route::get("/producto/exportarExcel", [ProductoController::class,"exportarExcel"]);

Route::middleware('auth:sanctum')->group(function(){

    // busqueda cliente
    Route::get("/cliente/buscar", [ClienteController::class, "buscarCliente"]);

    // registrar Persona con cuenta de usuario
    Route::post("/persona/guardar-persona-user", [PersonaController::class, "funGuardarPersonaUser"]);
    // asignar cuenta user a persona
    Route::post("/persona/{id}/adduser", [PersonaController::class, "funAddUserPersona"]);

    // subida de imagenes
    Route::post("/producto/{id}/subir-imagen", [ProductoController::class, "actualizaImagen"]);


    // CRUD API REST USER
    Route::get("/user", [UserController::class, "funListar"]);
    Route::post("/user", [UserController::class, "funGuardar"]);
    Route::get("/user/{id}", [UserController::class, "funMostrar"]);
    Route::put("/user/{id}", [UserController::class, "funModificar"]);
    Route::delete("/user/{id}", [UserController::class, "funEliminar"]);

    // CRUD ROLES
    Route::apiResource("role", RoleController::class);
    Route::apiResource("persona", PersonaController::class);
    Route::apiResource("permiso", PermisoController::class);
    Route::apiResource("documento", DocumentoController::class);

    Route::apiResource("categoria", CategoriaController::class);
    Route::apiResource("producto", ProductoController::class);
    Route::apiResource("cliente", ClienteController::class);
    Route::apiResource("pedido", PedidoController::class);

});

// Auth

Route::prefix('/v1/auth')->group(function(){

    Route::post("/login", [AuthController::class, "funLogin"]);
    Route::post("/register", [AuthController::class, "funRegister"]);

    Route::middleware('auth:sanctum')->group(function(){
        Route::get("/profile", [AuthController::class, "funProfile"]);
        Route::post("/logout", [AuthController::class, "funLogout"]);
    });
});

// redireccion (NO AUTENTICADO)
Route::get("/no-autenticado", function(){
    return ["mensaje" => "No tienes permiso para ver esta Pagina"];
})->name("login");