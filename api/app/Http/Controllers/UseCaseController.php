<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class UseCaseController
 * @package App\Http\Controllers
 */
class UseCaseController extends Controller
{
    use \PHPWorkFlow\WorkFlowDAOTrait;

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showUseCases(Request $request)
    {
        return self::standardJSONResponse($this->getWorkFlowDAO()->FetchUseCaseArr(), $request);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showUseCaseWithUseCaseId($use_case_id, Request $request)
    {
        if ($useCaseObj = $this->getWorkFlowDAO()->FetchUseCaseWithUseCaseId($use_case_id)) {
            return self::standardJSONResponse($useCaseObj, $request);
        }
        return self::standardJSONResponse(null, $request, 'cannot find object in question');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createUseCase(Request $request)
    {
        if (!$workFlowObj = $this->getWorkFlowDAO()->FetchWorkFlowWithWorkFlowId($request->json('work_flow_id'))) {
            return self::standardJSONResponse(null, $request, 'cannot find workFlow obj in question');
        }
        $useCaseObj = $this->getWorkFlowDAO()->CreateUseCase(
            [
                'WorkFlowId'    => $request->json('work_flow_id'),
                'Name'          => $request->json('name'),
                'Description'   => $request->json('description'),
                'UseCaseStatus' => \PHPWorkFlow\Enum\UseCaseStatusEnum::OPEN
            ]
        );
        return self::standardJSONResponse($useCaseObj, $request);
    }

    /**
     * @param $use_case_id
     * @return \Symfony\Component\HttpFoundation\Response|void
     */
    public function deleteUseCase($use_case_id, Request $request)
    {
        if ($useCaseObj = $this->getWorkFlowDAO()->FetchUseCaseWithUseCaseId($use_case_id)) {
            $this->getWorkFlowDAO()->DeleteUseCaseWithUseCaseId($use_case_id);
            return self::standardJSONResponse(['id' => $use_case_id], $request);
        }
        return self::standardJSONResponse(null, $request, 'cannot find object in question');
    }
}
