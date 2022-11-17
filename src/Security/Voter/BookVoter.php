<?php

namespace App\Security\Voter;

use App\Entity\Book;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class BookVoter extends Voter
{
    public const VIEW = 'book.view';
    public const EDIT = 'book.edit';
    private AuthorizationCheckerInterface $checker;

    public function __construct(AuthorizationCheckerInterface $checker)
    {
        $this->checker = $checker;
    }

    protected function supports(string $attribute, $subject)
    {
        return $attribute === self::EDIT && $subject instanceof Book;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        if ($this->checker->isGranted('ROLE_ADMIN')) {
            return true;
        }

        $user = $token->getUser();
        if (!$user instanceof User) {
            return false;
        }
        if (!$subject instanceof Book) {
            return false;
        }

        switch ($attribute) {
            case self::VIEW:
                return $this->checkView();
            case self::EDIT:
                return $this->checkEdit($subject, $user);
        }

        return false;
    }

    private function checkView(): bool
    {
        return true;
    }

    private function checkEdit(Book $book, User $user): bool
    {
        return $book->getCreatedBy() === $user;
    }
}