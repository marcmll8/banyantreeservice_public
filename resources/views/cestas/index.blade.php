@extends('layouts.app')

@section('content')
    <div class="fonscesta">
        <div class="container fonscestas">
            <h2 class="titulo">Cesta</h2>

            <br>
            <br>
            <div class="table-responsive">

                <table class="table table-striped mt-3">
                    <thead>
                        <tr class="text-center">
                            <th>Producte</th>
                            <th>Quantitat</th>
                            <th>Preu</th>
                            <th>Accions</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        @foreach ($products_line as $key => $product_line)

                            <tr class="text-center {{ $product_line['producte_id'] }}">

                                <td class="align-middle{{ $class[$key] }} ">
                                    {{ $product_line['producte_nom'] }}
                                </td>
                                <td class="align-middle{{ $class[$key] }}">
                                    {{ $product_line['producte_quantitat'] }}
                                </td>

                                @if (!in_array($product_line['producte_id'], $alerts))
                                    <td class="align-middle text-center">
                                        {{ $product_line['producte_preu'] }}
                                    </td>
                                @else
                                    <td class="align-middle">
                                        <div class="alert alert-danger mb-0" role="alert">
                                            Sin disponibilidad
                                        </div>
                                    </td>
                                @endif
                                <td class="align-middle{{ $class[$key] }}">

                                    {{-- PONER EL ACTION NECESARIO PARA QUE FUNCIONE EL FORMULARIO --}}

                                    <button type="button" value="{{ $product_line['producte_id'] }}"
                                        class="btn btn-danger eliminar-cistella"><i class="fa fa-trash-o"
                                            aria-hidden="true"></i></button>

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="text-center">
                            <th>{{ __('Totals:') }}</th>
                            <th>{{ $totals[0] }}</th>
                            <th>{{ $totals[1] }}</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <button type="button" class="btn btn-primary confirmar">Confirmar</button>
        </div>
    </div>
@endsection
