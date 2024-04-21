@extends('main')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @if(session()->has('success'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <p>{{ session()->get('success') }}</p>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            @if ($errors->any())
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <div class="col-md-8 text-center py-4">
                <h1>Edit Movie Form</h1>
            </div>
            <div class="col-md-8">
                <form action="{{ route('movie.update', $movie->id) }}" id="movieForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" id="title" value="{{ $movie->title }}">
                    </div>
                    <div class="form-group">
                        <label for="genre">Genre</label>
                        <input type="text" class="form-control" name="genre" id="genre" value="{{ $movie->genre }}">
                    </div>
                    <div class="form-group">
                        <label for="year">Release Year</label>
                        <input type="number" class="form-control" name="year" id="year" value="{{ $movie->year }}">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3">{{ $movie->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" name="image" id="image">
                        @if ($movie->image)
                            <img src="{{ asset('images/' . $movie->image) }}" alt="Movie Image" id="image_preview" class="img-thumbnail mt-2" style="width: 166px; height: 230px;
                            object-fit: cover;">
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script>

        $(document).ready(function() {
            $(`form[id='movieForm']`).validate({
                    rules: {
                    title: "required",
                    genre: "required",
                    year: {
                        required: true,
                        number: true
                    },
                    description: "required",
                    image: {
                        required: isset($movie->image) ? false : true,
                        extension: "jpg|jpeg|png|bmp"
                    }
                },
                messages: {
                    title: "Please enter the title of the Movie",
                    genre: "Genre is required",
                    year: {
                        required: "Release year is required",
                        number: "Release year must be numeric"
                    },
                    description: "Description is required",
                    image: {
                        required: "Image is required",
                        extension: "Invalid image file format (allowed: jpg, jpeg, png, bmp)"
                    }
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    error.insertAfter($(element));
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function(form) {

                    $('#submitForm').click(function() {
                        $(`form[id='movieForm']`).submit();
                    });

                }
            })

            $('#image').change(function(e) {

                if (this.files && this.files[0]) {
                    var reader =  new FileReader();

                    reader.onload = function(e) {
                        $('#image_preview').attr('src', e.target.result).show();
                    }

                    reader.readAsDataURL(this.files[0]);
                }
            })
        });
    </script>
@endpush
