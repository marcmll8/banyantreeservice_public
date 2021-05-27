@extends('layouts.app')

@section('content')
    <div class="fonsproducto">

        <div class="container productos">


            <h2 class="titulo">Agregar un producto</h2>
            <br>
            <br>
            <a href="{{ url('gestionproductos/') }}" type="button" class="btn btn-success">Volver</a>
            <br>
            <br>
            <form id="createproductform" method="POST">
                <div class="form-group">
                    <label for="Nombre">Nombre</label>
                    <input name="nom" type="text" class="form-control" id="Nombre" placeholder="Ropa">
                </div>
                <div class="form-group">
                    <label for="Mides">Mides</label>
                    <input name="mides" type="text" class="form-control" id="Mides" placeholder="10x10">
                </div>
                <div class="form-group">
                    <label for="Descripcion">Descripcion</label>
                    <textarea name="descripcio" class="form-control" id="Descripcion" rows="3" style=" resize: none;"
                        placeholder="color blanco"></textarea>
                </div>
                <div class="form-group">
                    <label for="Precio">Precio</label>
                    <input type="number" id="Precio" class="form-control" required name="price" min="0" value="0"
                        step=".01">
                </div>
                <div class="form-group">
                    <label for="Unidades">Tipo de venta de unidades</label>
                    <input name="unitats" type="text" class="form-control" id="Unidades" placeholder="Unidades">
                </div>

                <div class="form-group">
                    <label for="categoria">Categoria</label>
                    <select class="form-control" name="categoria" id="categoria">
                        <option value="">Seleccione la categoria</option>
                        <option value="Toallas">Toallas</option>
                        <option value="Sábanas">Sábanas</option>
                        <option value="Fundas de nordico">Fundas de nordico</option>
                        <option value="Textil para la limpieza">Textil para la limpieza</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="Unidades">Stock inicial</label>
                    <input type="number" id="quantitattotal" class="form-control" required name="quantitattotal" min="0"
                        value="0">
                </div>

                <button type="submit" class="btn btn-primary">Añadir</button>

            </form>
        </div>
    </div>
@endsection
