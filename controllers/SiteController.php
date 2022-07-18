<?php

namespace app\controllers;


use thecodeholic\phpmvc\Application;
use thecodeholic\phpmvc\Controller;
use thecodeholic\phpmvc\middlewares\AuthMiddleware;
use thecodeholic\phpmvc\Request;
use thecodeholic\phpmvc\Response;
use app\models\LoginForm;
use app\models\User;
use app\controllers\MyRequest;
use app\models\Buyer;
use app\controllers\MyAuth;
use PDO;

/**
 * Class SiteController
 *
 * @author  Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package app\controllers
 */

class SiteController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new MyAuth(['profile','buyer']));
    }

    public function home()
    {
        return $this->render('home', [
            'name' => 'Kodbel'
        ]);
    }

    public function login(Request $request)
    {
        $loginForm = new LoginForm();
        if ($request->getMethod() === 'post') {
            $loginForm->loadData($request->getBody());
            if ($loginForm->validate() && $loginForm->login()) {
                Application::$app->response->redirect('/');
                return;
            }
        }
        $this->setLayout('auth');
        return $this->render('login', [
            'model' => $loginForm
        ]);
    }

    public function register(Request $request)
    {
        $registerModel = new User();
        $registerModel->status = true;  
        
        if ($request->getMethod() === 'post') {
            $registerModel->loadData($request->getBody());
            if ($registerModel->validate() && $registerModel->save()) {
                Application::$app->session->setFlash('success', 'Thanks for registering');
                Application::$app->response->redirect('/');
                return 'Show success page';
            }

        }
        $this->setLayout('auth');
        return $this->render('register', [
            'model' => $registerModel
        ]);
    }

    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect('/');
    }

    public function contact()
    {
        return $this->render('contact');
    }

    public function profile()
    {
        return $this->render('profile');
    }

    public function buyer(Request $request){
        $registerModel = new Buyer();
        $registerModel->entry_by = Application::$app->user->getUserId();
        $registerModel->buyer_ip = $this->getIPAddress();
        $registerModel->hash_key = crypt( $request->getBody()['receipt_id'] , '$6$rounds=5000$usesomesillystringforsalt$');

        if ($request->getMethod() === 'post') {
            $registerModel->loadData($request->getBody());
            // echo '<pre>' . var_export($registerModel, true) . '</p>';
            // exit();
            if ($registerModel->validate() && $registerModel->save()) {
                Application::$app->session->setFlash('success', 'Thanks for inputing buyer');
                Application::$app->response->redirect('/');
                return 'Show success page';
            }

        }
        // $this->setLayout('auth');
        return $this->render('buyer', [
            'model' => $registerModel
        ]);


    }

    public function report(Request $request){
        // $registerModel = new Buyer();
        // $registerModel->entry_by = Application::$app->user->getUserId();
        // $registerModel->buyer_ip = $this->getIPAddress();
        // $registerModel->hash_key = crypt( $request->getBody()['receipt_id'] , '$6$rounds=5000$usesomesillystringforsalt$');

        

        $db = \thecodeholic\phpmvc\Application::$app->db;
        // between '2012-03-11 00:00:00' and '2012-05-11 23:59:00' 

        $daterange = $request->getBody()['daterange'];
        if(!empty($daterange)){
            
            $daterange = explode(' - ',$daterange);
            $query_string = 'SELECT * FROM buyer' . ' WHERE entry_at between \''.$daterange[0].'\' and \''.$daterange[1] . '\'' ;
        }else{
            $query_string = 'SELECT * FROM buyer';
        }
        $query = $db->prepare($query_string);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        // if ($request->getMethod() === 'post') {
        //     $registerModel->loadData($request->getBody());
        //     // echo '<pre>' . var_export($registerModel, true) . '</p>';
        //     // exit();
        //     if ($registerModel->validate() && $registerModel->save()) {
        //         Application::$app->session->setFlash('success', 'Thanks for registering');
        //         Application::$app->response->redirect('/');
        //         return 'Show success page';
        //     }

        // }
        // $this->setLayout('auth');
        return $this->render('report', [
            // 'model' => $registerModel,
            'report' => $result
        ]);


    }

    function getIPAddress() {  
        //whether ip is from the share internet  
         if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
                    $ip = $_SERVER['HTTP_CLIENT_IP'];  
            }  
        //whether ip is from the proxy  
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
         }  
        //whether ip is from the remote address  
        else{  
                 $ip = $_SERVER['REMOTE_ADDR'];  
         }  
         return $ip;  
    }  
}