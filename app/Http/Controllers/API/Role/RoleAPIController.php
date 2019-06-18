<?php

namespace App\Http\Controllers\API\Role;
 
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController; 
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Models\Permission;

 

/**
 * Class RoleAPIController
 * @package App\Http\Controllers\API\Role
 */

class RoleAPIController extends AppBaseController
{ 
 
    
    /**
     * @param Request $request
     * @return Response
     * 
     * @SWG\Post(
     *      path="/role/addRole",
     *      summary="Store a newly created Role in storage",
     *      tags={"Role & Permission"},
     *      description="Store Role",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="nasffme",
     *          in="body",
     *          description="Role that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="config('roles.models.role')")
     *      ),
     *      @SWG\Parameter(
     *          name="bddddddddody",
     *          in="body",
     *          description="Role that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="config('roles.models.role')")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="config('roles.models.role')"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */


    public function addRole(Request $request)
    {  
        $Role = config('roles.models.role')::create([
            'name' => $request->name,
            'slug' => $request->slug, 
        ]);

        return $this->sendResponse($Role->toArray(), 'Role retrieved successfully'); 
    }
 
 
    
    /**
     * @param Request $request
     * @return Response
     * 
     * @SWG\Post(
     *      path="/role/addPermission",
     *      summary="Store a newly created Permission in storage",
     *      tags={"Role & Permission"},
     *      description="Store Permission",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="name",
     *          in="body",
     *          description="Permission that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="config('Permissions.models.Permission')")
     *      ),
     *      @SWG\Parameter(
     *          name="slug",
     *          in="body",
     *          description="Permission that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="config('Permissions.models.Permission')")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="config('Permissions.models.Permission')"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */

    public function addPermission(Request $request)
    {   
        $Permission = Permission::create([
            'name' => $request->name,
            'slug' => $request->slug, 
        ]);

        return $this->sendResponse($Permission->toArray(), 'Permission retrieved successfully');
    } 

  
    
    /**
     * @param Request $request
     * @return Response
     * 
     * @SWG\Post(
     *      path="/role/addpermissiontorole",
     *      summary="Add Permission to Role",
     *      tags={"Role & Permission"},
     *      description="Add Permission to Role",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="roleId",
     *          in="body",
     *          description="Role Id",
     *          required=false,
     *          @SWG\Schema(ref="config('roles.models.role')")
     *      ),
     *      @SWG\Parameter(
     *          name="permissionId",
     *          in="body",
     *          description="Permission Id",
     *          required=false,
     *          @SWG\Schema(ref="config('permissions.models.permission')")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="config('roles.models.role')"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */

    public function addpermissiontorole(Request $request)
    {   
        $role = Role::find($request->roleId);
        $permission = Permission::find($request->permissionId);
        $PermissionRole = $role->attachPermission($permission);

        return $this->sendResponse($PermissionRole, 'PermissionRole retrieved successfully');
    } 

  
    
    /**
     * @param Request $request
     * @return Response
     * 
     * @SWG\Post(
     *      path="/role/deletepermission",
     *      summary="delete Permission from Role",
     *      tags={"Role & Permission"},
     *      description="Store Role",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="roleId",
     *          in="body",
     *          description="Role Id",
     *          required=false,
     *          @SWG\Schema(ref="config('roles.models.role')")
     *      ),
     *      @SWG\Parameter(
     *          name="permissionId",
     *          in="body",
     *          description="Permission Id",
     *          required=false,
     *          @SWG\Schema(ref="config('permission.models.permission')")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="all Permission should be deleted",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="config('roles.models.role')"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */ 

    public function deletepermission(Request $request)
    {   
        $role = Role::find($request->roleId);
        $permission = Permission::find($request->permissionId);
        $Role = $role->detachPermission($permission); 

        return $this->sendResponse($Role, 'Role retrieved successfully');
    }  

  
    
    /**
     * @param Request $request
     * @return Response
     * 
     * @SWG\Post(
     *      path="/role/deleteallpermission",
     *      summary="delete all Permission",
     *      tags={"Role & Permission"},
     *      description="delete all Permission",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          in="body",
     *          description="id role",
     *          required=false,
     *          @SWG\Schema(ref="config('roles.models.role')")
     *      ), 
     *      @SWG\Response(
     *          response=200,
     *          description="all Permission should be deleted",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="config('roles.models.role')"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */

    public function deleteallpermission(Request $request)
    {   
        $role = Role::find($request->roleId); 
        $Role = $role->detachAllPermissions();

        return $this->sendResponse($Role, 'Role retrieved successfully');
    } 
      
 
 
}
