import './bootstrap';
import * as bootstrap from 'bootstrap'

import * as jqueryExports from "jquery";
window.$ = jqueryExports.default;

// Импортируем стили
import '../sass/app.scss'

// Модальник для удаления
const deleteModal = document.getElementById('deleteModal')
deleteModal.addEventListener('show.bs.modal', event => {
    // Button that triggered the modal
    const button = event.relatedTarget
    // Extract info from data-bs-* attributes
    const name = button.getAttribute('data-bs-name')
    const link = button.getAttribute('data-bs-link')

    const modalTitle = deleteModal.querySelector('.modal-title')
    const modalText = deleteModal.querySelector('.modal-text')
    const modalButton = deleteModal.querySelector('.modal-button')

    modalTitle.textContent = `Подтверждение удаления ${name}`
    modalText.textContent = `Вы уверены, что хотите удалить ${name}?`
    modalButton.href = link
})
