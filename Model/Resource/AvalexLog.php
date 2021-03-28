<?php

namespace Avalex\PrivacyPolicy\Model\Resource;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class AvalexLog extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('avalex_log','version_id');
    }
}
