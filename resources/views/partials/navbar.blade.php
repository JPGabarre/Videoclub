<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="/" style="color:#777"><span style="font-size:15pt">&#9820;</span> Videoclub</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        @if( Auth::check() )
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item {{ Request::is('catalog') && ! Request::is('catalog/create')? 'active' : ''}}">
                        <a class="nav-link" href="{{url('/catalog')}}">
                            <span class="glyphicon glyphicon-film" aria-hidden="true"></span>
                            Catálogo
                        </a>
                    </li>
                    <li class="nav-item {{  Request::is('category ') ? 'active' : ''}}">
                        <a class="nav-link" href="{{url('/category')}}">
                            <span class="glyphicon glyphicon-filter" aria-hidden="true"></span> Categorias
                        </a>
                    </li>
                    <li class="nav-item {{  Request::is('favorite') ? 'active' : ''}}">
                        <a class="nav-link" href="{{url('/favorite')}}">
                            <span class="glyphicon glyphicon-heart" aria-hidden="true"></span> Favoritas
                        </a>
                    </li>
                    <li class="nav-item {{  Request::is('catalog/create') ? 'active' : ''}}">
                        <a class="nav-link" href="{{url('/catalog/create')}}">
                            <span>&#10010</span> Nueva película
                        </a>
                    </li>
                    <li class="nav-item {{  Request::is('review') ? 'active' : ''}}">
                        <a class="nav-link" href="{{url('/review')}}">
                            <span class="glyphicon glyphicon-comment" aria-hidden="true"></span> Comentarios
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav navbar-right">
                    <li class="nav-item">
                        <form action="{{ action('CatalogController@search') }}" method="GET">
                            <div class="row" style="margin-left:10px; margin-right:15px; margin-top:5px;">
                            <div class="col-9">
                                <input class="form-control" type="text" name="q" required/>
                            </div>
                            <div class="col-3">
                                <button type="submit" class="btn btn-primary mt-3 mt-sm-0">BUSCAR</button>
                            </div>
                            </div>
                        </form>
                    </li>
                    <li class="nav-item"  style="margin-top:5px; margin-left:5px;">
                        <form action="{{ url('/logout') }}" method="POST" style="display:inline">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-link nav-link" style="display:inline;cursor:pointer">
                                Cerrar sesión
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        @endif
    </div>
</nav>
