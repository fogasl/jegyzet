<?php

namespace FLDSoftware\WebApp\Authentication;

use FLDSoftware\Http\Request;

// Defines methods for authenticating a particular HTTP request.
interface IAuthenticator {

    // Accept incoming authentication request.
    // Input instance may contain arbitrary data required for the authentication
    // process (nor the request/response is sufficient?)
    public function accept(Request $request, Response $response): AuthenticationResult;

    // Called before a request is dispatched to a particular controller method.
    // Checks if the user have permission to access the requested resource.
    public function check(Request $request): AuthenticationResult;

    // Reject
    public function reject(Request $request): AuthenticationResult;

}

/*
$requestDispatcher->dispatch($request);

// Before calling controller method, check authentication state
// is the request is authenticated, continue
// throw exception otherwise and let RequestDispatcher handle redirection or so
// (up to the implementation)

RequestDispatcher::beforeDispatch(Request $request, Response $response, DispatchDestination $dest) {
    try {
        $auth = $dest->getAuthentication(); // controller::authentication() => array(array(method => strategy))

        if ($auth->required) {
            $strat = $this->context->getAuthStrategy($auth->strategy);
        }

        $intermediateResult = $strat->check($request);

        if ($intermediateResult->isGranted()) {
            logDebug("Request authenticated", $request);
            return true;
        } else {
            throw new NotAuthenticatedException($request);
        }
    } catch (NotAuthenticatedExcetpion $ex) {
        return false;
    } catch (\Exception $ex) {

    }
}


*/
