document.addEventListener('DOMContentLoaded', () => {
    const ListPro = document.getElementById('list-products');

    let products = [];

    function renderProducts() {
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
                                        '<td>' + pro.editar + '</td>';
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
    renderProducts();
});