jQuery(function ($) {
    class MainMenu {
        constructor(e) {
            this.$menu = $(e);
            this.$expandableMenu = this.$menu.find(".menu-hover");
            this.$leftMenu = this.$expandableMenu.find(".left-menu");
            this.$rightMenu = this.$expandableMenu.find(".right-menu");
            this.$seeMore = this.$expandableMenu.find(".see-more");
            this.$mainLinks = this.$menu.find(".main-menu-wrapper > div > ul > li");
        }

        init() {
            this.changeLinks();
            this.handleMouseLeave();
            this.$mainLinks.each((index, element) => {
                this.handleCategories($(element));
            });
        }

        changeLinks() {
            this.$menu.find(".main-menu-wrapper a").replaceWith(function () {
                const a = $(this);
                if (!a.attr("href") || a.attr("href") == "#") {
                    return "<span>" + a.html() + "</span>";
                }

                return a;
            });
        }

        handleCategories(category) {
            const subcategories = category.find("> ul > li").clone();
            if (subcategories.length < 1) {
                category.on("mouseover", () => {
                    this.$expandableMenu.stop().hide();
                    this.$mainLinks.removeClass("active");
                    this.resetData();
                });

                return;
            }

            category.hover(
                () => {
                    this.resetData();
                    this.$mainLinks.removeClass("active");
                    this.$seeMore.hide();

                    if (category.attr("id") === this.$leftMenu.data("id")) {
                        return;
                    }

                    category.addClass("active");
                    this.$expandableMenu.stop().hide();
                    this.$leftMenu.html("").data("id", category.attr("id"));
                    this.$rightMenu.find(".wrapper").html("");
                    this.$leftMenu.append(subcategories);
                    this.$leftMenu.find("> li").each((index, element) => {
                        this.handleSubCategories($(element));
                    });

                    setTimeout(() => {
                        this.$expandableMenu.stop().show();
                    }, 100);
                },
                () => {}
            );
        }

        handleMouseLeave() {
            this.$menu.on("mouseleave", () => {
                this.$expandableMenu.stop().hide();
                this.$mainLinks.removeClass("active");
                this.$seeMore.hide();
                this.resetData();
            });
        }

        handleSubCategories(subCategory) {
            const subsubcategoryItems = subCategory.find("> ul > li").clone();
            if (subsubcategoryItems.length >= 1) {
                subCategory.addClass("arrow");
            }

            subCategory.hover(
                () => {
                    this.$seeMore.hide();
                    if (subCategory.attr("id") === this.$rightMenu.data("id")) {
                        return;
                    }
                    this.$rightMenu.find(".wrapper").html("").hide();
                    this.$rightMenu.data("id", subCategory.attr("id"));
                    if (subsubcategoryItems.length > 5) {
                        this.$seeMore.fadeIn();
                        if (subsubcategoryItems.length > 10) {
                            const rest = Math.ceil(subsubcategoryItems.slice(5).length / 2);
                            subsubcategoryItems
                                .clone()
                                .slice(0, 5)
                                .appendTo(this.$rightMenu.find(".wrapper"))
                                .wrapAll("<div/>");
                            subsubcategoryItems
                                .clone()
                                .slice(5, 5 + rest)
                                .appendTo(this.$rightMenu.find(".wrapper"))
                                .wrapAll("<div/>");
                            subsubcategoryItems
                                .clone()
                                .slice(5 + rest)
                                .appendTo(this.$rightMenu.find(".wrapper"))
                                .wrapAll("<div/>");
                        } else {
                            subsubcategoryItems
                                .clone()
                                .slice(0, 5)
                                .appendTo(this.$rightMenu.find(".wrapper"))
                                .wrapAll("<div/>");
                            subsubcategoryItems
                                .clone()
                                .slice(5)
                                .appendTo(this.$rightMenu.find(".wrapper"))
                                .wrapAll("<div/>");
                        }

                        this.$seeMore.on("click", () => {
                            this.$rightMenu.find(".wrapper div").fadeIn();
                            this.$seeMore.hide();
                        });

                        this.$rightMenu.find(".wrapper").fadeIn();
                    } else {
                        this.$seeMore.hide();
                        this.$rightMenu
                            .find(".wrapper")
                            .append(subsubcategoryItems)
                            .wrapInner("<div></div>")
                            .fadeIn();
                    }
                },
                () => { }
            );
        }

        resetData() {
            this.$leftMenu.data("id", "");
            this.$rightMenu.data("id", "");
        }
    }

    class MainMenuMobile {
        constructor(e) {
            this.$menu = $(e);
            this.$expandableMenu = $('.mobile-expandable-menu');
            this.$menuList = this.$expandableMenu.find('.menu-list');
            this.$hamburger = this.$menu.find('.hamburger');
            this.$closeBtn = this.$expandableMenu.find('.close-button');
            this.$aple = $('body .bg-aple');
            this.$append = this.$expandableMenu.find('.menu-append-list').first();
            this.$appendSub = this.$expandableMenu.find('.menu-append-list').eq(1);
            this.$appendList = this.$append.find('.list');
            this.$appendListSub = this.$appendSub.find('.list');
            this.$activeItem = this.$expandableMenu.find('.mob-ex-header .title');
            this.$goBack = this.$append.find('.go-back');
            this.$goBackSub = this.$appendSub.find('.go-back');
            this.$appendContent = null;
            this.$activeItemContent = null;
        }

        init() {
            this.changeLinks();
            this.handleHamburger();
            this.handleCloseButton();
            this.handleItems();
            this.handleReturn();
        }

        handleItems() {
            const mainItems = this.$menuList.find('> div > ul > li');
            mainItems.each((index, element) => {
                const mainItem = $(element);
                const subItems = mainItem.find('> ul > li');

                if (subItems.length < 1) {
                    return;
                }

                mainItem.addClass('arrow');
                mainItem.on('click', (e) => {
                    this.$appendList.html("").append(subItems.clone());
                    this.$activeItem.html(mainItem.find('> span, > a').clone().text());
                    setTimeout(() => {
                        this.$append.addClass('scroll');
                    }, 10)
                    this.handleSubItems();
                });
            });
        }

        handleSubItems() {
            const items = this.$appendList.find('li');
            items.each((index, element) => {
                const item = $(element);
                const subItems = item.find('> ul > li');

                if (subItems.length < 1) {
                    return;
                }

                item.addClass('arrow');
                item.on('click', () => {
                    this.$appendContent = this.$appendList.find('> li').clone(true, true);
                    this.$activeItemContent = this.$activeItem.html();

                    this.$appendListSub.html("").append(subItems.clone());
                    this.$appendSub.addClass('scroll');
                    this.$activeItem.html(item.find('> span, > a').clone().text());
                })
            });
        }

        handleReturn() {
            this.$goBack.on('click', () => {
                this.$activeItem.html(this.$activeItem.data('default'));
                this.$append.removeClass('scroll');
            });

            this.$goBackSub.on('click', () => {
                this.$appendSub.removeClass('scroll');
                this.$appendList.html("").append(this.$appendContent);
                this.$activeItem.html("").html(this.$activeItemContent);

                this.$appendContent = null;
            });
        }

        changeLinks() {
            this.$menuList.find("a").replaceWith(function () {
                const a = $(this);
                if (!a.attr("href") || a.attr("href") == "#") {
                    return "<span>" + a.html() + "</span>";
                }

                return a;
            });
        }

        handleHamburger() {
            this.$hamburger.on ('click', () => {
                $('body').addClass('overflow-hidden');
                this.$expandableMenu.addClass('visible');
                this.$aple.fadeIn(200);
            });

            $(document).mouseup((e) => {
                if (!this.$expandableMenu.is(e.target) && this.$expandableMenu.has(e.target).length === 0 && this.$expandableMenu.hasClass('visible')) {
                    this.$expandableMenu.removeClass('visible');
                    $('body').removeClass('overflow-hidden');
                    this.$aple.fadeOut(200);
                }
            });
        }

        handleCloseButton() {
            this.$closeBtn.on ('click', () => {
                $('body').removeClass('overflow-hidden');
                this.$expandableMenu.removeClass('visible');
                this.$aple.fadeOut(200);
            });
        }
    }

    class UpperMainMenu {
        constructor(e) {
            this.$upperMenu = $(e);
            this.$switcher = $('.upper-menu-switcher');
            this.$aple = $('body .bg-aple');
            this.$closeBtn = $('#upper-expandable-menu .close-button');
        }

        init() {
            this.handleSwitcher();
            this.handleCloseButton();
        }

        handleSwitcher() {
            $(document).mouseup((e) => {
                if (
                    !this.$upperMenu.is(e.target) && 
                    this.$upperMenu.has(e.target).length === 0 && 
                    this.$upperMenu.hasClass('visible')
                ) {
                    this.$upperMenu.removeClass('visible');
                    $('body').removeClass('overflow-hidden');
                    this.$aple.fadeOut(200);
                }
            });

            this.$switcher.on ('click', () => {
                $('body').addClass('overflow-hidden');
                this.$upperMenu.addClass('visible');
                this.$aple.fadeIn(200);
            });
        }

        handleCloseButton() {
            this.$closeBtn.on ('click', () => {
                $('body').removeClass('overflow-hidden');
                this.$upperMenu.removeClass('visible');
                this.$aple.fadeOut(200);
            });
        }
    }

    mainMenu = $(window).width() > 1024 ? 
        new MainMenu("#navbar-holder") : new MainMenuMobile("#menu-mobile")
    mainMenu.init();

    if ($(window).width() <= 1024) {
        upperMenu = new UpperMainMenu('#upper-expandable-menu');
        upperMenu.init();
    } else {
        const menu = $('#upper-expandable-menu-desktop');
        const menuSwitcher = $(".upper-menu-switcher-wrapper");
        menuSwitcher.hover(
            (e) => {
                menu.stop(true, true).show();
                menuSwitcher.addClass('hovered');
            },
            (e) => {
                if (!menu.has($(e.relatedTarget)).length) {
                    menu.stop(true, true).hide();
                    menuSwitcher.removeClass('hovered');
                }
            }
        );

        menu.hover(
            (e) => {
                return;
            },
            (e) => {
                if (!menuSwitcher.is($(e.relatedTarget))) {
                    menu.stop(true, true).hide();
                    menuSwitcher.removeClass('hovered');
                }
            },
        );
    }
    
    $('#search-menu-form, #search-menu-form-mobile').on('submit', function (e) {
        e.preventDefault();
        window.location.href = 'https://globkurier.pl/shipment-tracking/' + $(this).find('input[type="search"]').val();
    });
});
