@extends('layouts.app')

@section('content')
    <div class="backproducts">

        <div class="container productos">
            <h2 class="titulo">Nuestros Productos</h2>
            @if (!$toallas->isEmpty())

                <h3 id="toallas" class="categoria">Toallas</h3>
                <div class="row ">
                    @foreach ($toallas as $producte)
                        <div class="col-sm-12	col-md-6	col-lg-4	col-xl-3">
                            <div class="card mb-3">

                                @if (!$producte->imatges->isEmpty())
                                    <a class="example-image-link" href="{{ $producte->imatges[0]['url'] }}"
                                        data-lightbox="example" style="width: 100%"><img style="width: 100%"
                                            class="example-image" src="{{ $producte->imatges[0]['url'] }}" /></a>

                                    {{-- <img src="{{$producte->imatges[0]["url"]}}" class="card-img-top lightbox_trigger" alt="..."> --}}

                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $producte->nom }}</h5>
                                    <p class="card-text"><b>Medidas: </b><br>{{ $producte->mides }}</p>
                                    <p class="card-text"><b>Especificaciones: </b><br>{{ $producte->descripcio }}</p>
                                    @guest
                                    @else
                                        <p class="card-text"><b> {{ $producte->unitat }}</b></p>
                                        <p class="card-text"><b> Precio:</b> {{ $producte->preu }}€</p>
                                        <a href="/productos/{{ $producte->id }}" class="btn btn-success">Ver</a>
                        @endif
                    </div>
            </div>
        </div>
        @endforeach
        </div>
        @endif
        @if (!$sabanas->isEmpty())
            <h3 id="sabanas" class="categoria">Sabanas</h3>
            <div class="row ">
                @foreach ($sabanas as $producte)
                    <div class="col-sm-12	col-md-6	col-lg-4	col-xl-3">

                        <div class="card mb-3">

                            @if (!$producte->imatges->isEmpty())
                                <a class="example-image-link" href="{{ $producte->imatges[0]['url'] }}" data-lightbox="example"
                                    style="width: 100%"><img style="width: 100%" class="example-image"
                                        src="{{ $producte->imatges[0]['url'] }}" alt="Girl looking out people on beach" /></a>

                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $producte->nom }}</h5>
                                <p class="card-text"><b>Medidas: </b><br>{{ $producte->mides }}</p>
                                <p class="card-text"><b>Especificaciones: </b><br>{{ $producte->descripcio }}</p>
                                @guest
                                @else
                                    <p class="card-text"><b> {{ $producte->unitat }}</b></p>
                                    <p class="card-text"><b> Precio:</b> {{ $producte->preu }}€</p>
                                    <a href="/productos/{{ $producte->id }}" class="btn btn-success">Ver</a>
                                 @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @endif
            @if (!$fundas->isEmpty())
                <h3 id="fundas" class="categoria">Fundas de nordicos</h3>
                <div class="row ">
                    @foreach ($fundas as $producte)
                        <div class="col-sm-12	col-md-6	col-lg-4	col-xl-3">
                            <div class="card mb-3">

                                @if (!$producte->imatges->isEmpty())
                                    <a class="example-image-link" href="{{ $producte->imatges[0]['url'] }}" data-lightbox="example"
                                        style="width: 100%"><img style="width: 100%" class="example-image"
                                            src="{{ $producte->imatges[0]['url'] }}" alt="Girl looking out people on beach" /></a>

                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $producte->nom }}</h5>
                                    <p class="card-text"><b>Medidas: </b><br>{{ $producte->mides }}</p>
                                    <p class="card-text"><b>Especificaciones: </b><br>{{ $producte->descripcio }}</p>
                                    @guest
                                    @else
                                        <p class="card-text"><b> {{ $producte->unitat }}</b></p>
                                        <p class="card-text"><b> Precio:</b> {{ $producte->preu }}€</p>
                                        <a href="/productos/{{ $producte->id }}" class="btn btn-success">Ver</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @endif

                @if (!$textil->isEmpty())
                    <h3 id="textil" class="categoria">Textil para limpieza</h3>
                    <div class="row ">
                        @foreach ($textil as $producte)
                            <div class="col-sm-12	col-md-6	col-lg-4	col-xl-3">
                                <div class="card mb-3">

                                    @if (!$producte->imatges->isEmpty())
                                        <a class="example-image-link" href="{{ $producte->imatges[0]['url'] }}" data-lightbox="example"
                                            style="width: 100%"><img style="width: 100%" class="example-image"
                                                src="{{ $producte->imatges[0]['url'] }}" alt="Girl looking out people on beach" /></a>

                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $producte->nom }}</h5>
                                        <p class="card-text"><b>Medidas: </b><br>{{ $producte->mides }}</p>
                                        <p class="card-text"><b>Especificaciones: </b><br>{{ $producte->descripcio }}</p>
                                        @guest
                                        @else
                                            <p class="card-text"><b> {{ $producte->unitat }}</b></p>
                                            <p class="card-text"><b> Precio:</b> {{ $producte->preu }}€</p>
                                            <a href="/productos/{{ $producte->id }}" class="btn btn-success">Ver</a>
                                    @endif
                                </div>
                            </div>
                            </div>
                        @endforeach
                    </div>
                @endif
        </div>

    </div>

@endsection
