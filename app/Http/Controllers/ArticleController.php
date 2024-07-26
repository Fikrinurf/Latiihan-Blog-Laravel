<?php

namespace App\Http\Controllers;

use auth;
use App\Models\Tag;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\File;


class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.artikel.index')->with([
            'articles'      => Article::orderBy('created_at', 'desc')->get(),
            'title'         => 'Artikel'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.artikel.artikel-baru')->with([
            'categories'    => Category::all(),
            'title'         => 'Artikel'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validasi = $request->validate([
            'judul'         => 'required|max:255',
            'slug'          => 'required|unique:articles',
            'gambar'        => 'image|file|max:2048',
            'category_id'   => 'required',
            'tag'           => 'required',
            'isi'           => 'required',

        ], [
            'judul.required'              => 'Judul artikel harus diisi',
            'judul.max'                   => 'Judul maximal 225 karakter',
            'slug.required'               => 'Slug tidak boleh kosong',
            'slug.unique'                 => 'Slug sudah dipakai',
            'gambar.image'                => 'File yang anda upload bukan gambar',
            'gambar.max'                  => 'Maximal ukuran gambar 2 MB',
            'category_id.required'        => 'Kategori artikel harus dipilih',
            'tag.required'                => 'Tag artikel harus diisi',
            'isi.required'                => 'Isi artikel harus diisi',
        ]);

        //jika ada gambar yang diupload user
        if ($request->file('gambar')) {

            $nama_gambar = $request->file('gambar')->hashName();
            $request->file('gambar')->move(public_path('images'), $nama_gambar);
            $validasi['gambar'] = $nama_gambar;
        }

        $validasi['user_id'] = auth()->user()->id;
        $validasi['kutipan'] = Str::limit(strip_tags($request->isi), 150);

        $article = Article::create($validasi);

        //insert tag ke tabel artikel tag
        $tags = explode(',', $request->tag);

        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate(['name' => trim($tagName)]);
            $article->tags()->attach($tag);
        }

        return back()->with('info', 'Artikel baru berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $article = Article::where('id', $id)->first();
        return view('dashboard.artikel.artikel-edit')->with([
            'categories'        => Category::all(),
            'data'              => $article,
            'tags'              => $article->tags()->implode('name', ','),
            'title'             => 'Artikel'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $article = Article::where('id', $id)->first();

        $validasi = [
            'judul'         => 'required|max:255',
            'gambar'        => 'image|file|max:2048',
            'category_id'   => 'required',
            'tag'           => 'required',
            'isi'           => 'required',
        ];

        if ($request->slug != $article->slug) {
            $validasi['slug'] = 'required|unique:articles';
        }

        $dataValidasi = $request->validate($validasi, [
            'judul.required'              => 'Judul artikel harus diisi',
            'judul.max'                   => 'Judul maximal 225 karakter',
            'slug.required'               => 'Slug tidak boleh kosong',
            'slug.unique'                 => 'Slug sudah dipakai',
            'gambar.image'                => 'File yang anda upload bukan gambar',
            'gambar.max'                  => 'Maximal ukuran gambar 2 MB',
            'category_id.required'        => 'Kategori artikel harus dipilih',
            'tag.required'                => 'Tag artikel harus diisi',
            'isi.required'                => 'Isi artikel harus diisi',
        ]);

        if ($request->file('gambar')) {
            if ($request->gambarLama) {
                File::delete(public_path('images/' . $request->gambarLama));
            }

            $nama_gambar = $request->file('gambar')->hashName();
            $request->file('gambar')->move(public_path('images'), $nama_gambar);
            $dataValidasi['gambar'] = $nama_gambar;
        }

        $dataValidasi['user_id'] = auth()->user()->id;
        $dataValidasi['kutipan'] = Str::limit(strip_tags($request->isi), 150);

        $article->update($dataValidasi);

        $tags = explode(',', $request->tag);
        $newTags = [];
        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate(['name' => trim($tagName)]);
            array_push($newTags, $tag->id);
        }

        $article->tags()->sync($newTags);

        return redirect('/dashboard/artikel')->with('info', 'Artikel berhasi di update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $article = Article::where('id', $id)->first();

        if ($article->gambar) {
            File::delete(public_path('images/') . $article->gambar);
        }

        $article->tags()->detach();

        Article::where('id', $id)->delete();

        return back()->with('info', 'Artikel telah dihapus');
    }

    public function getSlug(Request $request)
    {
        $slug = SlugService::createSlug(Article::class, 'slug', $request->judul);
        return response()->json(['slug' => $slug]);
    }
}
