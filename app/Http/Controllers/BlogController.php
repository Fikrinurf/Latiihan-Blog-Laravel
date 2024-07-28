<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Slide;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        return view('blog.index')->with(
            [
                'title'         => 'Beranda',
                'slides'        => Slide::all(),
                'categories'    => Category::all(),
                'articles'      => Article::orderBy('created_at', 'desc')->paginate(5)->withQueryString()
            ]
        );
    }

    public function article()
    {
        $articles = Article::latest();
        $filter = '';
        $filte_name = '';

        if (request('cari')) {
            $articles->where('judul', 'like', '%' . request('cari') . '%')
                ->orWhere('isi', 'like', '%' . request('cari') . '%');
            $filter = request('cari');
            $filte_name = 'Hasil Pencarian';
        }

        return view('blog.artikel')->with(
            [
                'title'         => 'Artikel',
                'categories'    => Category::all(),
                'articles'      => $articles->paginate(5)->withQueryString()
            ]
        );
    }
}
