 <!-- Responsive navbar-->
 <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
     <div class="container">
         <a class="navbar-brand" href="#!">SiBerita</a>
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
             aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span
                 class="navbar-toggler-icon"></span></button>
         <div class="collapse navbar-collapse" id="navbarSupportedContent">
             <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                 <li class="nav-item"><a class="nav-link {{ $title == 'Beranda' ? 'active' : '' }}"
                         href="{{ url('/') }}">Beranda</a>
                 </li>
                 <li class="nav-item"><a class="nav-link {{ $title == 'Artikel' ? 'active' : '' }}"
                         href="{{ url('/artikel') }}">Artikel</a></li>
                 <li class="nav-item"><a class="nav-link" href="#!">Tentang</a></li>
                 @auth
                     <li class="nav-item dropdown">
                         <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                             data-bs-toggle="dropdown" aria-haspopup="true"
                             aria-expanded="false">{{ explode(' ', auth()->user()->name)[0] }}</a>
                         <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                             <a class="dropdown-item" href="{{ url('/dashboard') }}">Dashboard</a>
                             <div class="dropdown-divider"></div>
                             <form action="{{ url('/logout') }}" method="post">
                                 @csrf
                                 <button type="submit" class="dropdown-item">Logout</button>
                             </form>
                         </div>
                     </li>
                 @else
                     <li class="nav-item"><a class="nav-link {{ $title == 'Login' ? 'active' : '' }}" aria-current="page"
                             href="{{ url('/login') }}">Login</a></li>
                 </ul>
             @endauth

         </div>
     </div>
 </nav>
