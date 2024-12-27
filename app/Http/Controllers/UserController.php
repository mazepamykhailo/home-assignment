<?php

namespace App\Http\Controllers;
 
use App\Repositories\user\UserRepository;
use App\Http\Requests\user\StoreUserRequest;
use App\Http\Requests\user\UpdateUserRequest;
use App\Notifications\EmployeeAddedNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 

class UserController extends Controller
{
    public $userRepository;
    private $user;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository =  $userRepository;

        $this->middleware(function ($request, $next) {

            $this->user = Auth::user();
            $this->authorize('is_manager',$this->user);

            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $users = $this->userRepository->paginate(5,['*'],'page');;
        return view('dashboard.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.user.create');
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $this->userRepository->create([
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        $employee->notify(new EmployeeAddedNotification());
        toast('Your User as been submited!','success');
        return redirect('/user');
    } 

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->userRepository->getById($id);
        return view('dashboard.user.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request)
    {
        $this->userRepository->updateById($request->id, $request->except('id'));
        return redirect('/user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    { 
        $this->userRepository->deleteById($id);
        return redirect()->back()->with('success','test dev');
    }
}
