<?php

namespace App\Repositories;

use App\User;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserRepository
 * @package App\Repositories
*/

class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email',
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }

    /**
     * @param $request
     * @return User|Model
     */
    public function createUser($request) : User
    {
        $input = $request->except('_token');
        $input['password'] = Hash::make($input['password']);
        $user = $this->create($input);
        $user->assignRole($request->input('roles'));
        return $user;
    }
}
