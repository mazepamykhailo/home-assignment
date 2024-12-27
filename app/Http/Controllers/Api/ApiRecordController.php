<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Record\RecordRepository; 
use App\Repositories\Category\CategoryRepository; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiRecordController extends Controller
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
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $records = $this->user->role == 'manager' 
            ? $this->recordRepository->paginate(10, ['*'], 'page') // Paginate records for manager
            : $this->user->records(10); // Paginate records for regular users

        $records->load('category'); // Load categories in one query
        $records->transform(function ($record) {
            $record->user_email = $record->user->email; // Add email to record
            return $record;
        });

        $categories = $this->categoryRepository->get(); // Fetch categories
        // Return JSON response with all records and categories
        return response()->json(['records' => $records, 'categories' => $categories]);

    }

    /**
     * Store a newly created resource in the database.
     *
     * @param  StoreRecordRequest  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    { 
        // Create a new record with authenticated user's ID
        $record = $this->recordRepository->create($request->merge(['user_id' => $this->user->id])->all());
        
        return response()->json([
            'message' => 'Record has been submitted!',
            'record' => $record,
        ], 201); // 201 Created
    } 

    /**
     * Show a specific resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $record = $this->recordRepository->getById($id); // Fetch record by ID

        return response()->json($record); // Return record data
    }

    /**
     * Update the specified resource in the database.
     *
     * @param  UpdateRecordRequest  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        // Update the record with the provided data
        $this->recordRepository->updateById(
            $id, 
            $request->except('id') + ['user_id' => $this->user->id]
        );

        return response()->json(['message' => 'Record has been updated!']); // Success response
    }

    /**
     * Remove the specified resource from the database.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $this->recordRepository->deleteById($id); // Delete the record by its ID

        return response()->json(['message' => 'Record has been deleted!']); // Success response
    }
}
