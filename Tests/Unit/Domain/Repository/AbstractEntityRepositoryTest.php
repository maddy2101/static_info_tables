<?php

namespace SJBR\StaticInfoTables\Tests\Unit\Domain\Repository;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use BadMethodCallException;
use SJBR\StaticInfoTables\Domain\Model\AbstractEntity;
use SJBR\StaticInfoTables\Domain\Repository\AbstractEntityRepository;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;

/**
 * Testcase.
 *
 * @author Oliver Klee <typo3-coding@oliverklee.de>
 */
class AbstractEntityRepositoryTest extends UnitTestCase
{
    /**
     * @var AbstractEntityRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject;

    protected function setUp()
    {
        $objectManager = $this->getAccessibleMock(ObjectManager::class, ['dummy'], [], '', false);
        $this->subject = $this->getAccessibleMockForAbstractClass(AbstractEntityRepository::class, [$objectManager]);
    }

    protected function tearDown()
    {
        unset($this->subject);
    }

    /**
     * @test
     */
    public function initializeObjectSetsRespectStoragePidToFalse()
    {
        $objectManager = $this->getAccessibleMock(ObjectManager::class, ['get'], [], '', false);

        /** @var AbstractEntityRepository $subject */
        $subject = $this->getAccessibleMockForAbstractClass(AbstractEntityRepository::class, [$objectManager]);

        $querySettings = $this->getAccessibleMock(Typo3QuerySettings::class, ['setRespectStoragePage']);
        $querySettings->expects($this->once())->method('setRespectStoragePage')->with(false);

        $objectManager
            ->expects($this->once())
            ->method('get')
            ->with(Typo3QuerySettings::class)
            ->willReturn($querySettings);

        $subject->initializeObject();
    }

    /**
     * @test
     */
    public function initializeObjectSetsDefaultQuerySettings()
    {
        $objectManager = $this->getAccessibleMock(ObjectManager::class, ['get'], [], '', false);
        $subject = $this->getAccessibleMockForAbstractClass(AbstractEntityRepository::class, [$objectManager], '', true, true, true, ['setDefaultQuerySettings']);

        $querySettings = $this->getAccessibleMock(Typo3QuerySettings::class);
        $objectManager
            ->expects($this->once())
            ->method('get')
            ->with(Typo3QuerySettings::class)
            ->willReturn($querySettings);

        $subject->expects($this->once())->method('setDefaultQuerySettings')->with($querySettings);

        /** @var AbstractEntityRepository $subject */
        $subject->initializeObject();
    }

    /**
     * @test
     */
    public function addThrowsException()
    {
        $this->expectException(BadMethodCallException::class);
        $this->subject->add(new AbstractEntity());
    }

    /**
     * @test
     */
    public function removeThrowsException()
    {
        $this->expectException(BadMethodCallException::class);
        $this->subject->remove(new AbstractEntity());
    }

    /**
     * @test
     */
    public function updateThrowsException()
    {
        $this->expectException(BadMethodCallException::class);
        $this->subject->update(new AbstractEntity());
    }

    /**
     * @test
     */
    public function removeAllThrowsException()
    {
        $this->expectException(BadMethodCallException::class);
        $this->subject->removeAll();
    }
}
