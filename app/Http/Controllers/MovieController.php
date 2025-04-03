<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class MovieController extends Controller
{
    private $apiKey = 'a277e116';
    private $omdbBaseUrl = 'http://www.omdbapi.com/';
    private $client;

    public function __construct()
    {
        // Inisialisasi Guzzle Client
        $this->client = new Client([
            'base_uri' => $this->omdbBaseUrl,
            'timeout'  => 10.0, // Timeout 10 detik
            'verify'   => false // Nonaktifkan SSL verification (opsional)
        ]);
    }

    /**
     * Menampilkan daftar film
     */
    public function index(Request $request)
    {
        try {
            $params = [
                'apikey' => $this->apiKey,
                's'      => $request->input('s', ''),
                'y'      => $request->input('y', ''),
                'type'   => $request->input('type', ''),
                'page'   => $request->input('page', 1)
            ];

            $response = $this->client->get('', ['query' => $params]);
            $movies = json_decode($response->getBody(), true);

            if (!isset($movies['Search'])) {
                $movies['Search'] = [];
            }

            // Get favorite IDs for the current user
            $favoriteIds = auth()->check()
                ? auth()->user()->favorites->pluck('imdb_id')->toArray()
                : [];

            if ($request->ajax()) {
                return response()->json($movies);
            }

            return view('movies.index', [
                'movies' => $movies,
                'search' => $params['s'],
                'year'   => $params['y'],
                'type'   => $params['type'],
                'favoriteIds' => $favoriteIds
            ]);
        } catch (\Exception $e) {
            return response()->view('errors.500', [
                'message' => 'Failed to fetch movies: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menampilkan detail film
     */
    public function show($id)
    {
        try {
            $params = [
                'apikey' => $this->apiKey,
                'i'      => $id,
                'plot'   => 'full'
            ];

            $response = $this->client->get('', ['query' => $params]);
            $movie = json_decode($response->getBody(), true);

            // Cek favorit
            $isFavorite = Favorite::where('user_id', Auth::id())
                ->where('imdb_id', $id)
                ->exists();

            return view('movies.show', [
                'movie'      => $movie,
                'isFavorite' => $isFavorite
            ]);
        } catch (\Exception $e) {
            return redirect()
                ->route('movies.index')
                ->with('error', 'Movie not found');
        }
    }

    /**
     * Menambahkan film ke favorit
     */
    public function addFavorite(Request $request)
    {
        $request->validate([
            'imdb_id' => 'required',
            'title'   => 'required',
            'year'    => 'required',
            'poster'  => 'nullable|url'
        ]);

        Favorite::firstOrCreate([
            'user_id' => Auth::id(),
            'imdb_id' => $request->imdb_id
        ], [
            'title'  => $request->title,
            'year'   => $request->year,
            'poster' => $request->poster
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Menghapus film dari favorit
     */
    public function removeFavorite($id)
    {
        $favorite = Favorite::where('user_id', Auth::id())
            ->where('imdb_id', $id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    /**
     * Menampilkan daftar favorit
     */
    public function favorites()
    {
        $favorites = Favorite::where('user_id', Auth::id())->get();
        return view('movies.favorites', compact('favorites'));
    }
}
