"use strict";

jQuery(window).load(function () {
    jQuery('#status').fadeOut();
    jQuery('#preloader').delay(350).fadeOut(function () {
        jQuery('body').delay(350).css({'overflow': 'visible'});
    });
});

jQuery(document).ready(function () {
    jQuery('.custom-nav > li').hover(function () {
        jQuery(this).addClass('nav-hover');
    }, function () {
        jQuery(this).removeClass('nav-hover');
    });

    $('.panel .tools .fa-times').click(function () {
        $(this).parents(".panel").parent().remove();
    });

    $('#helpPopover').click(function(e){
        e.preventDefault();
    });
    $('#helpPopover').popover({
        placement : 'bottom',
        title: 'Aplicativo Tracking',
        content: 'El aplicativo tracking soluciona la problemática de estructurar el seguimiento de correos a clientes inscritos en facturación electrónica, específicamente el envío de su documento tributario dado que a través de este medio se les hace llegar la factura o boleta de servicios del mes (link). Adicionalmente se necesita medir el medio por el cual el cliente consulta su documento, cualquiera sea el medio de distribución que se utilice (electrónico o papel) para despachar su factura o boleta',
        template: '<div class="popover-all">' +
        '<div class="popover-arrow"></div>' +
        '<div class="popover-inner">' +
        '<h3 class="popover-title">Example</h3>' +
        '<div class="popover-content"></div>' +
        '</div>' +
        '</div>'
    });
});
