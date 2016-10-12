<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Rych\Random\Random;

class PracticeController extends Controller
{

    public function example1() {
        $random = new Random();
        return $random->getRandomString(8);
    }
    /**
    * Display an index of all available index methods
    */
    public function index() {
        # Get all the methods in this class
        $actionsMethods = get_class_methods($this);
        # Loop through all the methods
        foreach($actionsMethods as $actionMethod) {
            # Only if the method includes the word "example"...
            if(strstr($actionMethod, 'example')) {
                # Display a link to that method's route
                echo '<a target="_blank" href="/practice/'.str_replace('example','',$actionMethod).'">'.$actionMethod.'</a>';
            }
        }
    }
}
