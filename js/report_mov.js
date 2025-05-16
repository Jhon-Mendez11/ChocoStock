document.addEventListener('DOMContentLoaded', () => {
    const ventasBody = document.getElementById('ventas-body');
    const orderSelect = document.getElementById('order');
    const verPdfBtn = document.getElementById('verPdfBtn');
    const descargarPdfBtn = document.getElementById('descargarPdfBtn');

    let limit = 8;
    let totalMov = 0;

    const loadVentas = async (order = 'desc') => {
        const res = await fetch(`../server/products/report_mov.php?order=${order}`);
        const data = await res.json();
        ventasBody.innerHTML = '';

        if (data.length === 0) {
            ventasBody.innerHTML = '<tr><td colspan="5">No hay registros de movimientos.</td></tr>';
        } else {
            totalMov = data.length;

            data.slice(0, limit).forEach(v => {
                const row = `
                    <tr>
                        <td>${parseInt(v.cantidad)}</td>
                        <td>${v.tipo_mov}</td>
                        <td>${v.nombre}</td>
                        <td>${parseFloat(v.precio).toFixed(2)}</td>
                        <td>${new Date(v.fecha).toLocaleDateString('es-PE')}</td>
                    </tr>
                `;
                ventasBody.innerHTML += row;
            });

        }

        // Actualiza los links de PDF
        verPdfBtn.href = `../server/products/report_mov.php?view_pdf=true&order=${order}`;
        descargarPdfBtn.href = `../server/products/report_mov.php?download_pdf=true&order=${order}`;
    };

    orderSelect.addEventListener('change', () => {
        limit = 8;
        loadVentas(orderSelect.value);
    });

    // Cargar por defecto en orden descendente
    loadVentas('desc');
});
