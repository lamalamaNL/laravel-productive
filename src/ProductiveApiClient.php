<?php

namespace LamaLama\Productive;

use LamaLama\Productive\Endpoints\TaskEndpoint;
use LamaLama\Productive\Exceptions\ApiException;
use LamaLama\Productive\Exceptions\HttpAdapterDoesNotSupportDebuggingException;
use LamaLama\Productive\Exceptions\IncompatiblePlatform;
use LamaLama\Productive\HttpAdapter\ProductiveHttpAdapterPicker;

class ProductiveApiClient
{
    /**
     * Endpoint of the remote API.
     */
    public const API_ENDPOINT = "https://api.productive.io/api";

    /**
     * Version of the remote API.
     */
    public const API_VERSION = "v2";

    /**
     * HTTP Methods
     */
    public const HTTP_GET = "GET";
    public const HTTP_POST = "POST";
    public const HTTP_DELETE = "DELETE";
    public const HTTP_PATCH = "PATCH";

    /**
     * @var \LamaLama\Productive\HttpAdapter\ProductiveHttpAdapterInterface
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $apiEndpoint = self::API_ENDPOINT;

    /**
     * RESTful Tasks resource.
     *
     * @var TasktEndpoint
     */
    public $tasks;

    /**
     * @var string
     */
    protected $authToken;

    /**
     * RESTful Client resource.
     *
     * @var ClientEndpoint
     */
    public $clients;

    /**
     * @param \GuzzleHttp\ClientInterface|\LamaLama\Productive\HttpAdapter\ProductiveHttpAdapterInterface|null $httpClient
     * @param \LamaLama\Productive\HttpAdapter\ProductiveHttpAdapterPickerInterface|null $httpAdapterPicker
     * @throws \LamaLama\Productive\Exceptions\IncompatiblePlatform|\LamaLama\Productive\Exceptions\UnrecognizedClientException
     */
    public function __construct($httpClient = null, $httpAdapterPicker = null)
    {
        $this->httpClient = [];
    }

    public function initializeEndpoints()
    {
        $this->tasks = new TaskEndpoint($this);
    }

    /**
     * @param string $url
     *
     * @return ProductiveApiClient
     */
    public function setApiEndpoint($url)
    {
        $this->apiEndpoint = rtrim(trim($url), '/');

        return $this;
    }

    /**
     * @return string
     */
    public function getApiEndpoint()
    {
        return $this->apiEndpoint;
    }

    /**
     * @return array
     */
    public function getVersionStrings()
    {
        return $this->versionStrings;
    }

    /**
     * @param string $authToken The Productive Auth token'
     *
     * @return ProductiveApiClient
     * @throws ApiException
     */
    public function setAuthToken($authToken)
    {
        $authToken = trim($authToken);

        $this->authToken = $authToken;

        return $this;
    }

    /**
     * @param string $accessToken OAuth access token, starting with 'access_'
     *
     * @return ProductiveApiClient
     * @throws ApiException
     */
    public function setAccessToken($accessToken)
    {
        $accessToken = trim($accessToken);

        if (! preg_match('/^access_\w+$/', $accessToken)) {
            throw new ApiException("Invalid OAuth access token: '{$accessToken}'. An access token must start with 'access_'.");
        }

        $this->apiKey = $accessToken;
        $this->oauthAccess = true;

        return $this;
    }

    /**
     * Returns null if no API key has been set yet.
     *
     * @return bool|null
     */
    public function usesOAuth()
    {
        return $this->oauthAccess;
    }

    /**
     * @param string $versionString
     *
     * @return ProductiveApiClient
     */
    public function addVersionString($versionString)
    {
        $this->versionStrings[] = str_replace([" ", "\t", "\n", "\r"], '-', $versionString);

        return $this;
    }

    /**
     * Enable debugging mode. If debugging mode is enabled, the attempted request will be included in the ApiException.
     * By default, debugging is disabled to prevent leaking sensitive request data into exception logs.
     *
     * @throws \LamaLama\Productive\Exceptions\HttpAdapterDoesNotSupportDebuggingException
     */
    public function enableDebugging()
    {
        if (
            ! method_exists($this->httpClient, 'supportsDebugging')
            || ! $this->httpClient->supportsDebugging()
        ) {
            throw new HttpAdapterDoesNotSupportDebuggingException(
                "Debugging is not supported by " . get_class($this->httpClient) . "."
            );
        }

        $this->httpClient->enableDebugging();
    }

    /**
     * Disable debugging mode. If debugging mode is enabled, the attempted request will be included in the ApiException.
     * By default, debugging is disabled to prevent leaking sensitive request data into exception logs.
     *
     * @throws \LamaLama\Productive\Exceptions\HttpAdapterDoesNotSupportDebuggingException
     */
    public function disableDebugging()
    {
        if (
            ! method_exists($this->httpClient, 'supportsDebugging')
            || ! $this->httpClient->supportsDebugging()
        ) {
            throw new HttpAdapterDoesNotSupportDebuggingException(
                "Debugging is not supported by " . get_class($this->httpClient) . "."
            );
        }

        $this->httpClient->disableDebugging();
    }

    /**
     * Perform a http call. This method is used by the resource specific classes. Please use the $payments property to
     * perform operations on payments.
     *
     * @param string $httpMethod
     * @param string $apiMethod
     * @param string|null $httpBody
     *
     * @return \stdClass
     * @throws ApiException
     *
     * @codeCoverageIgnore
     */
    public function performHttpCall($httpMethod, $apiMethod, $httpBody = null)
    {
        $url = $this->apiEndpoint . "/" . self::API_VERSION . "/" . $apiMethod;

        return $this->performHttpCallToFullUrl($httpMethod, $url, $httpBody);
    }

    /**
     * Perform a http call to a full url. This method is used by the resource specific classes.
     *
     * @see $payments
     * @see $isuers
     *
     * @param string $httpMethod
     * @param string $url
     * @param string|null $httpBody
     *
     * @return \stdClass|null
     * @throws ApiException
     *
     * @codeCoverageIgnore
     */
    public function performHttpCallToFullUrl($httpMethod, $url, $httpBody = null)
    {
        if (empty($this->apiKey)) {
            throw new ApiException("You have not set an Auth token. Please use setAuthToken() to set the Auth token.");
        }

        $userAgent = implode(' ', $this->versionStrings);

        $headers = [
            'Accept' => "application/json",
            'Authorization' => "Bearer {$this->apiKey}",
            'User-Agent' => $userAgent,
        ];

        if ($httpBody !== null) {
            $headers['Content-Type'] = "application/json";
        }

        return $this->httpClient->send($httpMethod, $url, $headers, $httpBody);
    }

    /**
     * Serialization can be used for caching. Of course doing so can be dangerous but some like to live dangerously.
     *
     * \serialize() should be called on the collections or object you want to cache.
     *
     * We don't need any property that can be set by the constructor, only properties that are set by setters.
     *
     * Note that the API key is not serialized, so you need to set the key again after unserializing if you want to do
     * more API calls.
     *
     * @deprecated
     * @return string[]
     */
    public function __sleep()
    {
        return ["apiEndpoint"];
    }

    /**
     * When unserializing a collection or a resource, this class should restore itself.
     *
     * Note that if you have set an HttpAdapter, this adapter is lost on wakeup and reset to the default one.
     *
     * @throws IncompatiblePlatform If suddenly unserialized on an incompatible platform.
     */
    public function __wakeup()
    {
        $this->__construct();
    }
}
