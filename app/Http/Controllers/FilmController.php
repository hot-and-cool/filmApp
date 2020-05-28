<?php

namespace App\Http\Controllers;

use App\Clip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Carbon\Carbon;
use PHPUnit\Framework\Constraint\IsTrue;

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

    public function show(Request $request, $movieId)
    {
        // 共通処理
        $apiKey = config('app.api_key');
        $baseUrl = config('app.base_url');
        $regionUrl = config('app.region_url');
        $method = 'GET';

        $searchWord = $request->input('search_movie');

        // 映画情報
        $url = $baseUrl . 'movie/' . $movieId . '?api_key=' . $apiKey . $regionUrl;
        $response = $this->client->request($method, $url);
        $item = $response->getBody();
        $item = json_decode($item, true);
        $releaseDate = new Carbon($item['release_date']);
        $releaseYear = $releaseDate->__get('year');

        // 出演者情報
        $creditsUrl = $baseUrl . 'movie/' . $movieId . '/credits?' . 'api_key=' . $apiKey . $regionUrl;
        $creditsResponse = $this->client->request($method, $creditsUrl);
        $credits = $creditsResponse->getBody();
        $credits = json_decode($credits, true);
        $casts = array_slice($credits['cast'], 0, 10); //出演者の10件表示
        $jobArray = array_column($credits['crew'], 'job');
        $directorNum = array_search('Director', $jobArray, true);
        $director = $credits['crew'][$directorNum];
        $writerNum = array_search('Writer', $jobArray, true);
        if ($writerNum) {
            $writer = $credits['crew'][$writerNum];
        }

        // 関連作品
        $recommendsUrl = $baseUrl . 'movie/' . $movieId . '/recommendations?' . 'api_key=' . $apiKey . $regionUrl;
        $recommendsResponse = $this->client->request($method, $recommendsUrl);
        $recommends = $recommendsResponse->getBody();
        $recommends = json_decode($recommends, true);

        // clip済み判定
        $clippedMovie = $this->clip->getFirstClip($movieId);

        return view('show', compact('item', 'searchWord', 'releaseYear', 'casts', 'recommends', 'director', 'writer', 'clippedMovie'));
    }

    public function storeClip(Request $request, $movieId)
    {
        $clippedMovie = $this->clip->getFirstClip($movieId);
        $inputs = $request->all();
        $inputs['user_id'] = Auth::id();
        if ($clippedMovie) {
            $this->clip->where('user_id', Auth::id())->where('movie_id', $movieId)->delete();
        } else {
            $this->clip->fill($inputs)->save();
        }

        return json_encode($inputs);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $movieId
     * @return \Illuminate\Http\Response
     */
    public function showPersonPage(Request $request, $personId)
    {
        $apiKey = config('app.api_key');
        $baseUrl = config('app.base_url');
        $regionUrl = config('app.region_url');
        $method = 'GET';

        $searchWord = $request->input('search_movie');

        // 基本情報
        $peopleUrl = $baseUrl . 'person/' . $personId . '?api_key=' . $apiKey . $regionUrl
                    . 'append_to_response=external_ids%2Ccredits';
        $response = $this->client->request($method, $peopleUrl);
        $person = $response->getBody();
        $person = json_decode($person, true);
        $knownAsNameArray = $person['also_known_as'];
        $kana = preg_grep('/^[ぁ-んァ-ン]+$/', $knownAsNameArray);
        $alp = preg_grep('/^[a-zA-Z]+$/', $knownAsNameArray);
        $kanji = preg_grep('/^[一-龠]+$/', $knownAsNameArray); //漢字、カタカナ込
        if (!empty($knownAsNameArray)) {
            $knownAsName = $kana;
        }
        $knownAsName = array_values($knownAsName);

        // 出演作品(制作に携わっていればcrewを取得)
        if (empty($person['credits']['crew'])) {
            $appearances = $person['credits']['cast'];
        } else {
            $appearances = $person['credits']['crew'];
        }

        return view('credit', compact('searchWord', 'person', 'appearances', 'knownAsName'));
    }

    public function showMypage(Request $request)
    {
        $apiKey = config('app.api_key');
        $baseUrl = config('app.base_url');
        $regionUrl = config('app.region_url');
        $method = 'GET';

        $searchWord = $request->input('search_movie');

        $myClipMovies = $this->clip->where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate();

        return view('mypage', compact('searchWord', 'myClipMovies'));
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
