<?php

namespace app\controllers;
use yii\helpers\Url;
use yii\web\Controller;

use bitcko\googlecalendar\GoogleCalendarApi;

/**
 * GoogleApi controller.
 *
 * @package app\controllers
 * @author  Mhmd Backer shehadi (bitcko) <www.bitcko.com>

 */
class GoogleCalendarController extends Controller
{
    public function behaviors() {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['http://localhost:3000', 'https://sistema-de-defesas.app.ic.ufba.br'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => null,
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => []
            ]
        ];

        $behaviors['authenticator'] = [
            'class' => \sizeg\jwt\JwtHttpBearerAuth::class,
            'except' => [
                'options',
                'auth'
            ],
        ];

        return $behaviors;
    }
    public function actionAuth(){

        $redirectUrl = Url::to(['/google-calendar/auth'], true);
        $calendarId = 'primary';
        $username="sistema_de_defesas";
        $googleApi = new GoogleCalendarApi($username, $calendarId, $redirectUrl);
        
        // $redirectUrl = Url::to(['/google-calendar/auth'], true);
        \Yii::error($redirectUrl, 'Redirect URL');

        if(!$googleApi->checkIfCredentialFileExists()){
            $googleApi->generateGoogleApiAccessToken();
        }
        \Yii::$app->response->data = "Google api authorization done";
    }
    public function actionCreateEvent(){
        $redirectUrl = Url::to(['/google-calendar/auth'], true);
        $calendarId = '1dimt5iv0ba88goaephucfrmqo@group.calendar.google.com';
        $username="sistema_de_defesas";
        $googleApi = new GoogleCalendarApi($username,$calendarId, $redirectUrl);
        // var_dump($googleApi); die();
        if($googleApi->checkIfCredentialFileExists()){
            $event = array(
                'summary' => 'Google I/O 2018',
                'location' => '800 Howard St., San Francisco, CA 94103',
                'description' => 'A chance to hear more about Google\'s developer products.',
                'start' => array(
                    'dateTime' => '2022-05-14T09:00:00-07:00',
                    'timeZone' => 'America/Los_Angeles',
                ),
                'end' => array(
                    'dateTime' => '2022-05-14T17:00:00-07:00',
                    'timeZone' => 'America/Los_Angeles',
                ),
                'recurrence' => array(
                    'RRULE:FREQ=DAILY;COUNT=2'
                ),
                'attendees' => array(
                    array('email' => 'lpage@example.com'),
                    array('email' => 'sbrin@example.com'),
                ),
                'reminders' => array(
                    'useDefault' => FALSE,
                    'overrides' => array(
                        array('method' => 'email', 'minutes' => 24 * 60),
                        array('method' => 'popup', 'minutes' => 10),
                    ),
                ),
            );

           $calEvent = $googleApi->createGoogleCalendarEvent($event);
            \Yii::$app->response->data = "New event added with id: ".$calEvent->getId() . " with link: " . $calEvent->htmlLink;
        }else{
            return $this->redirect(['auth']);
        }
    }


    public function actionDeleteEvent(){
        $calendarId = 'primary';
        $username="sistema_de_defesas";
        $googleApi = new GoogleCalendarApi($username,$calendarId);
        if($googleApi->checkIfCredentialFileExists()){
            $eventId ='event_id' ;

             $googleApi->deleteGoogleCalendarEvent($eventId);
            \Yii::$app->response->data = "Event deleted";
        }else{
            return $this->redirect(['auth']);
        }
    }

    public function actionCalendarsList(){
        $calendarId = 'primary';
        $username="sistema_de_defesas";
        $googleApi = new GoogleCalendarApi($username,$calendarId);
        if($googleApi->checkIfCredentialFileExists()){
          $calendars =    $googleApi->calendarList();
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            \Yii::$app->response->data = $calendars;
        }else{
            return $this->redirect(['auth']);
        }
    }

}