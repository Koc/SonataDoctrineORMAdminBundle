<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\DoctrineORMAdminBundle\Tests\Filter;

use Sonata\CoreBundle\Form\Type\BooleanType;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Sonata\DoctrineORMAdminBundle\Filter\NotNullableFilter;

class NotNullableFilterTest extends \PHPUnit_Framework_TestCase
{
    public function testFilterNo()
    {
        $filter = new NotNullableFilter();
        $filter->initialize('field_name', array('field_options' => array('class' => 'FooBar')));

        $builder = new ProxyQuery(new QueryBuilder());

        $filter->filter($builder, 'alias', 'field', array('type' => null, 'value' => BooleanType::TYPE_NO));

        $this->assertEquals(array('alias.field IS NOT NULL'), $builder->query);
        $this->assertEquals(true, $filter->isActive());
    }

    public function testFilterYes()
    {
        $filter = new NotNullableFilter();
        $filter->initialize('field_name', array('field_options' => array('class' => 'FooBar')));

        $builder = new ProxyQuery(new QueryBuilder());

        $filter->filter($builder, 'alias', 'field', array('type' => null, 'value' => BooleanType::TYPE_YES));

        $this->assertEquals(array('alias.field IS NULL'), $builder->query);
        $this->assertEquals(true, $filter->isActive());
    }
}
