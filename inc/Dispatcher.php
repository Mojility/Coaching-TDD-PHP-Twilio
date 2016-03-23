<?php

class Dispatcher {

    private $builder;

    function __construct(ResponseBuilder $builder) {
        $this->builder = $builder;
    }

    function invoke($group, $From, $Digits) {
        if (FORWARD_MODE == $group->getMode()) {
            if (!$group->isAdministrator($From)) {
                $response = $this->builder->buildForwardToAdministratorsResponse($group);
            } else {
                if ($Digits) {
                    if (10 == strlen($Digits)) {
                        $response = $this->builder->buildDialOutgoingCallResponse($group, $Digits);
                    } else {
                        $response = $this->builder->buildInvalidDigitsResponse();
                    }
                } else {
                    $response = $this->builder->buildGatherDigitsResponse();
                }
            }
        } else {
            $response = $this->builder->buildRejectCallResponse();
        }

        return $response;
    }

}
