<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class WorkItemController
 * @package App\Http\Controllers
 */
class WorkItemController extends Controller
{
    use \PHPWorkFlow\WorkFlowDAOTrait;

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showWorkItems(Request $request)
    {
        return self::standardJSONResponse($this->getWorkFlowDAO()->FetchWorkItemArr(), $request);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showWorkItemWithWorkItemId($work_item_id, Request $request)
    {
        return self::standardJSONResponse($this->getWorkFlowDAO()->FetchWorkItemWithWorkItemId($work_item_id),
            $request);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showWorkItemsWithUseCaseId($use_case_id, Request $request)
    {
        return self::standardJSONResponse($this->getWorkFlowDAO()->FetchWorkItemArrWithUseCaseIdArr($use_case_id),
            $request);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showWorkItemsWithWorkItemStatus($work_item_status, Request $request)
    {
        return self::standardJSONResponse(
            $this->getWorkFlowDAO()->FetchWorkItemArrWithWorkItemStatus(
                $work_item_status),
                $request
        );
    }
}
