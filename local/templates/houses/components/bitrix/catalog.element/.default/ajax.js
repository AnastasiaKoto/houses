class HouseVariationManager {
    constructor() {
        this.offersMap = window.OFFERS_DATA || {};
        this.selectedValues = {};
        this.propertyGroups = {};
        this.toggleBtn = null;
        this.editBlock = null;
        this.slider = null;
        this.price = null;
        
        this.init();
    }

    init() {
        this.toggleBtn = document.querySelector(".detail-product__mainscreen-config__head-change");
        this.editBlock = document.querySelector(
            ".detail-product__mainscreen-config__items.edit"
        );
        this.slider = document.querySelector('.detail__page-slider__images');
        this.price = document.querySelector('.detail-product__mainscreen-total__item-price');
        this.deadline = document.querySelector('.detail-product__mainscreen-total__item-date');
        this.bubblesSelect = document.querySelector(".custom-select-bubbles-js");
        this.options = this.bubblesSelect.querySelectorAll(".options li");
        this.bindEvents();
    }

    //вешает обработчики
    bindEvents() {
        document.addEventListener('change', (e) => {
            if (e.target.type === 'radio' && e.target.name.startsWith('HOUSES_')) {
                this.updateAvailability(e.target);
            }
        });
        document.addEventListener('click', (e) => {
            if (e.target.className.includes('HOUSES_')) {
                this.updateAvailability(e.target);
            }
        });
        document.addEventListener('DOMContentLoaded', () => {
            this.mainGalleryInit();
            this.selectBubbles();
        });

    }


    /*  FRONT START */
    //инициализация и переинициализация слайдера
    mainGalleryInit() {
        //this.slider.forEach(slider => {
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

        //});
    }

    //дополнительные постройки
    selectBubbles() {
        //document.querySelectorAll(".custom-select-bubbles-js").forEach(select => {
            const select = document.querySelector(".custom-select-bubbles-js");
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

                if (option.classList.contains("active")) {
                // снять выбор
                removeValue(value);
                } else {
                // добавить выбор
                //this.changePriceWithBuildings(price, 'plus');
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
                //this.changePriceWithBuildings(optionPrice, 'min');
                if (bubble) bubble.remove();
                
                updatePlaceholder();
            };

            document.addEventListener("click", () => {
            select.classList.remove("open");
            });
        //});
    }


    /*  FRONT END */

    //достает доступные комбинации
    updateAvailability(clickedElement) {
        const clickedId = clickedElement.id;
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
            console.log(allPropertiesSelected);
            this.toggleBtnBlock(allPropertiesSelected);
        }
    }

    // блокирует кнопку "сохранить"
    toggleBtnBlock(available) {
        if (this.toggleBtn) {
            console.log(available);
            this.toggleBtn.classList.toggle('noactive', !available);
        }
    }

    //блокирует блок доп.построек
    blockAnavaibleBubles(available) {
        const select = document.querySelector(".custom-select-bubbles-js");
        const options = select.querySelectorAll(".options li");
        if(options) {
            options.forEach(option => {
                option.classList.toggle('noactive', !available);
            })
        }
    }

    //заменяет контент галереи
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

    /*
    //добавляет к цене стоимость постройки
    changePriceWithBuildings(buildingPrice, action) {
        let finalPrice = 0;
        if(action === 'plus') {
            finalPrice = Number(this.price.dataset.finalPrice) + Number(buildingPrice);
        } else if(action === 'min') {
            finalPrice = Number(this.price.dataset.finalPrice) - Number(buildingPrice);
        }

        this.price.textContent = finalPrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ') + ' ₽';
        this.price.dataset.finalPrice = finalPrice;
        if(!this.price.dataset.buildings) {
            this.price.setAttribute('data-buildings', buildingPrice);
        } else {
            this.price.dataset.buildings = action === 'plus' ? Number(this.price.dataset.buildings) + Number(buildingPrice) : Number(this.price.dataset.buildings) - Number(buildingPrice);
        }
    }
    */

    //меняет срок и цену от доп.постройки
    changePropertyWithBuildings(property, action) {
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
                dataAttr: 'buildingsDeadline',
                finalDataAttr: 'deadline',
                suffix: ' дней',
                fallbackMessage: 'Срок не найден в комбинации'
            }
        };
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
                dataAttr: 'buildingsDeadline',
                finalDataAttr: 'deadline',
                suffix: ' дней',
                fallbackMessage: 'Срок не найден в комбинации'
            }
        };

        const config = properties[type];
        if (!config) {
            console.log('❌ Неизвестный тип свойства:', type);
            return;
        }

        const element = type === 'price' ? this.price : this.deadline;

        if (!combination || !combination.PROPERTIES || !combination.PROPERTIES[config.property] || 
            !combination.PROPERTIES[config.property].VALUE) {
            console.log('❌', config.fallbackMessage);
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
}