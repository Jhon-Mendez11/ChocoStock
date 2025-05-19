document.addEventListener('DOMContentLoaded', () => {
    const ventasBody = document.getElementById('ventas-body');
    const orderSelect = document.getElementById('order');
    const verPdfBtn = document.getElementById('verPdfBtn');
    const descargarPdfBtn = document.getElementById('descargarPdfBtn');

    let limit = 8;
    let totalVentas = 0;

    const loadVentas = async (order = 'desc') => {
        const res = await fetch(`../server/products/report_sales.php?order=${order}`);
        const data = await res.json();
        ventasBody.innerHTML = '';

        if (data.length === 0) {
            ventasBody.innerHTML = '<tr><td colspan="3">No hay registros de ventas.</td></tr>';
        } else {
            totalVentas = data.length;

            data.slice(0, limit).forEach(v => {
                const row = `
                    <tr>
                        <td>${v.cantidad}</td>
                        <td>${v.nombre}</td>                        
                        <td>${parseFloat(v.precio_venta).toFixed(2)}</td>
                        <td>${new Date(v.fecha).toLocaleDateString('es-PE')}</td>
                    </tr>
                `;
                ventasBody.innerHTML += row;
            });

        }
        // Actualiza los links de PDF
        verPdfBtn.href = `../server/products/report_sales.php?view_pdf=true&order=${order}`;
        descargarPdfBtn.href = `../server/products/report_sales.php?download_pdf=true&order=${order}`;
    };

    orderSelect.addEventListener('change', () => {
        limit = 8;
        loadVentas(orderSelect.value);
    });
    // Cargar por defecto en orden descendente
    loadVentas('desc');
});
