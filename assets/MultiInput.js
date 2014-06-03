/**
 * Created with JetBrains PhpStorm.
 * User: vedmaka
 * Date: 14.06.12
 * Time: 20:58
 * To change this template use File | Settings | File Templates.
 */

(function( $, mw ){ $.fn.multilize = function( flag ) {

    var self = this;
    var coll = 0;


    /* Search all multilized items */
    $('.pre-multilized').each(function(i,element){

        //if(i>0) {

            var removeButtonZ = $('<div class="btn .btn-mini" style="margin: 0 0 0 10px;">'+mw.msg('wikivotevoting-js-multiinput-button-remove')+'</div>');
            $(removeButtonZ).click(function() {
                $(this).parent().remove();
                $(this).remove();
            });
            $(element).after(removeButtonZ);
            $(element).removeClass('pre-multilized');
            $(element).addClass('no-multilize');

        //}

    });

    if( $(self).hasClass('no-multilize') ) return this;

    /* Check name and fix it */
    if( $(self).attr('name').indexOf('[') == -1 ) {
        $(self).attr('name', $(self).attr('name')+'[]' );
    }

    $(self).addClass('multilized-'+$(self).attr('id'));

    var addButton = $('<div class="btn .btn-mini" style="margin: 0 0 10px 10px;">'+mw.msg('voting-js-multiinput-button-add')+'</div> ');
    //if ( flag != undefined ) {
        $(self).after(addButton);
    //}else{
    //    $(self).append(addButton);
    //}

    $(addButton).click(function(){

        console.log(flag);

        coll++;

        var removeButton = $('<div class="btn .btn-mini" style="margin: 0 0 0 10px;">'+mw.msg('voting-js-multiinput-button-remove')+'</div>')

        var elementClone = $(self).clone();

        $(elementClone).addClass('multilized-'+$(elementClone).attr('id'));
        $(elementClone).attr('id', $(elementClone).attr('id')+'-clone-'+coll );

        if (flag == undefined)
            elementClone = $('<div></div>').append(elementClone);

        var lastClone = $( '*[name="'+$(self).attr('name').replace('[','').replace(']','')+'\[\]"]' ).get( $( '*[name="'+$(self).attr('name').replace('[','').replace(']','')+'\[\]"]').length -1 );

        if( $(lastClone).attr('id') == $(self).attr('id') ) {
            $(lastClone).after(elementClone);
        }else{
            if ( flag != undefined ) {
                console.log('after parent',flag);
                $(lastClone).parent().after(elementClone);
            }else{
                console.log('after',flag);
                $(lastClone).after(elementClone);
            }
        }

        $(elementClone).append(removeButton);

        $(removeButton).click(function() {
            $(this).parent().remove();
        });

    });

    return this;

}; })( jQuery, mediaWiki );