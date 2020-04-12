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
        $bookmarks = Bookmark::orderBy('created_at', 'DESC')->get();

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
            'url_origin' => ['required', 'unique:bookmarks']
        ]);

        $parser = new XpathParser($request->url_origin);
//        dd($parser->xml);
        // dd($parser->getLink($parser->get('/html/head/link[@rel="icon" or @rel="shortcut icon"]', 'href')));
        $new_fields = [
            'title' => $parser->get('/html/head/title'),
            'favicon' => $parser->getLink($parser->get('//link[@rel="icon" or @rel="shortcut icon"]', 'href')),
            'meta_description' => mb_strimwidth($parser->get('/html/head/meta[@name="description"]', 'content'), 0, 252, "..."),
            'meta_keywords' => $parser->get('/html/head/meta[@name="keywords"]', 'content'),
            'url_origin' => $parser->bookmark_url
        ];

        //Добавим к запросу все нужные поля
        $request->request->add($new_fields);

//        dd($request->all());
        $bookmark = Bookmark::add($request->all());
        if (!empty($request->file('image'))) {
            $bookmark->uploadImage($request->file('image'));
        }

        return redirect()->route('bookmarks.show', ['bookmark' => $bookmark->id]);
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
            'title' => 'required'
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
