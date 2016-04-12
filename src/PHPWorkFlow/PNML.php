<?php
/**
 * Class BOPNML
 */
namespace PHPWorkFlow;

use PHPWorkFlow\DB\Transition;
use PHPWorkFlow\DB\Place;
use PHPWorkFlow\DB\Arc;
use PHPWorkFlow\Enum\NotificationTypeEnum;
use PHPWorkFlow\Enum\TransitionTypeEnum;

/**
 * Class PNML
 * @package PHPWorkFlow
 */
class PNML
{
    use WorkFlowDAOTrait;
    use CommonUtilTrait;

    /**
     * @param string $pnml_file_path
     * @return DB\WorkFlow
     * @throws \Exception
     */
    public function UploadPNML($pnml_file_path)
    {
        $pnmlFileContents = file_get_contents($pnml_file_path);

        $lRootElement = new \SimpleXMLElement($pnmlFileContents);
        $workFlowNameNodeArr = $lRootElement->xpath('/pnml/net/name');
        $workFlowName = (string)$workFlowNameNodeArr[0]->text;

        /**
         * @todo fix me
         */
        while ($this->getWorkFlowDAO()->FetchWorkFlowWithName($workFlowName)) {
            /*
             * @todo - this should be Ver 1, Ver 2 .....
             */
            $workFlowName .= rand(1, 9);
        }
        /** @var \SimpleXMLElement[] $arcNodeArr */
        $arcNodeArr = $lRootElement->xpath('/pnml/net/arc');
        /** @var \SimpleXMLElement[] $transitionNodeArr */
        $transitionNodeArr = $lRootElement->xpath('/pnml/net/transition');
        /** @var \SimpleXMLElement[] $placeNodeArr */
        $placeNodeArr = $lRootElement->xpath('/pnml/net/place');

        $workFlowObj = $this->getWorkFlowDAO()->CreateWorkFlow(
            [
                'Name'         => $workFlowName,
                'Description'  => '{}',
                'TriggerClass' => 'Trigger' . $this->getCommonUtil()->CamelCapitalizeFieldName(str_replace(' ',
                        '', $workFlowName), true)
            ]
        );

        foreach ($placeNodeArr as $placeNode) {
            $placeAttributeArr = [];
            foreach ($placeNode->attributes() as $placeAttributeName => $placeAttributeValue) {
                $placeAttributeArr[$placeAttributeName] = (string)$placeAttributeValue;
            }
            if (isset($placeNode->name->text) && $placeNode->name->text) {
                $placeName = (string)$placeNode->name->text;
            } elseif (isset($placeAttributeArr['id'])) {
                $placeName = (string)strtoupper($placeAttributeArr['id']);
            } else {
                throw new \Exception("No place attr id found");
            }
            if (!preg_match("/^PL/i", $placeName)) {
                $placeName = 'PL' . rand(1000, 10000) . $placeName;
            }

            $placeDescriptionArr = [];
            if (isset($placeNode->description->text)) {
                $placeDescriptionArr = (array)json_decode($placeNode->description->text);
                if ($json_error = json_last_error()) {
                    throw new Exception_WorkFlow("json_error = " . $this->get_json_error($json_error) . " at " . $placeName);
                }
            }

            $placePositionAttributeArr = [];
            foreach ($placeNode->graphics->position->attributes() as $positionAttributeName => $positionAttributeValue) {
                $placePositionAttributeArr[$positionAttributeName] = (string)$positionAttributeValue;
            }
            $placeDimensionAttributeArr = [];
            foreach ($placeNode->graphics->dimension->attributes() as $dimensionAttributeName => $dimensionAttributeValue) {
                $placeDimensionAttributeArr[$dimensionAttributeName] = (string)$dimensionAttributeValue;
            }

            if (isset($placeDescriptionArr['PlaceType']) && $placeDescriptionArr['PlaceType'] == Enum\PlaceTypeEnum::START_PLACE) {
                $place_type = Enum\PlaceTypeEnum::START_PLACE;
            } elseif (isset($placeDescriptionArr['PlaceType']) && $placeDescriptionArr['PlaceType'] == Enum\PlaceTypeEnum::END_PLACE) {
                $place_type = Enum\PlaceTypeEnum::END_PLACE;
            } else {
                $place_type = Enum\PlaceTypeEnum::INTERMEDIATE_PLACE;
            }

            while ($this->getWorkFlowDAO()->FetchPlaceWithWorkFlowIdAndName($workFlowObj->getWorkFlowId(),
                $placeName)) {
                $placeName = $placeName . rand(1, 9);
            }
            while ($this->getWorkFlowDAO()->FetchPlaceWithWorkFlowIdAndYasperName($workFlowObj->getWorkFlowId(),
                $placeAttributeArr['id'])) {
                $placeAttributeArr['id'] = $placeAttributeArr['id'] . rand(1, 9);
            }
            $this->getWorkFlowDAO()->CreatePlace(
                [
                    'PlaceType'   => $place_type,
                    'Name'        => $placeName,
                    'WorkFlowId'  => $workFlowObj->getWorkFlowId(),
                    'PositionX'   => $placePositionAttributeArr['x'],
                    'PositionY'   => $placePositionAttributeArr['y'],
                    'DimensionX'  => $placeDimensionAttributeArr['x'],
                    'DimensionY'  => $placeDimensionAttributeArr['y'],
                    'YasperName'  => $placeAttributeArr['id'],
                    'Description' => json_encode($placeDescriptionArr)
                ]
            );
        }

        foreach ($transitionNodeArr as $transitionNode) {
            $transitionAttributeArr = [];
            foreach ($transitionNode->attributes() as $transitionAttributeName => $transitionAttributeValue) {
                $transitionAttributeArr[$transitionAttributeName] = (string)$transitionAttributeValue;
            }

            if (isset($transitionNode->name->text) && $transitionNode->name->text) {
                $transitionName = (string)$transitionNode->name->text;
            } else {
                throw new Exception_WorkFlow("No transitionName found");
            }

            $transitionJSON = [];
            if (isset($transitionNode->description->text) && $transitionNode->description->text) {
                $x = $transitionNode->description->text;
                $transitionJSON = (array)json_decode($transitionNode->description->text);
                if ($json_error = json_last_error()) {
                    throw new \Exception("json_error = " . $this->get_json_error($json_error) . " at " . $transitionName);
                }
            }

            $transition_type = null;
            if (strtoupper($transitionName) == 'TR0') {
                $transition_type = Enum\TransitionTypeEnum::EMITTER;
            } elseif (strtoupper($transitionName) == 'TR999') {
                $transition_type = Enum\TransitionTypeEnum::CONSUMER;
            } elseif (isset($transitionJSON['transition_type']) && $transitionJSON['transition_type']) {
                if (strtolower($transitionJSON['transition_type']) == Enum\TransitionTypeEnum::USER) {
                    $transition_type = Enum\TransitionTypeEnum::USER;
                } elseif (strtolower($transitionJSON['transition_type']) == Enum\TransitionTypeEnum::TIMED) {
                    $transition_type = Enum\TransitionTypeEnum::TIMED;
                } elseif (strtolower($transitionJSON['transition_type']) == Enum\TransitionTypeEnum::NOTIFICATION) {
                    $transition_type = Enum\TransitionTypeEnum::NOTIFICATION;
                } elseif (strtolower($transitionJSON['transition_type']) == Enum\TransitionTypeEnum::AUTO) {
                    $transition_type = Enum\TransitionTypeEnum::AUTO;
                } elseif (strtolower($transitionJSON['transition_type']) == Enum\TransitionTypeEnum::GATE) {
                    $transition_type = Enum\TransitionTypeEnum::GATE;
                } else {
                    throw new \Exception("No transition_type found for " . $transitionName);
                }
            }
            $transitionJSON['transition_type'] = $transition_type;

            $transitionPositionAttributeArr = [];
            foreach ($transitionNode->graphics->position->attributes() as $positionAttributeName => $positionAttributeValue) {
                $transitionPositionAttributeArr[$positionAttributeName] = (string)$positionAttributeValue;
            }
            $transitionDimensionAttributeArr = [];
            foreach ($transitionNode->graphics->dimension->attributes() as $dimensionAttributeName => $dimensionAttributeValue) {
                $transitionDimensionAttributeArr[$dimensionAttributeName] = (string)$dimensionAttributeValue;
            }

            while ($this->getWorkFlowDAO()->FetchTransitionWithWorkFlowIdAndName($workFlowObj->getWorkFlowId(),
                $transitionName)) {
                $transitionName = $transitionName . rand(1, 9);
            }
            while ($this->getWorkFlowDAO()->FetchTransitionWithWorkFlowIdAndYasperName($workFlowObj->getWorkFlowId(),
                $transitionAttributeArr['id'])) {
                $transitionAttributeArr['id'] = $transitionAttributeArr['id'] . rand(1, 9);
            }

            $time_delay = null;
            if ($transition_type == Enum\TransitionTypeEnum::TIMED) {
                if (isset($transitionJSON['time_delay']) && $transitionJSON['time_delay']) {
                    $time_delay = $transitionJSON['time_delay'];
                } else {
                    throw new \Exception("No time_delay found");
                }
            }

            $transitionObj = $this->getWorkFlowDAO()->CreateTransition(
                [
                    'WorkFlowId'              => $workFlowObj->getWorkFlowId(),
                    'Name'                    => $transitionName,
                    'Description'             => json_encode($transitionJSON),
                    'TransitionType'          => $transition_type,
                    'PositionX'               => $transitionPositionAttributeArr['x'],
                    'PositionY'               => $transitionPositionAttributeArr['y'],
                    'DimensionX'              => 32,
                    'DimensionY'              => 32,
                    'YasperName'              => $transitionAttributeArr['id'],
                    'TimeDelay'               => $time_delay,
                    'TransitionTriggerMethod' => $this->getCommonUtil()->CamelCapitalizeFieldName($transitionName,
                            true) . 'Trigger' . ucfirst($transition_type)
                ]
            );

            if ($transitionObj->getTransitionType() == TransitionTypeEnum::USER) {
                if (
                    isset($transitionJSON['routes']) &&
                    is_array($transitionJSON['routes']) &&
                    count($transitionJSON['routes']) > 0
                ) {
                    foreach ($transitionJSON['routes'] as $route) {
                        $this->getWorkFlowDAO()->CreateRoute(
                            [
                                'TransitionId' => $transitionObj->getTransitionId(),
                                'Route'        => $route
                            ]
                        );
                    }
                }
            } elseif ($transitionObj->getTransitionType() == TransitionTypeEnum::NOTIFICATION) {
                if (
                    isset($transitionJSON['notifications']) &&
                    is_array((array)$transitionJSON['notifications']) &&
                    count($transitionJSON['notifications']) > 0
                ) {
                    $notificationJSON = (array)$transitionJSON['notifications'];
                    if (isset($notificationJSON['email'])) {
                        foreach ((array)$notificationJSON['email'] as $email) {
                            $this->getWorkFlowDAO()->CreateNotification(
                                [
                                    'TransitionId'       => $transitionObj->getTransitionId(),
                                    'NotificationType'   => NotificationTypeEnum::EMAIL,
                                    'NotificationString' => $email
                                ]
                            );
                        }
                    }
                    if (isset($notificationJSON['SMS'])) {
                        foreach ((array)$notificationJSON['SMS'] as $email) {
                            $this->getWorkFlowDAO()->CreateNotification(
                                [
                                    'TransitionId'       => $transitionObj->getTransitionId(),
                                    'NotificationType'   => NotificationTypeEnum::SMS,
                                    'NotificationString' => $email
                                ]
                            );
                        }
                    }
                } else {
                    throw new \Exception("No notifications found");
                }
            } elseif ($transitionObj->getTransitionType() == TransitionTypeEnum::AUTO) {
                if (
                    isset($transitionJSON['commands']) &&
                    is_array((array)$transitionJSON['commands']) &&
                    count($transitionJSON['commands']) > 0
                ) {

                    foreach ($transitionJSON['commands'] as $command) {
                        $this->getWorkFlowDAO()->CreateCommand(
                            [
                                'TransitionId'  => $transitionObj->getTransitionId(),
                                'CommandSeq'    => (integer) $command->seq,
                                'CommandString' => (string) $command->command_string
                            ]
                        );
                    }
                }
            } elseif ($transitionObj->getTransitionType() == TransitionTypeEnum::GATE) {
                if (
                    isset($transitionJSON['gates']) &&
                    is_array($transitionJSON['gates']) &&
                    count($transitionJSON['gates']) > 1
                ) {
                    foreach ($transitionJSON['gates'] as $gate) {
                        $target_yasper_name = $this->getWorkFlowDAO()->FetchTransitionWithWorkFlowIdAndYasperName(
                            $workFlowObj->getWorkFlowId(),
                            $gate->target_transition
                        )->getYasperName();
                        $this->getWorkFlowDAO()->CreateGate(
                            [
                                'TransitionId'     => $transitionObj->getTransitionId(),
                                'Value'            => $gate->value,
                                'TargetYasperName' => $target_yasper_name
                            ]
                        );
                    }
                } else {
                    throw new \Exception("Less that 2 gates found");
                }
            }
        }

        foreach ($arcNodeArr as $arcNode) {
            $arcAttributeArr = [];
            foreach ($arcNode->attributes() as $arcAttributeName => $arcAttributeValue) {
                $arcAttributeArr[$arcAttributeName] = (string)$arcAttributeValue;
            }
            $arcName = $arcAttributeArr['source'] . ' -> ' . $arcAttributeArr['target'];
            if ($arcNode->description->text) {
                $arcDescriptionArr = (array)json_decode($arcNode->description->text);
                if ($json_error = json_last_error()) {
                    throw new \Exception("json_error = " . $this->get_json_error($json_error) . " at " . $arcName);
                }
            } else {
                $arcDescriptionArr = [];
            }
            /*
             * is this an INNIE out an OUTIE arc
             */
            if (preg_match("/^TR/i", $arcAttributeArr['target'])) {
                $transition_id = $this->getWorkFlowDAO()->FetchTransitionWithWorkFlowIdAndYasperName($workFlowObj->getWorkFlowId(),
                    $arcAttributeArr['target'])->getTransitionId();
                $place_id = $this->getWorkFlowDAO()->FetchPlaceWithWorkFlowIdAndYasperName($workFlowObj->getWorkFlowId(),
                    $arcAttributeArr['source'])->getPlaceId();
                $direction = 'IN';
            } else {
                $place_id = $this->getWorkFlowDAO()->FetchPlaceWithWorkFlowIdAndYasperName($workFlowObj->getWorkFlowId(),
                    $arcAttributeArr['target'])->getPlaceId();
                $transition_id = $this->getWorkFlowDAO()->FetchTransitionWithWorkFlowIdAndYasperName($workFlowObj->getWorkFlowId(),
                    $arcAttributeArr['source'])->getTransitionId();
                $direction = 'OUT';
            }
            if (isset($arcDescriptionArr['arc_type']) && $arcDescriptionArr['arc_type']) {
                $arc_type_name = $arcDescriptionArr['arc_type'];
            } else {
                $arc_type_name = Enum\ArcTypeEnum::SEQ;
            }
            while ($this->getWorkFlowDAO()->FetchArcWithWorkFlowIdAndName($workFlowObj->getWorkFlowId(),
                $arcName)) {
                $arcName = $arcName . rand(1, 9);
            }
            while ($this->getWorkFlowDAO()->FetchArcWithWorkFlowIdAndYasperName($workFlowObj->getWorkFlowId(),
                $arcAttributeArr['id'])) {
                $arcAttributeArr['id'] = $arcAttributeArr['id'] . rand(1, 9);
            }
            $this->getWorkFlowDAO()->CreateArc(
                [
                    'WorkFlowId'   => $workFlowObj->getWorkFlowId(),
                    'TransitionId' => $transition_id,
                    'PlaceId'      => $place_id,
                    'Direction'    => $direction,
                    'ArcType'      => $arc_type_name,
                    'Description'  => json_encode($arcDescriptionArr),
                    'Name'         => $arcName,
                    'YasperName'   => $arcAttributeArr['id']
                ]
            );
        }
        return $workFlowObj;
    }

    /**
     * @param            $work_flow_id
     * @param bool|false $use_case_id
     * @return string
     * @throws Exception_WorkFlow
     */
    public function GeneratePNML($work_flow_id, $use_case_id = false)
    {
        if ($use_case_id) {
            $useCaseObj = $this->getWorkFlowDAO()->FetchUseCaseWithUseCaseId($use_case_id);
            $workFlowObj = $this->getWorkFlowDAO()->FetchWorkFlowWithWorkFlowId($useCaseObj->getWorkFlowId());
        } else {
            $useCaseObj = null;
            $workFlowObj = $this->getWorkFlowDAO()->FetchWorkFlowWithWorkFlowId($work_flow_id);
        }

        $transitionObjArr = $this->getWorkFlowDAO()->FetchTransitionArrWithWorkFlowId($workFlowObj->getWorkFlowId());
        $placeObjArr = $this->getWorkFlowDAO()->FetchPlaceArrWithWorkFlowId($workFlowObj->getWorkFlowId());
        $arcObjArr = $this->getWorkFlowDAO()->FetchArcArrWithWorkFlowId($workFlowObj->getWorkFlowId());
        usort(
            $arcObjArr,
            function (Arc $a, Arc $b) {
                if ($a->getYasperName() == $b->getYasperName()) {
                    return 0;
                }
                return (substr($a->getYasperName(), 1) < substr($b->getYasperName(), 1)) ? -1 : 1;
            }
        );

        if (count($transitionObjArr) == 0) {
            throw new Exception_WorkFlow("WorkItem w/ messed up transitions Threw Exception " . __FILE__ . __LINE__);
        }
        if (count($placeObjArr) == 0) {
            throw new Exception_WorkFlow("WorkItem w/ messed up places Threw Exception " . __FILE__ . __LINE__);
        }
        if (count($arcObjArr) == 0) {
            throw new Exception_WorkFlow("WorkItem w/ messed up arcs Threw Exception " . __FILE__ . __LINE__);
        }

        $DOMObj = new \DOMDocument ('1.0', 'utf-8');
        $DOMObj->preserveWhiteSpace = false;
        $DOMObj->formatOutput = true;

        $PNMLElement = $DOMObj->createElement('pnml');
        $netElement = $DOMObj->createElement('net');
        $netElement->setAttribute('type', "http://www.yasper.org/specs/epnml-1.1");
        $netElement->setAttribute('id', 'do72');

        $nameElement = $DOMObj->createElement('name');
        $textElement = $DOMObj->createElement('text', $workFlowObj->getName());
        $nameElement->appendChild($textElement);
        $netElement->appendChild($nameElement);

        $descriptionElement = $DOMObj->createElement('description');
        $textElement = $DOMObj->createElement('text', json_encode((object)null));
        $descriptionElement->appendChild($textElement);
        $netElement->appendChild($descriptionElement);

        $toolSpecElement = $DOMObj->createElement('toolspecific');
        $toolSpecElement->setAttribute('tool', 'Yasper');
        $toolSpecElement->setAttribute('version', '1.2.4020.34351');
        $roleElement = $DOMObj->createElement('roles');
        $roleElement->setAttribute('xmlns', 'http://www.yasper.org/specs/epnml-1.1/toolspec');
        $toolSpecElement->appendChild($roleElement);
        $netElement->appendChild($toolSpecElement);

        /*
         * if a use_case_id was passed in, get the enabled WorkItems and Tokens
         */
        $enabledTransitionIdArr = [];
        $freeTokenPlaceIdArr = [];
        if ($useCaseObj) {
            foreach ($useCaseObj->getEnabledWorkItemArr() as $WorkItem) {
                $enabledTransitionIdArr[] = $WorkItem->getTransitionId();
            }
            foreach ($useCaseObj->getFreeTokenArr() as $Token) {
                $freeTokenPlaceIdArr[] = $Token->getPlaceId();
            }
        }

        /**
         * Deal with places
         */
        foreach ($placeObjArr as $placeObj) {
            /** @var $placeObj Place */
            $placeElement = $DOMObj->createElement('place');
            $placeElement->setAttribute('id', $placeObj->getYasperName());

            $textElement = $DOMObj->createElement('text', $placeObj->getName());
            $nameElement = $DOMObj->createElement('name');
            $nameElement->appendChild($textElement);
            $placeElement->appendChild($nameElement);

            $textElement = $DOMObj->createElement('text', json_encode(['PlaceType' => $placeObj->getPlaceType()]));
            $descriptionElement = $DOMObj->createElement('description');
            $descriptionElement->appendChild($textElement);
            $placeElement->appendChild($descriptionElement);

            $graphicsElement = $DOMObj->createElement('graphics');
            $positionElement = $DOMObj->createElement('position');
            $positionElement->setAttribute('x', $placeObj->getPositionX());
            $positionElement->setAttribute('y', $placeObj->getPositionY());
            $graphicsElement->appendChild($positionElement);

            $dimensionElement = $DOMObj->createElement('dimension');
            $dimensionElement->setAttribute('x', $placeObj->getDimensionX());
            $dimensionElement->setAttribute('y', $placeObj->getDimensionY());
            $graphicsElement->appendChild($dimensionElement);

            /*
             * append the $GraphicsElement to the $PlaceElement
             */
            $placeElement->appendChild($graphicsElement);

            if (in_array($placeObj->getPlaceId(), $freeTokenPlaceIdArr)) {
                $InitialMarkingElement = $DOMObj->createElement('initialMarking');
                $textElement = $DOMObj->createElement('text', 1);
                $InitialMarkingElement->appendChild($textElement);
                $placeElement->appendChild($InitialMarkingElement);
            }

            /*
             * finally - append the $PlaceElement to the $NetElement
             */
            $netElement->appendChild($placeElement);
        }

        /**
         * deal with transitions
         */
        foreach ($transitionObjArr as $transitionObj) {
            /** @var $transitionObj Transition */
            $transitionElement = $DOMObj->createElement('transition');

            $transitionElement->setAttribute('id', $transitionObj->getYasperName());

            $textElement = $DOMObj->createElement('text', $transitionObj->getName());
            $nameElement = $DOMObj->createElement('name');
            $nameElement->appendChild($textElement);
            $transitionElement->appendChild($nameElement);
            $transition_arr = [
                'transition_type' => $transitionObj->getTransitionType()
            ];
            if ($transitionObj->getTransitionType() == TransitionTypeEnum::USER) {
                if ($transitionObj->getRoutes()->count()) {
                    $transition_arr['routes'] = [];
                    foreach ($transitionObj->getRoutes() as $routeObj) {
                        $transition_arr['routes'][] = $routeObj->getRoute();
                    }
                }
            } elseif ($transitionObj->getTransitionType() == TransitionTypeEnum::GATE) {
                if ($transitionObj->getGates()->count()) {
                    $transition_arr['gates'] = [];
                    foreach ($transitionObj->getGates() as $gateObj) {
                        $gate_arr = [];
                        $gate_arr['value'] = $gateObj->getValue();
                        $gate_arr['target_transition'] = $gateObj->getTargetYasperName();
                        $transition_arr['gates'][] = $gate_arr;
                    }
                }
            } elseif ($transitionObj->getTransitionType() == TransitionTypeEnum::AUTO) {
                if ($transitionObj->getCommands()->count()) {
                    $transition_arr['commands'] = [];
                    foreach ($transitionObj->getCommands() as $commandObj) {
                        $command_arr = [];
                        $command_arr['seq'] = $commandObj->getCommandSeq();
                        $command_arr['command_string'] = $commandObj->getCommandString();
                        $transition_arr['commands'][] = $command_arr;
                    }
                }
            } elseif ($transitionObj->getTransitionType() == TransitionTypeEnum::NOTIFICATION) {
                if ($transitionObj->getNotifications()->count()) {
                    $transition_arr['notifications'] = [];
                    foreach ($transitionObj->getNotifications() as $notificationObj) {
                        if ($notificationObj->getNotificationType() == NotificationTypeEnum::EMAIL) {
                            $transition_arr['notifications']['email'][] = $notificationObj->getNotificationString();
                        } elseif ($notificationObj->getNotificationType() == NotificationTypeEnum::SMS) {
                            $transition_arr['notifications']['SMS'][] = $notificationObj->getNotificationString();
                        } else {
                            throw new Exception_WorkFlow("Invalid notification type " . __FILE__ . __LINE__);
                        }
                    }
                }
            } elseif ($transitionObj->getTransitionType() == TransitionTypeEnum::TIMED) {
                if ($transitionObj->getTimeDelay()) {
                    $transition_arr['time_delay'] = $transitionObj->getTimeDelay();
                }
            }
            $transition_description = json_encode($transition_arr);

            $textElement = $DOMObj->createElement('text', htmlentities($transition_description));

            $descriptionElement = $DOMObj->createElement('description');
            $descriptionElement->appendChild($textElement);
            $transitionElement->appendChild($descriptionElement);

            $graphicsElement = $DOMObj->createElement('graphics');
            $positionElement = $DOMObj->createElement('position');
            $positionElement->setAttribute('x', $transitionObj->getPositionX());
            $positionElement->setAttribute('y', $transitionObj->getPositionY());
            $graphicsElement->appendChild($positionElement);

            $TransitionSizeFactor = 1;
            if (in_array($transitionObj->getTransitionId(), $enabledTransitionIdArr)) {
                $TransitionSizeFactor = 2;
            }

            $dimensionElement = $DOMObj->createElement('dimension');
            $dimensionElement->setAttribute('x', $transitionObj->getDimensionX() * $TransitionSizeFactor);
            $dimensionElement->setAttribute('y', $transitionObj->getDimensionY() * $TransitionSizeFactor);
            $graphicsElement->appendChild($dimensionElement);
            $transitionElement->appendChild($graphicsElement);

            if ($transitionObj->getTransitionType() == TransitionTypeEnum::EMITTER) {
                $toolSpecElement = $DOMObj->createElement('toolspecific');
                $toolSpecElement->setAttribute('tool', 'Yasper');
                $toolSpecElement->setAttribute('version', '1.2.4020.34351');
                $collectorElement = $DOMObj->createElement('emitor');
                $collectorElement->setAttribute('xmlns', "http://www.yasper.org/specs/epnml-1.1/toolspec");
                $textElement = $DOMObj->createElement('text', 'true');
                $collectorElement->appendChild($textElement);
                $toolSpecElement->appendChild($collectorElement);
                $transitionElement->appendChild($toolSpecElement);
            } elseif ($transitionObj->getTransitionType() == TransitionTypeEnum::CONSUMER) {
                $toolSpecElement = $DOMObj->createElement('toolspecific');
                $toolSpecElement->setAttribute('tool', 'Yasper');
                $toolSpecElement->setAttribute('version', '1.2.4020.34351');
                $collectorElement = $DOMObj->createElement('collector');
                $collectorElement->setAttribute('xmlns', "http://www.yasper.org/specs/epnml-1.1/toolspec");
                $textElement = $DOMObj->createElement('text', 'true');
                $collectorElement->appendChild($textElement);
                $toolSpecElement->appendChild($collectorElement);
                $transitionElement->appendChild($toolSpecElement);
            }

            $netElement->appendChild($transitionElement);
        }

        /**
         * deal with arcs
         */
        foreach ($arcObjArr as $arcObj) {
            /** @var $arcObj Arc */
            $arcElement = $DOMObj->createElement('arc');
            $arcElement->setAttribute('id', $arcObj->getYasperName());

            $textElement = $DOMObj->createElement('text', $arcObj->getName());
            $nameElement = $DOMObj->createElement('name');
            $nameElement->appendChild($textElement);
            $arcElement->appendChild($nameElement);
            $arcDescriptionArr = ['arc_type' => $arcObj->getArcType()];
            if ($arcObj->getDirection() == 'IN') {
                $arcElement->setAttribute('source', $arcObj->getPlace()->getYasperName());
                $arcElement->setAttribute('target', $arcObj->getTransition()->getYasperName());
            } else {
                $arcElement->setAttribute('source', $arcObj->getTransition()->getYasperName());
                $arcElement->setAttribute('target', $arcObj->getPlace()->getYasperName());
            }

            $textElement = $DOMObj->createElement('text', json_encode($arcDescriptionArr));
            $descriptionElement = $DOMObj->createElement('description');
            $descriptionElement->appendChild($textElement);
            $arcElement->appendChild($descriptionElement);


            $netElement->appendChild($arcElement);
        }

        $PNMLElement->appendChild($netElement);
        $DOMObj->appendChild($PNMLElement);

        return $DOMObj->saveXML();
    }

    /**
     * @param $json_error_code
     * @return string
     */
    private function get_json_error($json_error_code)
    {
        switch ($json_error_code) {
            case JSON_ERROR_NONE:
                return ' - No errors';
            case JSON_ERROR_DEPTH:
                return ' - Maximum stack depth exceeded';
            case JSON_ERROR_STATE_MISMATCH:
                return ' - Underflow or the modes mismatch';
            case JSON_ERROR_CTRL_CHAR:
                return ' - Unexpected control character found';
            case JSON_ERROR_SYNTAX:
                return ' - Syntax error, malformed JSON';
            case JSON_ERROR_UTF8:
                return ' - Malformed UTF-8 characters, possibly incorrectly encoded';
            default:
                return ' - Unknown error';
                break;
        }
    }
}
