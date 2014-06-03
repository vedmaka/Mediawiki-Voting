<?php
/**
 *
 *
 * @file VotingExceptionHandler.php
 * @ingroup
 *
 * @licence GNU GPL v3 or later
 * @author Vedmaka < god.vedmaka@gmail.com >
 */
class VotingExceptionHandler
{

    public static function onException( $exception ) {

        var_dump($exception);
        return false;

    }

}
