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
            ->orderBy('id', 'desc')
            ->get();


        return view('search_results', compact('movies'))->render();
    }

    public function edit($id) {

        $movie = Movie::find($id);
        return view('edit', compact('movie'));
    }

    public function update(Request $request, $id) {

        $movie = Movie::find($id);
        $movie->title = $request->input('title');
        $movie->genre = $request->input('genre');
        $movie->year = $request->input('year');
        $movie->description = $request->input('description');

        $request->validate([
            'title' => 'required',
            'genre' => 'required',
            'year' => 'required|numeric',
            'description' => 'required',
            'image' => is_null($movie->image) ? 'required|image' : 'nullable|image'
        ]);

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $filename);
            $movie->image = $filename;
        }

        $movie->update();

        return redirect()->route('home')->with('success', 'Movie Updated successfully');
    }

    public function destroy($id) {

        $movie = Movie::find($id);

        $movie->delete();

        return redirect()->route('home')->with('success', 'Movie deleted successfully');
    }
}
