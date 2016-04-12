<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class WorkFlowController
 * @package App\Http\Controllers
 */
class WorkFlowController extends Controller
{
    use \PHPWorkFlow\WorkFlowDAOTrait;
    use \PHPWorkFlow\PNMLTrait;
    use \PHPWorkFlow\TriggerUtilTrait;

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showWorkFlows(Request $request)
    {
        return self::standardJSONResponse($this->getWorkFlowDAO()->FetchWorkFlowArr(), $request);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showWorkFlowWithWorkFlowId($work_flow_id, Request $request)
    {
        if ($workFlowObj = $this->getWorkFlowDAO()->FetchWorkFlowWithWorkFlowId($work_flow_id)) {
            return self::standardJSONResponse($workFlowObj, $request);
        }
        return self::standardJSONResponse(null, $request, 'cannot find object in question');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createWorkFlow(Request $request)
    {
        $workFlowObj = $this->getPNMLBusiness()->UploadPNML($request->file('pnml')->getPathname());
        $this->getTriggerUtil()->GenerateWorkFlowTriggerClass($workFlowObj);
        return self::standardJSONResponse($workFlowObj, $request);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteWorkFlow($work_flow_id, Request $request)
    {
        if ($workFlowObj = $this->getWorkFlowDAO()->FetchWorkFlowWithWorkFlowId($work_flow_id)) {
            $this->getWorkFlowDAO()->DeleteWorkFlowWithWorkFlowId($work_flow_id);
            return self::standardJSONResponse(['id' => $work_flow_id], $request);
        }
        return self::standardJSONResponse(null, $request, 'cannot find object in question');
    }
}
