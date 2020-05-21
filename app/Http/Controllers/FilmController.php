<?php

namespace App\Http\Controllers;

use App\Clip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Carbon\Carbon;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $client;
    protected $clip;

    public function __construct(Client $client, Clip $clip)
    {
        $this->middleware('auth');
        $this->client = $client;
        $this->clip = $clip;
    }

    public function index(Request $request)
    {
        // 共通処理
        $apiKey = config('app.api_key');
        $baseUrl = config('app.base_url');
        $regionUrl = config('app.region_url');
        $method = 'GET';

        // 検索およびカテゴリ分け
        $searchWord = $request->input('search_movie');
        $topRated = $request->input('top_rated');
        $latest = $request->input('latest');
        $upcoming = $request->input('upcoming');
        $urlWord = urlencode($searchWord);
        if (isset($searchWord)) {
            $sortUrl = 'search/movie?';
        } elseif (isset($topRated)) {
            $sortUrl = 'movie/top_rated?';
        } elseif (isset($latest)) {
            $sortUrl = 'movie/now_playing?';
        } elseif (isset($upcoming)) {
            $sortUrl = 'movie/upcoming?';
        } else {
            $sortUrl = 'movie/popular?';
        }

        $url = $baseUrl . $sortUrl . 'api_key=' . $apiKey . $regionUrl . 'query=' . $urlWord;
        $response = $this->client->request($method, $url);
        $items = $response->getBody();
        $items = json_decode($items, true);

        return view('index', compact('items', 'searchWord'));
    }

    public function show(Request $request, $id)
    {
        // 共通処理
        $apiKey = config('app.api_key');
        $baseUrl = config('app.base_url');
        $regionUrl = config('app.region_url');
        $method = 'GET';

        $searchWord = $request->input('search_movie');

        // 映画情報
        $url = $baseUrl . 'movie/' . $id . '?api_key=' . $apiKey . $regionUrl;
        $response = $this->client->request($method, $url);
        $item = $response->getBody();
        $item = json_decode($item, true);
        $releaseDate = new Carbon($item['release_date']);
        $releaseYear = $releaseDate->__get('year');

        // 出演者情報
        $creditsUrl = $baseUrl . 'movie/' . $id . '/credits?' . 'api_key=' . $apiKey . $regionUrl;
        $creditsResponse = $this->client->request($method, $creditsUrl);
        $credits = $creditsResponse->getBody();
        $credits = json_decode($credits, true);
        $casts = array_slice($credits['cast'], 0, 10); //10件表示

        // 関連作品
        $recommendsUrl = $baseUrl . 'movie/' . $id . '/recommendations?' . 'api_key=' . $apiKey . $regionUrl;
        $recommendsResponse = $this->client->request($method, $recommendsUrl);
        $recommends = $recommendsResponse->getBody();
        $recommends = json_decode($recommends, true);

        return view('show', compact('item', 'searchWord', 'releaseYear', 'casts', 'recommends'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
