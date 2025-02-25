<?php
/**
 * Copyright © Amazon.com, Inc. or its affiliates. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 *
 */

namespace Amazon\Pay\Block\Adminhtml\System\Config\Form;

use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * Displays links to available custom logs
 */
class DeveloperLogs extends \Magento\Config\Block\System\Config\Form\Field
{
    const DOWNLOAD_PATH = 'amazon_pay/pay/downloadLog';

    const LOGS = [
        'async' => ['name' => 'IPN Log', 'path' => \Amazon\Pay\Logger\Handler\AsyncIpn::FILENAME],
        'client' => ['name' => 'Client Log', 'path' => \Amazon\Pay\Logger\Handler\Client::FILENAME],
        'alexa' => ['name' => 'Alexa Log', 'path' => \Amazon\Pay\Logger\Handler\Alexa::FILENAME],
    ];

    /**
     * @var DirectoryList
     */
    private $directoryList;

    /**
     * @var \Magento\Backend\Model\UrlInterface
     */
    private $urlBuilder;

    /**
     * DeveloperLogs constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Model\UrlInterface $urlBuilder
     * @param DirectoryList $directoryList
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Model\UrlInterface $urlBuilder,
        DirectoryList $directoryList,
        $data = []
    ) {
        parent::__construct($context, $data);
        $this->directoryList = $directoryList;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @inheritdoc
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (!$this->getTemplate()) {
            $this->setTemplate('system/config/logs.phtml');
        }
        return $this;
    }

    /**
     * Render log list
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        // Remove scope label
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    /**
     * Renders string as an html element
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     *
     * @return string
     */
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        return $this->_toHtml();
    }

    /**
     * Returns markup for developer log field.
     *
     * @return \Magento\Framework\Phrase|string
     */
    public function getLinks()
    {
        $links = $this->getLogFiles();

        if ($links) {
            $output = '';

            foreach ($links as $link) {
                $output .= '<a href="' . $link['link'] . '">' . $link['name'] . '</a><br />';
            }

            return $output;
        }
        return __('No logs available');
    }

    /**
     * Get list of available log files.
     *
     * @return array
     */
    private function getLogFiles()
    {
        $links = [];
        $root = $this->directoryList->getPath(DirectoryList::ROOT);
        foreach (self::LOGS as $name => $data) {
            // phpcs:ignore Magento2.Functions.DiscouragedFunction
            if (file_exists($root . $data['path'])) {
                $links[] = [
                    'name' => $data['name'],
                    'link' => $this->urlBuilder->getUrl(self::DOWNLOAD_PATH, [
                        'name' => $name,
                    ]),
                ];
            }
        }
        return $links;
    }
}
