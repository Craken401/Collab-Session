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

// JavaScript modificado para la gestión de la sesión colaborativa

document.addEventListener('DOMContentLoaded', function() {
    const collabIconLink = document.querySelector('.collab_session_icon');
    const collabIconImage = collabIconLink ? collabIconLink.querySelector('img') : null;
    const modal = document.querySelector('#collab-session-modal');
    const closeModal = document.querySelector('.close-modal');
    let blinkInterval;

    if (collabIconLink && collabIconImage && modal && closeModal) {
        const startBlinking = () => {
            blinkInterval = setInterval(() => {
                collabIconImage.classList.toggle('collab_session_icon_active');
            }, 500);
        };

        const stopBlinking = () => {
            clearInterval(blinkInterval);
            collabIconImage.classList.add('collab_session_icon_active');
            collabIconImage.style.visibility = "visible";
        };

        startBlinking();
        setTimeout(stopBlinking, 5000);

        collabIconLink.addEventListener('click', function(event) {
            event.preventDefault();
            stopBlinking();
            modal.style.display = 'block';
            console.log('Icono clickeado');
        });

        closeModal.addEventListener('click', function() {
            modal.style.display = 'none';
        });

        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    }
});
