document.querySelectorAll('.compare-tabs__link').forEach(tab => {
  tab.addEventListener('click', () => {
    const tabId = tab.dataset.tab;

 
    document.querySelectorAll('.compare-tabs__link')
      .forEach(el => el.classList.remove('active'));
    tab.classList.add('active');


    document.querySelectorAll('.compare-tabs__content')
      .forEach(content => {
        content.classList.remove('active');
        if (content.dataset.tabContent === tabId) {
          content.classList.add('active');
        }
      });
  });
});
