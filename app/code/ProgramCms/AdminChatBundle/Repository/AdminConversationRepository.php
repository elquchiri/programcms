<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminChatBundle\Repository;

use Doctrine\Persistence\ManagerRegistry;
use ProgramCms\AdminBundle\Entity\AdminUser;
use ProgramCms\AdminChatBundle\Entity\AdminConversation;
use ProgramCms\AdminChatBundle\Entity\AdminMessage;
use ProgramCms\CoreBundle\Repository\AbstractRepository;

/**
 * Class AdminConversationRepository
 * @package ProgramCms\AdminChatBundle\Repository
 */
class AdminConversationRepository extends AbstractRepository
{
    /**
     * AdminConversationRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdminConversation::class);
    }

    /**
     * @param int $id
     * @return object|null
     */
    public function getById(int $id): ?object
    {
        return $this->findOneBy([
            'conversation_id' => $id
        ]);
    }

    /**
     * @param array $userIds
     * @return AdminConversation|null
     */
    public function findConversationByUsers(array $userIds): ?AdminConversation
    {
        // Sort user IDs to ensure consistent ordering
        //$userIds = array_map(fn(AdminUser $user) => $user->getUserId(), $users);
        $userIds = array_map('intval', $userIds);
        sort($userIds);

        $query = $this->createQueryBuilder('c')
            ->innerJoin(AdminUser::class, 'u')
            ->andWhere('u.user_id IN (:userIds)')
            ->groupBy('c.conversation_id')
            ->having('COUNT(u.user_id) = :userCount')
            ->setParameter('userIds', $userIds)
            ->setParameter('userCount', count($userIds))
            ->getQuery();

        // Get all conversations that match
        $conversations = $query->getResult();

        // Check if there’s a conversation with exactly the same users
        /** @var AdminConversation $conversation */
        foreach ($conversations as $conversation) {
            $conversationUserIds = array_map(fn(AdminUser $user) => $user->getUserId(), $conversation->getUsers()->toArray());
            sort($conversationUserIds);
            if ($userIds === $conversationUserIds) {
                return $conversation;
            }
        }

        return null; // No exact match found
    }

    /**
     * @param AdminUser $user
     * @return mixed
     */
    public function findUserConversationsOrderedByLastMessage(AdminUser $user): mixed
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.messages', 'm')
//            ->groupBy('c.conversation_id')
            ->orderBy('m.updated_at', 'DESC')
            ->where(':user MEMBER OF c.users')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
}