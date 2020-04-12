<?php

namespace App\Http\Controllers;

use App\Bookmark;
use App\Helpers\XpathParser;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BookmarkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $bookmarks = Bookmark::orderBy('created_at', 'DESC')->paginate(5);

        return view('bookmarks.index', ['bookmarks' => $bookmarks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('bookmarks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            //'title' => 'required',
            'url_origin' => ['required', 'unique:bookmarks', 'url', 'active_url']
        ]);

        $url_origin = $request->url_origin;
        $http_code = $this->url_test($url_origin);
        if (($http_code == "200") || ($http_code == "302")) {
            //dd($http_code);
        } else {
            return redirect('bookmarks/create')->withErrors(["1_error" => "Ошибка! сервер $url_origin вернул код ошибки: $http_code"]);
        }

        $parser = new XpathParser($url_origin);
        $new_fields = [
            'title' => $parser->get('/html/head/title'),
            'favicon' => $parser->getLink($parser->get('//link[@rel="icon" or @rel="shortcut icon"]', 'href')),
            'meta_description' => mb_strimwidth($parser->get('/html/head/meta[@name="description"]', 'content'), 0, 252, "..."),
            'meta_keywords' => $parser->get('/html/head/meta[@name="keywords"]', 'content'),
            'url_origin' => $parser->bookmark_url
        ];

        //Добавим к запросу все нужные поля
        $request->request->add($new_fields);
        //dd($request->all());
        $bookmark = Bookmark::add($request->all());
        return redirect()->route('bookmarks.show', ['bookmark' => $bookmark->id]);
    }

    private function url_test(string $url): int
    {
        $timeout = 10;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        $http_respond = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $http_code;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Factory|View
     */
    public function show($id)
    {
        $bookmark = Bookmark::find($id);
        return view('bookmarks.show', ['bookmark' => $bookmark]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Factory|View
     */
    public function edit($id)
    {
        $bookmark = Bookmark::find($id);
        return view('bookmarks.edit', ['bookmark' => $bookmark]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'url_origin' => ['required', 'unique:bookmarks', 'url', 'active_url']
        ]);

        $bookmark = Bookmark::find($id);
        $bookmark->edit($request->all());
        if (!empty($request->file('image'))) {
            $bookmark->uploadImage($request->file('image'));
        }

        return redirect()->route('bookmarks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        Bookmark::find($id)->remove();
        return redirect()->route('bookmarks.index');
    }
}
