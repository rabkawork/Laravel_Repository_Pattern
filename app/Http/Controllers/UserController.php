<?php
namespace App\Http\Controllers;

use App\Helpers\ResponseJson;
use App\Helpers\UsecreditHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Service\CreditlogService;
use App\Service\CreditService;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Service\UserService;
use Exception;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{

     /**
     * @var userService
     */
    protected $userService;
    protected $creditService;
    protected $creditlogService;


     /**
     * PostController Constructor
     *
     * @param UserService $userService
     *
     */
    public function __construct(UserService $userService, CreditService $creditService, CreditlogService $creditlogService)
    {
        $this->userService = $userService;
        $this->creditService = $creditService;
        $this->creditlogService = $creditlogService;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $post = $request->all();
            $data = $this->userService->saveUserData($post);
            $userId = (int) $data['id'];
            // add default credit
            $credit['user_id'] = $userId;
            $credit['credit_total'] = UsecreditHelper::getDefaultCredit($post['permission']);
            $defaultCredit = $this->creditService->saveCreditData($credit);
            $creditlog['user_id']   = $userId;
            $creditlog['credit_id'] = $defaultCredit['id'];
            $creditlog['amount']    = $credit['credit_total'];
            $creditlog['description'] = 'Default credit : '.$credit['credit_total'];
            $this->creditlogService->saveCreditlogData($creditlog);
            $result = ['user' => $data, 'credit' => $defaultCredit];
            return ResponseJson::responseSuccess('Registration Success', $result);
        } catch (Exception $e) {
            return ResponseJson::responseBadOrError('Registration error', $e->getMessage(), ResponseJson::HTTP_INTERNAL_SERVER_ERROR);
        }
    }



    public function login(LoginRequest $request): JsonResponse
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $result['token'] =  $user->createToken('MyApp')->plainTextToken;
            $result['name']  =  $user->name;
            $result['token_type']  =  'bearer';
            return ResponseJson::responseSuccess('User login successfully.', $result);
        } else {
            return ResponseJson::responseBadOrError("Login failed",array(), ResponseJson::HTTP_UNAUTHORIZED);
        }
    }

    // method for user logout and delete token
    public function logout()
    {
        try {
            $session = auth()->user()->tokens()->delete();
            return ResponseJson::responseSuccess('Logout success', []);
        } catch (Exception $e) {
            return ResponseJson::responseBadOrError('Registration error', $e->getMessage(), ResponseJson::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
