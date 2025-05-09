document.addEventListener('DOMContentLoaded', () => {
    const ventasBody = document.getElementById('ventas-body');
    const orderSelect = document.getElementById('order');
    const verPdfBtn = document.getElementById('verPdfBtn');
    const descargarPdfBtn = document.getElementById('descargarPdfBtn');

    const loadVentas = async (order = 'desc') => {
        const res = await fetch(`../server/products/report_product.php?order=${order}`);
        const data = await res.json();
        ventasBody.innerHTML = '';

        if (data.length === 0) {
            ventasBody.innerHTML = '<tr><td colspan="3">No hay registros de ventas.</td></tr>';
        } else {
            data.forEach(v => {
                const row = `
                    <tr>
                        <td>${v.cantidad}</td>
                        <td>${parseFloat(v.precio_venta).toFixed(2)}</td>
                        <td>${new Date(v.fecha).toLocaleDateString('es-PE')}</td>
                    </tr>
                `;
                ventasBody.innerHTML += row;
            });
        }

        // Actualiza los links de PDF
        verPdfBtn.href = `../server/products/report_product.php?view_pdf=true&order=${order}`;
        descargarPdfBtn.href = `../server/products/report_product.php?download_pdf=true&order=${order}`;
    };

    orderSelect.addEventListener('change', () => {
        const order = orderSelect.value;
        loadVentas(order);
    });

    // Cargar por defecto en orden descendente
    loadVentas('desc');
});
