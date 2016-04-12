<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class UseCaseController
 * @package App\Http\Controllers
 */
class TriggerFulfillmentController extends Controller
{
    use \PHPWorkFlow\WorkFlowDAOTrait;
    use \PHPWorkFlow\TriggerFulfillmentUtilTrait;

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showTriggerFulfillment(Request $request)
    {
        return self::standardJSONResponse($this->getTriggerFulfillmentUtil()->FetchTriggerFulfillmentArr(), $request);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showTriggerFulfillmentWithUseCaseId($use_case_id, Request $request)
    {
        if ($useCaseObj = $this->getWorkFlowDAO()->FetchUseCaseWithUseCaseId($use_case_id)) {
            return self::standardJSONResponse($this->getTriggerFulfillmentUtil()->FetchTriggerFulfillmentArrWithUseCaseId($use_case_id),
                $request);
        }
        return self::standardJSONResponse(null, $request, 'cannot find useCase object in question');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showTriggerFulfillmentWithUseCaseStatus($use_case_status, Request $request)
    {
        return self::standardJSONResponse(
            $this->getTriggerFulfillmentUtil()->FetchTriggerFulfillmentArrWithUseCaseStatus($use_case_status),
            $request
        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createTriggerFulfillment(Request $request)
    {
        if (!$useCaseObj = $this->getWorkFlowDAO()->FetchUseCaseWithUseCaseId($request->json('use_case_id'))) {
            return self::standardJSONResponse(null, $request, 'cannot find $useCaseObj in question');
        }
        $triggerFulfillmentObj = $this->getTriggerFulfillmentUtil()->CreateTriggerFulfillment(
            [
                'UseCaseId'    => $request->json('use_case_id'),
                'TransitionId' => $request->json('transition_id')
            ]
        );
        return self::standardJSONResponse($triggerFulfillmentObj, $request);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteTriggerFulfillmentWithTriggerFulfillmentId($trigger_fulfillment_id, Request $request)
    {
        if ($this->getTriggerFulfillmentUtil()->DeleteTriggerFulfillmentWithTriggerFulfillmentId($trigger_fulfillment_id)) {
            return self::standardJSONResponse(['id' => $trigger_fulfillment_id], $request);
        }
        return self::standardJSONResponse(null, $request, 'cannot find object in question');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteTriggerFulfillmentWithUseCaseId($use_case_id, Request $request)
    {
        if ($useCaseObj = $this->getWorkFlowDAO()->FetchUseCaseWithUseCaseId($use_case_id)) {
            $trigger_fulfillment_id_arr = [];
            foreach ($this->getTriggerFulfillmentUtil()->FetchTriggerFulfillmentArrWithUseCaseId($use_case_id) as $triggerFulfillmentObj) {
                $trigger_fulfillment_id_arr[] = $triggerFulfillmentObj->getTriggerFulfillmentId();
            }

            $this->getTriggerFulfillmentUtil()->DeleteTriggerFulfillmentWithUseCaseId($use_case_id);
            return self::standardJSONResponse(['id' => $trigger_fulfillment_id_arr], $request);
        }
        return self::standardJSONResponse(null, $request, 'cannot find object in question');
    }
}
