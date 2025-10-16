(function () {
	'use strict';

	if (!!window.JCCatalogSectionComponent)
		return;

	window.JCCatalogSectionComponent = function (params) {
		this.formPosting = false;
		this.siteId = params.siteId || '';
		this.ajaxId = params.ajaxId || '';
		this.template = params.template || '';
		this.componentPath = params.componentPath || '';
		this.parameters = params.parameters || '';

		if (params.navParams) {
			this.navParams = {
				NavNum: params.navParams.NavNum || 1,
				NavPageNomer: parseInt(params.navParams.NavPageNomer) || 1,
				NavPageCount: parseInt(params.navParams.NavPageCount) || 1
			};
		}

		this.bigData = params.bigData || { enabled: false };
		//модифицировано
		this.container = document.querySelector('[data-entity="items-row"]');
		this.more_container = document.querySelector('.show-more-container');
		this.showMoreButton = null;
		this.showMoreButtonMessage = null;

		if (this.bigData.enabled && BX.util.object_keys(this.bigData.rows).length > 0) {
			BX.cookie_prefix = this.bigData.js.cookiePrefix || '';
			BX.cookie_domain = this.bigData.js.cookieDomain || '';
			BX.current_server_time = this.bigData.js.serverTime;

			BX.ready(BX.delegate(this.bigDataLoad, this));
		}

		if (params.initiallyShowHeader) {
			BX.ready(BX.delegate(this.showHeader, this));
		}

		if (params.deferredLoad) {
			BX.ready(BX.delegate(this.deferredLoad, this));
		}

		if (params.lazyLoad) {
			this.showMoreButton = document.querySelector('[data-use="show-more-' + this.navParams.NavNum + '"]');
			this.showMoreButtonMessage = this.showMoreButton.innerHTML;
			BX.bind(this.showMoreButton, 'click', BX.proxy(this.showMore, this));
		}
	};

	window.JCCatalogSectionComponent.prototype =
	{
		checkButton: function () {
			if (this.showMoreButton) {
				if (this.navParams.NavPageNomer == this.navParams.NavPageCount) {
					BX.remove(this.showMoreButton);
				}
				else {
					this.more_container.appendChild(this.showMoreButton);
				}
			}
		},

		enableButton: function () {
			if (this.showMoreButton) {
				BX.removeClass(this.showMoreButton, 'disabled');
				this.showMoreButton.innerHTML = this.showMoreButtonMessage;
			}
		},

		disableButton: function () {
			if (this.showMoreButton) {
				BX.addClass(this.showMoreButton, 'disabled');
				this.showMoreButton.innerHTML = BX.message('BTN_MESSAGE_LAZY_LOAD_WAITER');
			}
		},
		showMore: function () {
			if (this.navParams.NavPageNomer < this.navParams.NavPageCount) {
				var data = {};
				data['action'] = 'showMore';
				data['PAGEN_' + this.navParams.NavNum] = this.navParams.NavPageNomer + 1;

				if (!this.formPosting) {
					this.formPosting = true;
					this.disableButton();
					this.sendRequest(data);
				}
			}
		},

		bigDataLoad: function () {
			// need remove all use this method
		},

		deferredLoad: function () {
			this.sendRequest({ action: 'deferredLoad' });
		},

		sendRequest: function (data) {
			var defaultData = {
				siteId: this.siteId,
				template: this.template,
				parameters: this.parameters
			};

			if (this.ajaxId) {
				defaultData.AJAX_ID = this.ajaxId;
			}

			BX.ajax({
				url: this.componentPath + '/ajax.php' + (document.location.href.indexOf('clear_cache=Y') !== -1 ? '?clear_cache=Y' : ''),
				method: 'POST',
				dataType: 'json',
				timeout: 60,
				data: BX.merge(defaultData, data),
				onsuccess: BX.delegate(function (result) {
					if (!result || !result.JS)
						return;
					BX.ajax.processScripts(
						BX.processHTML(result.JS).SCRIPT,
						false,
						BX.delegate(function () { this.showAction(result, data); }, this)
					);
				}, this)
			});
		},

		showAction: function (result, data) {
			if (!data)
				return;

			switch (data.action) {
				case 'showMore':
					this.processShowMoreAction(result);
					break;
				case 'deferredLoad':
					this.processDeferredLoadAction(result, data.bigData === 'Y');
					break;
			}
		},

		processShowMoreAction: function (result) {
			this.formPosting = false;
			this.enableButton();

			if (result) {
				this.navParams.NavPageNomer++;
				this.processItems(result.items);
				//this.processPagination(result.pagination);
				this.processEpilogue(result.epilogue);
				this.checkButton();
			}
		},

		processDeferredLoadAction: function (result, bigData) {
			if (!result)
				return;

			var position = bigData ? this.bigData.rows : {};

			this.processItems(result.items, BX.util.array_keys(position));
		},

		processItems: function (itemsHtml, position) {
			if (!itemsHtml)
				return;

			if (!this.container) {
				console.error('Container not found');
				return;
			}

			var processed = BX.processHTML(itemsHtml, false),
				temporaryNode = BX.create('DIV');

			var items, k, origRows;

			temporaryNode.innerHTML = processed.HTML;
			items = temporaryNode.querySelectorAll('[data-entity="item"]');

			if (items.length) {
				//this.showHeader(true);
				for (var k = 0; k < items.length; k++) {
					if (items[k] && this.container) {
						items[k].style.opacity = 0;

						this.container.appendChild(items[k]);
					}
				}
				new BX.easing({
					duration: 2000,
					start: { opacity: 0 },
					finish: { opacity: 100 },
					transition: BX.easing.makeEaseOut(BX.easing.transitions.quad),
					step: function (state) {
						for (var k in items) {
							if (items.hasOwnProperty(k)) {
								items[k].style.opacity = state.opacity / 100;
							}
						}
					},
					complete: function () {
						for (var k in items) {
							if (items.hasOwnProperty(k)) {
								items[k].removeAttribute('style');
							}
						}
					}
				}).animate();
			}
			BX.ajax.processScripts(processed.SCRIPT);
		},
		processEpilogue: function (epilogueHtml) {
			if (!epilogueHtml)
				return;

			var processed = BX.processHTML(epilogueHtml, false);
			BX.ajax.processScripts(processed.SCRIPT);
		},

		showHeader: function (animate) {
			var parentNode = BX.findParent(this.container, { attr: { 'data-entity': 'parent-container' } }),
				header;

			if (parentNode && BX.type.isDomNode(parentNode)) {
				header = parentNode.querySelector('[data-entity="header"]');

				if (header && header.getAttribute('data-showed') != 'true') {
					header.style.display = '';

					if (animate) {
						new BX.easing({
							duration: 2000,
							start: { opacity: 0 },
							finish: { opacity: 100 },
							transition: BX.easing.makeEaseOut(BX.easing.transitions.quad),
							step: function (state) {
								header.style.opacity = state.opacity / 100;
							},
							complete: function () {
								header.removeAttribute('style');
								header.setAttribute('data-showed', 'true');
							}
						}).animate();
					}
					else {
						header.style.opacity = 100;
					}
				}
			}
		}
	};
})();