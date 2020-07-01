@extends('layouts.app');

@section('content')
    <div class="card card-default">
        <div class="card-header">
            {{ isset($post) ? 'Edit Post' : 'Create Post' }}
        </div>
        <div class="card-body">
           @include('partials.errors')
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
                    <textarea id="description" name="description" class="form-control" rows="5">{{ isset($post) ? $post->description : '' }}</textarea>
                </div>
                <div class="form-group">
                    <label for="content">Content</label>
                        <input id="content" type="hidden" name="content" value="{{ isset($post) ? $post->content : '' }}">
                        <trix-editor input="content"></trix-editor>
                </div>

                @if(isset($post))
                <div class="form-group">
                    <img src="{{ asset('storage/'.$post->image) }}" alt="image" width="100%"/>
                </div>
                @endif
            
                <div class="form-group">
                    <label for="publish_at">Publish At</label>
                    <input type="text" id="publish_at" name="publish_at" class="form-control" value="{{ isset($post) ? $post->published_at : '' }}" />
                </div>
                <div class="form-group">
                    <label for="title">Image</label>
                    <input type="file" id="image" name="image" class="form-control" value="{{ isset($post) ? $post->image : '' }}" />
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <select class="form-control" name="category" id="category">
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            @if(isset($post))
                                @if($category->id == $post->category_id)
                                    selected
                                @endif
                            @endif
                            >{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    @if($tags->count() > 0)
                    <label for="tags">Tags</label>
                    <select class="form-control tag-selector" name="tags[]" id="tags" multiple>
                        @foreach($tags as $tag)
                        <option value="{{ $tag->id }}" 
                            @if(isset($post))
                                @if($post->hasTag($tag->id))
                                selected
                                @endif
                            @endif
                            >
                            {{ $tag->name }}
                        </option>
                        @endforeach
                    </select>
                    @endif
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success float-right">{{ isset($post) ? 'Update Post' : 'Create Post' }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.js"></script>    
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
        $("#publish_at").flatpickr({
            enableTime: true
        });

        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            $('.tag-selector').select2();
        });

    </script>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.css" />  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
@endsection

