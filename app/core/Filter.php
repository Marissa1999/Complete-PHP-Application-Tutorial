<?php

class Filter extends Controller
{

    public static function itemOwner($params)
    {
        $theItem = self::model('Item')->find($params[0]);

        if($theItem->user_id != $_SESSION['user_id'])
        {
            return '/home/index';
        }

        else
        {
            return false;
        }
    }

    public static function LoginFilter($params)
    {
        if($_SESSION['user_id'] == null)
        {
            return '/login/index';
        }
        else
        {
            return false;
        }
    }

}

?>