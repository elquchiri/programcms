/**
 * ElectroForums Community Edition
 *
 * Dashboard Sidebar Manager
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 * Created 04/12/2022
 */

$(function() {
    let activeMenuItem = null;
    let activeMenuItemId = null;

    let leftPixels = 110;
    let sideBarWidth = 270;

    $('.sidebar ul li a').click(function(e) {
        let menuItemId = $(this).attr('id');

        // Desactivate Dashboard click from MenuItems
        if(menuItemId == 'dashboard') {
            return;
        }

        e.preventDefault();

        if(activeMenuItem != null) {
            if(menuItemId == activeMenuItemId) {
                var currentMenuItem = $('.menu-items' + '#' + activeMenuItemId);
                // Hide current MenuItem
                currentMenuItem.animate({"left": '-' + sideBarWidth + 'px'}, 300, function() {
                    currentMenuItem.hide();
                    activeMenuItem = null;
                });
            }else{
                var currentMenuItem = $('.menu-items' + '#' + activeMenuItemId);
                // Hide current MenuItem
                currentMenuItem.animate({"left": '-' + sideBarWidth + 'px'}, 300, function() {
                    currentMenuItem.hide();
                });
                activeMenuItemId = menuItemId;
                activeMenuItem = $('.menu-items' + '#' + menuItemId);
                activeMenuItem.css({'left': '-' + sideBarWidth + 'px'});
                activeMenuItem.show();
                activeMenuItem.animate({"left": leftPixels + 'px'}, 300);

                // Activate Menu Item view
                $('.sidebar ul li a').removeClass('active');
                $(this).addClass('active');
            }
        }else{
            activeMenuItemId = menuItemId;
            activeMenuItem = $('.menu-items' + '#' + menuItemId);
            activeMenuItem.css({'left': '-' + sideBarWidth + 'px'});
            activeMenuItem.show();
            activeMenuItem.animate({"left": leftPixels + 'px'}, 300);

            // Activate Menu Item view
            $('.sidebar ul li a').removeClass('active');
            $(this).addClass('active');
        }
    });

    // Manage MenuItem Close
    $('.close-sign').click(function(e) {
        e.preventDefault();

        activeMenuItem.animate({"left": '-' + sideBarWidth + 'px'}, 300, function() {
            activeMenuItem.hide();
            activeMenuItem = null;
        });
    });
});