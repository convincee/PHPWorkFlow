<?php

/**
 * @method static assertArrayHasKey($key, $array, $message = '')
 * @method static assertArrayNotHasKey($key, $array, $message = '')
 * @method static assertAttributeContains($needle, $haystackAttributeName, $haystackClassOrObject, $message = '', $ignoreCase = FALSE, $checkForObjectIdentity = TRUE)
 * @method static assertAttributeContainsOnly($type, $haystackAttributeName, $haystackClassOrObject, $isNativeType = NULL, $message = '')
 * @method static assertAttributeCount($expectedCount, $haystackAttributeName, $haystackClassOrObject, $message = '')
 * @method static assertAttributeEmpty($haystackAttributeName, $haystackClassOrObject, $message = '')
 * @method static assertAttributeEquals($expected, $actualAttributeName, $actualClassOrObject, $message = '', $delta = 0, $maxDepth = 10, $canonicalize = FALSE, $ignoreCase = FALSE)
 * @method static assertAttributeGreaterThan($expected, $actualAttributeName, $actualClassOrObject, $message = '')
 * @method static assertAttributeGreaterThanOrEqual($expected, $actualAttributeName, $actualClassOrObject, $message = '')
 * @method static assertAttributeInstanceOf($expected, $attributeName, $classOrObject, $message = '')
 * @method static assertAttributeInternalType($expected, $attributeName, $classOrObject, $message = '')
 * @method static assertAttributeLessThan($expected, $actualAttributeName, $actualClassOrObject, $message = '')
 * @method static assertAttributeLessThanOrEqual($expected, $actualAttributeName, $actualClassOrObject, $message = '')
 * @method static assertAttributeNotContains($needle, $haystackAttributeName, $haystackClassOrObject, $message = '', $ignoreCase = FALSE, $checkForObjectIdentity = TRUE)
 * @method static assertAttributeNotContainsOnly($type, $haystackAttributeName, $haystackClassOrObject, $isNativeType = NULL, $message = '')
 * @method static assertAttributeNotCount($expectedCount, $haystackAttributeName, $haystackClassOrObject, $message = '')
 * @method static assertAttributeNotEmpty($haystackAttributeName, $haystackClassOrObject, $message = '')
 * @method static assertAttributeNotEquals($expected, $actualAttributeName, $actualClassOrObject, $message = '', $delta = 0, $maxDepth = 10, $canonicalize = FALSE, $ignoreCase = FALSE)
 * @method static assertAttributeNotInstanceOf($expected, $attributeName, $classOrObject, $message = '')
 * @method static assertAttributeNotInternalType($expected, $attributeName, $classOrObject, $message = '')
 * @method static assertAttributeNotSame($expected, $actualAttributeName, $actualClassOrObject, $message = '')
 * @method static assertAttributeSame($expected, $actualAttributeName, $actualClassOrObject, $message = '')
 * @method static assertClassHasAttribute($attributeName, $className, $message = '')
 * @method static assertClassHasStaticAttribute($attributeName, $className, $message = '')
 * @method static assertClassNotHasAttribute($attributeName, $className, $message = '')
 * @method static assertClassNotHasStaticAttribute($attributeName, $className, $message = '')
 * @method static assertContains($needle, $haystack, $message = '', $ignoreCase = FALSE, $checkForObjectIdentity = TRUE)
 * @method static assertContainsOnly($type, $haystack, $isNativeType = NULL, $message = '')
 * @method static assertContainsOnlyInstancesOf($classname, $haystack, $message = '')
 * @method static assertCount($expectedCount, $haystack, $message = '')
 * @method static assertEmpty($actual, $message = '')
 * @method static assertEqualXMLStructure(DOMElement $expectedElement, DOMElement $actualElement, $checkAttributes = FALSE, $message = '')
 * @method assertEquals($expected, $actual, $message = '', $delta = 0, $maxDepth = 10, $canonicalize = FALSE, $ignoreCase = FALSE)
 * @method static assertFalse($condition, $message = '')
 * @method static assertFileEquals($expected, $actual, $message = '', $canonicalize = FALSE, $ignoreCase = FALSE)
 * @method static assertFileExists($filename, $message = '')
 * @method static assertFileNotEquals($expected, $actual, $message = '', $canonicalize = FALSE, $ignoreCase = FALSE)
 * @method static assertFileNotExists($filename, $message = '')
 * @method static assertGreaterThan($expected, $actual, $message = '')
 * @method static assertGreaterThanOrEqual($expected, $actual, $message = '')
 * @method static assertInstanceOf($expected, $actual, $message = '')
 * @method static assertInternalType($expected, $actual, $message = '')
 * @method static assertJsonFileEqualsJsonFile($expectedFile, $actualFile, $message = '')
 * @method static assertJsonFileNotEqualsJsonFile($expectedFile, $actualFile, $message = '')
 * @method static assertJsonStringEqualsJsonFile($expectedFile, $actualJson, $message = '')
 * @method static assertJsonStringEqualsJsonString($expectedJson, $actualJson, $message = '')
 * @method static assertJsonStringNotEqualsJsonFile($expectedFile, $actualJson, $message = '')
 * @method static assertJsonStringNotEqualsJsonString($expectedJson, $actualJson, $message = '')
 * @method static assertLessThan($expected, $actual, $message = '')
 * @method static assertLessThanOrEqual($expected, $actual, $message = '')
 * @method static assertNotContains($needle, $haystack, $message = '', $ignoreCase = FALSE, $checkForObjectIdentity = TRUE)
 * @method static assertNotContainsOnly($type, $haystack, $isNativeType = NULL, $message = '')
 * @method static assertNotCount($expectedCount, $haystack, $message = '')
 * @method static assertNotEmpty($actual, $message = '')
 * @method static assertNotEquals($expected, $actual, $message = '', $delta = 0, $maxDepth = 10, $canonicalize = FALSE, $ignoreCase = FALSE)
 * @method static assertNotInstanceOf($expected, $actual, $message = '')
 * @method static assertNotInternalType($expected, $actual, $message = '')
 * @method static assertNotNull($actual, $message = '')
 * @method static assertNotRegExp($pattern, $string, $message = '')
 * @method static assertNotSame($expected, $actual, $message = '')
 * @method static assertNotSameSize($expected, $actual, $message = '')
 * @method static assertNotTag($matcher, $actual, $message = '', $isHtml = TRUE)
 * @method assertNull($actual, $message = '')
 * @method static assertObjectHasAttribute($attributeName, $object, $message = '')
 * @method static assertObjectNotHasAttribute($attributeName, $object, $message = '')
 * @method static assertRegExp($pattern, $string, $message = '')
 * @method static assertSame($expected, $actual, $message = '')
 * @method static assertSameSize($expected, $actual, $message = '')
 * @method static assertSelectCount($selector, $count, $actual, $message = '', $isHtml = TRUE)
 * @method static assertSelectEquals($selector, $content, $count, $actual, $message = '', $isHtml = TRUE)
 * @method static assertSelectRegExp($selector, $pattern, $count, $actual, $message = '', $isHtml = TRUE)
 * @method static assertStringEndsNotWith($suffix, $string, $message = '')
 * @method static assertStringEndsWith($suffix, $string, $message = '')
 * @method static assertStringEqualsFile($expectedFile, $actualString, $message = '', $canonicalize = FALSE, $ignoreCase = FALSE)
 * @method static assertStringMatchesFormat($format, $string, $message = '')
 * @method static assertStringMatchesFormatFile($formatFile, $string, $message = '')
 * @method static assertStringNotEqualsFile($expectedFile, $actualString, $message = '', $canonicalize = FALSE, $ignoreCase = FALSE)
 * @method static assertStringNotMatchesFormat($format, $string, $message = '')
 * @method static assertStringNotMatchesFormatFile($formatFile, $string, $message = '')
 * @method static assertStringStartsNotWith($prefix, $string, $message = '')
 * @method static assertStringStartsWith($prefix, $string, $message = '')
 * @method static assertTag($matcher, $actual, $message = '', $isHtml = TRUE)
 * @method static assertThat($value, PHPUnit_Framework_Constraint $constraint, $message = '')
 * @method static assertTrue($condition, $message = '')
 * @method static assertXmlFileEqualsXmlFile($expectedFile, $actualFile, $message = '')
 * @method static assertXmlFileNotEqualsXmlFile($expectedFile, $actualFile, $message = '')
 * @method static assertXmlStringEqualsXmlFile($expectedFile, $actualXml, $message = '')
 * @method static assertXmlStringEqualsXmlString($expectedXml, $actualXml, $message = '')
 * @method static assertXmlStringNotEqualsXmlFile($expectedFile, $actualXml, $message = '')
 * @method static assertXmlStringNotEqualsXmlString($expectedXml, $actualXml, $message = '')
 *
 * @codeCoverageIgnore
 */
class PHPWorkFlow_Framework_TestCase_Integration extends PHPUnit_Framework_TestCase
{

    use \PHPWorkFlow\WorkFlowDAOTrait;
    use \PHPWorkFlow\PNMLTrait;
    use \PHPWorkFlow\TriggerFulfillmentUtilTrait;
    use \PHPWorkFlow\TriggerUtilTrait;

    static protected $doFullCleanup = true;
    /**
     * @var bool
     * This should be false unless debugging
     */
    static protected $saveOffPNMLFiles = false;

    /**
     * Constructs a test case with the given name.
     *
     * @param  string $name
     * @param  array  $data
     * @param  string $dataName
     */
    public function __construct($name = NULL, array $data = [], $dataName = '')
    {
        ini_set('error_reporting', E_ALL | E_STRICT);
        parent::__construct($name, $data, $dataName);
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();
    }

    /**
     * Cleanup after test
     */
    protected function tearDown()
    {
        parent::tearDown();
    }

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        /**
         * these files are really only useful when debugging
         */
        if(self::$saveOffPNMLFiles)
        {
            if(file_exists(PHPWORKFLOW_ARTIFACTS_DIR . '/UnitTest/'))
            {
                self::deleteDir(PHPWORKFLOW_ARTIFACTS_DIR . '/UnitTest/');
                mkdir(PHPWORKFLOW_ARTIFACTS_DIR . '/UnitTest/');
            }
        }
    }

    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();
    }

    public function testTrivialToShutUpPHPUnit()
    {
        $this->assertInternalType('string', 'xxx');
    }

    /**
     * @param $dirPath
     * @return bool
     */
    public static function deleteDir($dirPath) {
        if (! is_dir($dirPath)) {
            if(! file_exists($dirPath))
            {
                return true;
            }
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        return rmdir($dirPath);
    }

    /**
     * @param \PHPWorkFlow\DB\UseCase $useCaseObj
     * @return bool|\PHPWorkFlow\DB\UseCase
     */
    public function finishTestWorkFlowUseCase(\PHPWorkFlow\DB\UseCase $useCaseObj)
    {
        $this->doSomething($useCaseObj, 'TR45EmailStaffStartingAddOrganizationTriggerUser', 0, 3, 1, __FUNCTION__);
        $this->doSomething($useCaseObj, 'TR1AddOrgType1TriggerUser', 0, 2, 2, __FUNCTION__);

        /*
         * here is we take the 'shortcut' around the TR22 loop
         */
        $this->getTriggerFulfillmentUtil()->CreateTriggerFulfillment(
            [
                'UseCaseId'              => $useCaseObj->getUseCaseId(),
                'TransitionId'  =>$this->getWorkFlowDAO()->FetchTransitionWithWorkFlowIdAndTransitionTriggerMethod(
                    $useCaseObj->getWorkFlowId(),
                    'TR5BuildUserRegistersTriggerGate'
                )->getTransitionId()
            ]
        );

        $this->doSomething($useCaseObj, 'TR3InviteBuildUserTriggerUser', 0, 2, 2, __FUNCTION__);
        $this->doSomething($useCaseObj, 'TR20CreateBuildUserConfigTriggerUser', 0, 4, 4, __FUNCTION__);
        $this->doSomething($useCaseObj, 'TR9AddBuildUserWorkPhoneTriggerUser', 0, 3, 4, __FUNCTION__);
        $this->doSomething($useCaseObj, 'TR10AddBuildUser24x7PhoneTriggerUser', 0, 2, 4, __FUNCTION__);
        $this->doSomething($useCaseObj, 'TR11AddBuildUserCellPhoneTriggerUser', 0, 2, 2, __FUNCTION__);
        $this->doSomething($useCaseObj, 'TR2InviteTeamAgentTriggerUser', 0, 2, 2, __FUNCTION__);
        $this->doSomething($useCaseObj, 'TR4TeamAgentRegistersTriggerUser', 0, 2, 2, __FUNCTION__);
        $this->doSomething($useCaseObj, 'TR19CreateTeamAgentConfigTriggerUser', 0, 4, 4, __FUNCTION__);
        $this->doSomething($useCaseObj, 'TR6AddTeamAgentWorkPhoneTriggerUser', 0, 3, 4, __FUNCTION__);
        $this->doSomething($useCaseObj, 'TR8AddTeamAgentCellPhoneTriggerUser', 0, 2, 4, __FUNCTION__);
        $this->doSomething($useCaseObj, 'TR7AddTeamAgentHomePhoneTriggerUser', 0, 2, 2, __FUNCTION__);
        $this->doSomething($useCaseObj, 'TR17AddTeamAgentFaxPhoneTriggerUser', 0, 1, 2, __FUNCTION__);
        $this->doSomething($useCaseObj, 'TR18AddBuildFaxPhoneTriggerUser', 0, 0, 0, __FUNCTION__);

        $useCaseObj = $this->getWorkFlowDAO()->FetchUseCaseWithUseCaseId($useCaseObj->getUseCaseId());
        if(! $useCaseObj->getOpenChildern())
        {
            $this->assertEquals(\PHPWorkFlow\Enum\UseCaseStatusEnum::CLOSED, $useCaseObj->getUseCaseStatus());
        }
        return $useCaseObj;
    }
    /**
     * @param \PHPWorkFlow\DB\UseCase $useCaseObj
     * @param                         $thing_to_do
     * @param                         $i | passing 0 supresses saveOffPnml()
     * @param null                    $expected_num_workItems
     * @param null                    $expected_num_free_tokens
     * @param string                  $test_name
     * @param bool|true               $checkThingToDoWorkItem
     */
    public function doSomething(
        PHPWorkFlow\DB\UseCase $useCaseObj,
        $thing_to_do,
        $i,
        $expected_num_workItems = null,
        $expected_num_free_tokens = null,
        $test_name = 'unknown',
        $checkThingToDoWorkItem = true
    ) {
        if ($checkThingToDoWorkItem) {
            $this->assertEquals(
                1,
                $this->getWorkFlowDAO()->FetchEnabledWorkItemWithUseCaseIdAndTransitionTriggerMethodCount(
                    $useCaseObj->getUseCaseId(),
                    $thing_to_do
                ),
                "doSomething - trying to do $thing_to_do but no workitem found -  use_case_id = " . $useCaseObj->getUseCaseId()
            );
            $this->assertEquals(
                1,
                count($useCaseObj->getEnabledWorkItemArrWithTransitionTriggerMethod($thing_to_do))
            );
        }
        $this->getTriggerFulfillmentUtil()->CreateTriggerFulfillment(
            [
                'UseCaseId' => $useCaseObj->getUseCaseId(),
                'TriggerFulfillmentStatus' => \PHPWorkFlow\Enum\TriggerFulfillmentStatusEnum::FREE,
                'TransitionId'  =>$this->getWorkFlowDAO()->FetchTransitionWithWorkFlowIdAndTransitionTriggerMethod(
                    $useCaseObj->getWorkFlowId(),
                    $thing_to_do
                )->getTransitionId()
            ]
        );

        $WorkFlowEngine = new PHPWorkFlow\WorkFlowEngine($useCaseObj->getUseCaseId());
        $WorkFlowEngine->PushWorkItems();

        if($i)
        {
            $this->saveOffPnml($useCaseObj->getWorkFlow(), $useCaseObj, $i, $test_name);
        }

        if ($expected_num_workItems) {
            $this->assertEquals(
                $expected_num_workItems,
                $useCaseObj->getEnabledWorkItemCount(),
                "doSomething - trying to do $thing_to_do one use_case = " . $useCaseObj->getUseCaseId() . "expected_num_workItems = $expected_num_workItems "
            );
        }
        if ($expected_num_free_tokens) {
            $this->assertEquals(
                $expected_num_free_tokens,
                $useCaseObj->getFreeTokenCount(),
                "doSomething - trying to do $thing_to_do one use_case = " . $useCaseObj->getUseCaseId() . "expected_num_free_tokens = $expected_num_free_tokens "
            );
        }
    }

    /**
     * @param $workFlowObj \PHPWorkFlow\DB\WorkFlow
     * @param $useCaseObj \PHPWorkFlow\DB\UseCase|null
     * @throws \PHPWorkFlow\Exception_WorkFlow
     */
    public function saveOffPnml(\PHPWorkFlow\DB\WorkFlow $workFlowObj, $useCaseObj=null, $context=0, $test_name){

        if (self::$saveOffPNMLFiles) {
            $work_flow_xml = $this->getPNMLBusiness()->GeneratePNML($workFlowObj->getWorkFlowId(), ($useCaseObj ? $useCaseObj->getUseCaseId() : null) );
            file_put_contents(PHPWORKFLOW_ARTIFACTS_DIR . '/UnitTest/'.__CLASS__.'.'.$test_name.'.'.$context.'.pnml',
                $work_flow_xml);
        }
    }

    /**
     * @return string
     */
    public function guid(){
        if (function_exists('com_create_guid')){
            return com_create_guid();
        }else{
            mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = chr(123)// "{"
                .substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12)
                .chr(125);// "}"
            return $uuid;
        }
    }
}
