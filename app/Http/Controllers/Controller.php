<?php

namespace App\Http\Controllers;

/**
 * @OA\OpenApi(
 *  @OA\Info(
 *      title="Barikalla",
 *      version="0.0.1",
 *      description="API documentation for Barikalla",
 *      @OA\Contact(
 *          email="iman_sp@yahoo.com"
 *      )
 *  ),
 *    @OA\Server(
 *      description=L5_SWAGGER_APP_NAME,
 *      url=L5_SWAGGER_CONST_HOST
 *  ),
 *  @OA\PathItem(
 *      path="/"
 *  )
 * ),
 * @OA\Tag(
 *   name="Auth",
 *   description="Authenticating"
 * ),
 */
abstract class Controller
{
    //
}
