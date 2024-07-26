<div class=" bg-white" id="sidebar-wrapper">
    <div class="sidebar-heading border-bottom bg-dark text-white">Admin Dashboard</div>
    <div class="list-group list-group-flush">
        <a class="list-group-item list-group-item-action list-group-item-light p-3 {{ $title == 'About' ? 'active' : '' }}"
            href="{{ url('/dashboard') }}">About</a>
        <a class="list-group-item list-group-item-action list-group-item-light p-3 {{ $title == 'Slide' ? 'active' : '' }}"
            href="{{ url('/dashboard/slide') }}">Slide</a>
        <a class="list-group-item list-group-item-action list-group-item-light p-3 {{ $title == 'Kategori' ? 'active' : '' }}"
            href="{{ url('/dashboard/kategori') }}">Kategori</a>
        <a class="list-group-item list-group-item-action list-group-item-light p-3 {{ $title == 'Artikel' ? 'active' : '' }}"
            href="{{ url('/dashboard/artikel') }}">Article</a>
    </div>
</div>
