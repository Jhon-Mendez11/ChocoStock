window.DeleteProduct = function (p_id) {
    fetch('/ChocoStock/server/products/delete.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ p_id: p_id })
    })
        .then(res => res.json())
        .then(data => {
            const mensajeDiv = document.getElementById('eliminacionMensaje');
            if (data.success) {
                mensajeDiv.innerText = '✅ Producto eliminado correctamente.';
                mensajeDiv.className = 'mensaje mensaje-exito';
                mensajeDiv.style.display = 'block';

                // Ocultar la fila del producto eliminado
                const fila = document.querySelector('[data-producto-id="' + p_id + '"]');
                if (fila) fila.remove();

            } else {
                mensajeDiv.innerText = '❌ Error al eliminar: ' + (data.error || 'Error desconocido');
                mensajeDiv.className = 'mensaje mensaje-error';
                mensajeDiv.style.display = 'block';
            }
            setTimeout(() => {
                mensajeDiv.style.display = 'none';
            }, 4000);
        })
        .catch(err => {
            const mensajeDiv = document.getElementById('eliminacionMensaje');
            mensajeDiv.innerText = '❌ Error en la petición: ' + err;
            mensajeDiv.className = 'mensaje mensaje-error';
            mensajeDiv.style.display = 'block';

            setTimeout(() => {
                mensajeDiv.style.display = 'none';
            }, 4000);
        });
}

function renderProducts() {
    const ListPro = document.getElementById('list-products');
    ListPro.innerHTML = '';
    fetch('server/user/session_info.php')
        .then(resp => resp.json())
        .then(data => {
            if (data.u_id) {
                console.log('Sesión activa para usuario:', data.u_id);
                fetch('server/products/products_list.php?u_id=' + data.u_id)
                    .then(res => res.json())
                    .then(products => {
                        console.log(products)
                        products.forEach(
                            pro => {
                                console.log(pro)

                                $error_men = "";

                                const row = document.createElement('tr');
                                row.setAttribute('data-producto-id', pro.p_id); // Para poder eliminar la fila luego

                                if (pro.cantidad <= 10) {
                                    row.style.backgroundColor = '#ffd6d6';
                                    $error_men = '¡Alerta!';
                                }
                                var fechaCompleta = pro.fecha;
                                var partes = fechaCompleta.split(' ');
                                var fechaSolo = partes[0];
                                var horaMinutos = partes[1].split(':');
                                var horaMinutosSolo = horaMinutos[0] + ':' + horaMinutos[1];
                                var fechaHora = fechaSolo + ' ' + horaMinutosSolo;
                                var can = parseInt(pro.cantidad);
                                var cantidad = can + ' ' + 'Kg'

                                row.innerHTML =
                                    '<td>' + pro.nombre + '</td>' +
                                    '<td>' + cantidad + '</td>' +
                                    '<td>' + pro.precio + '</td>' +
                                    '<td>' + fechaHora + '</td>' +
                                    '<td>' +
                                    '<a href="/ChocoStock/pages/edit_p.php?id=' + pro.p_id + '" class="btn-editar">Editar</a>' +
                                    '<button onclick="if(confirm(\'¿Estás seguro de que deseas eliminar este producto?\')) DeleteProduct(' + pro.p_id + ');" class="btn-eliminar">Eliminar</button>' +
                                    '</td>';

                                ListPro.appendChild(row);
                                '<p>' + $error_men + '</p>'
                            })
                    })
                    .catch(err => {
                        console.error('Error al cargar productos:', err);
                    });
            } else {
                console.warn(data.error || 'Sesión no activa');
                window.location.href = 'Pnl_login.php';
            }

        })
        .catch(err => {
            console.error('Error al verificar sesión:', err);
        });
}

document.addEventListener('DOMContentLoaded', () => {

    renderProducts();
    const form = document.getElementById('ventaForm');
    const message = document.getElementById('ventaMessage');

    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(form);

            try {
                const res = await fetch('server/products/add_sale.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await res.json();

                message.textContent = data.message;

                if (data.success) {
                    message.style.color = 'green';
                    form.reset();
                    renderProducts(); // si quieres actualizar productos tras venta
                } else {
                    message.style.color = 'red';
                }

            } catch (err) {
                message.textContent = 'Error en la solicitud';
                message.style.color = 'red';
            }
        });
    }

});
