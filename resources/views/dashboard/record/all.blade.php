@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Records') }} </div>

                <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Image</th>
                        <th scope="col">Category</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($records as $index => $record)
                    <tr>
                        <th scope="row">{{ $index + 1 }}</th>
                        <td>{{ $record->name }}</td>
                        <td><img src="{{ $record->image }}" /></td>
                        <td>{{ $record->category->category }}</td>
                        <td>
                            <a href="{{ Route('record/destroy', $record->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                            <a href="{{ Route('record', ['userId' => $record->user_id]) }}" class="btn btn-info"><i class="fa fa-user">{{ $record->user}}</i></a>
                        </td>
                    </tr>
                @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center"> 
                    {{ $records->links('pagination.custom') }}
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
 

@endsection
