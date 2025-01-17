<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Response\ApiResponse;
use App\Http\Presenter\AuthenticationResponseArrayPresenter;
use App\Http\Controllers\ApiController;
use App\Http\Request\Api\Auth\RegisterHttpRequest;
use App\Action\Auth\RegisterAction;
use App\Action\Auth\RegisterRequest;
use App\Http\Request\Api\Auth\LoginHttpRequest;
use App\Action\Auth\LoginRequest;
use App\Action\Auth\LoginAction;
use App\Action\Auth\LogoutAction;

class AuthController extends ApiController
{
    private $resetPasswordAction;
    private $sendResetPasswordAction;
    
    public function __construct(
        // ResetPasswordAction $resetPasswordAction, 
        // SendResetPasswordAction $sendResetPasswordAction
        )
    {
        // $this->resetPasswordAction = $resetPasswordAction;
        // $this->sendResetPasswordAction = $sendResetPasswordAction;
        $this->middleware('auth:api', ['except' => ['login', 'register', 'callResetPassword', 'sendPasswordResetLink']]);
    }
    public function register(
        RegisterHttpRequest $httpRequest,
        RegisterAction $action,
        AuthenticationResponseArrayPresenter $authenticationResponseArrayPresenter
    ) {
        $request = new RegisterRequest(
            $httpRequest->get('email'),
            $httpRequest->get('password'),
            $httpRequest->get('first_name'),
            $httpRequest->get('last_name'),
            $httpRequest->get('nickname')
        );
        $response = $action->execute($request);
        return $this->createSuccessResponse($authenticationResponseArrayPresenter->present($response));
    }
    public function login(
        LoginHttpRequest $httpRequest,
        LoginAction $action,
        AuthenticationResponseArrayPresenter $authenticationResponseArrayPresenter
    ): ApiResponse 
    {
        $request = new LoginRequest(
            $httpRequest->email,
            $httpRequest->password
        );
        $response = $action->execute($request);
        return $this->createSuccessResponse($authenticationResponseArrayPresenter->present($response));
    }
    public function me(
        GetAuthenticatedUserAction $action, UserArrayPresenter $userArrayPresenter
        ): ApiResponse
    {
        $response = $action->execute();
        return $this->createSuccessResponse($userArrayPresenter->present($response->getUser()));
    }
    public function logout(
        LogoutAction $action
        ): ApiResponse
    {
        $action->execute();
        return $this->createEmptyResponse();
    }
    public function update(
        UpdateProfileHttpRequest $httpRequest,
        UpdateProfileAction $action,
        UserArrayPresenter $userArrayPresenter
    ): ApiResponse 
    {
        $response = $action->execute(
            new UpdateProfileRequest(
                $httpRequest->get('email'),
                $httpRequest->get('first_name'),
                $httpRequest->get('last_name'),
                $httpRequest->get('nickname')
            )
        );
        return $this->createSuccessResponse($userArrayPresenter->present($response->getUser()));
    }
   
    // public function sendPasswordResetLink(
    //     SendResetPasswordHttpRequest $request
    //     )
    // {
        
    //     return $this->sendResetPasswordAction->execute($request);
    // }
    // public function callResetPassword(
    //     ResetPasswordHttpRequest $request
    //     )
    // {
    //     return $this->resetPasswordAction->execute($request);
    // }

    
}
