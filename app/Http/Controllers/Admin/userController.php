<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Addresses\addressRequest;
use App\Http\Requests\Users\userRequest;
use App\Models\Role;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class userController extends Controller
{

    private $user;
    private $paginate;
    /**
     * @var UserRepository
     */
    private $userRepo;

    public function __construct(UserRepository $repository)
    {
        $this->middleware('checkRole');
        $this->user = new User();
        $this->paginate = 15;
        $this->userRepo = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = $this->user->with('roles')->paginate($this->paginate);
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $roles = Role::all(['id', 'name']);
        return view('admin.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param userRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function store(userRequest $request)
    {
        $user = $this->userRepo->createUser($request);
        return $this->userRepo->passViewAfterCreated($user, 'users', 'user.index');
    }

    /**
     * Display the user profile.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $user = $this->userRepo->find($id)->load('orders');
        $orders = $user->orders;
        return view('admin.user.profile', compact('user', 'orders'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $user = $this->userRepo->find($id, ['user_id', 'name', 'email']);
        $roles = Role::all(['id', 'name']);
        $userRole = $user->roles->pluck('id')->toArray();
        return view('admin.user.edit', compact('user', 'roles', 'userRole'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $request
     * @param int $id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:200|min:4',
            'email' => ['required', 'email',
                Rule::unique('users', 'email')->whereNot('user_id', $id)
            ],
        ]);
        $user = $this->userRepo->update($request->except('_token'), $id);
        $tableName = config('permission.table_names')['model_has_roles'];
        $columnName = config('permission.column_names')['model_morph_key'];
        DB::table("$tableName")->where("$columnName", $id)->delete();
        $user = $user->assignRole($request->input('roles'));


        return $this->userRepo->passViewAfterUpdated($user, 'users', 'user.index');

    }

    /**
     * Show the form for editing user Address.
     *
     * @param int $id
     * @return Response
     */
    public function editAddress($id)
    {

        $user = $this->userRepo->find($id, ['user_id'])->load('address');
        $address = $user->address;
        return view('admin.user.editAddress', compact('user', 'address'));

    }

    /**
     *  updating user Address.
     *
     * @param int $id
     * @param  $request
     * @return RedirectResponse
     */
    public function updateAddress(addressRequest $request, $id)
    {
        $user = $this->userRepo->find($id)->address->fill($request->except('_token'));
        $result = $user->save();
        return $this->userRepo->passViewAfterUpdated($result,'addresses','user.index');
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
        $user = $this->userRepo->delete($id);
        return $this->userRepo->passViewAfterDeleted($user,'users');

    }
}
