/**
 * Created with JetBrains PhpStorm.
 * User: vedmaka
 * Date: 14.06.12
 * Time: 20:58
 * To change this template use File | Settings | File Templates.
 */

(function( $, mw ){ $.fn.multilize = function( ) {

    var self = this;
    var coll = 0;
    var selfId = $(self).attr('id');
    var selfContainer = null;

    /* Check if there are multilized elements on page */
    $('.multilized').each(function(i,elem){

        var remBtn = $('<div class="btn .btn-mini" style="margin: 0 0 0 4px;">'+mw.msg('wikivotevoting-js-multiinput-button-remove')+'</div>');
        $(remBtn).click(function(){
            $(this).parent().remove();
        });
        $(elem).append( remBtn );

    });

    /* Check element */
    if (self.tagName != 'DIV')
        $(self).wrap('<div class="multilized"></div>');
        selfContainer = $(self).parent();

    /* Append button */
    var addButton = $('<div class="btn .btn-mini" style="margin: 0 0 2px 10px; display: inline-block;">'+mw.msg('voting-js-multiinput-button-add')+'</div>');
    $(self).css('display','inline-block');
    $(self).after(addButton);

    $(addButton).click(function(){

        /* Clone element */
        var Duplicate = $(self).clone();
        $(Duplicate).attr('id', selfId+'-clone-'+coll );
        $(Duplicate).wrap('<div></div>');
        $(Duplicate).find('input').val('');
        Duplicate = Duplicate.parent();

        console.log(Duplicate.parent());

        var removeButton = $('<div class="btn .btn-mini" style="margin: 0 0 0 7px;">'+mw.msg('voting-js-multiinput-button-remove')+'</div>');

        $(removeButton).click(function(){
           $(this).parent().remove();
        });

        $(Duplicate).append(removeButton);

        $(Duplicate).hide();

        $('.multilized').last().after(Duplicate);
        $(Duplicate).addClass('multilized');

        $(Duplicate).fadeIn();


    });

    return this;

}; })( jQuery, mediaWiki );