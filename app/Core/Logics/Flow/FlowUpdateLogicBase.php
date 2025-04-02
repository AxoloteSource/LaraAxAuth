<?php

namespace App\Core\Logics\Flow;

use App\Core\Logics\Flow\Traits\FlowLogic;
use App\Core\Logics\Flow\Traits\WithValidates;
use App\Core\Logics\UpdateLogic;

abstract class FlowUpdateLogicBase extends UpdateLogic
{
    use FlowLogic, WithValidates;
}
