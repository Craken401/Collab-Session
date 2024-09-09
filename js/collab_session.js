// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

document.addEventListener('DOMContentLoaded', function() {
    const collabIconLink = document.querySelector('.collab_session_icon'); // Seleccionamos el enlace, no solo la imagen
    const collabIconImage = collabIconLink ? collabIconLink.querySelector('img') : null; // Seleccionamos la imagen
    const modal = document.querySelector('#collab-session-modal');
    const closeModal = document.querySelector('.close-modal');
    let blinkInterval;

    console.log("JavaScript cargado correctamente");

    if (collabIconLink && collabIconImage && modal && closeModal) {
        console.log("Icono colaborativo encontrado");

        // Iniciar el parpadeo del ícono
        const startBlinking = () => {
            blinkInterval = setInterval(() => {
                collabIconImage.classList.toggle('collab_session_icon_active');
            }, 500);
        };

        // Detener el parpadeo del ícono
        const stopBlinking = () => {
            clearInterval(blinkInterval);
            collabIconImage.classList.add('collab_session_icon_active');
            collabIconImage.style.visibility = "visible"; // Asegurarse de que sea visible
        };

        // Iniciar el parpadeo y detenerlo después de 5 segundos
        startBlinking();
        setTimeout(stopBlinking, 5000);

        // Mostrar el modal cuando se hace clic en el ícono, y detener el parpadeo si está activo
        collabIconLink.addEventListener('click', function(event) {
            event.preventDefault(); // Prevenir el comportamiento por defecto
            console.log("Icono clickeado");

            // Asegurarse de que el parpadeo se detiene si aún está activo
            stopBlinking();

            // Mostrar el modal
            modal.style.display = 'block';
        });

        // Cerrar el modal cuando el usuario haga clic en el botón de cerrar
        closeModal.addEventListener('click', function() {
            console.log("Botón de cerrar clickeado");
            modal.style.display = 'none';
        });

        // Cerrar el modal cuando el usuario haga clic fuera del contenido del modal
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                console.log("Clic fuera del modal");
                modal.style.display = 'none';
            }
        });
    } else {
        console.log("Icono colaborativo o modal no encontrado");
    }
});
