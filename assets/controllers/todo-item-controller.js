import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['checkbox'];

    async toggle(event) {
        const itemId = event.target.dataset.itemId;
        const listId = event.target.dataset.todoListId;
        const completed = event.target.checked;

        try {
            const response = await fetch(`/todo-lists/${listId}/items/${itemId}/completed`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ completed })
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const eventDetail = { itemId, listId, completed };
            const updateEvent = new CustomEvent('item-updated', { detail: eventDetail });
            document.dispatchEvent(updateEvent);

        } catch (error) {
            console.error('There was a problem with the fetch operation:', error);
            event.target.checked = !completed; // Revert the checkbox state on error
        }
    }
}