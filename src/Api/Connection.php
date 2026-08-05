<?php

namespace Webmaniabr\Nfse\Api;

use Webmaniabr\Nfse\Interfaces\APIConnection;

class Connection implements APIConnection
{
    /**
     * Bearer token de autenticação na API.
     * @var string
     */
    private string $bearerToken = '';

    /**
     * Informações de comunicação com proxy.
     * @see https://docs.guzzlephp.org/en/stable/request-options.html#proxy
     * @var array
     */
    private array $proxy = [];

    /**
     * Timeout (em segundos) das chamadas HTTP à API.
     * @see https://docs.guzzlephp.org/en/stable/request-options.html#timeout
     * @var array
     */
    private array $timeout = [];

    private static Connection $instance;

    private function __construct() { }

    /**
     * @return $this
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Define o token de autenticação.
     * @param string $token
     */
    public function setBearerToken(string $token)
    {
        $this->bearerToken = $token;
    }

    /**
     * Retorna o token de autenticação.
     * @return string
     */
    public function getBearerToken() : string
    {
        return $this->bearerToken;
    }

    /**
     * Define as informações do proxy.
     * @param array $proxy
     */
    public function setProxy(array $proxy)
    {
        $this->proxy = $proxy;
    }

    /**
     * Define o timeout das chamadas HTTP à API. Se não configurado, mantém o
     * padrão do Guzzle (sem timeout).
     * @param float $timeout Timeout total da requisição, em segundos.
     * @param float|null $connectTimeout Timeout de conexão, em segundos. Se omitido, mantém o valor atual.
     */
    public function setTimeout(float $timeout, ?float $connectTimeout = null)
    {
        $this->timeout['timeout'] = $timeout;
        if ($connectTimeout !== null) {
            $this->timeout['connect_timeout'] = $connectTimeout;
        }
    }

    /**
     * Retorna as opções de timeout configuradas, no formato de request options do Guzzle.
     * @return array
     */
    public function getTimeout() : array
    {
        return $this->timeout;
    }

    /**
     * {@inheritDoc}
     */
    public function getDomain() : string
    {
        return 'https://api.webmaniabr.com';
    }

    /**
     * {@inheritDoc}
     */
    public function getProxy() : array
    {
        return $this->proxy;
    }
}