<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\DoctrineORMAdminBundle\Filter;

use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\CoreBundle\Form\Type\BooleanType;

class NotNullableFilter extends Filter
{
    /**
     * {@inheritdoc}
     */
    public function filter(ProxyQueryInterface $queryBuilder, $alias, $field, $data)
    {
        if (!$data || !is_array($data) || !array_key_exists('type', $data) || !array_key_exists('value', $data)) {
            return;
        }

        if ($data['value'] == BooleanType::TYPE_YES) {
            $this->applyWhere($queryBuilder, sprintf('%s.%s IS NOT NULL', $alias, $field));
        } elseif ($data['value'] == BooleanType::TYPE_NO) {
            $this->applyWhere($queryBuilder, sprintf('%s.%s IS NULL', $alias, $field));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultOptions()
    {
        return array(
            'field_type'  => 'sonata_type_boolean'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getRenderSettings()
    {
        return array('sonata_type_filter_default', array(
            'field_type'       => $this->getFieldType(),
            'field_options'    => $this->getFieldOptions(),
            'operator_type'    => 'hidden',
            'operator_options' => array(),
            'label'            => $this->getLabel(),
        ));
    }
}
