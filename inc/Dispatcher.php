<?php

class Dispatcher {

    function invoke($group, $From, $Digits) {
        $builder = new ResponseBuilder();

        if (FORWARD_MODE == $group->getMode()) {
            if (!$group->isAdministrator($From)) {
                $response = $builder->buildForwardToAdministratorsResponse($group);
            } else {
                if ($Digits) {
                    if (10 == strlen($Digits)) {
                        $response = $builder->buildDialOutgoingCallResponse($group, $Digits);
                    } else {
                        $response = $builder->buildInvalidDigitsResponse();
                    }
                } else {
                    $response = $builder->buildGatherDigitsResponse();
                }
            }
        } else {
            $response = $builder->buildRejectCallResponse();
        }

        return $response;
    }

}
