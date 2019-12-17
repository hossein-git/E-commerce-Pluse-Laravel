<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\addressRequest;
use App\Http\Requests\userRequest;
use App\Models\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class userController extends Controller
{

    private $user;
    private $paginate;

    public function __construct()
    {
        $this->middleware('checkRole');
        $this->user = new User();
        $this->paginate = 15;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->with('roles')->paginate($this->paginate);
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all(['id', 'name']);
        return view('admin.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Http\requests\userRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(userRequest $request)
    {
        $input = $request->except('_token');
        $input['password'] = Hash::make($input['password']);
        $user = $this->user->create($input);
        $user->assignRole($request->input('roles'));
        return redirect()->route('user.index')->with(['success' => 'user has been created successfully']);
    }

    /**
     * Display the user profile.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (ctype_digit($id)) {

            $user = $this->user->findOrFail($id);
            $orders = $user->orders;
            return view('admin.user.profile', compact('user', 'orders'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (ctype_digit($id)) {
            $user = $this->user->findOrFail($id, ['user_id', 'name', 'email']);
            $roles = Role::select('id', 'name')->get();
            $userRole = $user->roles->pluck('id')->toArray();
            return view('admin.user.edit', compact('user', 'roles', 'userRole'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:200|min:4',
            'email' => ['required', 'email',
                Rule::unique('users', 'email')->whereNot('user_id', $id)
            ],
        ]);
        if (ctype_digit($id)) {
            $user = $this->user->findOrFail($id)->fill($request->except('_token'));
            $user->save();
            $tableName = config('permission.table_names')['model_has_roles'];
            $columnName = config('permission.column_names')['model_morph_key'];
            DB::table("$tableName")->where("$columnName", $id)->delete();
            $user->assignRole($request->input('roles'));

            return redirect()->route('user.index')->with(['success' => 'user has been updated successfully']);
        }
    }

    /**
     * Show the form for editing user Address.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function editAddress($id)
    {
        if (ctype_digit($id)) {
            $user = $this->user->findOrFail($id, ['user_id']);
            $address = $user->address;
            return view('admin.user.editAddress', compact('user', 'address'));
        }
    }

    /**
     *  updating user Address.
     *
     * @param int $id
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function updateAddress(addressRequest $request, $id)
    {
        if (ctype_digit($id)) {
            $user = $this->user->findOrFail($id)->address->fill($request->except('_token'));
            $user->save();
            return  redirect()->route('user.show', $id)->with(['success' => 'address has updated successfully']);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (ctype_digit($id)) {
            $user = $this->user->findOrFail($id)->delete();

            return $user
                ? response()->json(['success' => $user])
                : response()->json(['error' => 'error']);
        }
    }
}
