document.addEventListener("DOMContentLoaded", () => {
  const items = document.querySelectorAll(".ctalog-filters__acc-item");

  items.forEach(item => {
    const title = item.querySelector(".catalog-filter__acc-title");

    title.addEventListener("click", () => {

      item.classList.toggle("open");
    });
  });
});


document.addEventListener("DOMContentLoaded", () => {
  const trigger = document.querySelector(".catalog-filters__mobile-trigger");
  const filters = document.querySelector(".catalog-filters");
  const overlay = document.querySelector(".overlay");
  const dragLine = document.querySelector(".mobile-drag__line");
  const body = document.querySelector("body");

  let startY = 0;
  let isDragging = false;

  function openFilters() {
    filters.classList.add("active", "half");
    overlay.classList.add("active");
    body.classList.add("lock");
  }

  function closeFilters() {
    filters.classList.remove("active", "half", "full");
    overlay.classList.remove("active");
    body.classList.remove("lock");
  }

  function expandFilters() {
    filters.classList.remove("half");
    filters.classList.add("full");
  }

  trigger?.addEventListener("click", openFilters);
  overlay?.addEventListener("click", closeFilters);

  dragLine?.addEventListener("touchstart", (e) => {
    startY = e.touches[0].clientY;
    isDragging = true;
  });

  dragLine?.addEventListener("touchend", (e) => {
    if (!isDragging) return;
    isDragging = false;

    const endY = e.changedTouches[0].clientY;
    const deltaY = endY - startY;

    // Потянули вверх
    if (deltaY < -30 && filters.classList.contains("half")) {
      expandFilters();
    }

    // Потянули вниз
    if (deltaY > 30) {
      closeFilters();
    }
  });
});