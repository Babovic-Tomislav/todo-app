import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    async delete(event) {
        event.preventDefault();
        const url = event.currentTarget.href;

        try {
            const response = await fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            // Optionally, remove the deleted item from the DOM
            this.element.closest('.card').remove();
        } catch (error) {
            console.error('There was a problem with the fetch operation:', error);
        }
    }
}