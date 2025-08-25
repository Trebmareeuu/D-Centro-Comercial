/**
 * Script para la página de registro.
 *
 * Muestra dinámicamente los beneficios de registrarse como comprador o vendedor.
 */

// Esperar a que el contenido del DOM esté completamente cargado.
document.addEventListener('DOMContentLoaded', function() {

    // Seleccionar los elementos del DOM.
    const radioComprador = document.getElementById('tipo_comprador');
    const radioVendedor = document.getElementById('tipo_vendedor');
    const beneficiosContainer = document.getElementById('beneficios-dinamicos');

    // Definir los textos de los beneficios.
    const beneficiosComprador = `
        <h4>Beneficios como Comprador:</h4>
        <ul>
            <li><i class="fas fa-star"></i> Guarda tus tiendas favoritas.</li>
            <li><i class="fas fa-comments"></i> Califica y deja reseñas de tus compras.</li>
            <li><i class="fas fa-bell"></i> Recibe notificaciones sobre ofertas (próximamente).</li>
        </ul>
    `;

    const beneficiosVendedor = `
        <h4>Beneficios como Vendedor:</h4>
        <ul>
            <li><i class="fas fa-store"></i> Aumenta la visibilidad de tu negocio local.</li>
            <li><i class="fas fa-bullhorn"></i> Publica tu catálogo de productos.</li>
            <li><i class="fas fa-chart-line"></i> Accede a un panel para gestionar tu tienda.</li>
        </ul>
    `;

    // Función para actualizar el contenido.
    function actualizarBeneficios() {
        if (radioVendedor.checked) {
            beneficiosContainer.innerHTML = beneficiosVendedor;
        } else {
            beneficiosContainer.innerHTML = beneficiosComprador;
        }
        beneficiosContainer.style.display = 'block';
    }

    // Añadir los event listeners a los radio buttons.
    radioComprador.addEventListener('change', actualizarBeneficios);
    radioVendedor.addEventListener('change', actualizarBeneficios);

    // Llamar a la función una vez al cargar la página para mostrar el estado inicial.
    actualizarBeneficios();
});
