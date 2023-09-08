/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

import { Controller } from '@hotwired/stimulus';

/**
 * Sidebar Controller
 * Manage Backoffice entries and pages
 */
export default class Sidebar extends Controller {
    static targets = ['menuItem', 'menuItemLink', 'closeSign'];
    static sideBarWidth = $('.menu-items').css('width');
    static leftPixels = $('.sidebar').css('width');
    static dir = $('html').attr('dir') == 'rtl' ? 'right' : 'left';

    connect() {
        this.activeMenuItem = null;
        window.addEventListener('DOMContentLoaded', function() {
            var sidebar = document.querySelector('.sidebar');
            var lastScrollPosition = window.pageYOffset || document.documentElement.scrollTop;

            // Sync sidebar scroll with window scroll
            window.addEventListener('scroll', function() {
                var currentScrollPosition = window.pageYOffset || document.documentElement.scrollTop;
                var scrollAmount = currentScrollPosition - lastScrollPosition;
                sidebar.scrollTop += scrollAmount;
                lastScrollPosition = currentScrollPosition;
            });
        });
    }

    /**
     * @param menuItemId
     * @returns {*}
     */
    findMenuItemTarget(menuItemId) {
        return this.menuItemTargets.find(
            (menuItem) => menuItem.getAttribute('id') === menuItemId
        );
    }

    removeActiveClassFromMenuItems() {
        this.menuItemLinkTargets.forEach(
            (menuItemLink) => menuItemLink.classList.remove('active')
        );
    }

    /**
     * MenuItem click action
     * @param event
     */
    menuItemClick(event) {
        const menuItem = event.currentTarget;
        if(menuItem.hasAttribute('href') && menuItem.getAttribute('href') !== '#') {
            return;
        }

        const menuItemId = menuItem.getAttribute('id');

        event.preventDefault();
        if (this.activeMenuItem !== null) {
            if (menuItemId === this.activeMenuItem.getAttribute('id')) {
                this.hideCurrentMenuItemTarget();
            } else {
                this.hideCurrentMenuItemTarget();
                this.showMenuItemTarget(menuItem);
            }
        } else {
            this.showMenuItemTarget(menuItem);
        }
    }

    /**
     * @param event
     */
    closeSignClick(event) {
        event.preventDefault();
        this.hideCurrentMenuItemTarget();
    }

    hideCurrentMenuItemTarget() {
        const menuItemId = this.activeMenuItem.getAttribute('id');
        const targetMenu = this.findMenuItemTarget(menuItemId);
        this.animateMenuItem(targetMenu, `-${this.constructor.sideBarWidth}`, () => {
            targetMenu.style.display = 'none';
        });
        this.activeMenuItem = null;
    }

    /**
     * @param menuItem
     */
    showMenuItemTarget(menuItem) {
        this.activeMenuItem = menuItem;
        const menuItemId = menuItem.getAttribute('id');
        const targetMenu = this.findMenuItemTarget(menuItemId);
        targetMenu.style[this.constructor.dir] = `-${this.constructor.sideBarWidth}`;
        targetMenu.style.display = 'block';
        this.animateMenuItem(targetMenu, `${this.constructor.leftPixels}`);

        // Clean Active links and Activate current
        this.removeActiveClassFromMenuItems();
        menuItem.classList.add('active');
    }

    /**
     * @param menuItem
     * @param leftPosition
     * @param callback
     */
    animateMenuItem(menuItem, leftPosition, callback) {
        let css = {};
        css[this.constructor.dir] = leftPosition;
        $(menuItem).animate(
            css,
            250,
            callback
        );
    }
}