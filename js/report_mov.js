document.addEventListener('DOMContentLoaded', () => {
    const ventasBody = document.getElementById('ventas-body');
    const orderSelect = document.getElementById('order');
    const verPdfBtn = document.getElementById('verPdfBtn');
    const descargarPdfBtn = document.getElementById('descargarPdfBtn');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    const limit = 5; // Mostrar 5 registros por página
    let offset = 0;  // Índice desde donde se muestra la página actual
    let totalMov = 0;
    let currentOrder = 'desc'; // Guardar el orden actual

    const loadVentas = async (order = 'desc') => {
        currentOrder = order;
        const res = await fetch(`../server/products/report_mov.php?order=${order}`);
        const data = await res.json();
        ventasBody.innerHTML = '';

        if (data.length === 0) {
            ventasBody.innerHTML = '<tr><td colspan="5">No hay registros de movimientos.</td></tr>';
            totalMov = 0;
        } else {
            totalMov = data.length;

            // Mostrar solo el segmento correspondiente a offset y limit
            const paginatedData = data.slice(offset, offset + limit);

            paginatedData.forEach(v => {
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

        // Actualiza los links de PDF (los mantengo con el orden actual)
        verPdfBtn.href = `../server/products/report_mov.php?view_pdf=true&order=${order}`;
        descargarPdfBtn.href = `../server/products/report_mov.php?download_pdf=true&order=${order}`;

        // Actualizar estado de botones
        prevBtn.disabled = offset === 0;
        nextBtn.disabled = (offset + limit) >= totalMov;
    };

    orderSelect.addEventListener('change', () => {
        offset = 0; // resetear paginación al cambiar orden
        loadVentas(orderSelect.value);
    });

    prevBtn.addEventListener('click', () => {
        if (offset > 0) {
            offset -= limit;
            if (offset < 0) offset = 0;
            loadVentas(currentOrder);
        }
    });

    nextBtn.addEventListener('click', () => {
        if ((offset + limit) < totalMov) {
            offset += limit;
            loadVentas(currentOrder);
        }
    });

    // Cargar por defecto en orden descendente
    loadVentas('desc');
});
