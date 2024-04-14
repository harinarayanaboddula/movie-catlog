@extends('main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                @if (session()->has('success'))
                    <p>{{ session()->get('success') }}</p>
                @endif
                @if ($errors->any())
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="col-md-12 pb-4">
                <div class="d-flex justify-content-between align-items-center">

                        <form action="{{ route('search') }}" method="POST">
                            @csrf
                            <div class="d-flex align-items-center">
                                <input class="form-control mr-sm-2" name="search" type="search" id="searchInput" placeholder="Search" aria-label="Search">
                                <button type="submit" class="btn btn-primary" id="searchButton">Search</button>
                            </div>
                        </form>

                    <div>
                        <a href="{{ route('movie.index') }}"><button type="button" class="btn btn-primary">Add Movie </button></a>
                    </div>
                </div>
            </div>
            <div id="loader" class="text-center my-5 d-none"><i class="fa-solid fa-spinner fa-spin fa-3x"></i></div>
            @forelse ($movies as $movie)
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="{{ asset('images/'.$movie->image) }}" class="card-img-top image-tag" alt="image">
                    <div class="card-body">
                        <p class="card-text"><b>Title: </b>{{ $movie->title }}</p>
                        <p class="card-text"><b>Genre: </b>{{ $movie->genre }}</p>
                        <p class="card-text"><b>Release Year: </b>{{ $movie->year }}</p>
                        <p class="card-text line-clamp"><b>Description: </b>{{ $movie->description }}</p>
                        <button type="button" class="btn btn-primary read-more-btn" data-toggle="modal" data-target="#descriptionModal" data-description="{{ $movie->description }}">
                            Read More
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <p>No movies found for your search query.</p>
            @endforelse


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
    <script>
        $(document).ready(function() {
            $('.read-more-btn').click(function() {
                var description = $(this).data('description');
                $('#movieDescription').text(description);
            });
        });


    </script>
@endpush
