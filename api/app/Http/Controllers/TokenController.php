<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class TokenController
 * @package App\Http\Controllers
 */
class TokenController extends Controller
{
    use \PHPWorkFlow\WorkFlowDAOTrait;

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showTokens(Request $request)
    {
        return self::standardJSONResponse($this->getWorkFlowDAO()->FetchTokenArr(), $request);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showTokenWithTokenId($token_id, Request $request)
    {
        if ($tokenObj = $this->getWorkFlowDAO()->FetchTokenWithTokenId($token_id)) {
            return self::standardJSONResponse($tokenObj, $request);
        }
        return self::standardJSONResponse(null, $request, 'cannot find object in question');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showTokensWithUseCaseId($use_case_id, Request $request)
    {
        if (!$useCaseObj = $this->getWorkFlowDAO()->FetchUseCaseWithUseCaseId($use_case_id)) {
            return self::standardJSONResponse(null, $request, 'cannot find object in question');
        }
        return self::standardJSONResponse($this->getWorkFlowDAO()->FetchTokenArrWithUseCaseId($use_case_id), $request);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showTokensWithTokenStatus($token_status, Request $request)
    {
        return self::standardJSONResponse($this->getWorkFlowDAO()->FetchTokenArrWithTokenStatus($token_status),
            $request);
    }
}
