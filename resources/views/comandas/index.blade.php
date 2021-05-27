@extends('layouts.app')

@section('content')
    <div class="fonsproducto">

        <div class="container productos">
            @if (Auth::user()->esAdmin)
                <h2 class="titulo">Gestion de Comandas</h2>

            @else
                <h2 class="titulo">Comandas pendientes</h2>

            @endif
            <a href="{{ url('comandas/entregadas') }}" type="button" class="btn btn-success">Ver entregados</a>

            <br>
            <br>

            <table id="example" class="display">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        {{-- <th>Precio</th> --}}
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    @foreach ($comandas as $comanda)
                        <tr id="linia">
                            <td id="id">{{ $comanda->id }}</td>
                            <td id="nom">{{ $comanda->user->name }}</td>
                            {{-- <td id="preu">{{$comanda->preu}} €</td> --}}
                            <td> <a href="{{ url('comandas/' . $comanda->id) }}" type="button" class="btn btn-primary"><i
                                        class="far fa-eye"></i></a>
                                @if (Auth::user()->esAdmin == 1)



                                    @if ($comanda->estat == 0)
                                        <button type="button" class="btn btn-warning preparada"
                                            value="{{ $comanda->id }}">Preparada</button>
                                    @else
                                        <button type="button" value="{{ $comanda->id }}"
                                            class="btn btn-danger entregada">Entregada</button>

                                    @endif
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        {{-- <th>Precio</th> --}}
                        <th>Opciones</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

@endsection
