@extends('layouts.app');

@section('content')
    <div class="d-flex justify-content-end mb-2">
        <a href="{{ route('categories.create') }}" class="btn btn-success">Add Category</a>
    </div>
    <div class="card card-default">
        <div class="card-header">
            Categories
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <th>Name</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td class="d-flex justify-content-end">
                                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary btn-sm mr-2">Edit</a>
                                <a href="#" class="btn btn-danger btn-sm" onclick="handleDelete({{ $category->id }})">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="modal" tabindex="-1" role="dialog" id="deleteModel">
                <div class="modal-dialog" role="document">
                    <form id="deleteCategoryForm" method="POST" action="">
                        @csrf
                        @method('DELETE')

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Delete Category</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No, Go back</button>
                            </div>
                        </div>
                    </form>
                </div>
              </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function handleDelete(id){

            var form = document.getElementById('deleteCategoryForm');
            form.action = '/categories/'+id;

            $('#deleteModel').modal('show');
        }
    </script>    
@endsection
