class HouseVariationManager {
    constructor() {
        this.offersMap = window.OFFERS_DATA || {};
        this.buildingsMap = window.BUILDINGS_DATA || {};
        this.toggleBtn = null;
        this.editBlock = null;
        this.slider = null;
        this.sliderRecomendations = null;
        this.price = null;
        this.planeTabs = null;
        this.planeLinks = null;
        this.planeTabLinks = null;
        this.planeTabPanes = null;

        // Добавляем хранилища для экземпляров
        this.splideInstances = {};
        this.tabInstances = {};

        
        this.init();
    }

    init() {
        this.toggleBtn = document.querySelector(".detail-product__mainscreen-config__head-change");
        this.editBlock = document.querySelector(
            ".detail-product__mainscreen-config__items.edit"
        );
        this.slider = document.querySelector('.detail__page-slider__images');
        this.sliderRecomendations = document.querySelector('.examples-slider');
        this.price = document.querySelector('.detail-product__mainscreen-total__item-price');
        this.deadline = document.querySelector('.detail-product__mainscreen-total__item-date');
        this.bubblesSelect = document.querySelector(".custom-select-bubbles-js");
        if(this.bubblesSelect) {
            this.options = this.bubblesSelect.querySelectorAll(".options li");
        }
        this.planeTabs = document.querySelector('.detail-product__layout-tabs__content');
        this.planeLinks = document.querySelector('.detail-product__layout-tabs__links');
        this.planeTabLinks = document.querySelectorAll(".detail-product__layout-tabs__link");
        this.planeTabPanes = document.querySelectorAll(".tab-pane");
        this.bindEvents();
    }

    //вешает обработчики
    bindEvents() {
        document.addEventListener('change', (e) => {
            console.log('change');
            if (e.target.type === 'radio' && e.target.name.startsWith('HOUSES_')) {
                this.updateAvailability(e.target);
            }
        });
        document.addEventListener('click', (e) => {
            console.log('click');
            if (e.target.className.includes('HOUSES_')) {
                this.updateAvailability(e.target);
            }
        });
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => {
                this.initializeComponents();
            });
        } else {
            this.initializeComponents();
        }

        window.addEventListener('resize', this.refreshAccordions());
        document.addEventListener('tab-switched', this.refreshAccordions());

    }

    initializeComponents() {
        this.mainGalleryInit();
        this.selectBubbles();
        this.renderPlaneTabs();
        this.initTabsAndSliders();
        this.accInit();
        this.initEquipmentTabs();
        this.recomendationsSliderInit();
    }


    /*  FRONT START */
    // Инициализация табов и слайдеров галереи
    initTabsAndSliders() {
        const tabHeads = document.querySelectorAll('.detail-product__preview-tabs');
        if (!tabHeads.length) return;

        tabHeads.forEach(head => {
            const root = head.closest('.detail-product') || head.closest('.container') || head.parentElement;

            // Собираем панели контента (сначала внутри root, иначе — последовательные siblings)
            let contents = Array.from(root.querySelectorAll('.detail-product__preview-tabs__content') || []);
            if (!contents.length) {
                let node = root.nextElementSibling;
                while (node) {
                    if (node.classList && node.classList.contains('detail-product__preview-tabs__content')) {
                        contents.push(node);
                        node = node.nextElementSibling;
                        continue;
                    }
                    if (node.querySelector && node.querySelector('.detail-product__preview-tabs')) break;
                    node = node.nextElementSibling;
                }
            }

            const links = Array.from(head.querySelectorAll('.detail-product__preview-tabs__link'));
            const prevArrow = head.querySelector('.detail-product__preview-arrow__prev');
            const nextArrow = head.querySelector('.detail-product__preview-arrow__next');

            if (!links.length || !contents.length) {
                console.warn('Tabs: missing links or contents for widget', head);
                return;
            }

            const maxLen = Math.max(links.length, contents.length);
            for (let i = 0; i < maxLen; i++) {
                const l = links[i];
                const c = contents[i];

                if (l && c) {
                    if (!l.dataset.tab && c.dataset.tab) l.dataset.tab = c.dataset.tab;
                    else if (l.dataset.tab && !c.dataset.tab) c.dataset.tab = l.dataset.tab;
                    else if (!l.dataset.tab && !c.dataset.tab) {
                        const gen = `tab-${Date.now().toString(36)}-${i}`;
                        l.dataset.tab = gen;
                        c.dataset.tab = gen;
                    }
                } else if (l && !c) {
                    // есть ссылка без контента (создаём namespace)
                    if (!l.dataset.tab) l.dataset.tab = `tab-${Date.now().toString(36)}-${i}`;
                } else if (c && !l) {
                    if (!c.dataset.tab) c.dataset.tab = `tab-${Date.now().toString(36)}-${i}`;
                }
            }

            const contentMap = new Map();
            contents.forEach(c => {
                if (c.dataset.tab) contentMap.set(c.dataset.tab, c);
            });
            const linkMap = new Map();
            links.forEach(l => {
                if (l.dataset.tab) linkMap.set(l.dataset.tab, l);
            });

            // Сохраняем конфигурацию для этого экземпляра табов
            const tabInstanceId = `tabs-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`;
            this.tabInstances[tabInstanceId] = {
                head,
                root,
                contents,
                links,
                contentMap,
                linkMap,
                prevArrow,
                nextArrow,
                splides: {},
                activeTab: head.querySelector('.detail-product__preview-tabs__link.active')?.dataset.tab || links[0]?.dataset.tab
            };

            this.initTabInstance(this.tabInstances[tabInstanceId]);
        });
    }

    // Инициализация конкретного экземпляра табов
    initTabInstance(instance) {
        const { contents, links, contentMap, prevArrow, nextArrow, splides, activeTab } = instance;

        // Функция для инициализации Splide
        const mountSplideFor = (tabName) => {
            if (!tabName) return null;
            if (splides[tabName]) return splides[tabName];

            const content = contentMap.get(tabName);
            if (!content) return null;

            const el = content.querySelector('.detail-product__preview-tabs__slider') || content.querySelector('.splide');
            if (!el) return null;

            const computed = window.getComputedStyle(content);
            const wasHidden = computed.display === 'none' || computed.visibility === 'hidden';
            const prev = {};
            if (wasHidden) {
                prev.display = content.style.display;
                prev.visibility = content.style.visibility;
                prev.position = content.style.position;
                prev.left = content.style.left;

                content.style.display = 'block';
                content.style.visibility = 'hidden';
                content.style.position = 'absolute';
                content.style.left = '-9999px';
            }

            const splideOptions = {
                type: 'loop',
                autoWidth: true,
                gap: 20,
                perMove: 1,
                pagination: false,
                arrows: false,
                breakpoints: { 992: { gap: 10 } }
            };

            const splideInstance = new Splide(el, splideOptions);
            splideInstance.mount();

            if (wasHidden) {
                content.style.display = prev.display || '';
                content.style.visibility = prev.visibility || '';
                content.style.position = prev.position || '';
                content.style.left = prev.left || '';
            }

            splides[tabName] = splideInstance;
            setTimeout(() => {
                try { splideInstance.refresh(); } catch (e) { /* ignore */ }
            }, 50);

            return splideInstance;
        };

        // Инициализация активного таба
        contents.forEach(c => {
            if (c.dataset.tab === activeTab) {
                c.classList.add('active');
                c.style.display = '';
                mountSplideFor(activeTab);
            } else {
                c.classList.remove('active');
                c.style.display = 'none';
            }
        });

        // Навешиваем обработчики на ссылки
        links.forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const tabName = this.dataset.tab;
                if (!tabName || tabName === instance.activeTab) return;

                // Снимаем active у ссылок и контентов
                links.forEach(l => l.classList.remove('active'));
                contents.forEach(c => {
                    c.classList.remove('active');
                    c.style.display = 'none';
                });

                // Активируем выбранные
                this.classList.add('active');
                const newContent = contentMap.get(tabName);
                if (newContent) {
                    newContent.classList.add('active');
                    newContent.style.display = '';
                    // Инициализируем / обновляем слайдер для этого таба
                    mountSplideFor(tabName);
                }

                instance.activeTab = tabName;
            });
        });

        // Стрелки управляют текущим активным слайдером
        if (prevArrow) {
            prevArrow.addEventListener('click', () => { 
                splides[instance.activeTab]?.go('<'); 
            });
        }
        if (nextArrow) {
            nextArrow.addEventListener('click', () => { 
                splides[instance.activeTab]?.go('>'); 
            });
        }

        instance.mountSplideFor = mountSplideFor;
    }

    //инициализация табов комплектации

    initEquipmentTabs() {
        const tabWidgets = document.querySelectorAll(".equipment-tabs");

        tabWidgets.forEach(widget => {
            const links = widget.querySelectorAll(".equipment-tabs__link");
            const contents = widget.querySelectorAll(".equipment-tabs__content");

            if (!links.length || !contents.length) return;


            const activateTab = (tabName) => {

                links.forEach(l => l.classList.remove("active"));
                contents.forEach(c => {
                    c.classList.remove("active");
                    c.style.display = "none";
                });


                const activeLink = widget.querySelector(`.equipment-tabs__link[data-tab="${tabName}"]`);
                const activeContent = widget.querySelector(`.equipment-tabs__content[data-tab="${tabName}"]`);

                if (activeLink) activeLink.classList.add("active");
                if (activeContent) {
                    activeContent.classList.add("active");
                    activeContent.style.display = "";
                }
            }


            links.forEach(link => {
                link.addEventListener("click", e => {
                    e.preventDefault();
                    const tabName = link.dataset.tab;
                    if (tabName) activateTab(tabName);
                });
            });

            // При загрузке активный таб берём из верстки
            const defaultActive = widget.querySelector(".equipment-tabs__link.active");
            if (defaultActive && defaultActive.dataset.tab) {
                activateTab(defaultActive.dataset.tab);
            } else {
                // если в разметке active не проставлен — открыть первый
                const first = links[0];
                if (first && first.dataset.tab) activateTab(first.dataset.tab);
            }
        });
    }

    // Переинициализация всех табов и слайдеров
    reinitTabsAndSliders() {
        Object.values(this.tabInstances).forEach(instance => {
            Object.values(instance.splides || {}).forEach(splide => {
                try {
                    splide.destroy();
                } catch (e) {
                    console.warn('Error destroying splide instance:', e);
                }
            });
        });

        this.splideInstances = {};
        this.tabInstances = {};

        this.initTabsAndSliders();
    }

    //инициализация и переинициализация главного слайдера
    mainGalleryInit() {
        if(!this.slider) return;
        //this.slider.forEach(slider => {
            if(this.slider) {
                const splide = new Splide(this.slider, {
                    type: 'slide',
                    perPage: 1,
                    gap: 0,
                    pagination: true,
                    arrows: false,
                    drag: false,
                }).mount();

                this.slider._splide = splide;

                const track = this.slider.querySelector('.splide__track');

                track.addEventListener('mousemove', e => {
                    const rect = track.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const width = rect.width;

                    const slidesCount = splide.length;
                    const hoverZone = 15;

                    let index = Math.floor((x / width) * slidesCount);

                    if (x < hoverZone) index = 0;
                    if (x > width - hoverZone) index = slidesCount - 1;

                    splide.go(index);
                });
            }

        //});
    }

    //инициализация слайдера рекомендаций
    recomendationsSliderInit() {
        if (!this.sliderRecomendations) return;

        let splide;

        const initSplide = () => {
            if (window.innerWidth <= 1500) {
                if (!splide) {
                    splide = new Splide(this.sliderRecomendations, {
                        type: 'loop',
                        autoWidth: true,
                        perMove: 1,
                        pagination: false,
                        arrows: false,
                        gap: 20,
                        breakpoints: {
                            700: {
                                gap: 10
                            }
                        }
                    });
                    splide.mount();
                    this.sliderRecomendations._splide = splide;
                }
            } else {
                if (splide) {
                    splide.destroy();
                    splide = null;
                }
            }
        }

        initSplide();


        window.addEventListener('resize', initSplide);


        const prevArrow = document.querySelector('.examples-arrow__prev');
        const nextArrow = document.querySelector('.examples-arrow__next');

        if (prevArrow) {
            prevArrow.addEventListener('click', () => splide?.go('<'));
        }
        if (nextArrow) {
            nextArrow.addEventListener('click', () => splide?.go('>'));
        }
    }

    //дополнительные постройки
    selectBubbles() {
        //document.querySelectorAll(".custom-select-bubbles-js").forEach(select => {
            const select = document.querySelector(".custom-select-bubbles-js");
            if(!select) return;
            const trigger = select.querySelector(".selected");
            const options = select.querySelectorAll(".options li");
            const bubblesContainer = select.querySelector(".selected-bubbles");

            let selectedValues = [];

            function updatePlaceholder() {
            if (selectedValues.length === 0) {
                trigger.textContent = "Выберите вариант";
            } else {
                trigger.textContent = `Выбрано ${selectedValues.length} ${getPluralForm(selectedValues.length, ['постройка', 'постройки', 'построек'])}`;
            }
            }

            function getPluralForm(n, forms) {
            const n10 = n % 10, n100 = n % 100;
            if (n10 === 1 && n100 !== 11) return forms[0];
            if (n10 >= 2 && n10 <= 4 && (n100 < 10 || n100 >= 20)) return forms[1];
            return forms[2];
            }

            trigger.addEventListener("click", (e) => {
            e.stopPropagation();
            select.classList.toggle("open");
            });

            options.forEach(option => {
            option.addEventListener("click", (e) => {
                e.stopPropagation();
                const value = option.dataset.value;
                const price = option.dataset.price;
                const deadline = option.dataset.deadline;
                const buildingObject = this.buildingsMap[option.dataset.value];
                if (option.classList.contains("active")) {
                // снять выбор
                removeValue(value);
                } else {
                // добавить выбор
                this.changePropertyWithBuildings('price', price, 'plus');
                this.changePropertyWithBuildings('deadline', deadline, 'plus');
                if(buildingObject) {
                    this.insertPlaneTabs(buildingObject, 'plus');
                    this.changeParametersForBuildings(buildingObject, 'plus');
                    this.insertBuildingsImagesTab(buildingObject, 'plus');
                }
                option.classList.add("active");
                const optionText = option.innerHTML;
                selectedValues.push({ value, text: optionText });

                const bubble = document.createElement("div");
                bubble.className = "bubble";
                bubble.dataset.value = value;
                bubble.dataset.price = price;
                bubble.dataset.deadline = deadline;
                bubble.innerHTML = `
                    <span class="bubble-text">${optionText}</span>
                    <button class="bubble-remove" type="button"><svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.00058 5.00291L8.49565 8.49797M1.50549 8.49797L5.00058 5.00291L1.50549 8.49797ZM8.49565 1.50781L5.00058 5.00291L8.49565 1.50781ZM5.00058 5.00291L1.50549 1.50781L5.00058 5.00291Z" stroke="#8E9293" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    </button>
                `;
                bubblesContainer.appendChild(bubble);

                bubble.querySelector(".bubble-remove").addEventListener("click", () => {
                    removeValue(value);
                });
                }

                updatePlaceholder();
            });
            });

            const removeValue = (value) =>  {
                const option = select.querySelector(`.options li[data-value="${value}"]`);
                if (option) option.classList.remove("active");

                selectedValues = selectedValues.filter(v => v.value !== value);

                const bubble = bubblesContainer.querySelector(`.bubble[data-value="${value}"]`);
                const optionPrice = bubble.dataset.price;
                const optionDeadline = bubble.dataset.deadline;
                this.changePropertyWithBuildings('price', optionPrice, 'min');
                this.changePropertyWithBuildings('deadline', optionDeadline, 'min');
                this.insertPlaneTabs(this.buildingsMap[bubble.dataset.value], 'min');
                this.changeParametersForBuildings(this.buildingsMap[bubble.dataset.value], 'min');
                this.insertBuildingsImagesTab(this.buildingsMap[bubble.dataset.value], 'min');
                if (bubble) bubble.remove();
                
                updatePlaceholder();
            };

            document.addEventListener("click", () => {
            select.classList.remove("open");
            });
        //});
    }

    //plane tabs
    renderPlaneTabs() {
        if(!this.planeLinks) return;
        this.planeLinks.addEventListener("click", (e) => {
            if (e.target.classList.contains("detail-product__layout-tabs__link")) {
                e.preventDefault();

                // убираем active у всех
                const allLinks = this.planeLinks.querySelectorAll(".detail-product__layout-tabs__link");
                const allPanes = this.planeTabs.querySelectorAll(".tab-pane");
                
                allLinks.forEach(l => l.classList.remove("active"));
                allPanes.forEach(p => p.classList.remove("active"));

                // активируем выбранный таб
                e.target.classList.add("active");
                const tabId = e.target.getAttribute("data-tab");
                const targetPane = this.planeTabs.querySelector(`.tab-pane[data-tab="${tabId}"]`);
                if (targetPane) {
                    targetPane.classList.add("active");
                }
            }
        });

        // Инициализируем активный таб
        this.updateActiveTab(
            this.planeLinks.querySelectorAll(".detail-product__layout-tabs__link"),
            this.planeTabs.querySelectorAll(".tab-pane")
        );
    }

    //инициализация блока аккордеонов (модифицирована для переинициализации)
    accInit() {
        document.addEventListener('click', (e) => {
            if (e.target.matches('.equipment-tabs__content-acc dt')) {
                const dt = e.target;
                const item = dt.closest('li');
                const dd = item.querySelector('dd');
                
                if (!item || !dd) return;
                
                const isActive = item.classList.contains('active');
                
                if (isActive) {
                    item.classList.remove('active');
                    dd.style.maxHeight = null;
                } else {
                    item.classList.add('active');
                    dd.style.maxHeight = dd.scrollHeight + 'px';
                }
            }
        });
    }

    refreshAccordions() {
        document.querySelectorAll('.equipment-tabs__content-acc li.active dd')
            .forEach(dd => {
                dd.style.maxHeight = dd.scrollHeight + 'px';
            });
    }


    /*  FRONT END */


    /*  MAIN BLOCK  */

    //достает доступные комбинации
    updateAvailability(clickedElement) {
        const clickedId = clickedElement.id;
        //console.log(clickedId);
        const combination = this.findMatchingOffer();
        
        if(clickedId) {
            if(!combination) {
                console.log('Вариация не найдена!');
                const availableCombinations = Object.keys(this.offersMap).filter(comb => 
                    comb.includes(clickedId)
                );
                const available = false;
                this.blockAnavaibleBubles(available);
                this.disableUnavailableElements(availableCombinations);
            } else {
                console.log('Вариация найдена!');
                const available = true;
                this.blockAnavaibleBubles(available);
                this.changeGallery(combination);
                this.changeProperty(combination,'price');
                this.changeProperty(combination,'deadline');
                this.toggleBtnBlock(available);
                this.changePlaneTabs(combination);
                this.changeParameters(combination);
                this.changeProjectImagesTabs(combination);
                this.changeComplectationTabs(combination);
                this.changeRecomendationBlock(combination);
            }
        }
    }

    //собирает ключ из выбранных id и ищет совпадения в объекте
    findMatchingOffer() {
        const selectedElements = [];
        
        const checkedRadios = document.querySelectorAll('input[type="radio"][name^="HOUSES_"]:checked');
        checkedRadios.forEach(radio => {
            selectedElements.push(radio.id);
        });
        
        const activeLiElements = document.querySelectorAll('li.HOUSES_OPTION.active');
        activeLiElements.forEach(li => {
            selectedElements.push(li.id);
        });
        
        const combinationKey = selectedElements.sort().join('|');
        //console.log(combinationKey);
        // Ищем в offersMap
        const matchingOffer = this.offersMap[combinationKey];
        
        return matchingOffer;
    }

    //блокирует характеристики, недоступные в найденных комбинациях
    disableUnavailableElements(availableCombinations) {
        document.querySelectorAll('input[type="radio"][name^="HOUSES_"]').forEach(radio => {
            const elementId = radio.id;
            if(elementId) {
                const isAvailable = availableCombinations.some(comb => comb.includes(elementId));
                const label = radio.closest('label');
                
                if (label) label.classList.toggle('noactive', !isAvailable);
                if (!isAvailable && radio.checked) radio.checked = false;
            }
        });
        
        document.querySelectorAll('li.HOUSES_OPTION').forEach(li => {
            const elementId = li.id;
            if(elementId) {
                const isAvailable = availableCombinations.some(comb => comb.includes(elementId));
            
                li.classList.toggle('noactive', !isAvailable);
                if (!isAvailable && li.classList.contains('active')) {
                    li.classList.remove('active');
                    li.closest('.custom-select-js').querySelector('.selected').textContent = 'Выберите площадь';
                    this.editBlock.querySelector('input[name="HOUSES_SQUARES"]').value = '';
                }

            }
        });
        this.checkMainConfig();
    }

    //раскрывает конфигурационный блок
    showMainConfig() {
        const viewBlock = document.querySelector(
            ".detail-product__mainscreen-config__items:not(.edit)"
        );

        if(!viewBlock) return;

        this.editBlock.classList.add("open");
        viewBlock.classList.add("hidden");
        this.toggleBtn.textContent = "Сохранить";
    }

    //проверяет что в блоке главных х-к выбраны х-ки
    checkMainConfig() {
        const allPropertiesSelected = 
            this.editBlock.querySelector('input[name="HOUSES_STYLE"]:checked') !== null &&
            this.editBlock.querySelector('input[name="HOUSES_FLOORS"]:checked') !== null &&
            this.editBlock.querySelector('input[name="HOUSES_SQUARES"]').value !== '';
        
        if(!allPropertiesSelected) {
            this.showMainConfig();
            //console.log(allPropertiesSelected);
            this.toggleBtnBlock(allPropertiesSelected);
        }
    }

    // блокирует кнопку "сохранить"
    toggleBtnBlock(available) {
        if (this.toggleBtn) {
           // console.log(available);
            this.toggleBtn.classList.toggle('noactive', !available);
        }
    }

    //блокирует блок доп.построек
    blockAnavaibleBubles(available) {
        if(!this.bubblesSelect) return;
        const select = document.querySelector(".custom-select-bubbles-js");
        const options = select.querySelectorAll(".options li");
        if(options) {
            options.forEach(option => {
                option.classList.toggle('noactive', !available);
            })
        }
    }

    /* MAIN BLOCK END   */

    /*  PRICE & DEADLINE    */

    //меняет срок и цену от доп.постройки
    changePropertyWithBuildings(type, property, action) {
        const properties = {
            price: {
                property: 'FORMATTED_PRICE',
                dataAttr: 'price',
                dataBuildings: 'buildings',
                finalDataAttr: 'finalPrice',
                suffix: ' ₽'
            },
            deadline: {
                property: 'DEADLINE',
                dataAttr: 'deadline',
                dataBuildings: 'buildingsdeadline',
                finalDataAttr: 'finalDeadline',
                suffix: ' дней'
            }
        };
        const config = properties[type];
        if (!config) {
            console.log('Неизвестный тип свойства:', type);
            return;
        }

        property = property === '' ? 0 : property;
        const element = type === 'price' ? this.price : this.deadline;

        let finalNumber = 0;
        if(action === 'plus') {
            finalNumber = Number(element.dataset[config.finalDataAttr]) + Number(property);
        } else if(action === 'min') {
            finalNumber = Number(element.dataset[config.finalDataAttr]) - Number(property);
        }

        element.textContent = finalNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ') + config.suffix;
        element.dataset[config.finalDataAttr] = finalNumber;
        if(!element.dataset[config.dataBuildings]) {
            //element.setAttribute([config.dataBuildings], property);
            element.dataset[config.dataBuildings] = property;
        } else {
            element.dataset[config.dataBuildings] = action === 'plus' ? Number(element.dataset[config.dataBuildings]) + Number(property) : Number(element.dataset[config.dataBuildings]) - Number(property);
        }
    }

    //меняет cрок и цену от вариации
    changeProperty(combination, type) {
        const properties = {
            price: {
                property: 'FORMATTED_PRICE',
                dataAttr: 'buildings',
                finalDataAttr: 'finalPrice',
                suffix: ' ₽',
                fallbackMessage: 'Цена не найдена в комбинации'
            },
            deadline: {
                property: 'DEADLINE',
                dataAttr: 'buildingsdeadline',
                finalDataAttr: 'deadline',
                suffix: ' дней',
                fallbackMessage: 'Срок не найден в комбинации'
            }
        };

        const config = properties[type];
        if (!config) {
            console.log('Неизвестный тип свойства:', type);
            return;
        }

        const element = type === 'price' ? this.price : this.deadline;
        //console.log('Price element:', this.price);

        if (!combination || !combination.PROPERTIES || !combination.PROPERTIES[config.property] || 
            !combination.PROPERTIES[config.property].VALUE) {
            console.log(config.fallbackMessage);
            return;
        }

        const newValue = combination.PROPERTIES[config.property].VALUE;
        if (!element.dataset[config.dataAttr] || element.dataset[config.dataAttr] === "0") {
            if (type === 'price') {
                const formattedValue = newValue.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
                element.textContent = formattedValue + config.suffix;
            } else {
                element.textContent = newValue + config.suffix;
            }
            element.dataset[config.finalDataAttr] = newValue;
        } else {
            const totalValue = Number(newValue) + Number(element.dataset[config.dataAttr]);
            element.dataset[config.finalDataAttr] = totalValue;
            
            if (type === 'price') {
                const formattedValue = totalValue.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
                element.textContent = formattedValue + config.suffix;
            } else {
                element.textContent = totalValue + config.suffix;
            }
        }
    }

    /*  PRICE & DEADLINE END    */


    //заменяет контент главной галереи
    changeGallery(combination) {
        if (!combination || !combination.PROPERTIES || !combination.PROPERTIES.GALLERY || 
            !combination.PROPERTIES.GALLERY.VALUE || !Array.isArray(combination.PROPERTIES.GALLERY.VALUE)) {
            console.log('❌ Галерея не найдена в комбинации');
            return;
        }
        
        const gallery = combination.PROPERTIES.GALLERY.VALUE;
        
        const track = this.slider.querySelector('.splide__track');
        const list = track?.querySelector('.splide__list');
        if (!list) return;
        
        if (this.slider._splide) {
            this.slider._splide.destroy();
            this.slider._splide = null;
        }
        list.innerHTML = '';
        
        gallery.forEach((image, index) => {
            const slide = document.createElement('li');
            slide.className = 'splide__slide detail__page-slider__image-item';
            
            slide.innerHTML = `
                <div class="detail__page-slider__image-layer"></div>
                <div class="detail__page-slider__image-description">
                    ${image.DESCRIPTION || ''}
                </div>
                <img src="${image.PATH}" alt="img ${index + 1}">
            `;
            
            list.appendChild(slide);
        });
        
        this.mainGalleryInit();
    }

    //удаляет предыдущие табы
    resetPlaneTabs() {
        const links = document.querySelectorAll('.detail-product__layout-tabs__link[data-type="house"]');
        const tabs = document.querySelectorAll('.tab-pane[data-type="house"]');

        if(links.length === 0 && tabs.length === 0) {
            return;
        }

        links.forEach(item => {
            item.remove();
        })
        tabs.forEach(item => {
            item.remove();
        })
    }

    //собирает блок плана постройки
    changePlaneTabs(combination) {
        if (!combination || !combination.PROPERTIES || !combination.PROPERTIES.PLANE || 
            !combination.PROPERTIES.PLANE.VALUE_ELEMENT || !Array.isArray(combination.PROPERTIES.PLANE.VALUE_ELEMENT)) {
            console.log('Планировки не найдены в комбинации');
            return;
        }

        this.resetPlaneTabs();
        const planes = combination.PROPERTIES.PLANE.VALUE_ELEMENT;
        let counter = 1;
        
        planes.forEach((element, index) => {

            this.createTab(element, counter, 'house');

            counter ++;
        })

        this.planeTabLinks = document.querySelectorAll(".detail-product__layout-tabs__link");
        this.planeTabPanes = document.querySelectorAll(".tab-pane");
        this.renderPlaneTabs();
    }

    //считает табы
    countTabs(links) {
        let counter = 1;
        if(links) {
            links.forEach(link => { counter ++; });
        }
        return counter;
    }

    //добавляет табы к текущим в плане постройки
    insertPlaneTabs(building, action) {
        if(building.UF_GALLERY.length <= 0) {
            return;
        }
        let counter = this.countTabs(this.planeTabLinks);
        
        if(action === 'plus') {
            this.createTab(building, counter, 'building', building.UF_XML_ID);

            this.planeTabLinks = document.querySelectorAll(".detail-product__layout-tabs__link");
            this.planeTabPanes = document.querySelectorAll(".tab-pane");
            
            // Используем общий метод
            this.updateActiveTab(this.planeTabLinks, this.planeTabPanes);
        } else {
            document.querySelector(`.detail-product__layout-tabs__link[data-building-id="${building.UF_XML_ID}"`).remove();
            document.querySelector(`.tab-pane[data-building-id="${building.UF_XML_ID}"`).remove();
            this.sortTabsByDataTab();
        }
    }
    
    //добавляет таб
    createTab(element, counter, type, buildingId = false) {
        //ссылка
        let link = document.createElement('a');
        let active = counter === 1 ? 'active' : '';
        let description = type === 'house' ? element.UF_DESCRIPTION : element.UF_NAME;
        let file = type === 'house' ? element.UF_FILE : element.UF_PLANE;

        link.classList.add('detail-product__layout-tabs__link');
        if (active) link.classList.add(active);
        link.textContent =  description;
        link.setAttribute('data-type', type);
        link.setAttribute('data-tab', counter.toString());
        if(buildingId) link.setAttribute('data-building-id', buildingId.toString());

        //таб
        let img = document.createElement('img');
        img.setAttribute('src', file);

        //fancy link
        let imgLink = document.createElement('a');
        imgLink.classList.add('detail-product__layout-tabs__image');
        imgLink.setAttribute('href', file);
        imgLink.setAttribute('data-fancybox','');

        let viewIcon = document.createElement('div');
        viewIcon.classList.add('detail-product__layout-tabs__image-view__icon');
        viewIcon.innerHTML = `
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.5 9.16667H9.16667H7.5ZM10.8333 9.16667H9.16667H10.8333ZM9.16667 9.16667V7.5V9.16667ZM9.16667 9.16667V10.8333Z" fill="#8E9293"></path>
                <path d="M9.16667 9.16667V10.8333M7.5 9.16667H9.16667H7.5ZM10.8333 9.16667H9.16667H10.8333ZM9.16667 9.16667V7.5V9.16667Z" stroke="#8E9293" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M13.3333 13.3359L16.6667 16.6693" stroke="#8E9293" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M3.33334 9.16927C3.33334 12.3909 5.94502 15.0026 9.16668 15.0026C10.7803 15.0026 12.2409 14.3474 13.2969 13.2886C14.3493 12.2334 15 10.7773 15 9.16927C15 5.94761 12.3883 3.33594 9.16668 3.33594C5.94502 3.33594 3.33334 5.94761 3.33334 9.16927Z" stroke="#8E9293" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        `;

        //tab
        let panel = document.createElement('div');
        panel.classList.add('tab-pane');
        if (active) panel.classList.add(active);
        panel.setAttribute('data-tab', counter.toString());
        if(buildingId) panel.setAttribute('data-building-id', buildingId.toString());

        imgLink.appendChild(img);
        imgLink.appendChild(viewIcon);
        panel.appendChild(imgLink);

        // Добавляем в DOM
        this.planeTabs.appendChild(panel);
        this.planeLinks.appendChild(link);
        this.sortTabsByDataTab();
    }

    //сортирует табы
    sortTabsByDataTab() {
        const linksArray = Array.from(this.planeLinks.querySelectorAll('.detail-product__layout-tabs__link'));
        const tabsArray = Array.from(this.planeTabs.querySelectorAll('.tab-pane'));
        
        const sortedLinks = linksArray.sort((a, b) => {
            return parseInt(a.dataset.tab) - parseInt(b.dataset.tab);
        });
        
        const sortedTabs = tabsArray.sort((a, b) => {
            return parseInt(a.dataset.tab) - parseInt(b.dataset.tab);
        });
        
        this.planeLinks.innerHTML = '';
        this.planeTabs.innerHTML = '';
        
        sortedLinks.forEach(link => {
            this.planeLinks.appendChild(link);
        });
        
        sortedTabs.forEach(tab => {
            this.planeTabs.appendChild(tab);
        });
        
        // Обновляем активный таб
        this.updateActiveTab(
            this.planeLinks.querySelectorAll('.detail-product__layout-tabs__link'),
            this.planeTabs.querySelectorAll('.tab-pane'),
            true
        );
    }

    //сбрасывает активность
    updateActiveTab(links, contents, forceFirstActive = false) {
        if (!links || !contents || links.length === 0 || contents.length === 0) return;
        
        const linksArray = Array.from(links);
        const contentsArray = Array.from(contents);
        
        // Убираем active у всех
        linksArray.forEach(link => link.classList.remove('active'));
        contentsArray.forEach(content => content.classList.remove('active'));
        
        let activeLink = null;
        let activeContent = null;
        
        if (!forceFirstActive) {
            // Пытаемся сохранить текущий активный таб, если он не скрыт
            activeLink = linksArray.find(link => 
                link.classList.contains('active') && !link.classList.contains('hidden')
            );
            
            if (activeLink) {
                const tabId = activeLink.dataset.tab;
                activeContent = contentsArray.find(content => 
                    content.dataset.tab === tabId && !content.classList.contains('hidden')
                );
            }
        }
        
        // Если активный таб не найден или невалиден, ищем первый не скрытый
        if (!activeLink || !activeContent) {
            // Находим первую не скрытую ссылку
            activeLink = linksArray.find(link => !link.classList.contains('hidden'));
            
            if (activeLink) {
                const tabId = activeLink.dataset.tab;
                activeContent = contentsArray.find(content => 
                    content.dataset.tab === tabId && !content.classList.contains('hidden')
                );
            }
        }
        
        if (activeLink && activeContent) {
            activeLink.classList.add('active');
            activeContent.classList.add('active');
            if(activeContent.style.display === 'none') activeContent.style.display = '';
            if(activeLink.style.display === 'none') activeLink.style.display = '';
        } else {
            console.warn('No suitable active tab found');
        }
        
        return { activeLink, activeContent };
    }

    //меняет мелочь по типу площади размеров итп
    changeParameters(combination) {
        if (!combination || !combination.PROPERTIES) {
            return;
        }

        let parameters = document.querySelectorAll('.detail-product__layout-spec__item-value');
        parameters.forEach(parameter => {
            parameter.textContent = '-';

            if(parameter.classList.contains('square-value') && combination.PROPERTIES?.HOUSES_SQUARES?.VALUE_ELEMENT?.UF_DESCRIPTION) {
                parameter.textContent = combination.PROPERTIES?.HOUSES_SQUARES?.VALUE_ELEMENT?.UF_DESCRIPTION;
            }
            if(parameter.classList.contains('size-value') && combination.PROPERTIES?.SIZES?.VALUE) {
                parameter.textContent = combination.PROPERTIES?.SIZES?.VALUE;
            }
            if(parameter.classList.contains('height-value') && combination.PROPERTIES?.HEIGHT?.VALUE) {
                parameter.textContent = combination.PROPERTIES?.HEIGHT?.VALUE;
            }
        })
        let rooms = document.querySelectorAll('.detail-product__layout-additional-option__component-value-house');
        rooms.forEach(room => {
            room.textContent = '-';

            if(room.classList.contains('rooms-value') && combination.PROPERTIES?.ROOMS?.VALUE) {
                room.textContent = combination.PROPERTIES?.ROOMS?.VALUE;
            }
            if(room.classList.contains('storages-value') && combination.PROPERTIES?.STORAGE?.VALUE) {
                room.textContent = combination.PROPERTIES?.STORAGE?.VALUE;
            }
            if(room.classList.contains('wcs-value') && combination.PROPERTIES?.WCS?.VALUE) {
                room.textContent = combination.PROPERTIES?.WCS?.VALUE;
            }
        })
    }

    //меняет параметры построек
    changeParametersForBuildings(building, action) {
        const buildingParametersWrapper = document.querySelector('.detail-product__layout-additional-option-buildings');

        if(buildingParametersWrapper) {
            let componentsInner = buildingParametersWrapper.querySelector('.detail-product__layout-additional-option__components');
            if(action === 'plus') {
                let buildingComponent = document.createElement('div');
                buildingComponent.classList.add('detail-product__layout-additional-option__component');
                buildingComponent.dataset.building = building.UF_XML_ID;

                let title = document.createElement('div');
                title.classList.add('detail-product__layout-additional-option__component-name');
                title.innerHTML = `<span>${building.UF_NAME}</span>`;

                let separator = document.createElement('div');
                separator.classList.add('detail-product__layout-additional-option__component-devider');

                let value = document.createElement('div');
                value.classList.add('detail-product__layout-additional-option__component-value');
                value.classList.add('detail-product__layout-additional-option__component-value-building');
                value.innerHTML = `${building.UF_SQUARE} м<sup>2</sup>`;

                buildingComponent.appendChild(title);
                buildingComponent.appendChild(separator);
                buildingComponent.appendChild(value);

                componentsInner.appendChild(buildingComponent);

                if(buildingParametersWrapper.classList.contains('hidden')) buildingParametersWrapper.classList.remove('hidden');
            } else {
                buildingParametersWrapper.querySelector(`.detail-product__layout-additional-option__component[data-building="${building.UF_XML_ID}"]`).remove();
                
                if(buildingParametersWrapper.querySelectorAll('.detail-product__layout-additional-option__component').length <= 0) {
                    buildingParametersWrapper.classList.add('hidden');
                }
            }
        }
    }

    //меняет контент табов с галереей и аккордеонами
    changeTabsContent(combination, config) {
        const properties = combination.PROPERTIES;
        if (!properties) return;

        const {
            tabLinksSelector,
            tabContentsSelector,
            contentPropertyFilter,
            getContentData,
            updateContent
        } = config;

        const allTabLinks = document.querySelectorAll(tabLinksSelector);
        const allTabContents = document.querySelectorAll(tabContentsSelector);

        Object.values(properties).forEach(property => {
            const code = property.CODE;
            if (!code || !contentPropertyFilter(code)) return;

            const propertyTabWrapper = document.querySelector(`${tabContentsSelector}[data-property="${code}"]`);
            if (!propertyTabWrapper) return;

            const tabLink = document.querySelector(`${tabLinksSelector}[data-tab="${propertyTabWrapper.dataset.tab}"]`);
            const contentData = getContentData(property, properties);

            if (!contentData.hasContent) {
                propertyTabWrapper.classList.add('hidden');
                if (tabLink) tabLink.classList.add('hidden');
            } else {
                propertyTabWrapper.classList.remove('hidden');
                if (tabLink) tabLink.classList.remove('hidden');
                
                // Обновляем содержимое таба
                updateContent(propertyTabWrapper, contentData);
            }
        });

        // Обновляем активный таб
        this.updateActiveTab(allTabLinks, allTabContents);
        
        this.reinitTabsAndSliders();
    }

    // обертка для табов с галереей
    changeProjectImagesTabs(combination) {
        this.changeTabsContent(combination, {
            tabLinksSelector: '.detail-product__preview-tabs__link',
            tabContentsSelector: '.detail-product__preview-tabs__content',
            contentPropertyFilter: (code) => code.includes("_IMAGES"),
            getContentData: (property) => ({
                hasContent: property.VALUE && Array.isArray(property.VALUE),
                gallery: property.VALUE,
                code: property.CODE
            }),
            updateContent: (tabWrapper, contentData) => {
                this.updateGalleryContent(tabWrapper, contentData.gallery, contentData.code);
            }
        });
    }

    //обертка для табов с аккордеоном
    changeComplectationTabs(combination) {
        this.changeTabsContent(combination, {
            tabLinksSelector: '.equipment-tabs__link',
            tabContentsSelector: '.equipment-tabs__content',
            contentPropertyFilter: (code) => code.includes("_CONFIG"),
            getContentData: (property, allProperties) => {
                const imagePropertyCode = property.CODE.replace('_CONFIG', '_IMG');
                const imageProperty = allProperties[imagePropertyCode];
                const content = this.decodeHTML(property.VALUE);
                
                return {
                    hasContent: !!content,
                    content: content,
                    imageProperty: imageProperty
                };
            },
            updateContent: (tabWrapper, contentData) => {
                console.log(tabWrapper);
                tabWrapper.querySelector('.equipment-tabs__content-inner .equipment-tabs__content-acc').innerHTML = contentData.content;
                if (contentData.imageProperty && contentData.imageProperty?.VALUE) {
                    let tabsImg = tabWrapper.querySelector('.equipment-tabs__content-image img');
                    if(!tabsImg) {
                        let tabsImgEl = document.createElement('div');
                        tabsImgEl.classList.add('equipment-tabs__content-image');
                        tabsImgEl.innerHTML = `<img src="${contentData.imageProperty.VALUE}" alt="img">`;
                        tabWrapper.querySelector('.equipment-tabs__content-inner').appendChild(tabsImgEl);
                        console.log(tabsImgEl);
                    } else {
                        tabWrapper.querySelector('.equipment-tabs__content-image img').src = contentData.imageProperty.VALUE;
                    }
                }
                this.accInit();
            }
        });
        this.initEquipmentTabs();
    }

    decodeHTML(htmlString) {
        const textarea = document.createElement('textarea');
        textarea.innerHTML = htmlString;
        return textarea.value;
    }

    //обновляет контент галереи
    updateGalleryContent(tabWrapper, gallery, code) {
        const track = tabWrapper.querySelector('.splide__track');
        const list = track?.querySelector('.splide__list');
        if (!list) return;

        list.innerHTML = '';
        
        gallery.forEach((image, index) => {
            let image_path = '';
            if(code) {
                image_path = image.PATH;
            } else {
                image_path = image;
            }
            const slide = document.createElement('li');
            slide.className = 'splide__slide';
            
            slide.innerHTML = `
                <img src="${image_path}" alt="img ${index + 1}">
            `;
            
            list.appendChild(slide);
        });
    }
    
    //добавляет галереи доп построек
    insertBuildingsImagesTab(building, action) {
        const buildingGallery = building.UF_GALLERY;
        if(buildingGallery.length > 0) {
            let counter = this.countTabs(document.querySelectorAll('.detail-product__preview-tabs__link'));

            if(action === 'plus') {
                const linksWrapper = document.querySelector('.detail-product__preview-tabs__links');
                const allTabs = document.querySelectorAll('.detail-product__preview-tabs__content');
                const lastElement = allTabs[allTabs.length - 1];

                //ссылка
                let link = document.createElement('a');
                link.setAttribute('href', 'javascript:void(0)');
                link.classList.add('detail-product__preview-tabs__link');
                link.dataset.type = 'building';
                link.dataset.tab = counter;
                link.textContent = building.UF_NAME;

                let tab = document.createElement('div');
                tab.classList.add('detail-product__preview-tabs__content');
                tab.dataset.type = 'building';
                tab.dataset.tab = counter;
                tab.dataset.property = building.UF_XML_ID;
                tab.innerHTML = `<div class="splide detail-product__preview-tabs__slider">
                                    <div class="splide__track">
                                        <ul class="splide__list">
                                        </ul>
                                    </div>
                                </div>`;
                this.updateGalleryContent(tab, buildingGallery, false);
                
                linksWrapper.appendChild(link);
                lastElement.parentNode.insertBefore(tab, lastElement.nextSibling);
            } else {
                let tab = document.querySelector(`.detail-product__preview-tabs__content[data-property="${building.UF_XML_ID}"]`);
                let link = document.querySelector(`.detail-product__preview-tabs__link[data-tab="${tab.dataset.tab}"]`);

                if(tab && link) {
                    tab.remove();
                    link.remove();
                }
                this.updateActiveTab(
                    document.querySelectorAll(".detail-product__preview-tabs__link"),
                    document.querySelectorAll(".detail-product__preview-tabs__content")
                );
            }
        }
        this.reinitTabsAndSliders();
    }

    //меняет блок рекомендаций
    changeRecomendationBlock(combination) {

        const recomendationsSection = document.querySelector('.examples');
        if(!combination?.PROPERTIES || !combination?.PROPERTIES?.PROJECTS || !combination?.PROPERTIES?.PROJECTS?.VALUE_ELEMENTS) {
            recomendationsSection.classList.add('hidden');
            return;
        }

        const projects = combination.PROPERTIES.PROJECTS.VALUE_ELEMENTS;

        if(projects) {
            if(recomendationsSection.classList.contains('hidden')) recomendationsSection.classList.remove('hidden');
            const track = this.sliderRecomendations.querySelector('.splide__track');
            const list = track?.querySelector('.splide__list');
            if (!list) return;
            
            if (this.sliderRecomendations._splide) {
                this.sliderRecomendations._splide.destroy();
                this.sliderRecomendations._splide = null;
            }
            list.innerHTML = '';
            projects.forEach(project => {
                let projectCard = document.createElement('div');
                projectCard.classList.add('splide__slide', 'examples-item', 'projects-item');

                let gallery = project.PROPERTY_GALLERY_VALUE;
                if(gallery && gallery.length > 0) {
                    let projectImages = document.createElement('div');
                    projectImages.classList.add('splide', 'projects-slider__images');

                    let track = document.createElement('div');
                    track.classList.add('splide__track');

                    let list = document.createElement('ul');
                    list.classList.add('splide__list', 'projects-slider__image-items');

                    gallery.forEach((imgSrc, index) => {
                        const listItem = document.createElement('li');
                        listItem.className = 'splide__slide projects-slider__image-item';
                        
                        const img = document.createElement('img');
                        img.src = imgSrc;
                        img.alt = `project-image-${index + 1}`;
                        
                        listItem.appendChild(img);
                        list.appendChild(listItem);
                    })

                    track.append(list);
                    projectImages.append(track);
                    projectCard.appendChild(projectImages);

                    const projectsSlider = new ProjectsSlider(projectImages);
                    projectsSlider.reinit();
                } else {
                    let noimageEl = document.createElement('div');
                    noimageEl.classList.add('catalog-item__no-images');
                    noimageEl.innerHTML = `<img src="/local/templates/houses/assets/img/no-photo.jpg" alt="not-image">`;
                    projectCard.appendChild(noimageEl);
                }

                let projectBody = document.createElement('div');
                projectBody.classList.add('projects-item__body');
                projectBody.innerHTML = `<div class="projects-item__name">
                                            ${project.NAME}
                                        </div>
                                        <div class="projects-item__description">
                                            ${project.PREVIEW_TEXT}
                                        </div>
                                        <div class="projects-item__specs">
                                            ${project.PROPERTY_HOUSES_SQUARES_VALUE?.length > 0 ? `
                                                <div class="projects-item__spec">
                                                    <div class="projects-item__spec-name">
                                                        Площадь
                                                    </div>
                                                    <div class="projects-item__spec-value">
                                                        ${project.PROPERTY_HOUSES_SQUARES_VALUE[0]} м<sup>2</sup>
                                                    </div>
                                                </div>
                                            ` : ''}
                                            ${project.PROPERTY_HOUSES_SIZES_VALUE?.length > 0 ? `
                                                <div class="projects-item__spec">
                                                    <div class="projects-item__spec-name">
                                                        Размер
                                                    </div>
                                                    <div class="projects-item__spec-value">
                                                        ${project.PROPERTY_HOUSES_SIZES_VALUE[0]} м
                                                    </div>
                                                </div>
                                            ` : ''}
                                            ${project.PROPERTY_HOUSES_ROOMS_VALUE?.length > 0 ? `
                                                <div class="projects-item__spec">
                                                    <div class="projects-item__spec-name">
                                                        Комнаты
                                                    </div>
                                                    <div class="projects-item__spec-value">
                                                        ${project.PROPERTY_HOUSES_ROOMS_VALUE[0]}
                                                    </div>
                                                </div>
                                            ` : ''}
                                        </div>
                                    `;
                projectCard.appendChild(projectBody);
                list.appendChild(projectCard);
            })
            this.recomendationsSliderInit();
        }
    }

}