document.addEventListener("DOMContentLoaded", () => {
  const accordions = document.querySelectorAll('.questions-acc');
  if (!accordions.length) return;

  accordions.forEach(accordion => {
    const items = accordion.querySelectorAll('.question-acc__item');

    items.forEach(item => {
      const title = item.querySelector('.questions-acc__title');
      const content = item.querySelector('.question-acc__content');
      if (!title || !content) return;

      const style = window.getComputedStyle(content);
      const paddingBottom = parseFloat(style.paddingBottom) || 20;

      if (item.classList.contains('active')) {
        content.style.maxHeight = content.scrollHeight + paddingBottom + "px";
      } else {
        content.style.maxHeight = "0px";
      }

      title.addEventListener('click', () => {
        const isActive = item.classList.contains('active');

        if (isActive) {
          item.classList.remove('active');
          content.style.maxHeight = "0px";
        } else {
          item.classList.add('active');
          content.style.maxHeight = content.scrollHeight + paddingBottom + "px";
        }
      });
    });
  });
});