<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Survey;
use App\SurveyProspect;
use App\SurveyResult;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Entrepreneur;
use App\Customer;
use App\Order;


class AdminLoginController extends Controller
{
    
    public function getLogin() {
        return view('login');
    }

    public function doLogin()
    {
        // validate the info, create rules for the inputs
        $rules = array(
            'email'    => 'required|email', // make sure the email is an actual email
            'password' => 'required' // password can only be alphanumeric and has to be greater than 3 characters
        );
        $messages = [
            'email.required' => 'Veuillez saisir votre adresse e-mail',
            'email.email' => 'Le format de l\'adresse e-mail saisie est invalide',
            'password.required' => 'Veuillez saisir votre mot de passe',
            'password.alphaNum' => 'Le format du mot de passe est invalide',
            'password.min:3' => 'Le format du mot de passe est invalide',
        ];
        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules, $messages);

        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return Redirect::to('login')
                ->withErrors($validator) // send back all errors to the login form
                ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
        } else {

            // create our user data for the authentication
            $userdata = array(
                'email'     => Input::get('email'),
                'password'  => Input::get('password')
            );

            // attempt to do the login
            if (Auth::attempt($userdata)) {

                // validation successful!
                // redirect them to the secure section or whatever
                // return Redirect::to('secure');
                // for now we'll just echo success (even though echoing in a controller is bad)
                return Redirect::to('home');

            } else {        

                // validation not successful, send back to form 
                return Redirect::to('login')->with('message', 'Email et/ou mot de passe invalide.')->withInput(Input::except('password'));

            }

        }
    }

    public function doLogout()
    {
        Auth::logout(); // log the user out of our application
        return Redirect::to('login'); // redirect the user to the login screen
    }
         
}