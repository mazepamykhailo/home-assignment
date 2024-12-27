<?php

namespace App\Http\Controllers;

use App\Http\Requests\record\StoreRecordRequest;
use App\Http\Requests\record\UpdateRecordRequest;
use App\Models\User;
use App\Models\Record;
use App\Repositories\Record\RecordRepository; 
use App\Repositories\Category\CategoryRepository; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    protected $recordRepository; // Repository for managing record data
    protected $categoryRepository; // Repository for managing category data
    protected $user; // Currently authenticated user

    public function __construct(RecordRepository $recordRepository, CategoryRepository $categoryRepository)
    {
        $this->recordRepository = $recordRepository; // Initialize the record repository
        $this->categoryRepository = $categoryRepository; // Initialize the category repository

        // Middleware to set the authenticated user
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    /**
     * Display a list of all resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = $this->user->role == 'manager' 
            ? $this->recordRepository->paginate(10 ,['*'], 'page') // Paginate records for manager
            : $this->user->records(10); // Paginate records for regular users

        $records->load('category'); // Load categories in one query
        $records->transform(function ($record) {
            $record->user_email = $record->user->email; // Add email to record
            return $record;
        });

        // Return the view with all records
        return view('dashboard.record.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categoryRepository->get(); // Fetch categories
        return view('dashboard.record.create', compact('categories'));
    }

    /**
     * Store a newly created resource in the database.
     *
     * @param  \App\Http\Requests\StoreRecordRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRecordRequest $request)
    { 
        // Create a new record with authenticated user's ID
        $this->recordRepository->create($request->merge(['user_id' => $this->user->id])->all());
        toast('Record has been submitted!', 'success'); // Show success message
        return redirect()->route('record'); // redirect to record
    } 

    /**
     * Show the form for editing a specific resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = $this->categoryRepository->get(); // Fetch categories
        $record = $this->recordRepository->getById($id); // Fetch record by ID

        return view('dashboard.record.edit', compact('record', 'categories')); // Return edit view
    }

    /**
     * Update the specified resource in the database.
     *
     * @param  \App\Http\Requests\UpdateRecordRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRecordRequest $request)
    {
        // Update the record with the provided data

        $this->recordRepository->updateById(
            $request->id, 
            $request->except('id') + ['user_id' => $this->user->id]
        );

        toast('Record has been updated!', 'success'); // Show success message
        return redirect()->route('record'); //redirect to record
    }

    /**
     * Remove the specified resource from the database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->recordRepository->deleteById($id); // Delete the record by its ID
        toast('Record has been deleted!', 'success'); // Show success message
        return redirect()->route('record'); //redirect to record
    }
}
