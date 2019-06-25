<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * JWT powered User for Yii 2
 *
 * @see       https://github.com/sergeymakinen/yii2-jwt-user
 * @copyright Copyright (c) 2016-2017 Sergey Makinen (https://makinen.ru)
 * @license   https://github.com/sergeymakinen/yii2-jwt-user/blob/master/LICENSE MIT License
 */

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\ValidationData;
use yii\base\InvalidValueException;
use yii\web\Cookie; 

/**
 * User class with a JWT cookie as a backend.
 *
 * @see https://jwt.io
 * @see https://tools.ietf.org/html/rfc7519
 * @see \yii\web\User
 */
// class User extends ActiveRecord implements IdentityInterface
class User extends \yii\web\User
{

    /**
     * @var string JWT sign key. Must be random and secret.
     * @see https://tools.ietf.org/html/rfc7519#section-11
     * @since 3.0
     */
    public $key;
    /**
     * @var bool whether to use a [[IdentityInterface::getAuthKey()]] value to validate a token.
     * @since 3.0
     */
    public $useAuthKey = true;
    /**
     * @var bool whether to append a [[IdentityInterface::getAuthKey()]] value to the sign key or store it as a claim.
     * @since 3.0
     */
    public $appendAuthKey = false;
    /**
     * @var \Closure|string JWT audience claim ("aud").
     * @see https://tools.ietf.org/html/rfc7519#section-4.1.3
     * @since 1.1
     */
    public $audience;
    /**
     * @var \Closure|string JWT issuer claim ("iss").
     * @see https://tools.ietf.org/html/rfc7519#section-4.1.1
     * @since 3.0
     */
    public $issuer;
    /**
     * @inheritDoc
     */
    public function renewIdentityCookie()
    {
        try {
            /** @var IdentityInterface $identity */
            /** @var Token $token */
            list($identity, $token) = $this->getIdentityAndTokenFromCookie();
            if ($identity === null) {
                return;
            }
        } catch (\Exception $e) {
            if ($e instanceof InvalidValueException) {
                throw $e;
            }
            return;
        }
        $now = time();
        $builder = $this->createBuilderFromToken($token)
            ->setNotBefore($now);
        if ($token->hasClaim('exp')) {
            $builder->setExpiration($now + ($token->getClaim('exp') - $token->getClaim('nbf')));
        }
        $this->sendToken($builder, $identity);
    }
    /**
     * @inheritDoc
     */
    public function sendIdentityCookie($identity, $duration)
    {
        $now = time();
        $builder = (new Builder())
            ->setIssuedAt($now)
            ->setNotBefore($now)
            ->setId($identity->getId());
        if ($duration > 0) {
            $builder->setExpiration($now + $duration);
        }
        $issuer = $this->getPrincipal($this->issuer);
        if ($issuer !== null) {
            $builder->setIssuer($issuer);
        }
        $audience = $this->getPrincipal($this->audience);
        if ($audience !== null) {
            $builder->setAudience($audience);
        }
        if ($this->useAuthKey && !$this->appendAuthKey) {
            $builder->set('authKey', $identity->getAuthKey());
        }
        $this->sendToken($builder, $identity);
    }
    /**
     * @inheritDoc
     */
    public function getIdentityAndDurationFromCookie()
    {
        try {
            /** @var IdentityInterface $identity */
            /** @var Token $token */
            list($identity, $token) = $this->getIdentityAndTokenFromCookie();
        } catch (\Exception $e) {
            if ($e instanceof InvalidValueException) {
                throw $e;
            }
            $ip = \Yii::$app->getRequest()->getUserIP();
            $error = lcfirst($e->getMessage());
            \Yii::warning("Invalid JWT cookie from $ip: $error", __METHOD__);
            $this->removeIdentityCookie();
            return null;
        }
        if ($identity === null) {
            $this->removeIdentityCookie();
            return null;
        }
        return ['identity' => $identity, 'duration' => $token->hasClaim('exp') ? $token->getClaim('exp') - $token->getClaim('nbf') : 0];
    }
    /**
     * @return array|null
     */
    public function getIdentityAndTokenFromCookie()
    {
        $value = \Yii::$app->getRequest()->getCookies()->getValue($this->identityCookie['name']);
        // print_r(\Yii::$app->getRequest()->getCookies()); exit;
        if ($value === null) {
            return null;
        }
        $token = (new Parser())->parse($value);
        if ($this->useAuthKey && $this->appendAuthKey) {
            $identity = $this->getIdentityFromToken($token);
            if ($identity === null) {
                return null;
            }
            $this->assertSignature($token, $identity);
            $this->assertClaims($token);
        } else {
            $this->assertSignature($token);
            $this->assertClaims($token);
            $identity = $this->getIdentityFromToken($token);
            if ($identity === null) {
                return null;
            }
        }
        return [$identity, $token];
    }
    /**
     * @param \Closure|string|null $value
     * @return string|null
     */
    private function getPrincipal($value)
    {
        if (is_string($value)) {
            return $value;
        }
        if ($value instanceof \Closure) {
            return $value();
        }
        return \Yii::$app->getRequest()->getHostInfo();
    }
    /**
     * @param IdentityInterface|null $identity
     * @return string
     */
    private function getKey(IdentityInterface $identity = null)
    {
        $key = (string) $this->key;
        if ($this->useAuthKey && $this->appendAuthKey) {
            $key .= $identity->getAuthKey();
        }
        if ($key === '') {
            throw new InvalidValueException('Sign key cannot be empty.');
        }
        return $key;
    }
    /**
     * @param Token $token
     * @param IdentityInterface|null $identity
     */
    private function assertSignature(Token $token, IdentityInterface $identity = null)
    {
        $key = $identity === null ? $this->getKey() : $this->getKey($identity);
        if (!$token->verify(new Sha256(), $key)) {
            throw new \InvalidArgumentException('Invalid signature');
        }
    }
    /**
     * @param Token $token
     */
    private function assertClaims(Token $token)
    {
        $validationData = new ValidationData(time());
        $issuer = $this->getPrincipal($this->issuer);
        if ($issuer !== null) {
            $validationData->setIssuer($issuer);
        }
        $audience = $this->getPrincipal($this->audience);
        if ($audience !== null) {
            $validationData->setAudience($audience);
        }
        if (!$token->validate($validationData)) {
            throw new \InvalidArgumentException('Invalid claims');
        }
    }
    /**
     * @param Token $token
     * @return IdentityInterface|null
     */
    private function getIdentityFromToken(Token $token)
    {
        /* @var $class IdentityInterface */
        $class = $this->identityClass;
        $id = $token->getClaim('jti');
        $identity = $class::findIdentity($id);
        if ($identity === null) {
            return null;
        }
        if (!$identity instanceof IdentityInterface) {
            throw new InvalidValueException("$class::findIdentity() must return an object implementing IdentityInterface.");
        }
        if ($this->useAuthKey && !$this->appendAuthKey) {
            $authKey = $token->getClaim('authKey');
            if (!$identity->validateAuthKey($authKey)) {
                \Yii::warning("Invalid auth key attempted for user '$id': $authKey", __METHOD__);
                return null;
            }
        }
        return $identity;
    }
    /**
     * @param Token $token
     * @return Builder
     */
    private function createBuilderFromToken(Token $token)
    {
        $builder = new Builder();
        foreach (array_keys($token->getClaims()) as $name) {
            $builder->set($name, $token->getClaim($name));
        }
        return $builder;
    }
    /**
     * @param Builder $builder
     * @param IdentityInterface $identity
     */
    private function sendToken(Builder $builder, IdentityInterface $identity)
    {
        $cookie = new Cookie($this->identityCookie);
        $cookie->expire = $builder->getToken()->getClaim('exp', '0');
        $cookie->value = (string) $builder
            ->sign(new Sha256(), $this->getKey($identity))
            ->getToken();
            // print_r($cookie); exit;
        \Yii::$app->getResponse()->getCookies()->add($cookie);
    }

    /**
     * @param Builder $builder
     * @param IdentityInterface $identity
     */
    public function getTokenFromCookie()
    {
        $value = \Yii::$app->getRequest()->getCookies()->getValue($this->identityCookie['name']); 
        return ($value === null) ? null : (new Parser())->parse($value); 
    }























    // const STATUS_DELETED = 0;
    // const STATUS_ACTIVE = 10;

    // /**
    //  * @inheritdoc
    //  */
    // public static function tableName()
    // {
    //     return '{{%users}}';
    // }

    // /**
    //  * @inheritdoc
    //  */
    // public function behaviors()
    // {
    //     return [
    //         TimestampBehavior::className(),
    //     ];
    // }

    // /**
    //  * @inheritdoc
    //  */
    // public function rules()
    // {
    //     return [
    //         ['status', 'default', 'value' => self::STATUS_ACTIVE],
    //         ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
    //     ];
    // }

    // /**
    //  * @inheritdoc
    //  */
    // public static function findIdentity($id)
    // {
    //     return static::findOne(['UserID' => $id, 'UserStatusID' => self::STATUS_ACTIVE]);
    // }

    // /**
    //  * @inheritdoc
    //  */
    // public static function findIdentityByAccessToken($token, $type = null)
    // {
    //     throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    // }

    // /**
    //  * Finds user by username
    //  *
    //  * @param string $username
    //  * @return static|null
    //  */
    // public static function findByUsername($username)
    // {
    //     return static::findOne(['UserName' => $username, 'UserStatusID' => self::STATUS_ACTIVE]);
    // }

    // /**
    //  * Finds user by password reset token
    //  *
    //  * @param string $token password reset token
    //  * @return static|null
    //  */
    // public static function findByPasswordResetToken($token)
    // {
    //     if (!static::isPasswordResetTokenValid($token)) {
    //         return null;
    //     }

    //     return static::findOne([
    //         'password_reset_token' => $token,
    //         'status' => self::STATUS_ACTIVE,
    //     ]);
    // }

    // *
    //  * Finds out if password reset token is valid
    //  *
    //  * @param string $token password reset token
    //  * @return boolean
     
    // public static function isPasswordResetTokenValid($token)
    // {
    //     if (empty($token)) {
    //         return false;
    //     }

    //     $timestamp = (int) substr($token, strrpos($token, '_') + 1);
    //     $expire = Yii::$app->params['user.passwordResetTokenExpire'];
    //     return $timestamp + $expire >= time();
    // }

    // /**
    //  * @inheritdoc
    //  */
    // public function getId()
    // {
    //     return $this->getPrimaryKey();
    // }

    // /**
    //  * @inheritdoc
    //  */
    // public function getAuthKey()
    // {
    //     return $this->auth_key;
    // }

    // /**
    //  * @inheritdoc
    //  */
    // public function validateAuthKey($authKey)
    // {
    //     return $this->getAuthKey() === $authKey;
    // }

    // /**
    //  * Validates password
    //  *
    //  * @param string $password password to validate
    //  * @return boolean if password provided is valid for current user
    //  */
    // public function validatePassword($password)
    // {
    //     return Yii::$app->security->validatePassword($password, $this->password_hash);
    // }

    // /**
    //  * Generates password hash from password and sets it to the model
    //  *
    //  * @param string $password
    //  */
    // public function setPassword($password)
    // {
    //     $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    // }

    // /**
    //  * Generates "remember me" authentication key
    //  */
    // public function generateAuthKey()
    // {
    //     $this->auth_key = Yii::$app->security->generateRandomString();
    // }

    // /**
    //  * Generates new password reset token
    //  */
    // public function generatePasswordResetToken()
    // {
    //     $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    // }

    // /**
    //  * Removes password reset token
    //  */
    // public function removePasswordResetToken()
    // {
    //     $this->password_reset_token = null;
    // }
}
