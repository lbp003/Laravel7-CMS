@extends('layouts.app');

@section('content')
    <div class="d-flex justify-content-end mb-2">
        <a href="{{ route('posts.create') }}" class="btn btn-success">Create Post</a>
    </div>
    <div class="card card-default">
        <div class="card-header">
            Posts
        </div>
        <div class="card-body">
            @if($posts->count() > 0)
            <table class="table">
                <thead>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td><img src="{{ asset('storage/'.$post->image) }}" alt="image" width="100px" height="auto" /></td>
                            <td>{{ $post->title}}</td>
                            <td>{{ isset($post->category->id) ? $post->category->name : '' }}</td>
                            @if($post->trashed())
                            <td class="d-flex justify-content-end">
                                <form method="POST" action="{{ route('restore-posts', $post->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-primary btn-sm">Restore</button>
                                </form>
                            </td>
                            @else
                            <td class="d-flex justify-content-end">
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            </td>
                            @endif
                            <td>
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">{{ $post->trashed() ? 'Delete' : 'Trash' }}</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <h3 class="text-center">No Posts yet</h3>
            @endif
        </div>
    </div>
@endsection