document.addEventListener("DOMContentLoaded", () => {
  const accordionItems = document.querySelectorAll('.question-acc__item');
  if(!accordionItems) return;

  accordionItems.forEach(item => {
    const title = item.querySelector('.questions-acc__title');
    title.addEventListener('click', () => {
      accordionItems.forEach(i => {
        if (i !== item) i.classList.remove('active');
      });

      item.classList.toggle('active');
    });
  });
});