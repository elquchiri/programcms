$(document).ready(function() {
    let treeChild = $('.tree ul.child');

    $('.tree ul li span.title').click(function(e) {
        e.preventDefault();

        let childElement = $(this).next();
        if(childElement.length) {
            childElement.toggle();

            if($(this).hasClass('closed')) {
                $(this).removeClass('closed');
            }else{
                $(this).addClass('closed');
            }
        }
    });

    $('.tree ul li span.title .category-name').click(function(e) {
        e.stopPropagation();

        let url = $(this).data('url');
        window.location.href = url;
    });

    $('.tree-group').click(function(e) {
        e.preventDefault();

        let id = $(this).attr('id');
        switch(id) {
            case 'collapse':
                treeChild.hide();
                treeChild.find('span.title').removeClass('closed');
                break;
            case 'expand':
                treeChild.show();
                treeChild.find('span.title').addClass('closed');
                break;
        }
    });

    $('.add-category').click(function(e) {
        e.preventDefault();

        window.location.href = $(this).data('ef-url');
    });
});