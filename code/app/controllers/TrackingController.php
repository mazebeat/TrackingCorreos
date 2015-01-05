<?php

use Illuminate\Support\Facades\View;

/**
 * Class TrackingController
 */
class TrackingController extends ApiController
{
    /**
     *
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return View::make('dashboard.tracking.index');
    }

    /**
     * @return mixed
     */
    public function getSearchTracking()
    {
        return Session::get('searchTracking', array());
    }

    /**
     *
     */
    public function setSearchTracking()
    {
        if (Session::has('searchTracking')) {
            Session::forget('searchTracking');
        }
        
        Session::put('searchTracking', Input::all());
    }
} 
