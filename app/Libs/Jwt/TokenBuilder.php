<?php

namespace App\Libs\Jwt;

use DateTimeImmutable;
use http\Exception\InvalidArgumentException;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Token\Builder;
use Lcobucci\JWT\Token\Parser;
use App\Models\User;
use Lcobucci\JWT\Validation\Constraint\RelatedTo;
use Lcobucci\JWT\Validation\Validator;

class TokenBuilder
{
    public function __construct()
    {
    }

    public function generate(int $user_id, string $session_key): string
    {
        $tokenBuilder = (new Builder(new JoseEncoder(), ChainedFormatter::default()));
        $now = new DateTimeImmutable();
        $token = $tokenBuilder
            ->issuedBy(env('APP_URL'))
            ->issuedAt($now)
            ->canOnlyBeUsedAfter($now->modify('+2 minute'))
            ->expiresAt($now->modify('+1 hour'))
            ->withClaim('user_id', $user_id)
            ->withClaim('session_key', $session_key)
            ->getToken(new Sha256(), InMemory::plainText(random_bytes(32)));

        return $token->toString();
    }

    public function parse(string $access_token)
    {
        $parser = new Parser(new JoseEncoder());

        $token = $parser->parse($access_token);

        $user_id = $token->claims()->get('user_id');

        $user = User::findOrFail($user_id);
        $user->session_key = $token->claims()->get('session_key', '');

        return $user;
    }

    public function verify(string $access_token): void
    {
        $parser = new Parser(new JoseEncoder());

        $token = $parser->parse($access_token);

        $validator = new Validator();

        if (! $validator->validate($token, new RelatedTo('1234567891'))) {
            throw new InvalidArgumentException('Invalid Token!');
        }
    }
}
