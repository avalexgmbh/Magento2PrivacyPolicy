<?php

namespace Avalex\PrivacyPolicy\Model;

use \Magento\Framework\Model\AbstractModel;

class AvalexLog extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('Avalex\PrivacyPolicy\Model\Resource\AvalexLog');
    }

}
