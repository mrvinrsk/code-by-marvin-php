const Direction = {
    PREVIOUS: Node.DOCUMENT_POSITION_PRECEDING,
    NEXT: Node.DOCUMENT_POSITION_FOLLOWING
};
const getSibling = function (start, selector, direction) {
    // Sort the list of elements by their position in the DOM
    let list = Array.prototype.slice
        .call(document.querySelectorAll(selector), 0)
        .sort(function (a, b) {
            return a.compareDocumentPosition(b) & 2 ? 1 : -1;
        });

    for (const element of list) {
        // check if the current list item comes after the element in the DOM
        if (element.compareDocumentPosition(start) & direction) {
            return element;
        }
    }
};

window.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".scroll").forEach((scroll) => {
        const el = scroll.dataset.target;
        console.log(el);
        let scrollTo;

        if (el.startsWith("+")) {
            scrollTo = getSibling(scroll, el.substring(1), Direction.PREVIOUS);
        } else if (el.startsWith("-")) {
            scrollTo = getSibling(scroll, el.substring(1), Direction.NEXT);
        } else {
            scrollTo = document.querySelector(el);
        }

        console.debug(scroll, "scrolls to", scrollTo);

        scroll.addEventListener("click", () => {
            // scroll to the element, duration: 500ms
            scrollTo.scrollIntoView({
                behavior: "smooth",
                block: "start"
            });
        });
    });
});
