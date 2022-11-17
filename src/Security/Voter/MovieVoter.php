<?php

namespace App\Security\Voter;

use App\Entity\Movie;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class MovieVoter extends Voter
{
    public const VIEW = 'movie.view';
    public const EDIT = 'movie.edit';
    private AuthorizationCheckerInterface $checker;

    public function __construct(AuthorizationCheckerInterface $checker)
    {
        $this->checker = $checker;
    }

    protected function supports(string $attribute, $subject): bool
    {
        return \in_array($attribute, [self::VIEW, self::EDIT])
            && $subject instanceof Movie;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        if ($this->checker->isGranted('ROLE_ADMIN')) {
            return true;
        }
        $user = $token->getUser();
        if (!$user instanceof User) {
            return false;
        }

        switch ($attribute) {
            case self::VIEW:
                return $this->checkView($subject, $user);
            case self::EDIT:
                return $this->checkEdit($subject, $user);
            default:
                return false;
        }
    }

    private function checkView(Movie $movie, User $user): bool
    {
        $age = $user->getBirthday()
            ? $user->getBirthday()->diff(new \DateTimeImmutable())->y
            : null;

        switch ($movie->getRated()) {
            case 'Not Rated':
            case 'G':
                return true;
            case 'PG':
            case 'PG-13':
                return $age && $age >= 13;
            case 'R':
            case 'NC-17':
                return $age && $age >= 17;
            default:
                return false;
        }
    }

    private function checkEdit(Movie $movie, User $user): bool
    {
        return $this->checkView($movie, $user) && $movie->getCreatedBy() === $user;
    }
}