@extends('main')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @if(session()->has('success'))
                <p>{{ session()->get('success') }}</p>
            @endif
            @if ($errors->any())
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <div class="col-md-8 text-center py-4">
                <h1>Movie Form</h1>
            </div>
            <div class="col-md-8">
                <form action="{{ route('movie.store') }}" id="movieForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" id="title">
                    </div>
                    <div class="form-group">
                        <label for="genre">Genre</label>
                        <input type="text" class="form-control" name="genre" id="genre">
                    </div>
                    <div class="form-group">
                        <label for="year">Release Year</label>
                        <input type="number" class="form-control" name="year" id="year">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" name="image" id="image">
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
                        required: true,
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
                    event.preventDefault();

                    var formData = $(form).serialize();

                    // Make an AJAX request
                    $.ajax({
                        url: '{{ route("movie.store") }}', // Replace with your server endpoint
                        type: 'POST', // Use the appropriate HTTP method (POST, GET, etc.)
                        data: formData,
                        success: function(response) {
                            // Handle the success response (e.g., show a success message)
                            console.log('Form submitted successfully:', response);
                        },
                        error: function(error) {
                            // Handle the error response (e.g., show an error message)
                            console.error('Error submitting form:', error);
                        }
                    });

                    $('#submitForm').click(function() {
                        $(`form[id='movieForm']`).submit(); // Trigger the form submission
                    });

                }
            })
        });
    </script>
@endpush
