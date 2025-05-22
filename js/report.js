document.addEventListener('DOMContentLoaded', () => {
    // Obtener referencias a elementos del DOM
    const ventasBody = document.getElementById('ventas-body');
    const orderSelect = document.getElementById('order');
    const verPdfBtn = document.getElementById('verPdfBtn');
    const descargarPdfBtn = document.getElementById('descargarPdfBtn');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    // Límite de registros por página
    let limit = 5;
    // Página actual
    let currentPage = 1;
    // Total de registros
    let totalData = 0;
    // Variable para guardar los datos de ventas
    let ventasData;

    // Función para renderizar los datos de ventas según la página actual
    const renderVentas = (order) => {
        ventasBody.innerHTML = '';

        let contador = 0;
        // Cálculo del índice inicial y final para paginación
        let inicio = (currentPage - 1) * limit;
        let fin = inicio + limit;
        let i = 0;

        // Recorrer todos los datos manualmente (sin usar slice)
        while (i < totalData) {
            // Solo mostrar los que estén dentro del rango de la página actual
            if (i >= inicio && i < fin) {
                const v = ventasData[i];
                const row = `
                    <tr>
                        <td>${v.cantidad}</td>
                        <td>${v.nombre}</td>                        
                        <td>${parseFloat(v.precio_venta).toFixed(2)}</td>
                        <td>${new Date(v.fecha).toLocaleDateString('es-PE')}</td>
                    </tr>
                `;
                ventasBody.innerHTML += row;
                contador++;
            }
            i++;
        }

        // Si no se mostraron datos, indicar que no hay registros
        if (contador === 0) {
            ventasBody.innerHTML = '<tr><td colspan="4">No hay registros de ventas.</td></tr>';
        }

        // Deshabilitar botones si se está al inicio o final
        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = fin >= totalData;

        // Actualizar enlaces de PDF con el orden actual
        verPdfBtn.href = `../server/products/report_sales.php?view_pdf=true&order=${order}`;
        descargarPdfBtn.href = `../server/products/report_sales.php?download_pdf=true&order=${order}`;
    };

    // Función para cargar los datos de ventas desde el servidor
    const loadVentas = async (order = 'desc') => {
        const res = await fetch(`../server/products/report_sales.php?order=${order}`);
        const resultado = await res.json();
        ventasData = resultado;
        totalData = resultado.length;
        currentPage = 1; // Reiniciar a la primera página
        renderVentas(order);
    };

    // Evento cuando cambia el orden (ascendente o descendente)
    orderSelect.addEventListener('change', () => {
        currentPage = 1;
        loadVentas(orderSelect.value);
    });

    // Botón siguiente: pasar a la siguiente página
    nextBtn.addEventListener('click', () => {
        currentPage++;
        renderVentas(orderSelect.value);
    });

    // Botón anterior: volver a la página anterior
    prevBtn.addEventListener('click', () => {
        currentPage--;
        renderVentas(orderSelect.value);
    });

    // Cargar los datos inicialmente en orden descendente
    loadVentas('desc');
});
