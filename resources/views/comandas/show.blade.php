@extends('layouts.app')

@section('content')
    <div class="fonsproducto">

        <div class="container productos">
            <h2 class="titulo">Comanda {{ $comanda_id }}</h2>

            <br>
            <br>
            <a href="{{ url('comandas/') }}" type="button" class="btn btn-success">Volver</a>

            <div class="table-responsive">

                <table class="table table-striped mt-3">
                    <thead>
                        <tr class="text-center">
                            <th>Producto</th>
                            <th>Descripcion</th>
                            <th>Medidas</th>
                            <th>Tipo de venta</th>
                            <th>Quantitat</th>
                            <th>Preu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products_line as $key => $product_line)

                            <tr class="text-center {{ $product_line['producte_id'] }}">
                                <td class="align-middle{{ $class[$key] }} ">
                                    {{ $product_line['producte_nom'] }}
                                </td>

                                <td class="align-middle{{ $class[$key] }}">
                                    {{ $product_line['producte_descripcio'] }}
                                </td>
                                <td class="align-middle{{ $class[$key] }}">
                                    {{ $product_line['producte_mides'] }}
                                </td>
                                <td class="align-middle{{ $class[$key] }}">
                                    {{ $product_line['producte_unidad'] }}
                                </td>
                                <td class="align-middle{{ $class[$key] }}">
                                    {{ $product_line['producte_quantitat'] }}
                                </td>
                                <td class="align-middle text-center">
                                    {{ $product_line['producte_preu'] }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="text-center">
                            <th>{{ __('Totales:') }}</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>{{ $totals[0] }}</th>
                            <th>{{ $totals[1] }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
