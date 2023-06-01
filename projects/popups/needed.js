document.addEventListener("DOMContentLoaded", setupPopups);

function setupPopups() {
    const popups = document.querySelectorAll(".popup");
    popups.forEach((popup) => setupPopup(popup));

    const toggleButtons = document.querySelectorAll("[data-toggle-popup]");
    toggleButtons.forEach((button) => setupPopupToggleButton(button));

    const popupsOverlay = document.querySelector(".popups");
    if (popupsOverlay) {
        setupPopupsOverlay(popupsOverlay, popups);
    }

    if (popups.length > 0) {
        stopEventPropagationOnPopups(popups);
    }

    document.addEventListener("keyup", (e) => {
        if (e.key === "Escape") {
            if (popupShown()) {
                document
                    .querySelectorAll(".popups .popup.show")
                    .forEach((popup) => togglePopup(popup.id));
            }
        }
    });
}

function createDivElementWithClass(className) {
    const div = document.createElement("div");
    div.classList.add(className);
    return div;
}

function setupPopup(popup) {
    const close = createDivElementWithClass("close");
    close.addEventListener("click", () => togglePopup(popup.id));
    popup.appendChild(close);

    const handle = createDivElementWithClass("handle");
    setupHandleDrag(handle, popup);
    popup.appendChild(handle);
}

function setupHandleDrag(handle, popup) {
    let touchStartY = 0;
    let initialPopupBottom = 0;
    let dragging = false;
    let transitionDuration = 0;

    handle.addEventListener("mousedown", startDrag);
    handle.addEventListener("touchstart", startDrag);

    document.addEventListener("mousemove", drag);
    document.addEventListener("touchmove", drag);

    document.addEventListener("mouseup", endDrag);
    document.addEventListener("touchend", endDrag);
    document.addEventListener("touchcancel", endDrag);

    function startDrag(e) {
        e.preventDefault();
        dragging = true;
        transitionDuration = parseFloat(
            window.getComputedStyle(popup).transitionDuration
        );
        touchStartY = e.touches ? e.touches[0].clientY : e.clientY;
        initialPopupBottom = parseInt(window.getComputedStyle(popup).bottom);

        // Disable transitions while dragging
        popup.style.transitionDuration = "0s";
    }

    function drag(e) {
        if (!dragging) return;
        e.preventDefault();
        const deltaY = touchStartY - (e.touches ? e.touches[0].clientY : e.clientY);
        const position = Math.min(initialPopupBottom + deltaY, 0);
        popup.style.bottom = `${position}px`;
    }

    function endDrag() {
        if (!dragging) return;
        dragging = false;
        if (parseInt(window.getComputedStyle(popup).bottom) <= -100) {
            togglePopup(popup.id);
        }
        popup.style.bottom = ""; // Remove the inline bottom property

        // Re-enable transitions
        popup.style.transitionDuration = `${transitionDuration}s`;
    }
}

function setupPopupToggleButton(button) {
    button.addEventListener("click", () =>
        togglePopup(button.getAttribute("data-toggle-popup"))
    );
}

function setupPopupsOverlay(popupsOverlay, popups) {
    popupsOverlay.addEventListener("click", () => {
        popups.forEach((popup) => popup.classList.remove("show"));
        popupsOverlay.classList.remove("show");
        document.body.classList.remove("popup-shown");
    });
}

function stopEventPropagationOnPopups(popups) {
    popups.forEach((popup) =>
        popup.addEventListener("click", (e) => {
            e.stopImmediatePropagation();
            e.stopPropagation();
        })
    );
}

function togglePopup(id) {
    const popup = document.getElementById(id);
    popup.classList.toggle("show");

    const popupsOverlay = document.querySelector(".popups");
    if (popup.classList.contains("show")) {
        document.body.classList.add("popup-shown");
        popupsOverlay.classList.add("show");
    } else {
        document.body.classList.remove("popup-shown");
        popupsOverlay.classList.remove("show");
    }
}

function popupShown(id = null) {
    if (id) {
        return document.getElementById(id).classList.contains("show");
    } else {
        return document.querySelector(".popup.show") !== null;
    }
}
