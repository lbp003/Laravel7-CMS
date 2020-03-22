@extends('layouts.app');

@section('content')
    <div class="card card-default">
        <div class="card-header">
            {{ isset($post) ? 'Edit Post' : 'Create Post' }}
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="list-group">
                        @foreach ($errors->all() as $error)
                            <li class="list-group-item text-danger">
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ isset($post) ? route('posts.update', $post->id) : route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @if(isset($post))
                    @method('PUT')
                @endif
                
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" class="form-control" value="{{ isset($post) ? $post->title : '' }}" />
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="form-control" value="{{ isset($post) ? $post->description : '' }}" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea id="content" name="content" class="form-control" value="{{ isset($post) ? $post->content : '' }}" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <label for="publish_at">Publish At</label>
                    <input type="text" id="publish_at" name="publish_at" class="form-control" value="{{ isset($post) ? $post->publish_at : '' }}" />
                </div>
                <div class="form-group">
                    <label for="title">Image</label>
                    <input type="file" id="image" name="image" class="form-control" value="{{ isset($post) ? $post->image : '' }}" />
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success float-right">{{ isset($post) ? 'Update Post' : 'Create Post' }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
