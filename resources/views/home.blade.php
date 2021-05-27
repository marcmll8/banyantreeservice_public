@extends('layouts.app')

@section('content')
    <style>
        html {
            scroll-behavior: smooth;
        }

    </style>
    <div class="portada">
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div>

                        <img class="d-block w-100" src="/img/slide1.jpg" alt="First slide">
                        <div class="carousel-caption">
                            <h1>Bienvendido a Banyantree Service</h1>
                            <a href="#inicio"><button type="button" class="btn btn-success inicio"><i
                                        class="fas fa-angle-double-down"></i></button></a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="/img/slide2.jpg" alt="Second slide">
                    <div class="carousel-caption">
                        <h1>Descubre nuestros articulos</h1>
                        <a href="#inicio"><button type="button" class="btn btn-success inicio"><i
                                    class="fas fa-angle-double-down"></i></button></a>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="/img/slide3.jpg" alt="Third slide">
                    <div class="carousel-caption">
                        <h1>Productos de calidad</h1>
                        <a href="#inicio"><button type="button" class="btn btn-success inicio"><i
                                    class="fas fa-angle-double-down"></i></button></a>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <div class="container">
            <h1 class="h1" id="inicio">¿Quienes somos?</h1>
            <p class="p">Somos una empresa familiar, que desde el año 2002, nos dedicamos a la distribución de
                textiles de hotel para profesionales de la hostelería, casas rurales, alquileres, residencias...
                Nuestros productos són de calidad professional, y provienen de excedentes de stock de
                hoteles. El material es de algodon de calidad, a veces 100 % y otras mezclado 60-40 %.
                En el apartado de tejidos para limpieza, contamos con varias texturas que se adaptan a las
                necesidades de qualquier empresa.</p>
        </div>
        <div id="service" class="service">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="titlepage" id="productos">
                            <h2 class="h2">Nuestros Productos</h2>
                            <p class="p">Para saber toda la informacion de nuestros productos tiene que solicitar accesso.
                                Para solicitar acceso tiene que rellenar el formulario que hay en la parte inferior.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div id="multi-item-example" class="carousel slide carousel-multi-item" data-ride="carousel">

                <!--Controls-->
                <div class="controls-top">
                    <a class="btn-floating" href="#multi-item-example" data-slide="prev"><i
                            class="fas fa-chevron-left"></i></a>
                    <a class="btn-floating" href="#multi-item-example" data-slide="next"><i
                            class="fas fa-chevron-right"></i></a>
                </div>
                <!--/.Controls-->

                <!--Indicators-->
                <ol class="carousel-indicators">
                    <li data-target="#multi-item-example" data-slide-to="0" class="active"></li>
                    <li data-target="#multi-item-example" data-slide-to="1"></li>

                </ol>
                <!--/.Indicators-->

                <!--Slides-->
                <div class="carousel-inner" role="listbox">

                    <!--First slide-->

                    <div class="carousel-item active">
                        @if ($productes->count() >= 0)

                            <div class="col-md-4" style="float:left">
                                <div class="card mb-2">
                                    @if (!$productes[0]->imatges->isEmpty())
                                        <img src="{{ $productes[0]->imatges[0]['url'] }}" class="card-img-top" alt="...">

                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $productes[0]->nom }}</h5>
                                        <p class="card-text"><b>Midas: </b><br>{{ $productes[0]->mides }}</p>
                                        <p class="card-text"><b>Especificaciones: </b><br>{{ $productes[0]->descripcio }}
                                        </p>
                                        @guest
                                        @else
                                            <p class="card-text"><b> {{ $productes[0]->unitat }}</b></p>
                                            <p class="card-text"><b> Precio:</b> {{ $productes[0]->preu }}€</p>
                                            <a href="/productos/{{ $productes[0]->id }}" class="btn btn-primary">Ver</a>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
                @if ($productes->count() >= 2)

                    <div class="col-md-4" style="float:left">
                        <div class="card mb-2">

                            @if (!$productes[1]->imatges->isEmpty())
                                <img src="{{ $productes[1]->imatges[0]['url'] }}" class="card-img-top" alt="...">

                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $productes[1]->nom }}</h5>
                                <p class="card-text"><b>Midas: </b><br>{{ $productes[1]->mides }}</p>
                                <p class="card-text"><b>Especificaciones: </b><br>{{ $productes[1]->descripcio }}</p>
                                @guest
                                @else
                                    <p class="card-text"><b> {{ $productes[1]->unitat }}</b></p>
                                    <p class="card-text"><b> Precio:</b> {{ $productes[1]->preu }}€</p>
                                    <a href="/productos/{{ $productes[1]->id }}" class="btn btn-primary">Ver</a>
                    @endif
                </div>
            </div>
            </div>
            @endif
            @if ($productes->count() >= 3)

                <div class="col-md-4" style="float:left">
                    <div class="card mb-2">

                        @if (!$productes[2]->imatges->isEmpty())
                            <img src="{{ $productes[2]->imatges[0]['url'] }}" class="card-img-top" alt="...">

                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $productes[2]->nom }}</h5>
                            <p class="card-text"><b>Midas: </b><br>{{ $productes[2]->mides }}</p>
                            <p class="card-text"><b>Especificaciones: </b><br>{{ $productes[2]->descripcio }}</p>
                            @guest
                            @else
                                <p class="card-text"><b> {{ $productes[2]->unitat }}</b></p>
                                <p class="card-text"><b> Precio:</b> {{ $productes[2]->preu }}€</p>
                                <a href="/productos/{{ $productes[2]->id }}" class="btn btn-primary">Ver</a>
                @endif
                </div>
                </div>
                </div>
                @endif


                </div>
                <!--/.First slide-->
                @if ($productes->count() > 3)
                    <!--Second slide-->
                    <div class="carousel-item">
                        @if ($productes->count() >= 4)
                            <div class="col-md-4" style="float:left">
                                <div class="card mb-2">

                                    @if (!$productes[3]->imatges->isEmpty())
                                        <img src="{{ $productes[3]->imatges[0]['url'] }}" class="card-img-top" alt="...">

                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $productes[3]->nom }}</h5>
                                        <p class="card-text"><b>Midas: </b><br>{{ $productes[3]->mides }}</p>
                                        <p class="card-text"><b>Especificaciones: </b><br>{{ $productes[3]->descripcio }}</p>
                                        @guest
                                        @else
                                            <p class="card-text"><b> {{ $productes[3]->unitat }}</b></p>
                                            <p class="card-text"><b> Precio:</b> {{ $productes[3]->preu }}€</p>
                                            <a href="/productos/{{ $productes[3]->id }}" class="btn btn-primary">Ver</a>
                            @endif
                        </div>
                        </div>
                        </div>
                    @endif
                    @if ($productes->count() >= 5)

                        <div class="col-md-4" style="float:left">
                            <div class="card mb-2">
                                @if (!$productes[4]->imatges->isEmpty())
                                    <img src="{{ $productes[4]->imatges[0]['url'] }}" class="card-img-top" alt="...">

                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $productes[4]->nom }}</h5>
                                    <p class="card-text"><b>Midas: </b><br>{{ $productes[4]->mides }}</p>
                                    <p class="card-text"><b>Especificaciones: </b><br>{{ $productes[4]->descripcio }}</p>
                                    @guest
                                    @else
                                        <p class="card-text"><b> {{ $productes[4]->unitat }}</b></p>
                                        <p class="card-text"><b> Precio:</b> {{ $productes[4]->preu }}€</p>
                                        <a href="/productos/{{ $productes[4]->id }}" class="btn btn-primary">Ver</a>
                        @endif
                        </div>
                        </div>
                        </div>
                        @endif
                        @if ($productes->count() >= 6)

                            <div class="col-md-4" style="float:left">
                                <div class="card mb-2">

                                    @if (!$productes[5]->imatges->isEmpty())
                                        <img src="{{ $productes[5]->imatges[0]['url'] }}" class="card-img-top" alt="...">

                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $productes[5]->nom }}</h5>
                                        <p class="card-text"><b>Midas: </b><br>{{ $productes[5]->mides }}</p>
                                        <p class="card-text"><b>Especificaciones: </b><br>{{ $productes[5]->descripcio }}</p>
                                        @guest
                                        @else
                                            <p class="card-text"><b> {{ $productes[5]->unitat }}</b></p>
                                            <p class="card-text"><b> Precio:</b> {{ $productes[5]->preu }}€</p>
                                            <a href="/productos/{{ $productes[5]->id }}" class="btn btn-primary">Ver</a>
                            @endif
                            </div>
                            </div>
                            </div>
                            @endif
                            </div>
                            @endif
                            <!--/.Second slide-->



                            </div>
                            <!--/.Slides-->

                            </div>
                            <a href="/productos" class="productosira"><button class="productosir">Ver mas</button></a>

                            <!--/.Carousel Wrapper-->
                            </div>
                            <div id="testimonial" class="testimonial">
                                <div class="container">
                                    <div class="row">
                                        {{-- <div class="col-md-12">
                    <div class="titlepage">
                      <h3>Contacta con nosotros</h3>
                      <br>
                    </div>
                </div> --}}
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                            <iframe
                                                src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d4930.383223752325!2d3.069326466395607!3d42.26000980845907!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sca!2ses!4v1621173723693!5m2!1sca!2ses"
                                                width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                            <div class="contact">
                                                <h3>Solicita acceso</h3>
                                                <form id="solicitar">
                                                    {{ csrf_field() }}
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <input class="contactus" placeholder="Name" id="Nombre" type="text" name="Nombre"
                                                                required>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input class="contactus" placeholder="Email" id="Email" type="text" name="Email"
                                                                required>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input class="contactus" placeholder="Telefono" id="Telefono" type="text"
                                                                name="Telefono" required>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <textarea class="textarea" placeholder="Mensaje" id="Mensaje" type="text"
                                                                name="Mensaje"></textarea>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <button class="send">Enviar</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>

                        @endsection
