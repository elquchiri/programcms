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
export default class extends Controller {
    static targets = ['menuItem', 'menuItemLink', 'closeSign'];
    static sideBarWidth = 270;
    static leftPixels = 91;

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

    closeSignClick(event) {
        event.preventDefault();
        this.hideCurrentMenuItemTarget();
    }

    hideCurrentMenuItemTarget() {
        const menuItemId = this.activeMenuItem.getAttribute('id');
        const targetMenu = this.findMenuItemTarget(menuItemId);
        this.animateMenuItem(menuItemId, `-${this.constructor.sideBarWidth}px`, () => {
            targetMenu.style.display = 'none';
        });
        this.activeMenuItem = null;
    }

    showMenuItemTarget(menuItem) {
        this.activeMenuItem = menuItem;
        const menuItemId = menuItem.getAttribute('id');
        const targetMenu = this.findMenuItemTarget(menuItemId);
        targetMenu.style.left = `-${this.constructor.sideBarWidth}px`;
        targetMenu.style.display = 'block';
        this.animateMenuItem(menuItemId, `${this.constructor.leftPixels}px`);

        // Clean Active links and Activate current
        this.removeActiveClassFromMenuItems();
        menuItem.classList.add('active');
    }

    animateMenuItem(menuItemId, leftPosition, callback) {
        $('.menu-items#' + menuItemId).animate(
            { left: leftPosition },
            300,
            callback
        );
    }
}