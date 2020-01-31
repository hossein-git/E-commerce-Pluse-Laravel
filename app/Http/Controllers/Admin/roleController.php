<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\RoleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class roleController extends Controller
{
    private $role;
    /**
     * @var RoleRepository
     */
    private $roleRepo;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    function __construct(RoleRepository $repository)
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
        $this->role = new Role();
        $this->roleRepo = $repository;
    }


    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $roles = $this->role->orderBy('id', 'DESC')->paginate(5);
        return view('admin.roles.index', compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $permission = Permission::get(['id', 'name']);
        return view('admin.roles.create', compact('permission'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:roles,name',
            'permission' => 'required',
            'description' => 'required|string',
        ]);

        $role = $this->role->create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);
        $role->syncPermissions($request->input('permission'));


        return env('APP_AJAX')
            ? response()->json(['success' => 'Role created successfully'], 200)
            : redirect()->route('roles.index')->with('success', 'Role created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $role = $this->roleRepo->find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)->get();

        return view('admin.roles.show', compact('role', 'rolePermissions'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $role = $this->roleRepo->find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();
        return view('admin.roles.edit', compact('role', 'permission', 'rolePermissions'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'permission' => 'required',
            'description' => 'required|string',
        ]);

        $role = $this->role->findOrFail($id);
        $role->fill([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);
        $role->save();

        $role->syncPermissions($request->input('permission'));

        return $this->roleRepo->passViewAfterUpdated($role,'roles','roles.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Facade\FlareClient\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $role = $this->roleRepo->delete($id);
        return $this->roleRepo->passViewAfterDeleted($role, 'roles');

    }
}
