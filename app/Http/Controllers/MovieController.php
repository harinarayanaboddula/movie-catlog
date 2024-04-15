<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index() {
        return view('create');
    }

    public function store(Request $request) {

        $request->validate([
            'title' => 'required',
            'genre' => 'required',
            'year' => 'required|numeric',
            'description' => 'required',
            'image' => 'required|image'
        ]);

        $movie = new Movie;
        $movie->title = $request->input('title');
        $movie->genre = $request->input('genre');
        $movie->year = $request->input('year');
        $movie->description = $request->input('description');

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $filename);
            $movie->image = $filename;
        }

        $movie->save();

        return redirect()->route('home')->with('success', 'Movie added successfully');

    }

    public function getMoviesList() {

        return view('index');
    }

    public function search(Request $request) {
        $searchQuery = $request->input('search');

        $movies = Movie::where('title', 'like', "%".$searchQuery."%")
            ->orWhere('genre', 'like', "%".$searchQuery."%")
            ->orWhere('year', $searchQuery)
            ->get();


        return view('search_results', compact('movies'))->render();
    }
}
