<?php

/**
 * @apiGroup           UserPermission
 * @apiName            AssignPermissionsToUser
 *
 * @api                {GET} /v1/users/permissions/assign Assign Permissions To User
 * @apiDescription     Assign direct permissions to user
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated ['permissions' => 'manage-permissions', 'roles' => '']
 *
 * @apiHeader          {String} accept=application/json
 * @apiHeader          {String} authorization=Bearer
 *
 * @apiBody           {String} user_id
 * @apiBody           {Array} permission_ids Permission ID or Array of Permissions ID's
 *
 * @apiUse            UserSuccessSingleResponse
 */

use App\Containers\AppSection\Authorization\UI\API\Controllers\AssignPermissionsToUserController;
use Illuminate\Support\Facades\Route;

Route::post('users/permissions/assign', [AssignPermissionsToUserController::class, 'assignPermissionsToUser'])
    ->middleware(['auth:api']);

