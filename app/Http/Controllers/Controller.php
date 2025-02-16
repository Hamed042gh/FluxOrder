<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="FluxOrder", 
 *     version="1.0",
 *     description="This documentation is for the FluxOrder API."
 * ),
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="To access the API, you must send a Bearer token in the Authorization header. Example: `Bearer <token>`"
 * )
 */

abstract class Controller
{
    //
}
