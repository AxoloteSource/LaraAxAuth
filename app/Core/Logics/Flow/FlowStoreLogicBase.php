<?php

namespace App\Core\Logics\Flow;

use App\Core\Logics\Flow\Traits\FlowLogic;
use App\Core\Logics\Flow\Traits\WithValidates;
use App\Core\Logics\StoreLogic;

abstract class FlowStoreLogicBase extends StoreLogic
{
    use FlowLogic, WithValidates;
}
