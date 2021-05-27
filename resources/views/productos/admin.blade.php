@extends('layouts.app')

@section('content')
    <div class="fonsproducto">
        <div class="container fonsproductos">
            <h2 class="titulo">Gestion de Productos</h2>
            <a href="{{ url('gestionproductos/eliminados') }}" type="button" class="btn btn-danger">Ver eliminados</a>
            <a href="{{ url('productos/create') }}" type="button" class="btn btn-success">Agregar Producto</a>
            <a href="{{ url('gestionproductos/imagenes') }}" type="button" class="btn btn-info">Editar imagenes</a>

            <br>
            <br>

            <div class="table-responsive">
                <table id="example" class="display">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Mides</th>
                            <th>Descripcion</th>
                            <th>Precio</th>
                            <th>Opciones de venta</th>
                            <th>Stock total</th>
                            <th>Stock vendido</th>
                            <th>Stock restante</th>
                            <th>Categoria</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        @foreach ($productes as $producte)
                            <tr id="linia">
                                <td id="id">{{ $producte->producte->id }}</td>
                                <td id="nom">{{ $producte->producte->nom }}</td>
                                <td id="mides">{{ $producte->producte->mides }}</td>
                                <td id="descrpcio">{{ $producte->producte->descripcio }}</td>
                                <td id="preu">{{ $producte->producte->preu }} €</td>
                                <td id="unitat">{{ $producte->producte->unitat }} </td>
                                <td id="quantitattotal">{{ $producte->quantitat_total }} </td>
                                <td id="quantitatvenuda">{{ $producte->quantitat_venuda }} </td>

                                <td>{{ $producte->quantitat_total - $producte->quantitat_venuda }} </td>
                                <td id="categoria">{{ $producte->producte->categoria }} </td>

                                <td> <a href="{{ url('productos/' . $producte->producte->id) }}" type="button"
                                        class="btn btn-primary" style="width: 45px ;margin-bottom:2px"><i
                                            class="far fa-eye"></i></a>
                                    <button type="button" class="btn btn-warning edit-item"
                                        data-item-id="{{ $producte->producte->id }}"
                                        style="width: 45px;margin-bottom:2px"><i class="far fa-edit"></i></button>
                                    <button type="button" value="{{ $producte->producte->id }}"
                                        class="btn btn-danger eliminar-producte" style="width: 45px;margin-bottom:2px"><i
                                            class="fa fa-trash-o" aria-hidden="true"></i></button>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Mides</th>
                            <th>Descripcion</th>
                            <th>Precio</th>
                            <th>Opciones de venta</th>
                            <th>Stock total</th>
                            <th>Stock vendido</th>
                            <th>Stock restante</th>
                            <th>Categoria</th>
                            <th>Opciones</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="edit-modal-label">Editar Producto</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="attachment-body-content">
                            <form class="edit-form" method="POST">
                                {{ method_field('PUT') }}
                                {{ csrf_field() }}
                                <input type="hidden" name="id" id="modal-input-id">
                                <div class="form-group">
                                    <label class="col-form-label" for="modal-input-name">Nom</label>
                                    <input type="text" name="nom" class="form-control" id="modal-input-name" required
                                        autofocus>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label" for="modal-input-mides">Medidas</label>
                                    <input type="text" name="mides" class="form-control" id="modal-input-mides" required>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label" for="modal-input-description">Descripcion</label>
                                    <input type="text" name="descripcio" class="form-control" id="modal-input-description"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label" for="modal-input-preu">Precio</label>
                                    <input type="number" id="modal-input-preu" class="form-control" name="preu" min="0"
                                        step=".01">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label" for="modal-input-unitat">Opciones de venta</label>
                                    <input type="text" name="unitat" class="form-control" id="modal-input-unitat" required>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label" for="modal-input-quantitattotal">Cantidad total</label>
                                    <input type="number" name="quantitattotal" class="form-control"
                                        id="modal-input-quantitattotal" min="0" required>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label" for="modal-input-quantitatvenuda">Cantidad vendida</label>
                                    <input type="number" name="quantitatvenuda" class="form-control"
                                        id="modal-input-quantitatvenuda" min="0" required>
                                </div>
                                <div class="form-group">
                                    <label for="modal-input-categoria">Categoria</label>
                                    <select class="form-control" name="categoria" id="modal-input-categoria">
                                        <option value="">Seleccione la categoria</option>
                                        <option value="Toallas">Toallas</option>
                                        <option value="Sábanas">Sábanas</option>
                                        <option value="Fundas de nordico">Fundas de nordico</option>
                                        <option value="Textil para la limpieza">Textil para la limpieza</option>
                                    </select>
                                </div>


                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
