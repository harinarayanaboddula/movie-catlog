@forelse ($movies as $movie)
<div class="col-md-4">
    <div class="card mb-4">
        <img src="{{ asset('images/'.$movie->image) }}" class="card-img-top image-tag" alt="image">
        <div class="card-body">
            <p class="card-text"><b>Title: </b>{{ $movie->title }}</p>
            <p class="card-text"><b>Genre: </b>{{ $movie->genre }}</p>
            <p class="card-text"><b>Release Year: </b>{{ $movie->year }}</p>
            <p class="card-text line-clamp"><b>Description: </b>{{ $movie->description }}</p>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <button type="button" class="btn btn-outline-primary read-more-btn" data-toggle="modal" data-target="#descriptionModal" data-description="{{ $movie->description }}">
                        Read More
                    </button>
                </div>
                <div class="d-flex align-items-center">
                    <a href="{{ route('movie.edit', $movie->id)}}" class="mr-1"><button class="btn btn-outline-secondary">Edit</button></a>
                    <form id="deleteMovieForm">
                        @csrf
                        <button type="button" class="btn btn-outline-danger" id="delete-movie">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@empty
<p>No movies found for your search query.</p>
@endforelse
