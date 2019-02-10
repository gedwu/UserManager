<?php

namespace UserManager\Http\Controllers;

use Illuminate\Http\Request;
use UserManager\Http\Requests;
use UserManager\UserManager;
use UserManager\Http\Resources\UserManager as UserManagerResource;

class UserManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = UserManager::orderBy('updated_at', 'desc')->paginate(5);

        return UserManagerResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validate($request, [
        'name' => 'required|max:30|min:4',
        'email' => 'required|email|unique:user_managers|max:30|min:6',
        'phone' => 'required|unique:user_managers|max:50|min:8',
        'gender' => 'nullable|max:1|min:1',
        'status' => 'nullable|boolean|max:1|min:1'
    ]);

        $user = new UserManager();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->status = $request->input('status');
        $user->gender = $request->input('gender');


        $return = ['success' => 'User Created'];
        if($user->save()) {
            return response()->json($return);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return UserManagerResource
     */
    public function show($id)
    {
        $user = UserManager::findOrFail($id);

        return new UserManagerResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return UserManagerResource
     * @throws \Exception
     */
    public function destroy($id)
    {
        $user = UserManager::findOrFail($id);

        if ($user->delete()) {
            return new UserManagerResource($user);
        }

        //@todo: change it
        return 'error delete';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $validator = $this->validate($request, [
            'name' => 'required|max:30|min:4',
            'email' => 'required|email|max:30|min:6',
            'phone' => 'required|max:50|min:8',
            'gender' => 'nullable|max:1|min:1',
            'status' => 'nullable|boolean|max:1|min:1'
        ]);

        $user = UserManager::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');

        $return = ['success' => 'User Updated'];
        if($user->save()) {
            return response()->json($return);
        }
    }
}
