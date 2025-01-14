<?php

/**
 * Copyright © Amazon.com, Inc. or its affiliates. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 *  http://aws.amazon.com/apache2.0
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */

namespace Amazon\Pay\Model\Config\Source;

class PaymentAction implements \Magento\Framework\Data\OptionSourceInterface
{
    const AUTHORIZE = 'authorize';
    const AUTHORIZE_AND_CAPTURE = 'authorize_capture';

    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return [
            ['value' => static::AUTHORIZE, 'label' => __('Charge when order is shipped')],
            ['value' => static::AUTHORIZE_AND_CAPTURE, 'label' => __('Charge when order is placed')],
        ];
    }
}
