@extends('blog.layout.main')

@section('content')
    <div class="col-lg-8">
        @if ($articles->count())
            <div class="card mb-4 border-0">
                <a href="{{ 'artikel/' . $articles[0]->slug }}"><img class="card-img-top"
                        src="{{ asset('images/' . $articles[0]->gambar) }}" alt="gambar artikel" /></a>
                <div class="card-body px-0">
                    <div class="small text-muted">Diposting {{ $articles[0]->created_at->format('d F Y') }} - Kategori <a
                            href="/artikel?kategori={{ $articles[0]->category->slug }}"
                            class="text-decoration-none">{{ $articles[0]->category->nama }}</a></div>
                    <h2 class="card-title">{{ $articles[0]->judul }}</h2>
                    <p class="card-text">{{ strip_tags($articles[0]->kutipan) }}</p>
                    <a class="text-decoration-none" href="/artikel/{{ $articles[0]->slug }}">Lanjut Baca →</a>
                    <div class="mt-3">
                        @foreach ($articles[0]->tags as $tag)
                            <a href="/artikel?tag={{ $tag->slug }}"
                                class="badge bg-secondary text-decoration-none link-light">{{ $tag->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- Nested row for non-featured blog posts-->
            <div class="row">
                @foreach ($articles->skip(1) as $article)
                    <div class="col-lg-6">
                        <div class="card mb-4 border-0">
                            <a href="{{ 'artikel/' . $article->slug }}"><img class="card-img-top"
                                    src="{{ asset('images/' . $article->gambar) }}" alt="gambar artikel" /></a>
                            <div class="card-body px-0">
                                <div class="small text-muted">Diposting {{ $article->created_at->format('d F Y') }} -
                                    Kategori
                                    <a href="/artikel?kategori={{ $article->category->slug }}"
                                        class="text-decoration-none">{{ $article->category->nama }}</a>
                                </div>
                                <h2 class="card-title">{{ $article->judul }}</h2>
                                <p class="card-text">{{ strip_tags($article->kutipan) }}</p>
                                <a class="text-decoration-none" href="/artikel/{{ $article->slug }}">Lanjut Baca →</a>
                                <div class="mt-3">
                                    @foreach ($article->tags as $tag)
                                        <a href="/artikel?tag={{ $tag->slug }}"
                                            class="badge bg-secondary text-decoration-none link-light">{{ $tag->name }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Pagination-->
        @else
            <h3 class="my2">
                <i class="fa-solid fa-magnifying-glass"></i> Tidak artikel yang anda cari ....
            </h3>
        @endif

        @if ($articles->hasPages())
            <hr>
        @endif

        {{ $articles->links() }}
    </div>
@endsection
