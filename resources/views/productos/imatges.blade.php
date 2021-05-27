@extends('layouts.app')

@section('content')
    <div class="fonsproducto">

        <div class="container productos">


            <h2 class="titulo">Editar imagenes</h2>
            <br>
            <br>
            <a href="{{ url('gestionproductos/') }}" type="button" class="btn btn-success">Volver</a>
            <br>
            <br>
            <form method="POST" enctype="multipart/form-data" action="imagenes/create">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="categoria">Producte</label>
                    <select class="form-control" name="producteid" id="producteid">
                        @foreach ($productes as $producte)
                            <option value="{{ $producte->id }}">{{ $producte->nom }}</option>
                        @endforeach
                    </select>
                    <div class="form-group">
                        <label for="title">Imatge</label>
                        <input value="" type="file" name="imatge" id="imatge" class="form-control botoedit">
                    </div>
                    <button type="submit" class="btn btn-primary">Añadir</button>

            </form>
            <br><br>
            <table id="example" class="display">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>iamgen</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    @foreach ($imatges as $imatge)
                        <tr id="linia">
                            <td id="id">{{ $imatge->producte->id }}</td>
                            <td id="nom">{{ $imatge->producte->nom }}</td>
                            <td id="img"><img src="/{{ $imatge->url }}" width="10%"></td>
                            <td>
                                <form action="imagenes/delete/{{ $imatge->id }}" method="POST">
                                    {{ csrf_field() }}
                                    {!! method_field('delete') !!}
                                    <button type="submit" value="{{ $imatge->producte->id }}" class="btn btn-danger "><i
                                            class="fa fa-trash-o" aria-hidden="true"></i></button>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>iamgen</th>
                        <th>Opciones</th>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>
@endsection
