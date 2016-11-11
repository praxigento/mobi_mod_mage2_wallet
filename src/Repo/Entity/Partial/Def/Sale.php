<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Wallet\Repo\Entity\Partial\Def;

class Sale
    extends \Praxigento\Core\Repo\Def\Entity
    implements \Praxigento\Wallet\Repo\Entity\Partial\ISale
{
    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource,
        \Praxigento\Core\Repo\IGeneric $repoGeneric
    ) {
        parent::__construct($resource, $repoGeneric, \Praxigento\Wallet\Data\Entity\Partial\Sale::class);
    }

    public function create($data)
    {
        return parent::create($data); // TODO: Change the autogenerated stub
    }

    public function updateById($id, $data)
    {
        return parent::updateById($id, $data); // TODO: Change the autogenerated stub
    }

}