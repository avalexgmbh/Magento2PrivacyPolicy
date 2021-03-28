<?php

namespace Avalex\PrivacyPolicy\Model\Resource\AvalexLog;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'version_id';
    protected $_eventPrefix = 'avalex_privacy_policy_avalex_log_collection';
    protected $_eventObject = 'avalex_log_collection';

    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            'Avalex\PrivacyPolicy\Model\AvalexLog',
            'Avalex\PrivacyPolicy\Model\Resource\AvalexLog'
        );
    }
}
