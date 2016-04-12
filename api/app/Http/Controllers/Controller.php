<?php
namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use Illuminate\Http\Request;

/**
 * Class Controller
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    const JSON_RESPONCE_SUCCESS = 'success';
    const JSON_RESPONCE_FAIL = 'fail';

    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_DELETE = 'DELETE';

    /**
     * @param        $data
     * @param string $status
     * @return \Symfony\Component\HttpFoundation\Response
     */
    static function standardJSONResponse($data, Request $request, $errors = [], $warnings = [])
    {
        $responce_arr = [
            "status" => $errors ? Controller::JSON_RESPONCE_FAIL : Controller::JSON_RESPONCE_SUCCESS,
            "meta"   => self::standardJSONMeta($request, $data)
        ];
        if ($data || is_array($data)) {
            $responce_arr['data'] = self::arrayificate($data);
        }
        if ($errors) {
            $responce_arr['errors'] = self::standardJSONErrors($errors);
        }
        if ($warnings) {
            $responce_arr['warnings'] = self::standardJSONWarnings($warnings);
        }
        return response()->json($responce_arr);
    }

    /**
     * @param Request $request
     * @return array
     */
    static function standardJSONMeta(Request $request, $data = null)
    {
        $returnMe = [
            'request_method' => $request->method(),
            'request_uri'    => $request->getRequestUri(),
            'time'           => time()
        ];
        if (is_array($data)) {
            $returnMe['count'] = count($data);
        }
        return $returnMe;
    }

    /**
     * @param $errors
     * @return array|null
     */
    static function standardJSONErrors($errors)
    {
        if (is_array($errors)) {
            return self::arrayificate($errors);
        }
        if (is_object($errors)) {
            return [self::arrayificate($errors)];
        }
        return [$errors];
    }

    /**
     * @param $warnings
     * @return array|null
     */
    static function standardJSONWarnings($warnings)
    {
        if (is_array($warnings)) {
            return self::arrayificate($warnings);
        }
        if (is_object($warnings)) {
            return [self::arrayificate($warnings)];
        }
        return [$warnings];
    }

    /**
     * @param array $oject_or_object_arr
     * @return array|null
     * @throws \Exception
     */
    static function arrayificate($oject_or_object_arr)
    {
        if (!$oject_or_object_arr) {
            if (is_array($oject_or_object_arr)) {
                /**
                 * empty array
                 */
                return [];
            }
            return null;
        } elseif (is_object($oject_or_object_arr) && method_exists($oject_or_object_arr, 'toArray')) {
            return $oject_or_object_arr->toArray();
        } elseif (is_array($oject_or_object_arr)) {
            $returnMe = [];
            foreach ($oject_or_object_arr as $candidateObj) {
                if (is_object($candidateObj) && method_exists($candidateObj, 'toArray')) {
                    $returnMe[] = $candidateObj->toArray();
                } else {
                    return $oject_or_object_arr;
                }
            }
            return $returnMe;
        }
        return $oject_or_object_arr;
    }
}
