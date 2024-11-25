import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["collectionContainer", "deleteItemButton"]

    static values = {
        index    : Number,
        prototype: String,
    }

    addCollectionElement(event)
    {
        event.preventDefault();

        const newForm = this.prototypeValue.replace(/__name__/g, this.indexValue);
        this.indexValue++;

        const newElement = document.createElement('li');
        newElement.innerHTML = newForm;
        newElement.innerHTML += `<button type="button" data-action="form-collection#deleteCollectionElement">${this.deleteItemButtonTarget.innerHTML}</button>`;
        this.collectionContainerTarget.appendChild(newElement);

    }

    deleteCollectionElement(event) {
        event.preventDefault();
        const item = event.currentTarget.closest('li');
        if (item) {
            item.remove();
        }
    }
}