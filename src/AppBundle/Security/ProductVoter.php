<?php

namespace AppBundle\Security;
/**
 * Created by PhpStorm.
 * User: JAGUILAR
 * Date: 24/03/2017
 * Time: 2:32 PM
 */
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use AppBundle\Entity\Product;

class ProductVoter extends Voter
{
    const CREATE = 'new';
    const EDIT   = 'edit';

    /**
     * @var AccessDecisionManagerInterface
     */
    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }
    /**
     * Determines if the attribute and subject are supported by this voter.
     *
     * @param string $attribute An attribute
     * @param mixed $subject The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool True if the attribute and subject are supported, false otherwise
     */
    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, array(self::CREATE, self::EDIT))) {
            return false;
        }
        if (!$subject instanceof Product) {
            return false;
        }


        return true;
    }

    /**
     * Perform a single access check operation on a given attribute, subject and token.
     * It is safe to assume that $attribute and $subject already passed the "supports()" method check.
     *
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        /** @var Product */
        $product = $subject; // $subject must be a Post instance, thanks to the supports method

        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case self::CREATE:
                // if the user is an admin, allow them to create new posts
                if ($this->decisionManager->decide($token, array('ROLE_ADMIN'))) {
                    return true;
                }

                break;
            case self::EDIT:
                // if the user is the author of the post, allow them to edit the posts
                if ($user->getEmail() === $product->getCode()) {
                    return true;
                }

                break;
        }

        return false;
    }
}