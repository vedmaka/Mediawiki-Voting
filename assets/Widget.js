( function( $ ) {

    /* Collection of controls */

    /* Search all control blocks */
    $('.wikivote-voting-control').each( function( num, element ) {

        var control = $(element).attr('control');

        var Titles = $(element).attr('titles').split(',');
        var NumberOfScores = Titles.length;
        var ValuesId = $(element).attr('values').split(',');

        switch (control) {

            /* Stars */
            case '0':

                $(element).raty({

                    starOn  : 'medal_big_on.png',
                    starOff : 'medal_big_off.png',
                    path: '/extensions/Voting/assets/',
                    width: 180,
                    hints: Titles,
                    number: NumberOfScores,
                    click: function( score, evt ) {

                        if ( evt != undefined ) {

                            var elem = evt.target;

                            $(elem).parents('.wikivote-voting-control:first').attr('score', ValuesId[$(elem).index()] );

                        }else{

                            var elem = this;
                            $(elem).attr('score', ValuesId[$(elem).index()] );

                        }

                        checkControls( $(elem).parents('.wikivote-voting-widget:first') );

                    }

                });

                /* Stored score pop */
                if( $(element).attr('stored_score') != undefined ) {

                    var storedScore = $(element).attr('stored_score');
                    var numScore = ValuesId.indexOf(storedScore)+1;

                    $(element).raty('click', numScore);

                }

            break;

            /* Select */
            case '1':

                var Select = $('<select class="wvw-select"></select>');

                    $(Select).append( $('<option value="-1" disabled selected >-'+mw.msg('wikivotevoting-js-select-control-null')+'-</option>') );

                    $(Titles).each(function(i,v){

                        var Option = $('<option></option>');
                        $(Option).val( ValuesId[i] );
                        $(Option).html( v );
                        $(Select).append(Option);

                    });

                $(element).append(Select);

                $(Select).change(function(){

                    $(this).parent().attr('score',$(this).find('option:selected').val());

                    checkControls( $(this).parents('.wikivote-voting-widget:first') );

                });

                /* Stored score pop */
                if( $(element).attr('stored_score') != undefined ) {

                    var storedScore = $(element).attr('stored_score');
                    $(element).find('option[value="'+storedScore+'"]').attr('selected','selected');
                    $(element).find('select').trigger('change');

                }

            break;

            /* Switch */
            case '2':

                $(Titles).each(function(i,v){

                    var SwitchButton = $('<button class="btn btn-mini wvw-switcher"></button>');
                    $(SwitchButton).html( v );
                    $(SwitchButton).val( ValuesId[i] );
                    $(element).append(SwitchButton);

                    $(SwitchButton).click(function(){

                        $(this).parent().find('.wvw-switcher').removeClass('disabled');
                        $(this).addClass('disabled');
                        $(this).parent().attr('score', $(this).val() );

                        checkControls( $(this).parents('.wikivote-voting-widget:first') );

                    });

                });

                /* Stored score pop */
                if( $(element).attr('stored_score') != undefined ) {

                    var storedScore = $(element).attr('stored_score');
                    $(element).find('button[value="'+storedScore+'"]').click();

                }

            break;

            /* Checkboxes */
            case '3':

                $(Titles).each(function(i,v){

                    var Checkbox = $('<input type="checkbox" class="wvw-checkbox" id="wvw-ch-'+i+'" />');
                    var Label = $('<label for="wvw-ch-'+i+'"></label>');
                    var CheckDiv = $('<div class="wvw-checkbox-container"></div>');
                    $(Label).html( v );
                    $(Checkbox).val( ValuesId[i] );
                    $(CheckDiv).append(Checkbox);
                    $(CheckDiv).append(Label);
                    $(element).append(CheckDiv);

                    $(CheckDiv).click(function(){

                        $(this).parent().find('.wvw-checkbox-container').removeClass('wvw-checkbox-container-selected');
                        $(this).parent().find('input').attr('checked',false);
                        $(this).addClass('wvw-checkbox-container-selected');
                        $(this).find('input').attr('checked',true);

                        $(this).parent().attr('score', $(this).find('input').val() );

                        checkControls( $(this).parents('.wikivote-voting-widget:first') );

                    });

                });

                /* Stored score pop */
                if( $(element).attr('stored_score') != undefined ) {

                    var storedScore = $(element).attr('stored_score');
                    $(element).find('input[value="'+storedScore+'"]').click();
                    $(element).find('input[value="'+storedScore+'"]').attr('checked',true);

                }

            break;

			/* Just circles */
			case '4':

				$(element).raty({

					starOn  : 'circle_on.png',
					starOff : 'circle_off.png',
					path: '/extensions/Voting/assets/',
					width: 180,
					hints: Titles,
					number: NumberOfScores,
					click: function( score, evt ) {

						if ( evt != undefined ) {

							var elem = evt.target;

							$(elem).parents('.wikivote-voting-control:first').attr('score', ValuesId[$(elem).index()] );

						}else{

							var elem = this;
							$(elem).attr('score', ValuesId[$(elem).index()] );

						}

						checkControls( $(elem).parents('.wikivote-voting-widget:first') );

					}

				});

				/* Stored score pop */
				if( $(element).attr('stored_score') != undefined ) {

					var storedScore = $(element).attr('stored_score');
					var numScore = ValuesId.indexOf(storedScore)+1;

					$(element).raty('click', numScore);

				}

			break;

        }

    });

    function disableWidget( target ) {
        $(target).find('.wvw-submit').attr('disabled', true);
        $(target).find('.wvw-shadow').show();
    }

    function enableWidget( target ) {
        $(target).find('.wvw-submit').attr('disabled', false);
        $(target).find('.wvw-shadow').hide();
    }

    /* Check if all controls voted */
    function checkControls( target ) {

        var allVoted = true;
        $(target).find('.wikivote-voting-control').each(function(i,v){

            if( $(v).attr('score') == '-1' ) allVoted = false;

        });

        if( allVoted ) {
            $(target).find('.wvw-submit').attr('disabled', false);
        }

    }

    /* Send button */
    $('.wvw-submit').click(function(){

        /* Fetch all scores */
        var widget = $(this).parents('.wikivote-voting-widget:first');
        var groupId = $(widget).attr('voting-group');
        var pageId = $(widget).attr('page');
        var revisionId = $(widget).attr('revision');
        var Ratings = [];
        var Votes = [];

        //Comments
        var Comment = $(widget).find('.wv-voting-comments-block').find('input').val();

        disableWidget( widget );

        $(widget).find('.wikivote-voting-control').each(function(i,v){

            Ratings.push( $(v).attr('rating') );
            Votes.push( $(v).attr('score') );

        });

        storeVotes( Ratings, Votes, groupId, pageId, revisionId, widget, Comment );

    });

    /* Send votings */
    function storeVotes( ratings, votes, groupId, pageId, revisionId, widget, Comment ) {

        var ApiUrl = '/api.php?action=wikivotevoting&do=store&group_id='+groupId
            +'&ratings='+ratings.join(',')+'&votes='+votes.join(',')
            +'&comment='+Comment
            +'&page_id='+pageId
            +'&revision_id='+revisionId
            +'&format=json';
        $.get( ApiUrl, function( data ){

            var dataArr = data.wikivotevoting.data;
            var status = data.wikivotevoting.status;

            if (status.indexOf('error') != -1) {

                /* Error response from api */

            }else{

                /* Sucessfully stored */
                //$(widget).find('.wvw-ratings-block').css('background-color','rgb(219, 219, 219)');
                /* Show success message */
                $(widget).css('width',$(widget).width()+'px');
                $(widget).width($(widget).width());
                $(widget).find('.ratings').fadeOut(
                    function() {
                        $(widget).find('.result-message').html( dataArr['message'] );
                        $(widget).find('.result-message').fadeIn();
                        enableWidget( widget );
                    }
                );

            }

        });
    }

    //Fade them in
    $('.wikivote-voting-widget').fadeIn();

    /* Summary */

    $(".wikivote-summary-rating-value").each(function(i,element){

        var value = $(element).html();

        console.log(value);

        var Titles = $(element).attr('titles').split(',');
        var NumberOfScores = Titles.length;
        var Values = $(element).attr('values').split(',');

        switch( $(element).attr('view_format') ) {

            case '0':
                //Nothing
            break;

            case '1':
                //Stars
                //From 1 to 5 descretisation only

                value = Math.abs( parseInt(value) );

                $(element).raty({

                    starOn  : 'medal_big_on.png',
                    starOff : 'medal_big_off.png',
                    path: '/extensions/Voting/assets/',
                    width: 200,
                    number: NumberOfScores,
                    hints: Titles,
                    score: value,
                    readOnly : true

                });

            break;

            case '2':
                //Bar

                $(element).html('');

                $(element).css('height','20px');

                /* Insert rulers */
                var ruler = $("<div></div>");
                    $(ruler).css('overflow','hidden');
                    $(ruler).css('margin-bottom','5px');

                var left = $("<span>"+Titles[0]+"</span>");
                    $(left).css('float','left');
                    $(left).css('font-size','12px');
                    $(left).css('max-width','80px');
                    $(left).css('text-align','left');
                    $(left).appendTo(ruler);

                var right = $("<span>"+Titles[Titles.length-1]+"</span>");
                    $(right).css('float','right');
                    $(right).css('font-size','12px');
                    $(right).css('max-width','80px');
                    $(right).css('text-align','right');
                    $(right).appendTo(ruler);

                $(element).before( ruler );

                $(element).progressbar({
                    max: Math.max.apply(null, Values),
                    min: Math.min.apply(null, Values),
                    value: parseInt(value)
                });

            break;

            case '3':
                //Yes/No
                //Detects more or less summary value based on values variants

                var ValMax = Math.max.apply(null, Values);
                var ValMin = Math.min.apply(null, Values);

                var ValMiddle = ValMax/2;

                if( value > ValMiddle ) {

                    $(element).addClass('font-color-green');
                    $(element).html( mw.msg('wikivotevoting-js-view-format-yesno-yes') );

                }else{

                    $(element).addClass('font-color-red');
                    $(element).html( mw.msg('wikivotevoting-js-view-format-yesno-no') );

                }


            break;

			case '4':
				//Circles
				//From 1 to 5 descretisation only

				value = Math.abs( parseInt(value) );

				$(element).raty({

					starOn  : 'circle_on.png',
					starOff : 'circle_off.png',
					path: '/extensions/Voting/assets/',
					width: 200,
					number: NumberOfScores,
					hints: Titles,
					score: value,
					readOnly : true

				});

			break;

        }

    });

    //Simple mode fix


} )( jQuery );