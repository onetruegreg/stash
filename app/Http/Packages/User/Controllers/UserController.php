<?php
/**
 * Created by PhpStorm.
 * User: greg
 * Date: 9/17/17
 * Time: 4:52 PM
 */

namespace App\Http\Packages\User\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Packages\User\Gateways\UserGateway;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Log;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * @var UserGateway
     */
    private $gateway;

    private $status = Controller::RESPONSE_SUCCESS;

    /**
     * UserController constructor.
     * @param Request $request
     * @param UserGateway $gateway
     */
    public function __construct(Request $request, UserGateway $gateway)
    {
        parent::__construct($request);
        $this->gateway = $gateway;
    }

    /**
     * @var array
     */
    private $createRules = array(
        'email'        => 'required|max:200',
        'phone_number' => 'required|max:20',
        'full_name'    => 'max:200',
        'password'     => 'required|max:100',
        'metadata'     => 'max:2000',
    );

    /**
     * POST /api/v1/users
     *
     * Don't do much but read requests and format responses. Let the business classes do the rest.
     * @return Response
     */
    public function store()
    {
        $response = array();
        $this->request->validate($this->createRules);
        try {
            $response['user'] = $this->gateway->createUser($this->request->json()->all());
            $this->status = Controller::RESPONSE_CREATED;
        } catch (QueryException $e) {
            //Let MySQL's unique indexes handle ensuring that email and phone are unique.
            if (str_contains($e->getMessage(), 'EMAIL_UNIQUE')) {
                //Looks dumb to put the same message twice but I want to match the laravel validator response format.
                $response['message'] = 'An account already exists for the email ' . $this->request->input('email');
                $response['errors']['email'][] = 'An account already exists for the email ' . $this->request->input('email');
                $this->status = Controller::RESPONSE_BAD_REQUEST;
            } elseif (str_contains($e->getMessage(), 'PHONE_NUMBER_UNIQUE')) {
                $response['message'] = 'An account already exists for the phone number ' . $this->request->input('phone_number');
                $response['errors']['phone_number'][] = 'An account already exists for the phone number ' . $this->request->input('phone_number');
                $this->status = Controller::RESPONSE_BAD_REQUEST;
            } else {
                $response['message'] = 'Oops! We\'re experiencing technical difficulties. :(';
                $this->status = Controller::RESPONSE_SERVER_ERROR;
                Log::error((string)$e);
            }
        } catch (Exception $e) {
            $this->status = Controller::RESPONSE_SERVER_ERROR;
            Log::error('[UserController] Unknown Exception: ' . (string)$e);
        }
        return new Response($response, $this->status);
    }

    /**
     * GET api/v1/users
     *
     * @return Response
     */
    public function get()
    {
        $response = array();

        //Don't really need validation on the query. Its not saved so it can pretty much be anything.
        $keyword = $this->request->input('query');
        try {
            $response['users'] = $this->gateway->getUsers($keyword);
        /**
         * Not looking out for anything in particular. MySQL or ElasticSearch could fail but we wouldn't be able to do
         * anything about it here so we'll just log and fail as gracefully as possible.
         */
        } catch (Exception $e) {
            $this->status = Controller::RESPONSE_SERVER_ERROR;
            Log::error('[UserController] Unknown Exception: ' . (string)$e);
        }
        return new Response($response, $this->status);
    }
}
