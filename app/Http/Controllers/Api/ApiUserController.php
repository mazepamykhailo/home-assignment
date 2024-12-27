<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\user\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 

class ApiUserController extends Controller
{
    //
    protected $userRepository; 

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;

        $this->middleware(function ($request, $next) {

            $this->user = Auth::user();
            $this->authorize('is_manager',$this->user);
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = $this->userRepository->paginate(5);

        return response()->json([
            'success' => true,
            'data' => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\user\StoreUserRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $user = $this->userRepository->create([
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User has been created successfully!',
            'data' => $user,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = $this->userRepository->getById($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\user\UpdateUserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $user = $this->userRepository->updateById($id, $request->except('id'));

        return response()->json([
            'success' => true,
            'message' => 'User has been updated successfully!',
            'data' => $user,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->userRepository->deleteById($id);

        return response()->json([
            'success' => true,
            'message' => 'User has been deleted successfully!',
        ]);
    }
}
