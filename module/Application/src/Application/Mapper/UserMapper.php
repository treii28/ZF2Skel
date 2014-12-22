<?php
/**
 * Created by PhpStorm.
 * User: scottw
 * Date: 12/12/14
 * Time: 4:22 PM
 */

namespace Application\Mapper;

use Application\Entity\Users;
use Application\Entity\Addresses;

class UserMapper extends AbstractMapper {

    const ENTITY_NAME = 'Application\\Entity\\Users';

    /**
     * Get a new Addresses object for this user with some fields pre-populated
     *
     * @param \Application\Entity\Users|int $user
     * @throws \Exception for user id not found (when given an integer id)
     * @return \Application\Entity\Addresses
     */
    public function getNewAddress($user) {
        if($user instanceof \Application\Entity\Users) {
            $userObj = $user;
        } else {
            $userId = intval($user);
            $userObj = $this->findUserById($userId);
            if(!($user instanceof \Application\Entity\Users)) {
                throw new \Exception(__METHOD__." user not found for id '$userId'");
            }
        }
        $newAddress = new \Application\Entity\Addresses();
        $newAddress->setUserId($userObj);
        $newAddress->setFirstName($userObj->getFirstName());
        $newAddress->setMiddleName($userObj->getMiddleName());
        $newAddress->setLastName($userObj->getLastName());
        $newAddress->setEmail($userObj->getEmail());
        $newAddress->setPhone($userObj->getPhone());
        return $newAddress;
    }
}