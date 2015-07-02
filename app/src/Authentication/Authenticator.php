<?php

namespace App\Authentication;


class Authenticator {

    /**
     * Storage
     *
     * @var null|array|\ArrayAccess
     */
    protected $storage = null;

    /**
     * @var Adapter\AbstractAdapter Auth adapter
     */
    protected $adapter = null;

    /**
     * Message storage key
     *
     * @var string
     */
    protected $storageKey = 'SlimAuth';

    /**
     * Create new Flash messages service provider
     *
     * @param Adapter\AbstractAdapter $adapter
     * @param null|array|\ArrayAccess $storage
     */
    public function __construct(Adapter\AbstractAdapter $adapter = null, &$storage = null)
    {
        //if (null !== $storage) {
            $this->setStorage($storage);
        //}
        if (null !== $adapter) {
            $this->setAdapter($adapter);
        }
    }

    /**
     * Returns the persistent storage handler
     *
     * Session storage is used by default unless a different storage adapter has been set.
     *
     * @return array|\ArrayAccess
     */
    public function getStorage()
    {
        if (null === $this->storage) {
            $this->setStorage();
        }
        return $this->storage;
    }
    /**
     * Sets the persistent storage handler
     *
     * @param array|\ArrayAccess $storage
     * @return Authenticator
     */
    public function setStorage(&$storage = null)
    {
        // Set storage
        if (is_array($storage) || $storage instanceof \ArrayAccess) {
            $this->storage = &$storage;
        } elseif (is_null($storage)) {
            if (!isset($_SESSION)) {
                throw new \RuntimeException('Authentication middleware failed. Session not found.');
            }
            $this->storage = &$_SESSION;
        } else {
            throw new \InvalidArgumentException('Storage must be an array or implement \ArrayAccess');
        }

        return $this;
    }

    /**
     * Returns the authentication adapter
     *
     * The adapter does not have a default if the storage adapter has not been set.
     *
     * @return Adapter\AbstractAdapter|null
     */
    public function getAdapter()
    {
        return $this->adapter;
    }
    /**
     * Sets the authentication adapter
     *
     * @param Adapter\AbstractAdapter $adapter
     * @return Authenticator
     */
    public function setAdapter(Adapter\AbstractAdapter $adapter)
    {
        $this->adapter = $adapter;
        return $this;
    }

    /**
     * Authenticates user.
     *
     * @param string $identity User identifier (username, email, etc)
     * @param string $credential User password
     *
     * @return Result
     * @throws \RuntimeException
     */
    public function authenticate($identity, $credential)
    {
        if (!$adapter = $this->getAdapter()) {
            throw new \RuntimeException('An adapter must be set or passed prior to calling authenticate()');
        }
        $adapter = $this->getAdapter();
        $adapter->setIdentity($identity);
        $adapter->setCredential($credential);
        $result = $adapter->authenticate();
        /**
         * ZF-7546 - prevent multiple successive calls from storing inconsistent results
         * Ensure storage has clean state
         */
        if ($this->hasIdentity()) {
            $this->clearIdentity();
        }
        if ($result->isValid()) {
            $this->storage[$this->storageKey]=$result->getIdentity();
        }
        return $result;
    }

    /**
     * Returns true if and only if an identity is available from storage
     *
     * @return bool
     */
    public function hasIdentity()
    {
        return !empty($this->storage[$this->storageKey]);
    }
    /**
     * Returns the identity from storage or null if no identity is available
     *
     * @return mixed|null
     */
    public function getIdentity()
    {
        if (empty($this->storage[$this->storageKey])) {
            return null;
        }
        return $this->storage[$this->storageKey];
    }
    /**
     * Clears the identity from persistent storage
     *
     * @return void
     */
    public function clearIdentity()
    {
        $this->storage[$this->storageKey]=[];
    }

}