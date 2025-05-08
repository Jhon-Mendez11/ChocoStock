window.DeleteProduct = function (p_id) {
    fetch('server/products/delete_product.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ p_id: p_id })
    })
        .then(res => res.json())
        .then(data => {
            alert(data.message || "Producto eliminado.");
            // Aquí puedes recargar la tabla si deseas:
            renderProducts(); // si tienes esta función definida
        })
        .catch(err => {
            console.error("Error eliminando producto:", err);
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

                                const row = document.createElement('tr');
                                row.innerHTML =
                                    '<td>' + pro.nombre + '</td>' +
                                    '<td>' + pro.cantidad + '</td>' +
                                    '<td>' + pro.precio + '</td>' +
                                    '<td>' + pro.fecha + '</td>' +
                                    '<td><a class="btn-eliminar" onclick="DeleteProduct(' + pro.p_id + ')">Eliminar</a></td>';
                                ListPro.appendChild(row);
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
});