$(document).ready(function () {
  //aqui fem la funcio del lightbox
  lightbox.option({
    'resizeDuration': 200,
    'wrapAround': true
  })

  //aqui inicialitzem el TOAST (notificacions)
  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })


  /*****************************************************
   *                                                   *
   *                 GESTIO DE PRODUCTES               *
   *                                                   *
   *****************************************************/



  $('#example').DataTable({ responsive: true });

  /**
   * for showing edit item popup
   */

  //aqui fem una funcio per obrir un modal per editar els productes
  $(document).on('click', ".edit-item", function () {
    $(this).addClass('edit-item-trigger-clicked');

    var options = {
      'backdrop': 'static'
    };
    $('#edit-modal').modal(options)
  })

  // on modal show
  $('#edit-modal').on('show.bs.modal', function () {
    var el = $(".edit-item-trigger-clicked");
    var row = el.closest("#linia");
    // agafar informacio
    var id = el.data('item-id');
    var name = row.children("#nom").text();
    var mides = row.children("#mides").text();
    var description = row.children("#descrpcio").text();
    var preu = row.children("#preu").text();
    preu = parseFloat(preu);
    var unitat = row.children("#unitat").text();
    var quantitattotal = row.children("#quantitattotal").text();
    quantitattotal = parseInt(quantitattotal);
    var quantitatvenuda = row.children("#quantitatvenuda").text();
    quantitatvenuda = parseInt(quantitatvenuda);
    var categoria = row.children("#categoria").text();

    // posa la informacio als inputs
    $("#modal-input-id").val(id);
    $("#modal-input-name").val(name);
    $("#modal-input-description").val(description);
    $("#modal-input-mides").val(mides);
    $("#modal-input-preu").val(preu);
    $("#modal-input-unitat").val(unitat);
    $("#modal-input-quantitattotal").val(quantitattotal);
    $("#modal-input-quantitatvenuda").val(quantitatvenuda);
    $("#modal-input-categoria").val(categoria);

  })


  //aqui creem una peticio ajax que el que fa es enviar la informacio per editar un producte i despres actualitza la taula
  $("body").on("submit", 'form.edit-form', function (e) {
    e.preventDefault();
    $.ajaxSetup({
      headers: { 'X-CSRF-Token': $('meta[name=_token]').attr('content') }
    }),
      $.ajax({
        url: "/productos/" + $("#modal-input-id").val(),
        type: 'PUT',
        dataType: "json",
        data: $(e.target).serialize(),

        success: function (callback) {
          console.log(callback.productes);
          $('#example').DataTable().clear();
          $('#example').DataTable().destroy();
          $("#tbody").empty();
          $.each(callback["productes"], function (index, value) {
            console.log(index + ": " + value["id"])
            $('#tbody').append(' <tr id="linia"><td>' + value["producte"]["id"] + '</td><td id="nom">' + value["producte"]["nom"] + '</td><td id="mides">' + value["producte"]["mides"] + '</td><td id="descrpcio">' + value["producte"]["descripcio"] + '</td><td id="preu">' + value["producte"]["preu"] + ' €</td><td id="unitat">' + value["producte"]["unitat"] + ' </td><td id="quantitattotal">' + value["quantitat_total"] + ' </td><td id="quantitatvenuda">' + value["quantitat_venuda"] + ' </td> <td >' + (value["quantitat_total"] - value["quantitat_venuda"]) + ' </td>  <td id="categoria">' + value["producte"]["categoria"] + '</td>   <td > <a href="productos/' + value["producte"]["id"] + '" type="button" style="width: 45px;margin-bottom:2px" class="btn btn-primary"><i class="far fa-eye"></i></a> <button type="button" style="width: 45px;margin-bottom:2px" class="btn btn-warning edit-item"  data-item-id="' + value["producte"]["id"] + '"><i class="far fa-edit"></i></button> <button type="button" style="width: 45px;margin-bottom:2px" value="' + value["producte"]["id"] + '" class="btn btn-danger eliminar-producte"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>')
          });
          $('#example').DataTable({ responsive: true });

          $(".modal").modal('toggle');
          Toast.fire({
            icon: 'success',
            title: "Se ha editado correctamente"
          })
        },
        error: function (status) {
          console.log(status)
          Toast.fire({
            icon: 'error',
            title: "No se ha editado correctamente"
          })
        }
      })
  })


  //aqui creem una peticio ajax que el que fa es enviar la informacio per crear un producte
  $('#createproductform').on("submit", function (e) {
    e.preventDefault();
    $.ajaxSetup({
      headers: {
        'X-CSRF-TPKEN': $('meta[name="csrf-token"]').attr('content')
      }
    }),
      $.ajax({
        url: "/productos",
        type: 'POST',
        dataType: "json",
        data: {
          method: "POST", submit: true, _token: $('meta[name="csrf-token"]').attr('content'), nom: $("#Nombre").val(),
          mides: $("#Mides").val(), descripcio: $("#Descripcion").val(), preu: $("#Precio").val(),
          unitat: $("#Unidades").val(), quantitattotal: $("#quantitattotal").val(), categoria: $("select#categoria option").filter(":selected").val()
        },
        success: function (callback) {
          console.log(callback);
          $('#createproductform').trigger('reset');
          $('#example').DataTable({ responsive: true }).draw(true);
          Toast.fire({
            icon: 'success',
            title: "El producto se ha creado correctamente"
          })
        },
        error: function (status) {
          console.log(status)
          Toast.fire({
            icon: 'error',
            title: "No se ha creado correctamente"
          })
        }
      })
  })


  //aqui creem una peticio ajax que el que fa es enviar la id d'un producte per eliminar-lo i despres actualitza la taula
  $("body").on("click", "button.eliminar-producte", function (e) {
    e.preventDefault();
    $.ajaxSetup({
      headers: {
        'X-CSRF-TPKEN': $('meta[name="csrf-token"]').attr('content')
      }
    }),
      $.ajax({
        url: "/productos/" + $(this).val(),
        type: 'DELETE',
        dataType: "json",
        data: {
          method: "DELETE", submit: true, _token: $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (callback) {
          console.log(callback)
          $('#example').DataTable().clear();
          $('#example').DataTable().destroy();
          $("#tbody").empty();
          $.each(callback["productes"], function (index, value) {
            console.log(index + ": " + value["id"])
            $('#tbody').append(' <tr id="linia"><td>' + value["producte"]["id"] + '</td><td id="nom">' + value["producte"]["nom"] + '</td><td id="mides">' + value["producte"]["mides"] + '</td><td id="descrpcio">' + value["producte"]["descripcio"] + '</td><td id="preu">' + value["producte"]["preu"] + ' €</td><td id="unitat">' + value["producte"]["unitat"] + ' </td><td id="quantitattotal">' + value["quantitat_total"] + ' </td><td id="quantitatvenuda">' + value["quantitat_venuda"] + ' </td> <td >' + (value["quantitat_total"] - value["quantitat_venuda"]) + ' </td>  <td id="categoria">' + value["producte"]["categoria"] + '</td>   <td > <a href="productos/' + value["producte"]["id"] + '" type="button" style="width: 45px;margin-bottom:2px" class="btn btn-primary"><i class="far fa-eye"></i></a> <button type="button" style="width: 45px;margin-bottom:2px" class="btn btn-warning edit-item"  data-item-id="' + value["producte"]["id"] + '"><i class="far fa-edit"></i></button> <button type="button" style="width: 45px;margin-bottom:2px" value="' + value["producte"]["id"] + '" class="btn btn-danger eliminar-producte"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>')
          });

          $('#example').DataTable({ responsive: true });
          Toast.fire({
            icon: 'success',
            title: "Se ha eliminado correctamente"
          })
        },
        error: function (status) {
          console.log(status)
          Toast.fire({
            icon: 'error',
            title: "No se ha eliminado"
          })
        }

      })


  })
  
  //aqui creem una peticio ajax que el que fa es enviar la id tornar a activar un producte i despres actualitza la taula
  $("body").on("click", "button.volveractivar", function (e) {
    e.preventDefault();
    $.ajaxSetup({
      headers: {
        'X-CSRF-TPKEN': $('meta[name="csrf-token"]').attr('content')
      }
    }),
      $.ajax({

        url: "/gestionproductos/eliminados/" + $(this).val(),
        type: 'PUT',
        dataType: "json",
        data: {
          method: "PUT", submit: true, _token: $('meta[name="csrf-token"]').attr('content'), id: $(this).val()
        },
        success: function (callback) {
          console.log(callback)
          $('#example').DataTable().clear();
          $('#example').DataTable().destroy();
          $("#tbody").empty();
          $.each(callback["productes"], function (index, value) {
            console.log(index + ": " + value["id"])
            $('#tbody').append(' <tr id="linia"><td>' + value["producte"]["id"] + '</td><td id="nom">' + value["producte"]["nom"] + '</td><td id="mides">' + value["producte"]["mides"] + '</td><td id="descrpcio">' + value["producte"]["descripcio"] + '</td><td id="preu">' + value["producte"]["preu"] + ' €</td><td id="unitat">' + value["producte"]["unitat"] + ' </td><td id="unitat">' + value["quantitat_total"] + ' </td><td id="unitat">' + value["quantitat_venuda"] + ' </td> <td id="unitat">' + (value["quantitat_total"] - value["quantitat_venuda"]) + ' </td>     <td > <a href="productos/' + value["producte"]["id"] + '" type="button" style="width: 45px;margin-bottom:2px" class="btn btn-primary"><i class="far fa-eye"></i></a> <button type="button" style="width: 45px;margin-bottom:2px" class="btn btn-warning edit-item"  data-item-id="' + value["producte"]["id"] + '"><i class="far fa-edit"></i></button><button type="button" value="' + value["producte"]["id"] + '" class="btn btn-success volveractivar">Volver a activar</button></td></tr>')
          });
          $('#example').DataTable({ responsive: true });

          Toast.fire({
            icon: 'success',
            title: "La comanda esta preparada"
          })
        },
        error: function (status) {
          console.log(status)
          Toast.fire({
            icon: 'error',
            title: "Ha habido algun error"
          })
        }

      })
  })
  // aqui amagem el modal
  $('#edit-modal').on('hide.bs.modal', function () {
    $('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')

    $("#edit-form").trigger("reset");
  })






  /*****************************************************
  *                                                    *
  *                 GESTIO DE CESTA                    *
  *                                                    *
  *****************************************************/

  //aqui fem una peticio ajax per afegir un producte a la cistella
  $('#añadirproductocesta').on("submit", function (e) {
    e.preventDefault();
    $.ajaxSetup({
      headers: {
        'X-CSRF-TPKEN': $('meta[name="csrf-token"]').attr('content')
      }
    }),
      $.ajax({
        url: "/cesta",
        type: 'POST',
        dataType: "json",
        data: {
          method: "POST", submit: true, _token: $('meta[name="csrf-token"]').attr('content'), id: $("#id").val(),
          quantitat: $("#cantidad").val()
        },
        success: function (callback) {
          if (callback.quantitat > 0) {
            $('#añadirproductocesta').trigger('reset');
            Toast.fire({
              icon: 'success',
              title: "El producto se ha añadido correctamente"
            })
          }
          else {
            Toast.fire({
              icon: 'error',
              title: "No se ha añadido correctamente, la cantidad tiene que ser superior a 0"
            })
          }

        },
        error: function (status) {
          console.log(status)
          Toast.fire({
            icon: 'error',
            title: "No se ha añadido correctamente"
          })
        }
      })
  })

  //aqui creem una peticio ajax que és eliminar un producte de la cistella
  $("body").on("click", "button.eliminar-cistella", function (e) {
    e.preventDefault();
    $.ajaxSetup({
      headers: {
        'X-CSRF-TPKEN': $('meta[name="csrf-token"]').attr('content')
      }
    }),
      $.ajax({

        url: "cesta/" + $(this).val(),
        type: 'DELETE',
        dataType: "json",
        data: {
          method: "DELETE", submit: true, _token: $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (callback) {
          console.log(callback)

          $("." + callback).remove();

          Toast.fire({
            icon: 'success',
            title: "Se ha eliminado correctamente"
          })
        },
        error: function (status) {
          console.log(status)
          Toast.fire({
            icon: 'error',
            title: "No se ha eliminado"
          })
        }

      })
  })

  //aqui fem una peticio ajax i segons amb la informacio que li arriba, el que fa es mirar que hi hagi productes a la cistella, 
  //si el preu es igual o superior a 100 i si tots els productes estan disponibles. si una de les opcions anteriors estan malament,
  //mostrara un error sino anira anira a la comanda feta
  $("body").on("click", "button.confirmar", function (e) {
    e.preventDefault();
    $.ajaxSetup({
      headers: {
        'X-CSRF-TPKEN': $('meta[name="csrf-token"]').attr('content')
      }
    }),
      $.ajax({

        url: "cesta/confirmar",
        type: 'GET',
        dataType: "json",
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (callback) {
          console.log(callback)
          if (callback == "error1") {
            Toast.fire({
              icon: 'error',
              title: "La cesta está vacia"
            })
          }
          else if (callback == "error2") {
            Toast.fire({
              icon: 'error',
              title: "El precio total tiene que ser igual o superior a 100"
            })
          }
          else if (callback == "error3") {
            Toast.fire({
              icon: 'error',
              title: "Todos los porductos tienen que estar disponibles"
            })
          }
          else if (callback == "error4") {
            Toast.fire({
              icon: 'error',
              title: "El precio total tiene que ser igual o superior a 100 y todos los porductos tienen que estar disponibles"
            })
          }
          else {
            window.location.href = callback;
          }
        },
        error: function (status) {
          console.log(status)
          Toast.fire({
            icon: 'error',
            title: "No se ha creado correctamente"
          })
        }

      })
  })




  /*****************************************************
  *                                                    *
  *                 GESTIO DE COMANDAS                 *
  *                                                    *
  *****************************************************/

  //aqui creem una peticio ajax que el que fa es enviar la id per fer que una comanda esta preparada i despres actualitza la taula
  $("body").on("click", "button.preparada", function (e) {
    e.preventDefault();
    $.ajaxSetup({
      headers: {
        'X-CSRF-TPKEN': $('meta[name="csrf-token"]').attr('content')
      }
    }),
      $.ajax({

        url: "comandas/" + $(this).val(),
        type: 'PUT',
        dataType: "json",
        data: {
          method: "PUT", submit: true, _token: $('meta[name="csrf-token"]').attr('content'), id: $(this).val()
        },
        success: function (callback) {
          console.log(callback)
          $('#example').DataTable().clear();
          $('#example').DataTable().destroy();
          $("#tbody").empty();
          $.each(callback, function (index, value) {
            console.log(index + ": " + value["id"])
            if (value["estat"] == 1) {
              $('#tbody').append(' <tr id="linia"><td>' + value["id"] + '</td><td id="nom">' + value["user"]["name"] + '</td><td > <a href="comandas/' + value["id"] + '" type="button" class="btn btn-primary"><i class="far fa-eye"></i></a> <button type="button" value="' + value["id"] + '" class="btn btn-danger entregada">Entregar</button></td></tr>')
            }
            else {
              $('#tbody').append(' <tr id="linia"><td>' + value["id"] + '</td><td id="nom">' + value["user"]["name"] + '</td><td > <a href="comandas/' + value["id"] + '" type="button" class="btn btn-primary"><i class="far fa-eye"></i></a>                <button type="button" class="btn btn-warning preparada"  value="' + value["id"] + '">Preparada</button>                </td></tr>')
            }
          });
          $('#example').DataTable({ responsive: true });

          Toast.fire({
            icon: 'success',
            title: "La comanda esta preparada"
          })
        },
        error: function (status) {
          console.log(status)
          Toast.fire({
            icon: 'error',
            title: "Ha habido algun error"
          })
        }

      })
  })

  //aqui creem una peticio ajax que el que fa es entregar una comanda i despres actualitza la taula
  $("body").on("click", "button.entregada", function (e) {
    e.preventDefault();
    $.ajaxSetup({
      headers: {
        'X-CSRF-TPKEN': $('meta[name="csrf-token"]').attr('content')
      }
    }),
      $.ajax({
        url: "comandas/" + $(this).val(),
        type: 'DELETE',
        dataType: "json",
        data: {
          method: "DELETE", submit: true, _token: $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (callback) {
          console.log(callback)
          $('#example').DataTable().clear();
          $('#example').DataTable().destroy();
          $("#tbody").empty();
          $.each(callback, function (index, value) {
            console.log(index + ": " + value["id"])
            if (value["estat"] == 1) {
              $('#tbody').append(' <tr id="linia"><td>' + value["id"] + '</td><td id="nom">' + value["user"]["name"] + '</td><td > <a href="comandas/' + value["id"] + '" type="button" class="btn btn-primary"><i class="far fa-eye"></i></a> <button type="button" value="' + value["id"] + '" class="btn btn-danger entregada">Entregar</button></td></tr>')
            }
            else {
              $('#tbody').append(' <tr id="linia"><td>' + value["id"] + '</td><td id="nom">' + value["user"]["name"] + '</td><td > <a href="comandas/' + value["id"] + '" type="button" class="btn btn-primary"><i class="far fa-eye"></i></a>                <button type="button" class="btn btn-warning preparada"  value="' + value["id"] + '">Preparada</button>                </td></tr>')
            }
          });

          $('#example').DataTable({ responsive: true });
          Toast.fire({
            icon: 'success',
            title: "Se ha entregado el pedido"
          })
        },
        error: function (status) {
          console.log(status)
          Toast.fire({
            icon: 'error',
            title: "No se ha entregado el pedido"
          })
        }

      })
  })

  //aqui creem una peticio ajax que el que fa es enviar la id per fer que una comanda esta no estigui ni preparada ni entregada 
  //i despres actualitza la taula
  $("body").on("click", "button.noentregada", function (e) {
    e.preventDefault();
    $.ajaxSetup({
      headers: {
        'X-CSRF-TPKEN': $('meta[name="csrf-token"]').attr('content')
      }
    }),
      $.ajax({

        url: "/comandas/entregadas/" + $(this).val(),
        type: 'PUT',
        dataType: "json",
        data: {
          method: "PUT", submit: true, _token: $('meta[name="csrf-token"]').attr('content'), id: $(this).val()
        },
        success: function (callback) {
          console.log(callback)
          $('#example').DataTable().clear();
          $('#example').DataTable().destroy();
          $("#tbody").empty();
          $.each(callback, function (index, value) {
            console.log(index + ": " + value["id"])
            $('#tbody').append(' <tr id="linia"><td>' + value["id"] + '</td><td id="nom">' + value["user"]["name"] + '</td><td > <a href="comandas/' + value["id"] + '" type="button" class="btn btn-primary"><i class="far fa-eye"></i></a><button type="button" value="' + value["id"] + '" class="btn btn-success noentregada">No entregada</button></td></tr>')
          });
          $('#example').DataTable({ responsive: true });

          Toast.fire({
            icon: 'success',
            title: "La comanda esta preparada"
          })
        },
        error: function (status) {
          console.log(status)
          Toast.fire({
            icon: 'error',
            title: "Ha habido algun error"
          })
        }

      })
  })




  /*****************************************************
  *                                                    *
  *                 GESTIO DE USUARIS                  *
  *                                                    *
  *****************************************************/

  //aqui creem una peticio ajax que el que fa es eliminar un usuari i despres actualitza la taula
  $("body").on("click", "button.eliminar-user", function (e) {
    e.preventDefault();
    $.ajaxSetup({
      headers: {
        'X-CSRF-TPKEN': $('meta[name="csrf-token"]').attr('content')
      }
    }),
      $.ajax({
        url: "user/" + $(this).val(),
        type: 'DELETE',
        dataType: "json",
        data: {
          method: "DELETE", submit: true, _token: $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (callback) {
          console.log(callback)
          $('#example').DataTable().clear();
          $('#example').DataTable().destroy();
          $("#tbody").empty();
          $.each(callback, function (index, value) {
            console.log(index + ": " + value["id"])
            $('#tbody').append(' <tr id="linia"><td>' + value["id"] + '</td><td id="nom">' + value["name"] + '</td><td id="email">' + value["email"] + '</td><td ><button type="button" value="' + value["id"] + '" class="btn btn-danger eliminar-user"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>')
          });

          $('#example').DataTable({ responsive: true });
          Toast.fire({
            icon: 'success',
            title: "Se ha eliminado correctamente"
          })
        },
        error: function (status) {
          console.log(status)
          Toast.fire({
            icon: 'error',
            title: "No se ha eliminado correctamente"
          })
        }

      })
  })

  //aqui creem una peticio ajax que el que fa es crear un usuari i despres actualitza la taula
  $('#createuserform').on("submit", function (e) {
    e.preventDefault();
    $.ajaxSetup({
      headers: {
        'X-CSRF-TPKEN': $('meta[name="csrf-token"]').attr('content')
      }
    }),
      $.ajax({
        url: "/user",
        type: 'POST',
        dataType: "json",
        data: {
          method: "POST", submit: true, _token: $('meta[name="csrf-token"]').attr('content'), name: $("#name").val(),
          email: $("#email").val(), password: $("#password").val(), passwordconfirm: $("#password-confirm").val()
        },
        success: function (callback) {
          console.log(callback);
          if (callback != "error1" && callback != "error2") {
            $('#createuserform').trigger('reset');
            $('#example').DataTable().clear();
            $('#example').DataTable().destroy();
            $("#tbody").empty();
            $.each(callback, function (index, value) {
              $('#tbody').append(' <tr id="linia"><td>' + value["id"] + '</td><td id="nom">' + value["name"] + '</td><td id="email">' + value["email"] + '</td><td ><button type="button" value="' + value["id"] + '" class="btn btn-danger eliminar-user"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>')
            });

            $('#example').DataTable({ responsive: true });
            Toast.fire({
              icon: 'success',
              title: "El usuario se ha creado correctamente"
            })
          }
          else if (callback == "error1") {
            Toast.fire({
              icon: 'error',
              title: "El correo ya existe"
            })
          }
          else {
            Toast.fire({
              icon: 'error',
              title: "Las contraseñas no coinciden"
            })
          }

        },
        error: function (status) {
          console.log(status)
          Toast.fire({
            icon: 'error',
            title: "No se ha creado correctamente"
          })
        }
      })
  })


  //aqui creem una peticio ajax que el que fa es enviar la informacio perque es pugui solicitar acces a la web 
  //i despres actualitza la taula
  $('#solicitar').on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: "/solicitar",
      type: 'POST',
      dataType: "json",
      data: {
        method: "POST", submit: true, _token: $('meta[name="csrf-token"]').attr('content'), nom: $("#Nombre").val(),
        email: $("#Email").val(), telefon: $("#Telefono").val(), mensaje: $("#Mensaje").val(),
      },
      success: function (callback) {
        console.log(callback);
        $('#solicitar').trigger('reset');
        $('#example').DataTable({ responsive: true }).draw(true);
        Toast.fire({
          icon: 'success',
          title: "Su solicitud se ha creado correctamente."
        })
      },
      error: function (status) {
        console.log(status)
        Toast.fire({
          icon: 'error',
          title: "No se ha creado correctamente"
        })
      }
    })
  })
})