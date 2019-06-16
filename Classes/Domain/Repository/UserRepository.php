<?php
declare(strict_types=1);
namespace In2code\Luxletter\Domain\Repository;

use Doctrine\DBAL\DBALException;
use In2code\Luxletter\Domain\Model\User;
use In2code\Luxletter\Utility\DatabaseUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

/**
 * Class UserRepository
 */
class UserRepository extends AbstractRepository
{
    /**
     * @var array
     */
    protected $defaultOrderings = [
        'lastName' => QueryInterface::ORDER_ASCENDING
    ];

    /**
     * @param int $groupIdentifier
     * @return QueryResultInterface
     */
    public function getUserPreviewFromGroup(int $groupIdentifier): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching($query->equals('usergroup.uid', $groupIdentifier));
        $query->setLimit(3);
        return $query->execute();
    }

    /**
     * @param int $groupIdentifier
     * @return int
     * @throws DBALException
     */
    public function getUserAmountFromGroup(int $groupIdentifier): int
    {
        $connection = DatabaseUtility::getConnectionForTable(User::TABLE_NAME);
        $query = 'select count(uid) from ' . User::TABLE_NAME . ' ';
        $query .= 'where find_in_set(' . (int)$groupIdentifier . ',usergroup)';
        return (int)$connection->executeQuery($query)->fetchColumn(0);
    }
}
