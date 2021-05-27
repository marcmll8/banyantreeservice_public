@extends('layouts.app')

@section('content')
    <div class="backproduct">
        <div class="container producto">
            <div class="row">
                <div class="col-sm-12	col-md-3	col-lg-3	col-xl-3">
                    @if (!$producte->imatges->isEmpty())
                        <a class="example-image-link" href="/{{ $producte->imatges[0]['url'] }}" data-lightbox="example-1"
                            style="width: 100%"><img style="width: 100%" class="example-image"
                                src="/{{ $producte->imatges[0]['url'] }}" alt="Girl looking out people on beach" /></a>

                        {{-- <img src="/{{$producte->imatges[0]["url"]}}" class="card-img-top" alt="..."> --}}

                    @endif
                </div>
                <div class="col-sm-12	col-md-9	col-lg-9	col-xl-9">
                    <h1>{{ $producte->nom }}</h1>
                    <div class="row">

                        <div class="col-sm-12	col-md-6	col-lg-6	col-xl-6">
                            <h3>Especificaciones:</h3>
                        </div>
                        <div class="col-sm-12	col-md-6	col-lg-6	col-xl-6 mt-1">
                            <p>{{ $producte->descripcio }}</p>
                        </div>
                        <h4 class="col-12">Precio: {{ $producte->preu }}€</h4>
                        <h4 class="col-12">Medidas: {{ $producte->mides }}</h4>

                        <form id="añadirproductocesta" {{-- action="/cesta" --}} method="POST">
                            {{-- {{ csrf_field() }} --}}
                            <input type="hidden" name="id" id="id" value="{{ $producte->id }}">
                            <div class="form-group">
                                <label for="cantidad">Cantidad</label>
                                <input type="number" id="cantidad" class="form-control" required name="cantidad" min="0"
                                    value="0">
                            </div>
                            <button type="submit" class="btn btn-primary">Añadir</button>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
