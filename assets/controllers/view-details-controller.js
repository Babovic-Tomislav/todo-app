import { Controller } from '@hotwired/stimulus';
import {Modal} from 'bootstrap';

export default class extends Controller {
    static targets = ['modal', 'modalBody'];

    open(event) {
        event.preventDefault();
        const url = event.currentTarget.dataset.url;

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.text())
            .then(html => {
                this.modalBodyTarget.innerHTML = html;
                const modal = new Modal(this.modalTarget);
                modal.show();
            })
            .catch(error => {
                console.error('Error loading modal content:', error);
                this.modalBodyTarget.innerHTML = '<p>Error loading content.</p>';
            });
    }

    connect() {
        document.addEventListener('item-updated', this.updateCardData.bind(this));
        this.initialCardData = this.element.innerHTML; // Store the initial card data
    }

    stopPropagation(event) {
        event.stopPropagation();
    }

    updateCardData(event) {
        const { itemId, listId, completed } = event.detail;
        const itemElement = this.element.querySelector(`[data-item-id="${itemId}"]`);
        if (itemElement) {
            itemElement.querySelector('.item-completed').textContent = completed ? '✅' : '❌';
        }
        console.log(2)
    }
}