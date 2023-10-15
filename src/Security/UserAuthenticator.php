<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class UserAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'user_login';

    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function supports(Request $request): bool
    {
        return self::LOGIN_ROUTE === $request->attributes->get('_route')
            && $request->isMethod('POST');
    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email', '');

        $request->getSession()->set(Security::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {


        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->urlGenerator->generate('user_index'));
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}

// // src/Security/LoginFormAuthenticator.php
// namespace App\Security;

// use App\Entity\User;
// use Doctrine\ORM\EntityManagerInterface;
// use Symfony\Component\HttpFoundation\RedirectResponse;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
// use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
// use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
// use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
// use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
// use Symfony\Component\Security\Core\Security;
// use Symfony\Component\Security\Core\User\UserInterface;
// use Symfony\Component\Security\Core\User\UserProviderInterface;
// use Symfony\Component\Security\Csrf\CsrfToken;
// use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
// use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
// use Symfony\Component\Security\Guard\PasswordAuthenticatedInterface;
// use Symfony\Component\Security\Http\Util\TargetPathTrait;

// class UserAuthenticator extends AbstractFormLoginAuthenticator implements PasswordAuthenticatedInterface
// {
//     use TargetPathTrait;

//     public const LOGIN_ROUTE = 'user_login';

//     private $entityManager;
//     private $urlGenerator;
//     private $csrfTokenManager;
//     private $passwordEncoder;

//     public function __construct(EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator, CsrfTokenManagerInterface $csrfTokenManager, UserPasswordEncoderInterface $passwordEncoder)
//     {
//         $this->entityManager = $entityManager;
//         $this->urlGenerator = $urlGenerator;
//         $this->csrfTokenManager = $csrfTokenManager;
//         $this->passwordEncoder = $passwordEncoder;
//     }

//     public function supports(Request $request): bool
//     {
//         return self::LOGIN_ROUTE === $request->attributes->get('_route')
//             && $request->isMethod('POST');
//     }

//     public function getCredentials(Request $request)
//     {
//         $credentials = [
//             'email' => $request->request->get('email'),
//             'password' => $request->request->get('password'),
//             'csrf_token' => $request->request->get('_csrf_token'),
//         ];
//         $request->getSession()->set(
//             Security::LAST_USERNAME,
//             $credentials['email']
//         );

//         return $credentials;
//     }

//     public function getUser($credentials, UserProviderInterface $userProvider): ?User
//     {
//         $token = new CsrfToken('authenticate', $credentials['csrf_token']);
//         if (!$this->csrfTokenManager->isTokenValid($token)) {
//             throw new InvalidCsrfTokenException();
//         }

//         $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $credentials['email']]);

//         if (!$user) {
//             // fail authentication with a custom error
//             throw new CustomUserMessageAuthenticationException('Email could not be found.');
//         }

//         return $user;
//     }

//     public function checkCredentials($credentials, UserInterface $user): bool
//     {
//         return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
//     }

//     /**
//      * Used to upgrade (rehash) the user's password automatically over time.
//      */
//     public function getPassword($credentials): ?string
//     {
//         return $credentials['password'];
//     }

//     public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey): ?Response
//     {
//         if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
//             return new RedirectResponse($targetPath);
//         }

//         // For example : return new RedirectResponse($this->urlGenerator->generate('some_route'));
//         return new RedirectResponse($this->urlGenerator->generate('user_show'));
//     }

//     protected function getLoginUrl(): string
//     {
//         return $this->urlGenerator->generate(self::LOGIN_ROUTE);
//     }
// }

// namespace App\Security;

// use Symfony\Component\HttpFoundation\RedirectResponse;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
// use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
// use Symfony\Component\Security\Core\Security;
// use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
// use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
// use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
// use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
// use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
// use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
// use Symfony\Component\Security\Http\Util\TargetPathTrait;

// class UserAuthenticator extends AbstractLoginFormAuthenticator
// {
//     use TargetPathTrait;

//     public const LOGIN_ROUTE = 'user_login';

//     public function __construct(private UrlGeneratorInterface $urlGenerator)
//     {
//     }

//     public function authenticate(Request $request): Passport
//     {
//         $id = $request->request->get('id', '');

//         $request->getSession()->set(Security::LAST_USERNAME, $id);

//         $p = new Passport(
//             new UserBadge($id),
//             new PasswordCredentials($request->request->get('password', '')),
//             [
//                 new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
//                 new RememberMeBadge(),
//             ]
//         );
//         dump($p);

//         die;

//         // return new Passport(
//         //     new UserBadge($id),
//         //     new PasswordCredentials($request->request->get('password', '')),
//         //     [
//         //         new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
//         //         new RememberMeBadge(),
//         //     ]
//         // );
//     }

//     public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
//     {
//         if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
//             return new RedirectResponse($targetPath);
//         }

//         // For example:
//         // return new RedirectResponse($this->urlGenerator->generate('some_route'));
//         return new RedirectResponse($this->urlGenerator->generate('user_show'));
//     }

//     protected function getLoginUrl(Request $request): string
//     {
//         return $this->urlGenerator->generate(self::LOGIN_ROUTE);
//     }
// }
