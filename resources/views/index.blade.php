@extends('main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                @if (session()->has('success'))
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
            </div>
            <div class="col-md-12 pb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <input class="form-control mr-sm-2" name="search" type="search" id="searchData"
                            placeholder="Search movies, genre or year" aria-label="Search">
                        <button type="button" class="btn btn-primary" id="searchButton">Search</button>
                    </div>
                    <div>
                        <a href="{{ route('movie.index') }}"><button type="button" class="btn btn-primary">Add Movie </button></a>
                    </div>
                </div>
            </div>
            <div id="loader" class="text-center my-5 d-none"><i class="fa-solid fa-spinner fa-spin fa-3x"></i></div>
            <div class="col-md-12">
                <div id="movieResults" class="row"></div>
            </div>


            <div class="modal fade" id="descriptionModal" tabindex="-1" role="dialog"
                aria-labelledby="descriptionModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="descriptionModalLabel">Movie Description</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p id="movieDescription"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .image-tag {
            height: 252px;
            width: 348px;
            object-fit: cover;
        }

        .line-clamp {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            text-overflow: ellipsis;
            overflow: hidden;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.read-more-btn', function() {
                var description = $(this).data('description');
                $('#movieDescription').text(description);
                $('#descriptionModal').modal('show');
            });
            fetchMovies();
        });
        $('#searchData').keydown(function(e) {
            if (e.keyCode == 13) {
                fetchMovies($(this).val());
            }
        });
        $('#searchButton').click(function(e) {
            fetchMovies($('#searchData').val());
        });
        $('#delete-movie').click(function(e) {
            var data = $(this);
            $('#delete-movie').prop('disabled', true)

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: '{{ route("movie.destroy", $movie->id)}}'
                success: function(response) {
                    $('#delete-movie').prop('disabled', false)
                    Swal.fire({
                        title: 'Are you Sure?',
                        text: 'You want to delete the Movie',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if(result.isConfirmed) {
                            $('#deleteMovieForm').submit();
                        }
                    })
                }
                error: function(xhr, status, error) {
                    $('#delete-movie').prop('disabled', false)
                    console.log(error);
                }
            })

        })

        function fetchMovies(search = null) {
            $('#loader').removeClass('d-none');
            $('#movieResults').html('');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: '{{ route("search") }}',
                data: {
                    search: search
                },
                success: function(response) {
                    $('#loader').addClass('d-none');
                    $('#movieResults').html(response);
                },
                error: function(xhr, status, error) {
                    $('#loader').addClass('d-none');
                    $('#movieResults').html(
                        '<p class="text-center my-5">There is some issue with fetching the search results</p>'
                        );
                }
            })
        }
    </script>
@endpush
