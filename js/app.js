document.addEventListener('DOMContentLoaded', () => {
    const ListPro = document.getElementById('list-products');

    let products = [];

    ListPro.innerHTML = '';
    function renderProducts() {
        fetch('server/user/session_info.php')
            .then(resp => resp.json())
            .then(data => {
                if (data.u_id) {
                    console.log('Sesión activa para usuario:', data.u_id);
                    fetch('server/products/products_list.php?u_id=' + data.u_id)
                        .then(res => res.json())
                        .then(products => {
                            products.forEach(pro => {
                                const li = document.createElement('li');
                                li.innerHTML =
                                    '<span>' + pro.nombre + '   -   </span>' +
                                    '<span>' + pro.cantidad + '</span>';
                                ListPro.appendChild(li);
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